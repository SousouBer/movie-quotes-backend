<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NotificationController extends Controller
{
	public function index(Request $request): AnonymousResourceCollection
	{
		$userNotifications = $request->user()->receivedNotifications()->orderBy('created_at', 'desc')->get();

		return NotificationResource::collection($userNotifications);
	}
}
