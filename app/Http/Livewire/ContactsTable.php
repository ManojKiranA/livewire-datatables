<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class ContactsTable extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $sortField;
    public $sortAsc = true;
    public $search = '';

    /**
     * Length(s) of Pagination to Be Displayed.
     *
     * @var array
     */
public $paginationList = [5, 10, 15,25, 50, 75, 100, 300, 500];

public function updatingPerpage($pageNumber)
{
    logger()->info($pageNumber);
}

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = ! $this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function render()
    {
        $contacts = \App\Contact::search($this->search)
        ->when($this->sortField,function($query){
            return $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
        })
        ->paginate($this->perPage);
        
        // logger()->info($contacts->toArray());
        return view('livewire.contacts-table', [
            'contacts' => $contacts,
        ]);
    }
}
