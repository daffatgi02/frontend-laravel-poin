<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Notifications\NewSaleNotification;

class SaleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Toko');
    }

    /**
     * Display a listing of the sales.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $store = Store::where('user_id', Auth::id())->first();

        if (!$store) {
            return redirect()->route('toko.dashboard')->with('error', 'Anda belum memiliki toko.');
        }

        if ($store->status !== 'verified') {
            return redirect()->route('toko.dashboard')->with('error', 'Toko Anda belum diverifikasi oleh Admin.');
        }

        $sales = Sale::where('store_id', $store->id_toko)
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('toko.sales.index', compact('sales', 'store'));
    }

    /**
     * Show the form for creating a new sale.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $store = Store::where('user_id', Auth::id())->first();

        if (!$store) {
            return redirect()->route('toko.dashboard')->with('error', 'Anda belum memiliki toko.');
        }

        if ($store->status !== 'verified') {
            return redirect()->route('toko.dashboard')->with('error', 'Toko Anda belum diverifikasi oleh Admin.');
        }

        $products = Product::where('store_id', $store->id_toko)
            ->where('stok', '>', 0)
            ->get();

        return view('toko.sales.create', compact('products', 'store'));
    }

    /**
     * Store a newly created sale in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id_produk',
            'jumlah' => 'required|integer|min:1',
            'harga_jual' => 'required|numeric|min:0',
            'tanggal_penjualan' => 'required|date',
            'bukti_penjualan' => 'required|array|min:1|max:10',
            'bukti_penjualan.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'catatan' => 'nullable|string'
        ]);

        $store = Store::where('user_id', Auth::id())->first();

        if (!$store || $store->status !== 'verified') {
            return redirect()->route('toko.dashboard')->with('error', 'Toko Anda belum diverifikasi atau tidak ditemukan.');
        }

        $product = Product::findOrFail($request->product_id);

        if ($product->store_id != $store->id_toko) {
            return redirect()->route('toko.sales.create')->with('error', 'Produk tidak terkait dengan toko Anda.');
        }

        // Check if the requested quantity is available (considering reserved stock)
        if ($product->available_stock < $request->jumlah) {
            return redirect()->route('toko.sales.create')->with('error', 'Stok produk tidak mencukupi. Stok tersedia: ' . $product->available_stock);
        }

        // Handle multiple file uploads
        $buktiPaths = [];
        if ($request->hasFile('bukti_penjualan')) {
            foreach ($request->file('bukti_penjualan') as $photo) {
                $path = $photo->store('bukti-penjualan', 'public');
                $buktiPaths[] = $path;
            }
        }

        // Create sale record with JSON encoded paths
        $sale = Sale::create([
            'store_id' => $store->id_toko,
            'product_id' => $request->product_id,
            'jumlah' => $request->jumlah,
            'harga_jual' => $request->harga_jual,
            'tanggal_penjualan' => $request->tanggal_penjualan,
            'bukti_penjualan' => json_encode($buktiPaths),
            'catatan' => $request->catatan,
            'status' => 'pending'
        ]);

        // Reserve the stock (increment reserved_stock)
        $product->reserved_stock += $request->jumlah;
        $product->save();

        // Send notification to all admin users
        $this->notifyAdmins($sale, $store, $product);

        return redirect()->route('toko.sales.index')->with('success', 'Penjualan berhasil dicatat dan menunggu verifikasi admin.');
    }

    /**
     * Send notification to all admin users about new sale
     *
     * @param Sale $sale
     * @param Store $store
     * @param Product $product
     * @return void
     */
    private function notifyAdmins($sale, $store, $product)
    {
        // Get all admin users
        $adminUsers = \App\Models\User::where('role', 'Admin')->get();

        foreach ($adminUsers as $admin) {
            $admin->notify(new \App\Notifications\NewSaleNotification($sale, $store, $product));
        }
    }
    /**
     * Display the specified sale.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $store = Store::where('user_id', Auth::id())->first();

        if (!$store) {
            return redirect()->route('toko.dashboard')->with('error', 'Anda belum memiliki toko.');
        }

        $sale = Sale::where('id_penjualan', $id)
            ->where('store_id', $store->id_toko)
            ->with(['product', 'store'])
            ->firstOrFail();

        return view('toko.sales.show', compact('sale'));
    }

    /**
     * Generate a PDF receipt for a sale.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function generatePdf($id)
    {
        $store = Store::where('user_id', Auth::id())->first();

        if (!$store) {
            return redirect()->route('toko.dashboard')->with('error', 'Anda belum memiliki toko.');
        }

        $sale = Sale::where('id_penjualan', $id)
            ->where('store_id', $store->id_toko)
            ->with(['product', 'store'])
            ->firstOrFail();

        $pdf = PDF::loadView('toko.sales.pdf', compact('sale'));

        return $pdf->download('bukti-penjualan-' . $id . '.pdf');
    }
}
