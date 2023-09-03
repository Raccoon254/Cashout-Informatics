<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-warning hover:bg-opacity-40 btn-circle ring z-20 ring-blue-700']) }}>
    {{ $slot }}
</button>
