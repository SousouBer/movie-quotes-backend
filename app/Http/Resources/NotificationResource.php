<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class NotificationResource extends JsonResource
{
	public function toArray(Request $request): array
	{
		$authorAvatarUrl = $this->sender->avatar;

		if (!str_starts_with($this->sender->avatar, 'https')) {
			if ($this->sender->avatar && Storage::disk('public')->exists($this->sender->avatar)) {
				$authorAvatarUrl = asset('storage/' . $this->sender->avatar);
			} else {
				$authorAvatarUrl = asset($this->sender->avatar);
			}
		}

		return [
			'id'               => $this->id,
			'quote_id'         => $this->quote_id,
			'author_avatar'    => $authorAvatarUrl,
			'author_username'  => $this->sender->username,
			'like_received'    => $this->whenNotNull($this->like_received !== null ? __('general.like_created') : null),
			'comment_received' => $this->when($this->comment_received !== null, __('general.comment_created')),
			'is_read'          => $this->when($this->is_read, $this->is_read !== 0),
			'time_created'     => $this->created_at,
		];
	}
}
