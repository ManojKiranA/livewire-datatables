<div>
    <input 
    wire:model.lazy.debounce.1s="websiteHost" 
    type="text" 
    placeholder="Enter Host">

    @if (!is_array($webSiteSSLInformation))
        {{$webSiteSSLInformation}}
    @elseif(is_array($webSiteSSLInformation))
    <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Heading</th>
            <th scope="col">Value</th>
          </tr>
        </thead>
        <tbody>
            
            @foreach ($webSiteSSLInformation as $sslHead => $sslValue)

            <tr>
                <th scope="row">{{$loop->iteration}}</th>
                <td>{{$sslHead}}</td>
                @if (!is_array($sslValue))
                    <td>{{$sslValue}}</td>
                @elseif(is_array($sslValue))
                    <td>{{implode(',',$sslValue)}}</td>
                @endif
              </tr>
            @endforeach
        </tbody>
    </table>
    @endif    
</div>
