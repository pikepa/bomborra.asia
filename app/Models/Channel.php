<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Channel extends Model
{
    use HasFactory;

    protected $table = 'channels';

    protected $fillable = ['name', 'slug', 'status', 'sort'];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function getDisplayStatusAttribute($status)
    {
        if ($this->status === true) {
            return 'Active';
        }

        return 'Inactive';
    }

    // Model Relationships
    public function posts(): HasMany
    {
        return $this->HasMany(Post::class);
    }
}
