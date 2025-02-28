<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class Tag extends Model
{
    use HasFactory;

    protected $table = 'tags';

    protected $fillable = ['name', 'slug'];

    /*
    *       Relationships
    */

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }
}
