<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
	public function index(Request $request): AnonymousResourceCollection
	{
		$userNotifications = $request->user()->receivedNotifications()->orderBy('created_at', 'desc')->get();

		return NotificationResource::collection($userNotifications);
	}

	public function markRead(Notification $notification): JsonResponse
	{
		$notification->is_read = true;
		$notification->save();

		return response()->json(['message' => 'Notification read successfully'], 201);
	}

	public function markAllAsRead(): JsonResponse
	{
		$user = Auth::user();
		$user->receivedNotifications()->update(['is_read' => true]);

		return response()->json(['message' => 'Notifications read successfully'], 201);
	}
}
