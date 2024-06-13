<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('notification.{id}', function (User $user, int $id) {
	return true;
});
