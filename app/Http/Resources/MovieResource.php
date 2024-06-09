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
			$this->mergeWhen($request->route()->getName() === 'movies.index', [
				'title'                   => $this->title,
				'director'                => $this->director,
			]),
			'poster'                  => $posterUrl,
			'quotes_count'            => $this->quotes()->count(),
			'year'                    => $this->year,
			'genres'                  => GenreResource::collection($this->genres),
			$this->mergeWhen($request->route()->getName() === 'movies.show', [
				'title'                   => $this->title,
				'quotes'                  => QuoteResource::collection($this->quotes),
				'description'             => $this->description,
				'budget'                  => $this->budget,
			]),
			$this->mergeWhen($request->route()->getName() === 'movies.edit', [
				'title'                    => [
					'en' => $this->getTranslation('title', 'en'),
					'ka' => $this->getTranslation('title', 'ka'),
				],
				'description'                    => [
					'en' => $this->getTranslation('description', 'en'),
					'ka' => $this->getTranslation('description', 'ka'),
				],
				'director'                    => [
					'en' => $this->getTranslation('director', 'en'),
					'ka' => $this->getTranslation('director', 'ka'),
				],
				'budget'                  => $this->budget,
				'genres'                  => GenreResource::collection($this->genres),
			]),
		];
	}
}
