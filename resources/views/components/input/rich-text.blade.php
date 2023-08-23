@props([
'initialValue' => '',
'unique'=> ''])


<div class="rounded " {{$attributes}}
        wire:ignore 
        x-data 
        @trix-blur="$dispatch('change', $event.target.value)">

    <input id="unique" value="{{ $initialValue }}" type="hidden">

    <trix-editor class="text-lg form-textarea rounded block w-full transition duration-150 ease-in-out " input="unique"></trix-editor>
</div>

