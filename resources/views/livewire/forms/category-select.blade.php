<div>
    <select wire:model.live="category_id" class="w-full text-lg rounded">
        <option value=''>Select Category</option>
        @foreach ($queryCategories as $category)
        <option wire:key="{{ $loop->index }}" value="{!! $category->id !!}">{{  $category->name }} </option>
        @endforeach
    </select>

</div>  