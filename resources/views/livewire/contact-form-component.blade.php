<div>
    <div wire:poll.3000ms>
        Current time: {{ now()->format('h:i:s A') }}
    </div>
    
    <div wire:offline>
        You are now offline.
    </div>
</div>