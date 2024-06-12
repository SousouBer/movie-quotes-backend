<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('notification', function () {
	return true;
});
