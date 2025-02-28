<?php

declare(strict_types=1);

namespace App\Livewire\DataTable;

trait WithSorting
{
    public $sortField;

    public $sortDirection = 'asc';

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field
            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
            : 'asc';

        $this->sortField = $field;
    }

    public function applySorting($query)
    {
        return $query->orderBy($this->sortField, $this->sortDirection);
    }
}
