<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RestaurantCreated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $password;

    /**
     * Create a new notification instance.
     *
     * @param $user
     * @param $password
     */
    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
                    ->subject('Welcome to Our Platform')
                    ->greeting('Hello ' . $this->user->name . ',')
                    ->line('Your restaurant has been successfully registered.')
                    ->line('Here are your login credentials:')
                    ->line('Email: ' . $this->user->email)
                    ->line('Password: ' . $this->password)
                    ->line('Please change your password after logging in.')
                    ->action('Login', url('/login'))
                    ->line('Thank you for joining us!');
    }
}