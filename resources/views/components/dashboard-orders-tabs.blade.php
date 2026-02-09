<nav {{ $attributes->merge(['class' => 'flex space-x-1 bg-gray-100 p-1 rounded-xl w-fit']) }} aria-label="Tabs">
    @php
        $tabs = [
            'available' => 'Available',
            'subscribed' => 'Subscribed',
        ];
    @endphp

    @foreach($tabs as $value => $label)
        <button
            @click="activeTab = '{{ $value }}'"
            :class="activeTab === '{{ $value }}' ? 'bg-white text-indigo-700 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
            class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200"
            type="button"
        >
            {{ $label }}
        </button>
    @endforeach
</nav>
