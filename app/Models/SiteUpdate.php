<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SiteUpdate extends Model
{
    use HasFactory;

    const STATUSES = [
        'Draft' => 'Draft',
        'Submitted' => 'Submitted',
        'Sent' => 'Sent',
    ];

    protected $casts = ['date' => 'date'];

    protected $guarded = [];

    public function getDateForHumansAttribute()
    {
        return $this->date->format('M d, Y');
    }

    public function getStatusColorAttribute()
    {
        return
        [
            'Draft' => 'indigo',
            'Sent' => 'green',
        ][$this->status] ?? 'cool-gray';
    }

    public function posts(): BelongsToMany
    {
        return $this->BelongsToMany(Post::class, 'post_site_update');
    }
}
