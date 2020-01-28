<div>

    <input wire:model="search" type="text" placeholder="Search posts by title..."><input wire:model.debounce.1s="pagination" type="text" placeholder="Search posts by title...">

    <h1>Search Results:</h1>

    <ol>
       @foreach($posts as $post)
           <li>{{ $post->name }}</li>
       @endforeach
    </ol>
 </div>