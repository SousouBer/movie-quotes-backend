<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailVerificationNotification extends Notification implements ShouldQueue
{
	use Queueable;

	protected $verificationUrl;

	public function __construct(string $verificationUrl)
	{
		$this->verificationUrl = explode('/email-verify/', $verificationUrl)[1];
	}

	public function via(object $notifiable): array
	{
		return ['mail'];
	}

	public function toMail(object $notifiable): MailMessage
	{
		return (new MailMessage)->subject('Please verify your email address')->view('email-verification', ['verificationUrl' => $this->verificationUrl, 'username' => $notifiable->username, 'email' => $notifiable->email]);
	}

	public function toArray(object $notifiable): array
	{
		return [
		];
	}
}
