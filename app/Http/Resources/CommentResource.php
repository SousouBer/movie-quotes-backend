<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
	public function toArray(Request $request): array
	{
		return [
			'id'      => $this->id,
			'author'  => UserResource::make($this->user),
			'comment' => $this->comment,
		];
	}
}
