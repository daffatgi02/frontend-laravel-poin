<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of all products.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Hanya admin yang bisa melihat semua produk
        if (auth()->user()->role !== 'Admin') {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $products = Product::with('store')->get();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Hanya admin yang bisa menambahkan produk
        if (auth()->user()->role !== 'Admin') {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Hanya ambil toko yang terverifikasi
        $stores = Store::where('status', 'verified')->get();
        return view('admin.products.create', compact('stores'));
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Hanya admin yang bisa menambahkan produk
        if (auth()->user()->role !== 'Admin') {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $request->validate([
            'store_id' => 'required|exists:stores,id_toko',
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'foto_produk' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'reward_poin' => 'required|integer|min:0',
        ]);

        // Cek status toko
        $store = Store::find($request->store_id);
        if (!$store || $store->status !== 'verified') {
            return redirect()->route('admin.products.create')->with('error', 'Produk hanya bisa ditambahkan ke toko yang terverifikasi.');
        }

        // Handle file upload
        $fotoPath = $request->file('foto_produk')->store('foto-produk', 'public');

        // Create product
        Product::create([
            'store_id' => $request->store_id,
            'nama_produk' => $request->nama_produk,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'foto_produk' => $fotoPath,
            'reward_poin' => $request->reward_poin,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Display the specified product.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $product = Product::with('store')->findOrFail($id);

        // Jika user adalah Toko, pastikan mereka hanya bisa melihat produk milik toko mereka
        if (auth()->user()->role === 'Toko') {
            $store = Store::where('user_id', auth()->id())->first();
            if (!$store || $product->store_id !== $store->id_toko) {
                return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke produk ini.');
            }
        }

        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Hanya admin yang bisa mengedit produk
        if (auth()->user()->role !== 'Admin') {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $product = Product::findOrFail($id);
        $stores = Store::where('status', 'verified')->get();

        return view('admin.products.edit', compact('product', 'stores'));
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Hanya admin yang bisa mengupdate produk
        if (auth()->user()->role !== 'Admin') {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $request->validate([
            'store_id' => 'required|exists:stores,id_toko',
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'foto_produk' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'reward_poin' => 'required|integer|min:0',
        ]);

        // Cek status toko
        $store = Store::find($request->store_id);
        if (!$store || $store->status !== 'verified') {
            return redirect()->route('admin.products.edit', $id)->with('error', 'Produk hanya bisa ditambahkan ke toko yang terverifikasi.');
        }

        $product = Product::findOrFail($id);

        // Update product data
        $product->store_id = $request->store_id;
        $product->nama_produk = $request->nama_produk;
        $product->deskripsi = $request->deskripsi;
        $product->harga = $request->harga;
        $product->stok = $request->stok;
        $product->reward_poin = $request->reward_poin;

        // Handle file upload if a new image is provided
        if ($request->hasFile('foto_produk')) {
            // Delete old image
            if ($product->foto_produk) {
                Storage::disk('public')->delete($product->foto_produk);
            }

            // Store new image
            $fotoPath = $request->file('foto_produk')->store('foto-produk', 'public');
            $product->foto_produk = $fotoPath;
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Hanya admin yang bisa menghapus produk
        if (auth()->user()->role !== 'Admin') {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $product = Product::findOrFail($id);

        // Delete image file
        if ($product->foto_produk) {
            Storage::disk('public')->delete($product->foto_produk);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
