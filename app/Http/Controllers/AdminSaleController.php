<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminSaleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Admin');
    }

    /**
     * Display a listing of the sales.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $sales = Sale::with(['store', 'product'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.sales.index', compact('sales'));
    }

    /**
     * Display the specified sale.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $sale = Sale::with(['store', 'product'])
            ->findOrFail($id);

        return view('admin.sales.show', compact('sale'));
    }

    /**
     * Update the sale status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,verified,rejected',
            'catatan_admin' => 'nullable|string'
        ]);

        $sale = Sale::findOrFail($id);
        $oldStatus = $sale->status;
        $newStatus = $request->status;

        // Get the product to update stock
        $product = Product::findOrFail($sale->product_id);

        // Handle stock updates based on status change
        if ($oldStatus != $newStatus) {
            if ($oldStatus == 'pending') {
                // Release the reserved stock since we're changing from pending
                $product->reserved_stock -= $sale->jumlah;

                if ($newStatus == 'verified') {
                    // If verifying, reduce actual stock
                    if ($product->stok < $sale->jumlah) {
                        // This should never happen if reserved stock logic is working properly,
                        // but it's a safeguard
                        return redirect()->back()->with('error', 'Stok produk tidak mencukupi untuk verifikasi penjualan ini.');
                    }

                    // Reduce actual stock
                    $product->stok -= $sale->jumlah;
                }
                // If rejecting, just release the reservation, no need to modify actual stock
            } else if ($oldStatus == 'verified' && $newStatus != 'verified') {
                // If changing from verified to rejected or pending, restore actual stock
                $product->stok += $sale->jumlah;

                if ($newStatus == 'pending') {
                    // If changing back to pending, re-reserve the stock
                    $product->reserved_stock += $sale->jumlah;
                }
            } else if ($oldStatus == 'rejected' && $newStatus == 'verified') {
                // If changing from rejected to verified, reduce actual stock
                if ($product->stok < $sale->jumlah) {
                    return redirect()->back()->with('error', 'Stok produk tidak mencukupi untuk verifikasi penjualan ini.');
                }

                $product->stok -= $sale->jumlah;
            } else if ($oldStatus == 'rejected' && $newStatus == 'pending') {
                // If changing from rejected to pending, reserve stock
                if ($product->available_stock < $sale->jumlah) {
                    return redirect()->back()->with('error', 'Stok tersedia tidak mencukupi untuk mengubah status menjadi menunggu.');
                }

                $product->reserved_stock += $sale->jumlah;
            }

            $product->save();
        }

        // Update sale status and admin notes
        $sale->status = $newStatus;
        $sale->catatan_admin = $request->catatan_admin;
        $sale->save();

        return redirect()->route('admin.sales.index')->with('success', 'Status penjualan berhasil diperbarui.');
    }
    /**
     * Generate a PDF receipt for a sale.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function generatePdf($id)
    {
        $sale = Sale::where('id_penjualan', $id)
            ->with(['product', 'store'])
            ->firstOrFail();

        $pdf = PDF::loadView('admin.sales.pdf', compact('sale'));

        return $pdf->download('bukti-penjualan-admin-' . $id . '.pdf');
    }
}
