<?php

namespace App\Notifications;

use App\Models\Sale;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SaleVerifiedNotification extends Notification
{
    use Queueable;

    protected $sale;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Sale $sale)
    {
        $this->sale = $sale;
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
            'sale_id' => $this->sale->id_penjualan,
            'product_name' => $this->sale->product->nama_produk,
            'quantity' => $this->sale->jumlah,
            'message' => "Penjualan {$this->sale->product->nama_produk} ({$this->sale->jumlah} pcs) telah diverifikasi.",
            'type' => 'sale_verified'
        ];
    }
}
