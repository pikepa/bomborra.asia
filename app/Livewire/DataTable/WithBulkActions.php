<?php

namespace App\Livewire\DataTable;

trait WithBulkActions
{
    public $selectPage = false;

    public $selectAll = false;

    public $selected = [];

    public function updatedSelected()
    {
        $this->selectAll = false;
        $this->selectPage = false;
    }

    public function updatedSelectPage($value)
    {
        $this->selected = $value
            ? $this->selectPage
            : [];
    }

    public function selectPage()
    {
        $this->selected = $this->rows->pluck('id')->map(fn ($id) => (string) $id);
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
