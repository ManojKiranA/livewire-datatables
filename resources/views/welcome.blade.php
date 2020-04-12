<html>
    <head>
        <title>Building a DataTable with Livewire</title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.css" crossorigin="anonymous">
    
        <script src="https://kit.fontawesome.com/107c56b88c.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.js" crossorigin="anonymous"></script>

        {{-- <link href="{{ asset(mix('/css/app.css')) }}" rel="stylesheet" />
    <script src="{{ asset(mix('/js/app.js')) }}" defer></script> --}}

    @livewireStyles
    </head>
    <body>
        <div id="app" class="text-center">
            {{-- @livewire('auto-complete-component',['user' => new \App\User]) --}}
            {{-- @livewire('contacts-table') --}}
            {{-- @livewire('contacts-table-component') --}}
            {{-- @livewire('contact-form-component') --}}
            {{-- @livewire('search-posts') --}}
            {{-- @livewire('s-s-l-certificate') --}}
            {{-- @livewire('convert-case-component') --}}
            {{-- @livewire(App\Http\Livewire\DateTimeFormatCheck::class) --}}
            @livewire(App\Http\Livewire\DepandDropDown::class)
            
        </div>
    </body>
    @livewireScripts
</html>
