<?php

namespace App\Http\Livewire;

use App\Contact;
use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;

class ContactsTableComponent extends TableComponent
{
    use WithPagination;

    public $search;

    public $pageLength;


    public $readyToLoadContacts = false;

    public function loadContacts()
    {
        $this->readyToLoadContacts = true;
    }

    public function updating($name, $value)
    {
        $this->readyToLoadContacts = false;
        //list of Property changes in which that
        //page number needs to be set to 
        //first page

        $changePagintionToOne = [
            'search',
            'pageLength',
        ];
            if(in_array($name,$changePagintionToOne)):
                    $this->gotoPage(1);
            endif;
        $this->readyToLoadContacts = true;
    }    

    public function render()
    {
        // logger()->info(request()->all());        

        $contactObject = (new Contact);

        if(! $this->pageLength)
        {
            $this->pageLength = $contactObject->getPerPage();
        }

        $search = $this->search;

        $contacts = $this->readyToLoadContacts ?  Contact::query()
                            ->when($this->search,function(Builder $builder) use ($search){
                                return $builder->where('name','LIKE','%'.$search.'%')
                                        ->orWhere('email','LIKE','%'.$search.'%');
                            })
                            ->paginate($this->pageLength)
                             : 
                             [];
                        
        return view('livewire.contacts-table-component',compact('contacts'));
    }
}
