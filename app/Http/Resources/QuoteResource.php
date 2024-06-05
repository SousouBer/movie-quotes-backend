<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuoteResource extends JsonResource
{
	public function toArray(Request $request): array
	{
		$pictureUrl = $this->picture;

		if (str_starts_with($this->picture, '/tmp')) {
			$pictureUrl = $this->getFirstMediaUrl('pictures');
		}

		return [
			'id'                            => $this->id,
			'quote'                         => $this->quote,
			'picture'                       => $pictureUrl,
			'likes_count'                   => $this->likes()->count(),
			'comments_count'                => $this->comments()->count(),
			'movie'                         => [
				'id'    => $this->movie->id,
				'title' => $this->movie->title,
				'year'  => $this->movie->year,
			],
			'quote_author'                  => UserResource::make($this->user),
			'comments'                      => CommentResource::collection($this->comments),
		];
	}
}
