<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
	public function toArray(Request $request): array
	{
		$avatarUrl = $this->avatar;

		if (!str_starts_with($this->avatar, 'https')) {
			if ($this->avatar && Storage::disk('public')->exists($this->avatar)) {
				$avatarUrl = asset('storage/' . $this->avatar);
			} else {
				$avatarUrl = asset($this->avatar);
			}
		}

		return [
			'avatar'            => $avatarUrl,
			'username'          => $this->username,
			$this->mergeWhen($request->route()->getName() === 'user.show', [
				'is_google_account' => $this->whenNotNull($this->google_id),
				'email'             => $this->email,
			]),
			$this->mergeWhen($request->route()->getName() === 'movies.index', [
				'movies' => MovieResource::collection($this->movies),
			]),
		];
	}
}
