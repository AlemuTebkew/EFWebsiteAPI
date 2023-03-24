<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ThanksNotification extends Notification
{
    use Queueable;



    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
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
            ->greeting('Dear Applicant:
                     Thank you for submitting your application to the EF Architect and Engineering Consulting PLC')
            ->line('Your application has been sent to our Human Resources department for review and consideration. Due to the large number of applications we receive, we are not available to discuss the role with applicants unless they are progressed to an active candidate.')

            ->line('We appreciate your interest in a career opportunity with the EF Architect and Engineering Consulting PLC')

            ->line('EF Architect and Engineering Consulting PLC Recruitment Team');
        // ->line('Your Reset code is '. $this->token);
    }
}
