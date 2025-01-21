<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiteUpdate extends Model
{
    use HasFactory;

    const STATUSES = [
        'Draft' => 'Draft',
        'Submitted' => 'Submitted',
        'Sent' => 'Sent',
    ];

    protected $casts = ['update_date' => 'date'];

    protected $guarded = [];

    public function scopeFiltertitle($query, $text = '')
    {
        return $query->whereHas('post', function ($q) use ($text): void {
            $q->where('title', 'LIKE', '%'.$text.'%');
        });
    }

    public function getDateForHumansAttribute()
    {
        return $this->update_date->format('M d, Y');
    }

    public function getStatusColorAttribute()
    {
        return
        [
            'Draft' => 'indigo',
            'Sent' => 'green',
        ][$this->status] ?? 'cool-gray';
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
