<?php

namespace App\Traits;

trait LivewireSortable
{
    public $sortField;

    public $sortDirection;

    public function sortItems($field)
    {
        if (method_exists($this, 'resetPage')) {
            $this->resetPage();
        }

        if ($this->sortField === $field) {
            if ($this->sortDirection === 'asc') {
                $this->sortDirection = 'desc';
            } else {
                $this->sortField = null;
                $this->sortDirection = null;
            }

            return;
        }

        $this->sortField = $field;
        $this->sortDirection = 'asc';
    }
}
