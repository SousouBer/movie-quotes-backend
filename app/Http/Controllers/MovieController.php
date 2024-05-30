<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MovieController extends Controller
{
	public function index(): AnonymousResourceCollection
	{
		return MovieResource::collection(Movie::all());
	}

	public function show(Movie $movie): MovieResource
	{
		return MovieResource::make($movie);
	}

	public function store(StoreMovieRequest $request): JsonResponse
	{
		$movie = Movie::create($request->validated());

		if ($request->hasFile('poster')) {
			$movie->addMediaFromRequest('poster')->toMediaCollection('posters');
		}

		return response()->json(['message' => 'Movie added successfully'], 201);
	}
}
