<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Post extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $table = 'posts';

    protected $casts = [
        'published_at' => 'datetime:Y-m-d',
    ];

    protected $fillable = [
        'title',
        'cover_image',
        'slug',
        'body',
        'is_in_vault',
        'meta_description',
        'channel_id',
        'published_at',
        'notifiable',
        'author_id',
        'category_id',
    ];

    // protected function PublishedAt(): Attribute
    // {
    //     return Attribute::make(
    //         get: function ($value) {
    //             if ($value !== null) {
    //                 return Carbon::parse($value)->format('d-m-Y');
    //             }

    //             return 'Draft';
    //         },
    //         set: function ($value) {
    //             if ($value == 'Draft' or $value == '') {
    //                 return null;
    //             }

    //             return Carbon::parse($value)->format('Y-m-d  H:m:s');
    //         }
    //     );
    // }

    public function scopePublished($query)
    {
        return $query->where('published_at', '<', now());
    }

    public function getPublishedStatusAttribute($value)
    {
        if (! empty($this->published_at) && $this->published_at < now()) {
            return 'Published';
        }
        if ($this->published_at > now() | empty($this->published_at)) {
            return 'Draft';
        }
    }

    public function getTrimmedBodyAttribute($value)
    {
        return Str::words(strip_tags($this->body), 120);
    }

    public function getDisplayPublishedAtAttribute($value)
    {
        if ($this->published_at != null) {
            return $this->published_at->toFormattedDateString();
        }

        return '';
    }

    public function getWordcountAttribute($value)
    {
        $n = (str_word_count($this->body) / 200);
        $whole = floor($n);
        $fraction = $n - $whole;
        if (($whole + (round($fraction * 60) > 30 ? 1 : 0)) > 1) {
            return ' : '.($whole + (round($fraction * 60) > 30 ? 1 : 0)).' - min read.';
        } else {
            return;
        }
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }

    public function featuredUrl()
    {
        return $this->featured_image
        ? Storage::disk('s3')->url($this->featured_image)
        : '';
    }

    // Media Definitions
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(200)
            ->height(200)
            ->sharpen(10);

        $this->addMediaConversion('full')
            ->width(800)
            ->height(800)
            ->sharpen(10);
    }

    /*
    *       Relationships
    */

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->BelongsTo(Category::class);
    }

    public function channel(): BelongsTo
    {
        return $this->BelongsTo(Channel::class);
    }

    public function siteUpdates(): BelongsToMany
    {
        return $this->BelongsToMany(SiteUpdate::class, 'post_site_update');
    }

    public function tags(): HasMany
    {
        return $this->HasMany(Tag::class, 'post_tag');
    }
}
