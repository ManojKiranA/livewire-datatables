<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;

class DepandDropDown extends Component
{

    public $startingAlphabet;

    public $nameOfCountry;

    public function getAlphabetListProperty()
    {
        $alphabetRange = range('A', 'Z');

        return collect($alphabetRange)->combine($alphabetRange)->toArray();
    }

    public function getNameListProperty()
    {
        if($this->startingAlphabet){
            return collect(json_decode(file_get_contents('https://restcountries.eu/rest/v2/all'),true))
                        ->pluck('name')
                        ->filter(function($value){
                            return Str::startsWith($value,$this->startingAlphabet);
                        })->toArray();
        }else{
            return [];
        }
        
    
    }

    public function render()
    {
        return view('livewire.depand-drop-down');
    }
}
