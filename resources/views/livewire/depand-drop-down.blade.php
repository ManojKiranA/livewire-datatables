<div>
    {!! Form::select('startingAlphabet', $this->alphabetList, null, ['wire:model' => 'startingAlphabet','class' => 'form-control', 'placeholder' => 'Choose Any Alphabet' ]) !!}
    <br>
    {!! Form::select('nameList', $this->nameList, $nameOfCountry, ['wire:model' => 'nameOfCountry','class' => 'form-control', ! $startingAlphabet ? 'disabled' : '' , 'placeholder' => ! $startingAlphabet ? 'Choose Alphabet First' : ' You Can Select Country' ]) !!}
</div>
