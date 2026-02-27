<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           Details Order: #{{ $order->id }} {{ $order->title }}
        </h2>
    </x-slot>

    <x-slot name="sidebar">
        @include('layouts.sidebar')
    </x-slot>

    <div class="bg-white p-6 shadow sm:rounded-lg">
        <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-100">
            <div>
                <span class="block text-sm text-gray-500 uppercase tracking-wider font-semibold">Accumulated</span>
                <span class="text-3xl font-bold text-indigo-600">${{ number_format($order->current_amount, 2) }}</span>
            </div>
            <div class="text-right">
                <span class="block text-sm text-gray-500 uppercase tracking-wider font-semibold">Threshold</span>
                <span class="text-xl font-medium text-gray-700">${{ number_format($order->free_shipping_threshold, 2) }}</span>
            </div>
        </div>

        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            Participants ({{ $order->subscribers->count() }})
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($order->subscribers as $subscriber)
                <div class="flex items-center p-4 bg-gray-50 rounded-xl border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="relative flex-shrink-0">
                        <img src="{{ $subscriber->avatar ? asset('storage/' . $subscriber->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($subscriber->name) }}"
                             alt="{{ $subscriber->name }}"
                             class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-sm">
                    </div>

                    <div class="ml-4 overflow-hidden">
                        <p class="text-sm font-bold text-gray-900 truncate" title="{{ $subscriber->name }}">
                            {{ $subscriber->name == $order->user->name ? 'YOU' : $subscriber->name}}
                        </p>
                        <div class="flex items-center text-xs text-gray-500">
                            <span class="mr-1">Joined with:</span>
                            <span class="font-semibold text-green-600">
                            ${{ number_format($subscriber->subscribedOrders->find($order->id)->pivot->amount, 2) }}
                        </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
