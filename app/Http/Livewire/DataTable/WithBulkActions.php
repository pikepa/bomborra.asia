<?php

namespace App\Http\Livewire\DataTable;

trait WithBulkActions
{
    public $selectPage = false;

    public $selectAll = false;

    public $selected = [];

    public function updatedSelectPage($value)
    {
        $this->selected = $value
            ? $this->rows->pluck('id')->map(fn ($id) => (string) $id)
            : [];
    }

    public function updatedSelected()
    {
        $this->selectAll = false;
        $this->selectPage = false;
    }

    public function selectAll()
    {
        $this->selectAll = true;
    }

    public function getSelectedRowsQueryProperty()
    {
        return (clone $this->rowsQuery)
            ->unless($this->selectAll, fn ($query) => $query->whereKey($this->selected));
    }
}
