<?php

namespace App\Notifications;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewApplicationNotification extends Notification
{
    use Queueable;

    protected $application;

    public function __construct($job, $applicant)
    {
        $this->job = $job;
        $this->applicant = $applicant;
    }

    public function via($notifiable)
    {
        return ['database']; // You can add other channels as needed (e.g., 'mail', 'broadcast', etc.)
    }
    
    public function toDatabase($notifiable)
{
    $applicant = User::find($this->applicant)->first(); // Make sure to retrieve a single user

    if ($applicant) {
        return [
            'job_name' => $this->job->name,
            'applicant_name' => $applicant->name,
        ];
    }

    return [];
}




}