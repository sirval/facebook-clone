<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserPostReactionNotification extends Notification
{
    use Queueable;

    public readonly string $name;
    public readonly string $email;
    public  string $type;
    public readonly string $time;
    public readonly string $content;
    public readonly string $postOwner;
    /**
     * Create a new notification instance.
     */
    public function __construct(string $name, string $email, string $type, string $time, string $content, string $postOwner)
    {
        $this->name = $name;
        $this->email = $email;
        $this->type = $type;
        $this->time = $time;
        $this->content = $content;
        $this->postOwner = $postOwner;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        if (Auth::id() == $this->postOwner) {
           $pronoun = "You";
        }else {
            $pronoun = $this->name;
        }
        if ($this->type == 'comment') {
            $message = "{$pronoun} commented on your post";
        }
        if ($this->type == 'liked'){
            $message = "{$pronoun} liked your post";
        }
        if ($this->type == 'unliked'){
            $message = "{$pronoun} unliked your post";
        }
        return (new MailMessage)
                    ->subject($message.' '.$this->time)
                    ->line(Str::limit($this->content, 30, '...'))
                    ->action('Read More', url('/home'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

}
