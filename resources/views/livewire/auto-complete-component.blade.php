<span>
    {{-- Success is as dangerous as failure. --}}
    <style>        
        /*the container must be positioned relative:*/
        .autocomplete {
          position: relative;
          display: inline-block;
        }
        
        
        
        
        .autocomplete-items {
          position: absolute;
          border: 1px solid #d4d4d4;
          border-bottom: none;
          border-top: none;
          z-index: 99;
          /*position the autocomplete items to be the same width as the container:*/
          top: 100%;
          left: 0;
          right: 0;
        }
        
        .autocomplete-items div {
          padding: 10px;
          cursor: pointer;
          background-color: #fff; 
          border-bottom: 1px solid #d4d4d4; 
        }
        
        /*when hovering an item:*/
        .autocomplete-items div:hover {
          background-color: #e9e9e9; 
        }
        
        /*when navigating through the items using the arrow keys:*/
        .autocomplete-active {
          background-color: DodgerBlue !important; 
          color: #ffffff; 
        }
        </style>
        </head>     
        <body>
    
        
        <h4>Livewire AutoComplete</h4>
        
        <!--Make sure the form has the autocomplete function switched off:-->
          <div class="autocomplete" style="width:700px;">
            <input 
                id="search" 
                type="text" 
                placeholder="Contacts" 
                class="form-control" 
                wire:model.debounce.200ms='search'>
            
            @if($this->results)
            
            <div class="autocomplete-items">
                @if(is_array($this->results))
                    @foreach ($this->results as $eachContact)
                    <div>
                        {!! $eachContact !!}
                        {{-- <input type="hidden" value="Denmark"> --}}
                    </div>    
                    @endforeach
                @else
                    <div>{{$this->results}}</div>
                @endif
             </div>
             @endif
          </div>
       <button wire:click='fooBar'>Test</button> 
</span>
