<?php

namespace App\Notifications;

use App\Models\Point;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PointsEarnedNotification extends Notification
{
    use Queueable;

    protected $point;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Point $point)
    {
        $this->point = $point;
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
            'point_id' => $this->point->id,
            'points' => $this->point->points,
            'message' => "Anda mendapatkan {$this->point->points} poin dari {$this->point->description}.",
            'type' => 'points_earned'
        ];
    }
}
