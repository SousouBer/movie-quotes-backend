<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
	public function store(StoreCommentRequest $request): JsonResponse
	{
		Comment::create($request->validated());

		return response()->json((['message' => 'Comment added successfully']), 201);
	}
}
