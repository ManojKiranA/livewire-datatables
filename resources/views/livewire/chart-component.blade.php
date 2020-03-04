{{-- <div>
    <style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>  
    <section class="content">
       <div class="container-fluid p-0">
          <div class="card card-default">
             <div class="card-body">
                   <hr>
                   <div class="row">
                      <div class="col-md-3 form-group">
                         <label for="crud_id" class="control-label">List of Tables</label> 
                         {!! Form::select('table_names', $this->tablesList, null, ['class' => 'form-control',"wire:model" => "selectedTable"]) !!}
                      </div>
                      
                      <div id="aggregate_function_div" class="col-md-3 form-group">
                         <label for="aggregate_function" class="control-label">
                             {!! $selectedTable ?  "Columns for Table <b>{$selectedTable}</b>" : "Columns"!!}
                        </label> 
                         {!! Form::select('table_name_columns', $this->tableColumns, null, ['class' => 'form-control',"wire:model" => "selectedTableColumns" ,'multiple' => true]) !!}
                      </div>

                      <div class="col-md-3 form-group">
                        <label class="switch"> Show Serial Number
                            {!! Form::checkbox('showSerialNumber', null, $showSerialNumber, ['wire:model' => "showSerialNumber"]) !!}
                            <span class="slider round"></span>
                          </label>
                      </div>
                      @if ($tableData)
                        <div class="col form-inline">
                          Per Page: &nbsp;
                          <select wire:model="perPage" class="form-control">
                              @foreach ($this->paginationList as $eachItem)
                              <option>{{$eachItem}}</option>
                              @endforeach
                          </select>
                        </div>
                      @endif
                   </div>
             </div>
          </div>
       </div>
        @if ($tableData)
        
            <table class="table table-bordered">
                <thead>
                <tr>
                    @if ($showSerialNumber)
                        <th scope="col">#</th>
                    @endif
                    @foreach ($selectedTableColumns as $eachColumnNames)
                        <td>{{$eachColumnNames}}</td>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                    @if ($showSerialNumber)
                        @foreach ($tableData as $eachRecord)
                        <tr>
                            <th scope="row">{{$tableData->firstItem() + $loop->index}}</th>
                            @foreach ($selectedTableColumns as $eachColumnNames)
                                <td>{{Str::limit(data_get($eachRecord,$eachColumnNames),100)}}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    @else
                    @foreach ($tableData as $eachRecord)
                        <tr>
                            @foreach ($selectedTableColumns as $eachColumnNames)
                                <td>{{Str::limit(data_get($eachRecord,$eachColumnNames),100)}}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            {{$tableData->links()}}
            
        @endif

    </section>
 </div> --}}

 <div>
  {{$chartObject->container()}}
  {!! $chartObject->script() !!}
 </div>