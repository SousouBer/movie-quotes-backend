<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\EmailVerificationNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmailVerificationNotification implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	protected $user;

	protected $verificationUrl;

	public function __construct(User $user, string $verificationUrl)
	{
		$this->user = $user;
		$this->verificationUrl = $verificationUrl;
	}

	public function handle(): void
	{
		$this->user->notify(new EmailVerificationNotification($this->verificationUrl));
	}
}
