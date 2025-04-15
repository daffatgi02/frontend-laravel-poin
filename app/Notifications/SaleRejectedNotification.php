<?php

namespace App\Notifications;

use App\Models\Sale;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SaleRejectedNotification extends Notification
{
    use Queueable;

    protected $sale;
    protected $reason;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Sale $sale, $reason = null)
    {
        $this->sale = $sale;
        $this->reason = $reason;
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
            'reason' => $this->reason,
            'message' => "Penjualan {$this->sale->product->nama_produk} ({$this->sale->jumlah} pcs) telah ditolak" . ($this->reason ? ": {$this->reason}" : "."),
            'type' => 'sale_rejected'
        ];
    }
}
