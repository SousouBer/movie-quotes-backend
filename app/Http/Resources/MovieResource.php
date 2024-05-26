<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
	public function toArray(Request $request): array
	{
		return [
			'id'           => $this->id,
			'title'        => $this->title,
			'poster'       => $this->poster,
			'quotes_count' => $this->quotes()->count(),
			'yeat'         => $this->year,
			$this->mergeWhen($request->route()->getName() === 'movies.show', [
				'director'                => $this->director,
				'genres'                  => $this->genres(),
				'description'             => $this->description(),
				'budget'                  => $this->budget,
			]),
		];
	}
}
