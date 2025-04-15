<?php

namespace App\Notifications;

use App\Models\Store;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class StoreVerificationNotification extends Notification
{
    use Queueable;

    protected $store;
    protected $status;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Store $store, $status)
    {
        $this->store = $store;
        $this->status = $status;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'store_id' => $this->store->id_toko,
            'store_name' => $this->store->nama_toko,
            'status' => $this->status,
            'message' => $this->status == 'verified'
                ? "Toko {$this->store->nama_toko} telah diverifikasi dan sekarang aktif."
                : "Toko {$this->store->nama_toko} telah ditolak. Silakan hubungi admin untuk informasi lebih lanjut.",
            'type' => 'store_verification'
        ];
    }
}
