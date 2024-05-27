<?php

namespace App\Http\Controllers;

use App\Http\Resources\MovieResource;
use App\Models\Movie;

class MovieController extends Controller
{
	public function show(Movie $movie): MovieResource
	{
		return MovieResource::make($movie);
	}
}
