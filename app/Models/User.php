<?php

namespace App\Models;

use App\Notifications\PasswordResetNotification;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
	use HasFactory;

	use Notifiable;

	protected $guarded = ['id'];

	protected $hidden = [
		'password',
		'remember_token',
	];

	protected function casts(): array
	{
		return [
			'email_verified_at' => 'datetime',
			'password'          => 'hashed',
		];
	}

	public function sendPasswordResetNotification($token): void
	{
		$url = config('app.frontend_url') . '/landing?email=' . $this->email . '&token=' . $token;

		$this->notify(new PasswordResetNotification($url));
	}

	public function movies(): HasMany
	{
		return $this->hasMany(Movie::class);
	}

	public function quotes(): HasMany
	{
		return $this->hasMany(Quote::class);
	}

	public function comments(): HasMany
	{
		return $this->hasMany(Comment::class);
	}

	public function receivedNotifications(): HasMany
	{
		return $this->hasMany(Notification::class, 'receiver_id');
	}

	public function sentNotifications(): HasMany
	{
		return $this->hasMany(Notification::class, 'sender_id');
	}
}
