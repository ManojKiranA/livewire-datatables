<div>
    <div class="row mb-4">
        <div class="col form-inline">
            Per Page: &nbsp;
            <select class="form-control" wire:model.debounce.1ms="pageLength">
                @foreach ($this->paginationList as $eachItem)
                <option>{{$eachItem}}</option>
                @endforeach
            </select>
        </div>

        <div class="col">
            <input 
            class="form-control" 
            type="text" 
            placeholder="Search Contacts..." 
            wire:model.debounce.300ms="search"
            >
        </div>
    </div>

    <table class="table table-bordered" wire:init="loadContacts">
        <thead>
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
          </tr>
        </thead>
        <tbody>
            @forelse ($contacts as $eachContact)
            <tr>
                    <td>{{$eachContact->name}}</td>
                    <td>{{$eachContact->email}}</td>
            </tr>
            @empty

            <tr>

                <tr>
                    <td colspan="2" style="text-align: center;">
                        {{-- <img alt="No Data" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjQiIGhlaWdodD0iNDEiIHZpZXdCb3g9IjAgMCA2NCA0MSIgIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CiAgPGcgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMCAxKSIgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIj4KICAgIDxlbGxpcHNlIGZpbGw9IiNGNUY1RjUiIGN4PSIzMiIgY3k9IjMzIiByeD0iMzIiIHJ5PSI3Ii8+CiAgICA8ZyBmaWxsLXJ1bGU9Im5vbnplcm8iIHN0cm9rZT0iI0Q5RDlEOSI+CiAgICAgIDxwYXRoIGQ9Ik01NSAxMi43Nkw0NC44NTQgMS4yNThDNDQuMzY3LjQ3NCA0My42NTYgMCA0Mi45MDcgMEgyMS4wOTNjLS43NDkgMC0xLjQ2LjQ3NC0xLjk0NyAxLjI1N0w5IDEyLjc2MVYyMmg0NnYtOS4yNHoiLz4KICAgICAgPHBhdGggZD0iTTQxLjYxMyAxNS45MzFjMC0xLjYwNS45OTQtMi45MyAyLjIyNy0yLjkzMUg1NXYxOC4xMzdDNTUgMzMuMjYgNTMuNjggMzUgNTIuMDUgMzVoLTQwLjFDMTAuMzIgMzUgOSAzMy4yNTkgOSAzMS4xMzdWMTNoMTEuMTZjMS4yMzMgMCAyLjIyNyAxLjMyMyAyLjIyNyAyLjkyOHYuMDIyYzAgMS42MDUgMS4wMDUgMi45MDEgMi4yMzcgMi45MDFoMTQuNzUyYzEuMjMyIDAgMi4yMzctMS4zMDggMi4yMzctMi45MTN2LS4wMDd6IiBmaWxsPSIjRkFGQUZBIi8+CiAgICA8L2c+CiAgPC9nPgo8L3N2Zz4K"/> --}}
                        <p>
                             No Records To Show
                        </p>
                    </td>
                 </tr>

            </tr>
                
            @endforelse
        </tbody>
      </table>
      @if (! $this->readyToLoadContacts)
          <span>
            Loading
          </span>
      @endif
      {{optional($contacts)->links()}}
</div>
