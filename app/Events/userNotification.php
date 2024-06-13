<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class userNotification implements ShouldBroadcast
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	public $notification;

	public function __construct($notification)
	{
		$this->notification = $notification;
	}

	public function broadcastOn(): Channel
	{
		return new Channel('notification.' . $this->notification['receiver_id']);
	}
}
