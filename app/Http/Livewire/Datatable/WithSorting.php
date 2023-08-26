<?php

namespace app\Http\Livewire\Datatable;

trait WithSorting
{
    public $sortDirection = 'desc';

    public $sortField;

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function applySorting($query)
    {
        return $query->orderby($this->sortField, $this->sortDirection);
    }
}
