<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuoteResource extends JsonResource
{
	public function toArray(Request $request): array
	{
		return [
			'id'             => $this->id,
			'quote'          => $this->quote,
			'picture'        => $this->picture,
			'likes_count'    => $this->likes()->count(),
			'comments_count' => $this->comments()->count(),
			$this->mergeWhen($request->route()->getName() === 'quotes.show', [
				'quote_author'                  => $this->user,
				'comments'                      => $this->comments(),
			]),
		];
	}
}
