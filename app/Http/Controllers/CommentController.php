<?php

namespace App\Http\Controllers;

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

		return QuoteResource::make($updatedQuote);
	}
}
