<?php

namespace App\Http\Controllers;

use App\Events\userNotification;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\QuoteResource;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\Quote;

class CommentController extends Controller
{
	public function store(StoreCommentRequest $request): QuoteResource
	{
		Comment::create($request->validated());

		$updatedQuote = Quote::findOrFail($request->input('quote_id'));

		$newNotification = Notification::create([
			'quote_id'         => $updatedQuote->id,
			'receiver_id'      => $updatedQuote->user->id,
			'sender_id'        => $request->validated()['user_id'],
			'is_read'          => false,
			'comment_received' => true,
		]);

		userNotification::dispatch(NotificationResource::make($newNotification));

		return QuoteResource::make($updatedQuote);
	}
}
