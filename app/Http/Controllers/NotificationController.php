<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class NotificationController extends Controller
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
     * Display all notifications.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Retrieve all notifications and create a manual paginator
        $notifications = Auth::user()->notifications;
        $page = request('page', 1);
        $perPage = 10;
        $notifications = new \Illuminate\Pagination\LengthAwarePaginator(
            $notifications->forPage($page, $perPage),
            $notifications->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark notification as read.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
        }

        return back();
    }

    /**
     * Mark all notifications as read.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return back();
    }
    /**
     * Handle notification click and redirect to the appropriate page.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleClick($id)
    {
        $notification = Auth::user()->notifications->where('id', $id)->first();

        if (!$notification) {
            return redirect()->route('notifications.index')->with('error', 'Notifikasi tidak ditemukan.');
        }

        // Mark notification as read
        $notification->markAsRead();

        // Redirect based on notification type
        $data = $notification->data;

        if (isset($data['url'])) {
            // If notification has a URL, redirect to it
            return redirect($data['url']);
        } elseif ($data['type'] == 'new_sale') {
            // Fallback for new sale notifications without URL
            return redirect()->route('admin.sales.show', $data['sale_id']);
        } elseif ($data['type'] == 'sale_verified' || $data['type'] == 'sale_rejected') {
            // Redirect to sale details for store users
            return redirect()->route('toko.sales.show', $data['sale_id']);
        } elseif ($data['type'] == 'store_verification') {
            // Redirect to store dashboard
            return redirect()->route('toko.dashboard');
        } elseif ($data['type'] == 'points_earned') {
            // Redirect to points history
            return redirect()->route('toko.points.index');
        } else {
            // Default fallback
            return redirect()->route('notifications.index');
        }
    }
    /**
     * Delete all notifications for the authenticated user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteAll()
    {
        Auth::user()->notifications->each->delete();

        return redirect()->route('notifications.index')
            ->with('success', 'Semua notifikasi berhasil dihapus.');
    }
    /**
     * Delete a specific notification.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $notification = Auth::user()->notifications->where('id', $id)->first();

        if ($notification) {
            $notification->delete();
            return back()->with('success', 'Notifikasi berhasil dihapus.');
        }

        return back()->with('error', 'Notifikasi tidak ditemukan.');
    }
}
