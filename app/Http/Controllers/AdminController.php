<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\User;
use App\Models\Product;
use App\Notifications\StoreVerificationNotification;

class AdminController extends Controller
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
     * Show the dashboard for admin.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $storeCount = Store::count();
        $pendingStores = Store::where('status', 'pending')->count();
        $verifiedStores = Store::where('status', 'verified')->count();

        return view('admin.dashboard', compact('storeCount', 'pendingStores', 'verifiedStores'));
    }

    /**
     * Show the list of all stores.
     *
     * @return \Illuminate\View\View
     */
    public function stores()
    {
        $stores = Store::with('user')->get();

        return view('admin.stores', compact('stores'));
    }

    /**
     * Show the store detail.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function showStore($id)
    {
        $store = Store::with('user')->findOrFail($id);

        return view('admin.store_detail', compact('store'));
    }

    /**
     * Update the store status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStoreStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,verified,nonaktif',
        ]);

        $store = Store::findOrFail($id);
        $oldStatus = $store->status;
        $store->status = $request->status;
        $store->save();

        // Send notification when status changes
        if ($oldStatus != $request->status) {
            $user = User::find($store->user_id);

            if ($request->status == 'verified') {
                $user->notify(new StoreVerificationNotification($store, 'verified'));
            } else if ($request->status == 'nonaktif') {
                $user->notify(new StoreVerificationNotification($store, 'rejected'));
            }
        }

        return redirect()->route('admin.stores')->with('success', 'Status toko berhasil diperbarui.');
    }

    /**
     * Show users without stores.
     *
     * @return \Illuminate\View\View
     */
    public function usersWithoutStore()
    {
        $users = User::whereDoesntHave('store')
            ->where('role', 'Toko')
            ->get();

        return view('admin.users_without_store', compact('users'));
    }

    /**
     * Create a store for a user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createStoreForUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama_toko' => 'required|string|max:255',
            'alamat' => 'required|string',
            'nama_pemilik' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'status' => 'required|in:pending,verified,nonaktif',
            'foto1' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'foto2' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'foto3' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Check if the user already has a store
        $existingStore = Store::where('user_id', $request->user_id)->first();
        if ($existingStore) {
            return redirect()->route('admin.users_without_store')->with('error', 'Pengguna ini sudah memiliki toko.');
        }

        // Handle file uploads
        $foto1Path = $request->file('foto1')->store('foto-toko', 'public');
        $foto2Path = $request->file('foto2')->store('foto-toko', 'public');
        $foto3Path = $request->file('foto3')->store('foto-toko', 'public');

        // Create store
        Store::create([
            'user_id' => $request->user_id,
            'nama_toko' => $request->nama_toko,
            'alamat' => $request->alamat,
            'nama_pemilik' => $request->nama_pemilik,
            'no_hp' => $request->no_hp,
            'foto1' => $foto1Path,
            'foto2' => $foto2Path,
            'foto3' => $foto3Path,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.stores')->with('success', 'Toko berhasil dibuat untuk pengguna.');
    }
}
