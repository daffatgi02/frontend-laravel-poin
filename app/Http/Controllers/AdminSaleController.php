<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Store;
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
        $sale->status = $request->status;
        $sale->catatan_admin = $request->catatan_admin;
        $sale->save();

        // If verified, perhaps calculate and add points to the store
        if ($request->status === 'verified') {
            // This is where you could implement your reward points logic
            // For example, adding points based on the product's reward_poin value
            // This is just a placeholder - implement your specific logic

            // $product = $sale->product;
            // $pointsToAdd = $product->reward_poin * $sale->jumlah;
            // Add points to store or user
        }

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
