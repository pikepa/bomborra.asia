<button {{ $attributes->merge(['class' => 'text-white bg-teal-600 hover:bg-indigo-500 active:bg-indigo-700 border-indigo-600']) }}>
    {{ $slot }}
</button>