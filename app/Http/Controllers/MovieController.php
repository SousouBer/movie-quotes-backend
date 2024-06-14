<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
	public function index(): AnonymousResourceCollection
	{
		$user = Auth::user();

		$movies = $user->movies()->orderBy('created_at', 'desc')->get();

		return MovieResource::collection($movies);
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

	public function edit(Movie $movie): MovieResource
	{
		return MovieResource::make($movie);
	}

	public function update(UpdateMovieRequest $request, Movie $movie): JsonResponse
	{
		$updatedMovieDetails = $request->validated();

		$movie->update($updatedMovieDetails);

		$movie->genres()->sync($updatedMovieDetails['genres']);

		if ($request->hasFile('poster')) {
			$movie->clearMediaCollection('posters');

			$movie->addMediaFromRequest('poster')->toMediaCollection('posters');
		}

		return response()->json(['message' => 'Movie updated successfully'], 201);
	}

	public function destroy(Movie $movie): JsonResponse
	{
		$movie->delete();

		return response()->json(['message' => 'Movie deleted successfully'], 200);
	}
}
