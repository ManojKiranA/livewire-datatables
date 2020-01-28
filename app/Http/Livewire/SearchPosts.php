<?php

namespace App\Http\Livewire;

use App\Contact;
use Illuminate\Http\Request;
use Livewire\Component;

class SearchPosts extends Component
{
    public $search;
    public $pagination;

    protected $updatesQueryString = ['search','pagination'];

    public function mount(Request $request)
    {
        $this->search = $request->query('search', $this->search);
        $this->pagination = $request->query('pagination', $this->pagination);
    }

    public function render()
    {
        return view('livewire.search-posts', [
            'posts' => Contact::query()
                        ->when($this->search,function($query){
                            $query->where('name', 'like', '%'.$this->search.'%')
                            ->take(20);
                        })
                        ->get(),
        ]);
    }
}
