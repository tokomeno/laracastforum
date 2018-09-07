<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
// use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ThreadWasUpdated extends Notification
{
    // use Queueable;
    protected $reply;
    protected $thread;
    protected $replyname = 'no name';
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($thread, $reply, $name)
    {
        $this->thread = $thread;
        $this->reply = $reply; 
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
            'message' => $this->reply->owner->name . ' replited to ' . $this->thread->title,
            'link' => $this->thread->path()
        ];
    }



 

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }


}
