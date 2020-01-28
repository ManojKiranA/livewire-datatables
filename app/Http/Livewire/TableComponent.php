<?php
namespace App\Http\Livewire;

use Livewire\Component;

class TableComponent extends Component
{
    protected function getPaginationListProperty(): array
    {
        return [
            5,
            10,
            20,
            30,
            50,
            100,
            150,
            200,
            300
        ];
    }
}