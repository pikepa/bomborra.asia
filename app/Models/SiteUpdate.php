<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SiteUpdate extends Model
{
    use HasFactory;

    protected $casts = ['date' => 'date'];

    public function getDateForHumansAttribute()
    {
        return $this->date->format('M d, Y');
    }

    public function posts(): BelongsToMany
    {
        return $this->BelongsToMany(Post::class, 'post_site_update');
    }
}
