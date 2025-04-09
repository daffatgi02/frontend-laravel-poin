<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TokoController extends Controller
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
     * Show the dashboard for store owner.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $user = Auth::user();
        $store = Store::where('user_id', $user->id)->first();

        return view('toko.dashboard', compact('store'));
    }

    /**
     * Show the form for creating a store.
     *
     * @return \Illuminate\View\View
     */
    public function createStore()
    {
        return view('toko.create_store');
    }

    /**
     * Store a newly created store in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeStore(Request $request)
    {
        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'alamat' => 'required|string',
            'nama_pemilik' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'foto1' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'foto2' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'foto3' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle file uploads
        $foto1Path = $request->file('foto1')->store('foto-toko', 'public');
        $foto2Path = $request->file('foto2')->store('foto-toko', 'public');
        $foto3Path = $request->file('foto3')->store('foto-toko', 'public');

        // Create store
        Store::create([
            'user_id' => Auth::id(),
            'nama_toko' => $request->nama_toko,
            'alamat' => $request->alamat,
            'nama_pemilik' => $request->nama_pemilik,
            'no_hp' => $request->no_hp,
            'foto1' => $foto1Path,
            'foto2' => $foto2Path,
            'foto3' => $foto3Path,
            'status' => 'pending',
        ]);

        return redirect()->route('toko.dashboard')->with('success', 'Toko berhasil dibuat dan sedang menunggu verifikasi admin.');
    }

    /**
     * Show the list of products for the store.
     *
     * @return \Illuminate\View\View
     */
    public function products()
    {
        $user = Auth::user();
        $store = Store::where('user_id', $user->id)->first();

        if (!$store) {
            return redirect()->route('toko.dashboard')->with('error', 'Anda belum memiliki toko.');
        }

        if ($store->status !== 'verified') {
            return redirect()->route('toko.dashboard')->with('error', 'Toko Anda belum diverifikasi oleh Admin.');
        }

        $products = Product::where('store_id', $store->id_toko)->get();

        return view('toko.products', compact('products', 'store'));
    }
}
