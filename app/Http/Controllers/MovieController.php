<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
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
		$movieDetails = $request->validated();

		$movie = Movie::create($movieDetails);

		if ($request->hasFile('poster')) {
			$movie->addMediaFromRequest('poster')->toMediaCollection('posters');
		}

		$genreIds = $movieDetails['genres'];
		$movie->genres()->attach($genreIds);

		return response()->json(['message' => 'Movie added successfully'], 201);
	}

	public function update(UpdateMovieRequest $request, Movie $movie): JsonResponse
	{
		$updatedMovieDetails = $request->validated();

		$movie->update($updatedMovieDetails);

		return response()->json(['message' => 'Movie updated successfully'], 201);
	}
}
