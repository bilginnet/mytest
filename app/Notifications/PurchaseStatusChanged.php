<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PurchaseStatusChanged extends Notification
{
    use Queueable;

    protected $purchase;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($purchase)
    {
        $this->purchase = $purchase;
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
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        switch ($this->purchase->status) {
            case 'started':
                $message = "Satın alma işlemi gerçekleşti. Uygulama: {$this->purchase->application_id}";
                break;
            case 'renewed':
                $message = "Daha önce satın alınmış uygulama için yenileme gerçekleşti. Uygulama: {$this->purchase->application_id}";
                break;
            case 'canceled':
                $message = "Satın almış olduğunuz uygulama için iptal işlemi gerçekleşti. Uygulama: {$this->purchase->application_id}";
                break;
        }

        $application = Application::findOrFail($this->purchase->application_id);
        return [
            'app_id' => $this->purchase->application_id,
            'uuid' => $application->uuid,
            'status' => $this->purchase->status,
            'message' => $message,
        ];
    }
}
