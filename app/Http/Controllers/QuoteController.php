<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequest;
use App\Http\Resources\QuoteResource;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class QuoteController extends Controller
{
	public function index(): AnonymousResourceCollection
	{
		return QuoteResource::collection(Quote::all());
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
}
