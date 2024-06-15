<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;

class Quote extends Model implements HasMedia
{
	use HasFactory;

	use HasTranslations;

	use InteractsWithMedia;

	public $translatable = ['quote'];

	protected $guarded = ['id'];

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	public function movie(): BelongsTo
	{
		return $this->belongsTo(Movie::class);
	}

	public function comments(): HasMany
	{
		return $this->hasMany(Comment::class);
	}

	public function likes(): HasMany
	{
		return $this->hasMany(Like::class);
	}

	public function scopeSearch(Builder $query, string $search): Builder
	{
		$locale = App::getLocale();

		if (Str::startsWith($search, '#')) {
			$searchQuote = Str::substr($search, 1);

			if ($locale === 'en') {
				return $query->where('quote->en', 'like', '%' . $searchQuote . '%');
			} elseif ($locale === 'ka') {
				return $query->where('quote->ka', 'like', '%' . $searchQuote . '%');
			}
		} elseif (Str::startsWith($search, '@')) {
			$searchMovie = Str::substr($search, 1);

			return $query->whereHas('movie', function (Builder $query) use ($searchMovie, $locale) {
				if ($locale === 'en') {
					$query->where('title->en', 'like', '%' . $searchMovie . '%');
				} elseif ($locale === 'ka') {
					$query->where('title->ka', 'like', '%' . $searchMovie . '%');
				}
			});
		}
	}
}
