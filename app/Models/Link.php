<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Link extends Model
{
    use HasFactory;

    protected $table = 'links';

    protected $casts = [
        'published_at' => 'date',
    ];

    protected $fillable = [
        'title',
        'url',
        'owner_id',
        'position',
        'sort',
        'status',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(
            related: User::class,
            foreignKey: 'owner_id',
        );
    }
}
