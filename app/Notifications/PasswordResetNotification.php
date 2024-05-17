<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class sendPasswordResetNotification extends Notification
{
	use Queueable;

	protected $resetPasswordUrl;

	public function __construct(string $resetPasswordUrl)
	{
		$this->resetPasswordUrl = $resetPasswordUrl;
	}

	public function via(object $notifiable): array
	{
		return ['mail'];
	}

	public function toMail(object $notifiable): MailMessage
	{
		return (new MailMessage)->subject('Reset your password')->view('password-reset', ['resetPasswordUrl' => $this->resetPasswordUrl, 'username' => $notifiable->username]);
	}

	public function toArray(object $notifiable): array
	{
		return [
		];
	}
}
