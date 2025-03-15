<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewTaskCreated extends Notification
{
    use Queueable;

    /**
     * Summary of model
     * @var mixed
     */
    protected $model;

    /**
     * Summary of event
     * @var mixed
     */
    protected $event;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($model, $event)
    {
        $this->model = $model;
        $this->event = $event;
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
        return [];
    }

    /**
     * Summary of toDatabase
     * @param mixed $notifiable
     * @return array<string>
     */
    public function toDatabase($notifiable)
    {
        return [
            'data' => auth()->user()->name . ' ' . $this->event . ' ' . $this->model->table . ' table data!'
        ];
    }
}
