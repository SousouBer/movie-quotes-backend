<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuoteResource;
use App\Models\Quote;
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
}
