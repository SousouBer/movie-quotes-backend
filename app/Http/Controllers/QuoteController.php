<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuoteResource;
use App\Models\Quote;

class QuoteController extends Controller
{
	public function show(Quote $quote): QuoteResource
	{
		return QuoteResource::make($quote);
	}
}
