<?php

namespace App\Http\Controllers;

use App\Models\Point;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PointController extends Controller
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
     * Display points history for the authenticated store.
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

        $points = Point::where('store_id', $store->id_toko)
            ->with('sale.product')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalPoints = $store->total_points;

        return view('toko.points.index', compact('points', 'totalPoints', 'store'));
    }
}
