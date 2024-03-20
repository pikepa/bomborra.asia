<div>
    <select wire:model='channel_id' class="w-full text-lg rounded">
        <option value='' selected >Select Channel</option>
        @foreach ($queryChannels as $channel)
        <option wire:key="{{ $channel->id }}" value="{{ $channel->id }}">{{  $channel->name }} </option>
        @endforeach
    </select>
</div>  