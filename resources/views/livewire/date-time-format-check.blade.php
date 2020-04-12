<div>
    <input type="datetime-local" class="form-control flex-2" wire:model="dateTime">
    @error('dateTime') {{$message}} @enderror
</div>
