<?php

namespace App\Http\Livewire;

use App\Contact;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Illuminate\Support\Str;

class AutoCompleteComponent extends Component
{
    // protected $search;

    public $search;

    public $results;

    protected $user;

    public function fooBar()
    {
        Log::info('hai');
    }

    public function mount($user = null)
    {
        $this->user = $user;
    }

    public function render()
    {

        if($this->search){

            $searchWord = $this->search;

            $count = 3;
            
            if(Str::contains($searchWord,':')){
                [$searchWord,$count] = explode(':',$searchWord);

                if($count === ''){
                    $count = 3;
                }
            }
            
            $users = Contact::query()
                ->where('name','LIKE','%'.$searchWord.'%')
                ->orWhere('email','LIKE','%'.$searchWord.'%')
                ->take($count)
                ->get()
                ->map(function($eachContact) use ($searchWord){
                    return $this->highlightStringInParagraph($eachContact->name.' ('.$eachContact->email .')',$searchWord,'red');
                });
                
                if($users->isNotEmpty()):
                    $this->results = $users->toArray();
                endif;

                if($users->isEmpty()):
                    $this->results = 'No Records To Show';
                endif;
        }else{
            $this->results = null;
        }

        return view('livewire.auto-complete-component');
    }

    public  function highlightStringInParagraph(string $paragraphText, $highlightWords,$highlightColor='red')
    {
        if (is_array($highlightWords)) 
        {
            foreach($highlightWords as $highlightWord)
            {
                $paragraphText = preg_replace(
                    "|($highlightWord)|Ui" ,
                    "<span style=\"color:".$highlightColor. ";\"><b>$1</b></span>" ,
                    $paragraphText 
                );
            }
        }
        elseif (!is_array($highlightWords)) 
        {
           
            $paragraphText = preg_replace(
                    "|($highlightWords)|Ui" ,
                    "<span style=\"color:".$highlightColor. ";\"><b>$1</b></span>" ,
                    $paragraphText 
                );
        }
        return $paragraphText;
    }
}
