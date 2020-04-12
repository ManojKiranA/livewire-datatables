<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;

class DateTimeFormatCheck extends Component
{
    public $dateTime;

    public function updated($field)
    {
        // dd($this->dateTime,Carbon::parse($this->dateTime));
        $this->validateOnly($field, [
            'dateTime' => 'date_format:Y-m-d H:i:s',
        ]);
    }

    public function render()
    {
        return view('livewire.date-time-format-check');
    }
}
