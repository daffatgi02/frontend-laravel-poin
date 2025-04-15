<?php

namespace App\Notifications;

use App\Models\Sale;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewSaleNotification extends Notification
{
    use Queueable;

    protected $sale;
    protected $store;
    protected $product;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Sale $sale, Store $store, Product $product)
    {
        $this->sale = $sale;
        $this->store = $store;
        $this->product = $product;
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
            'store_id' => $this->store->id_toko,
            'store_name' => $this->store->nama_toko,
            'product_id' => $this->product->id_produk,
            'product_name' => $this->product->nama_produk,
            'quantity' => $this->sale->jumlah,
            'sale_date' => $this->sale->tanggal_penjualan,
            'message' => "Toko {$this->store->nama_toko} melaporkan penjualan {$this->product->nama_produk} ({$this->sale->jumlah} pcs) yang membutuhkan verifikasi.",
            'type' => 'new_sale',
            'url' => route('admin.sales.show', $this->sale->id_penjualan)
        ];
    }
}
