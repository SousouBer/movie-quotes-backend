<?php

namespace App\Http\Controllers;

use App\Events\userNotification;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\QuoteResource;
use App\Models\Comment;
use App\Models\Quote;

class CommentController extends Controller
{
	public function store(StoreCommentRequest $request): QuoteResource
	{
		Comment::create($request->validated());

		$updatedQuote = Quote::findOrFail($request->input('quote_id'));

		// I will also change this data, and create table for notifications in the next branch.
		$notification = [
			'comment_author_id' => $request->validated()['user_id'],
			'quote_author_id'   => $updatedQuote->user->id,
			'message'           => 'Your quote has been commented!',
		];

		userNotification::dispatch($notification);

		return QuoteResource::make($updatedQuote);
	}
}
