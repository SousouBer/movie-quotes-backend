<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
	public function toArray(Request $request): array
	{
		$posterUrl = $this->poster;

		if (str_starts_with($this->poster, '/tmp')) {
			$posterUrl = $this->getFirstMediaUrl('posters');
		}

		return [
			'id'           => $this->id,
			'title'        => $this->title,
			'poster'       => $posterUrl,
			'quotes_count' => $this->quotes()->count(),
			'year'         => $this->year,
			$this->mergeWhen($request->route()->getName() === 'movies.show', [
				'director'                => $this->director,
				'genres'                  => GenreResource::collection($this->genres),
				'quotes'                  => QuoteResource::collection($this->quotes),
				'description'             => $this->description,
				'budget'                  => $this->budget,
			]),
		];
	}
}
