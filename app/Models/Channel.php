<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Channel extends Model
{
    use HasFactory;

    protected $table = 'channels';

    protected $fillable = ['name', 'slug', 'status', 'sort'];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function getDisplayStatusAttribute($status)
    {
        if ($this->status == true) {
            return 'Active';
        } else {
            return 'Inactive';
        }
    }

    //Model Relationships
    public function posts(): HasMany
    {
        return $this->HasMany(Post::class);
    }
}
