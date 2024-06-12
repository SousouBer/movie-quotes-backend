<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class NotificationResource extends JsonResource
{
	public function toArray(Request $request): array
	{
		$authorAvatarUrl = $this->avatar;

		if (!str_starts_with($this->avatar, 'https')) {
			if ($this->avatar && Storage::disk('public')->exists($this->avatar)) {
				$avatarUrl = asset('storage/' . $this->avatar);
			} else {
				$avatarUrl = asset($this->avatar);
			}
		}

		return [
			'id'               => $this->id,
			'quote_id'         => $this->quote_id,
			'author_avatar'    => $authorAvatarUrl,
			'like_received'    => $this->when($this->like_received !== false, __('general.like_created')),
			'comment_received' => $this->when($this->comment_received !== false, __('general.comment_created')),
			'is_read'          => $this->is_read,
			'time_created'     => $this->timestamps,
		];
	}
}
