<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ConvertCaseComponent extends Component
{
    public $textContent;

    public $characterCount = 0;

    public $wordCount = 0;

    public $lineCount = 0;
    
    public function updatesProperty()
    {
        $this->characterCount = strlen($this->textContent);
        $this->wordCount = str_word_count($this->textContent);

        $lineCount = count(explode("\n",$this->textContent));

        if($this->textContent && $lineCount === 0){
            $this->lineCount = 1;
        }else{
            $this->lineCount = $lineCount;
        }
    }
    /**
     * Clears the text Content
     *
     * @return void
     **/
    public function clear()
    {
        $this->updatesProperty();
        $this->textContent = null;
    }

    /**
     * Converts text to uppercase
     *
     * @return void
     **/
    public function upperCase()
    {
        $this->updatesProperty();
        $this->textContent = strtoupper($this->textContent);
    }

    /**
     * Converts text to lowercase
     *
     * @return void
     **/
    public function lowerCase()
    {
        $this->updatesProperty();
        $this->textContent = strtolower($this->textContent);
    }

    /**
     * Converts words to capitalize
     *
     * @return void
     **/
    public function capitalizedCase()
    {
        $this->updatesProperty();

        $this->textContent = collect(explode(" ",$this->textContent))
                                ->map(function($each){
                                    return ucfirst(strtolower($each));
                                })
                                ->implode(' ');
    }

    /**
     * Converts words to capitalize
     *
     * @return void
     **/
    public function sentenceCase()
    {
        $this->updatesProperty();

        $sentences = preg_split('/([.?!]+)/', $this->textContent, -1,PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE); 
        $newString = ''; 
        foreach ($sentences as $key => $sentence) { 
            $newString .= ($key & 1) == 0? 
                ucfirst(strtolower(trim($sentence))) : 
                $sentence.' '; 
        } 
        $newSentenceString =  trim($newString); 

        $this->textContent = $newSentenceString;
    }

    public function render()
    {
        $this->updatesProperty();

        return view('livewire.convert-case-component');
    }
}
