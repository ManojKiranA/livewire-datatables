<div>
    <div class="row mb-4">
        <div class="col form-inline">
            Per Page: &nbsp;
            <select wire:model="perPage" class="form-control">
                @foreach ($this->paginationList as $eachItem)
                <option>{{$eachItem}}</option>
                @endforeach
            </select>
        </div>

        <div class="col">
            <input wire:model="search" class="form-control" type="text" placeholder="Search Contacts...">
        </div>
    </div>

    <div class="row">
        <div class="table-responsive">
        <table class="table">
            <thead>
                    <tr>
                            <th><a wire:click.prevent="sortBy('id')" role="button" href="#">
                                Id
                                @include('includes._sort-icon', ['field' => 'id'])
                            </a></th>
                            <th><a wire:click.prevent="sortBy('name')" role="button" href="#">
                                Name
                                @include('includes._sort-icon', ['field' => 'name'])
                            </a></th>
                            <th><a wire:click.prevent="sortBy('email')" role="button" href="#">
                                Email
                                @include('includes._sort-icon', ['field' => 'email'])
                            </a></th>
                            <th><a wire:click.prevent="sortBy('favorite_color')" role="button" href="#">
                                    Favorite Color
                                    @include('includes._sort-icon', ['field' => 'favorite_color'])
                                </a></th>
                            
                            <th><a wire:click.prevent="sortBy('birthdate')" role="button" href="#">
                                Birthdate
                                @include('includes._sort-icon', ['field' => 'birthdate'])
                            </a></th>
                            <th><a wire:click.prevent="sortBy('last_contacted_at')" role="button" href="#">
                                    Last Contacted At
                                    @include('includes._sort-icon', ['field' => 'last_contacted_at'])
                                </a></th>
                            
                        </tr>  
            </thead>
            <tbody>
                @foreach ($contacts as $contact)
                    <tr>
                        <td>{{ $contact->id }}</td>
                        <td>{{ $contact->name }}</td>
                        <td>{{ $contact->email }}</td>
                        <td>{{ $contact->favorite_color }}</td>
                        <td>{{ $contact->birthdate->format('m-d-Y') }}</td>
                        <td>{{ $contact->last_contacted_at->format('m-d-Y') }}</td>
                        
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                    <tr>
                            <th><a wire:click.prevent="sortBy('id')" role="button" href="#">
                                Id
                                @include('includes._sort-icon', ['field' => 'id'])
                            </a></th>
                            <th><a wire:click.prevent="sortBy('name')" role="button" href="#">
                                Name
                                @include('includes._sort-icon', ['field' => 'name'])
                            </a></th>
                            <th><a wire:click.prevent="sortBy('email')" role="button" href="#">
                                Email
                                @include('includes._sort-icon', ['field' => 'email'])
                            </a></th>
                            <th><a wire:click.prevent="sortBy('favorite_color')" role="button" href="#">
                                    Favorite Color
                                    @include('includes._sort-icon', ['field' => 'favorite_color'])
                                </a></th>
                            
                            <th><a wire:click.prevent="sortBy('birthdate')" role="button" href="#">
                                Birthdate
                                @include('includes._sort-icon', ['field' => 'birthdate'])
                            </a></th>
                        </tr>                
            </tfoot>
        </table>
        </div>
    </div>

    <div class="row">
        <div class="col">
            {{ $contacts->links() }}
        </div>

        <div class="col text-right text-muted">
            Showing {{ $contacts->firstItem() }} to {{ $contacts->lastItem() }} out of {{ $contacts->total() }} results
        </div>
    </div>
</div>
