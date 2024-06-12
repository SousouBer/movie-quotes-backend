<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLikeRequest;
use App\Http\Requests\StoreQuoteRequest;
use App\Http\Requests\UpdateQuoteRequest;
use App\Http\Resources\QuoteResource;
use App\Models\Like;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class QuoteController extends Controller
{
	public function index(): AnonymousResourceCollection
	{
		$quotes = Quote::orderBy('created_at', 'desc')->get();

		return QuoteResource::collection($quotes);
	}

	public function show(Quote $quote): QuoteResource
	{
		return QuoteResource::make($quote);
	}

	public function store(StoreQuoteRequest $request): JsonResponse
	{
		$quoteDetails = $request->validated();

		$quote = Quote::create($quoteDetails);

		if ($request->hasFile('picture')) {
			$quote->addMediaFromRequest('picture')->toMediaCollection('pictures');
		}

		$quote->user()->associate($quoteDetails['user_id']);
		$quote->movie()->associate($quoteDetails['movie_id']);

		return response()->json(['message' => 'Quote added successfully'], 201);
	}

	public function edit(Quote $quote): QuoteResource
	{
		return QuoteResource::make($quote);
	}

	public function update(UpdateQuoteRequest $request, Quote $quote): JsonResponse
	{
		$updatedQuoteDetails = $request->validated();

		if ($request->hasFile('picture')) {
			$quote->clearMediaCollection('pictures');

			$quote->addMediaFromRequest('picture')->toMediaCollection('pictures');
		}

		$quote->update($updatedQuoteDetails);

		return response()->json(['message' => 'Quote updated successfully'], 201);
	}

	public function like(StoreLikeRequest $request): QuoteResource
	{
		$userId = $request->validated()['user_id'];
		$quoteId = $request->validated()['quote_id'];

		$existingLike = Like::where([['user_id', $userId], ['quote_id', $quoteId]])->first();

		if ($existingLike) {
			$existingLike->delete();
		} else {
			$like = Like::create($request->validated());

			$like->save();
		}

		return QuoteResource::make(Quote::findOrFail($request->input('quote_id')));
	}

	public function destroy(Quote $quote): JsonResponse
	{
		$quote->delete();

		return response()->json(['message' => 'Quote deleted successfully'], 200);
	}
}
