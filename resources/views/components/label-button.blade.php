    <!-- Smile, breathe, and go slowly. - Thich Nhat Hanh -->

<button name={{ $title }} {{ $attributes->merge(['class' => 'inline-flex items-center px-4 py-2 bg-mio border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-mio-700 active:bg-mio-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>