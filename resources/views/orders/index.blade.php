<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Orders</h2>
    </x-slot>

    <x-slot name="sidebar">
        @include('layouts.sidebar')
    </x-slot>

    <div class="bg-white p-6 shadow sm:rounded-lg">
        <div class="flex justify-end mb-6">
            <a href="{{ route('orders.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="-ml-1 mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Create order
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @forelse($orders as $order)
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 flex flex-col hover:shadow-md transition shadow-sm">
                    <h3 class="font-bold text-gray-900 text-lg mb-3 truncate" title="{{ $order->title }}">
                        {{ $order->title }}
                    </h3>

                    <div class="mb-2">
                        <span class="block text-xs text-gray-500 uppercase font-semibold">Accumulated</span>
                        <span class="text-indigo-600 font-bold text-lg">{{ number_format($order->current_amount, 2) }} ₴</span>
                    </div>

                    <div class="mb-3">
                        <span class="block text-xs text-gray-500 uppercase font-semibold">Threshold</span>
                        <span class="text-gray-700 font-medium">{{ number_format($order->free_shipping_threshold, 2) }} ₴</span>
                    </div>

                    <div class="mt-auto pt-3 border-t border-gray-200">
                        <span class="block text-xs text-gray-400 mb-1 font-semibold">Planning Date:</span>
                        <span class="text-sm text-gray-600 italic">
                            {{ $order->join_deadline_at ? \Carbon\Carbon::parse($order->join_deadline_at)->format('d.m.Y H:i') : 'No deadline' }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500">You have not created any order yet</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
