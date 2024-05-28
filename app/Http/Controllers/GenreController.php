<?php

namespace App\Http\Controllers;

use App\Http\Resources\GenreResource;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GenreController extends Controller
{
	public function index(Request $request): AnonymousResourceCollection
	{
		return GenreResource::collection(Genre::all());
	}
}
