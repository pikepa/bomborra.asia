<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;

trait HasManageableDate
{
    public function scopeToday(Builder $query, string $column = 'created_at'): void
    {
        $query->whereDate($column, today());
    }

    public function scopeYesterday(Builder $query, string $column = 'created_at'): void
    {
        $query->whereDate($column, Carbon::yesterday());
    }

    public function scopeCurrentWeek(Builder $query, string $column = 'created_at'): void
    {
        $query->whereBetween($column, [now()->startOfWeek(), now()]);
    }

    public function scopeCurrentMonth(Builder $query, string $column = 'created_at'): void
    {
        $query->whereBetween($column, [now()->startOfMonth(), now()]);
    }

    public function scopeCurrentQuarter(Builder $query, string $column = 'created_at'): void
    {
        $query->whereBetween($column, [now()->startOfQuarter(), now()]);
    }

    public function scopeCurrentYear(Builder $query, string $column = 'created_at'): void
    {
        $query->whereBetween($column, [now()->startOfYear(), now()]);
    }

    public function scopeLast7Days(Builder $query, string $column = 'created_at'): void
    {
        $query->whereBetween($column, [today()->subDays(6), now()]);
    }

    public function scopeLast30Days(Builder $query, string $column = 'created_at'): void
    {
        $query->whereBetween($column, [today()->subDays(29), now()]);
    }

    public function scopeLast90Days(Builder $query, string $column = 'created_at'): void
    {
        $query->whereBetween($column, [today()->subDays(89), now()]);
    }

    public function scopePreviousWeek(Builder $query, string $column = 'created_at'): void
    {
        $query->whereBetween($column, [now()->startOfWeek()->subDays(7), now()->startOfWeek()]);
    }

    public function scopePreviousMonth(Builder $query, string $column = 'created_at'): void
    {
        $query->whereBetween($column, [now()->startOfMonth()->subMonth(), now()->startOfMonth()]);
    }

    public function scopePreviousQuarter(Builder $query, string $column = 'created_at'): void
    {
        $query->whereBetween($column, [now()->startOfQuarter()->subMonths(3), now()->startOfQuarter()]);
    }

    public function createdTimeDiff(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at->diffForHumans(),
        );
    }

    public function lastUpdatedTimeDiff(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at->diffForHumans(),
        );
    }
}
