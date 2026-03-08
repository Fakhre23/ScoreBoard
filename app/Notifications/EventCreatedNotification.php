<?php

namespace App\Notifications;

use App\Models\Event;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventCreatedNotification extends Notification
{

    protected $event;

    /**
     * Create a new notification instance.
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Event: ' . $this->event->title)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('A new event has been created: **' . $this->event->title . '**')
            ->line('Description: ' . $this->event->description)
            ->line('Location: ' . $this->event->location)
            ->line('Start: ' . $this->event->start_datetime)
            ->line('End: ' . $this->event->end_datetime)
            ->action('View Event', url('/events/' . $this->event->id))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification for database.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'event_id' => $this->event->id,
            'event_title' => $this->event->title,
            'message' => "New event created: {$this->event->title}",
            'type' => 'event_created',
            'created_at' => now(),
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'event_id' => $this->event->id,
            'event_title' => $this->event->title,
            'message' => "New event created: {$this->event->title}",
        ];
    }
}
