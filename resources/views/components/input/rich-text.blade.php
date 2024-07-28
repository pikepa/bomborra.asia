@props([
'initialValue' => '',
'unique'=> ''])


<div class="rounded " {{$attributes}}
        wire:ignore 
        x-data 
        @trix-blur="$dispatch('body_value_updated',[ $event.target.value])">

    <input id="{{ $unique }}" value="{{ $initialValue }}" hidden >

    <trix-editor class="text-lg form-textarea rounded block w-full transition duration-150 ease-in-out " input="{{ $unique }}"></trix-editor>
</div>

