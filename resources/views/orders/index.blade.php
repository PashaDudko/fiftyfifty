<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Orders</h2>
    </x-slot>

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 500)"
             class="mb-4 flex items-center p-4 text-green-800 border-t-4 border-green-300 bg-green-50 rounded-lg" role="alert">
            <div class="ml-3 text-sm font-medium">{{ session('success') }}</div>
            <button type="button" @click="show = false" class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg p-1.5 hover:bg-green-200 h-8 w-8">
                <span class="sr-only">Dismiss</span>
                <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
            </button>
        </div>
    @endif

    <x-slot name="sidebar">
        @include('layouts.sidebar')
    </x-slot>

    <div class="bg-white p-6 shadow sm:rounded-lg" x-data="{ activeTab: 'active' }">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
{{--            <nav class="flex space-x-1 bg-gray-100 p-1 rounded-xl w-fit" aria-label="Tabs">--}}
{{--                <button @click="activeTab = 'active'"--}}
{{--                        :class="activeTab === 'active' ? 'bg-white text-indigo-700 shadow-sm' : 'text-gray-500 hover:text-gray-700'"--}}
{{--                        class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200">--}}
{{--                    Active--}}
{{--                </button>--}}
{{--                <button @click="activeTab = 'paused'"--}}
{{--                        :class="activeTab === 'paused' ? 'bg-white text-indigo-700 shadow-sm' : 'text-gray-500 hover:text-gray-700'"--}}
{{--                        class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200">--}}
{{--                    Paused--}}
{{--                </button>--}}
{{--                <button @click="activeTab = 'closed'"--}}
{{--                        :class="activeTab === 'closed' ? 'bg-white text-indigo-700 shadow-sm' : 'text-gray-500 hover:text-gray-700'"--}}
{{--                        class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200">--}}
{{--                    Closed--}}
{{--                </button>--}}
{{--            </nav>--}}

            <x-order-status-tabs />

            <a href="{{ route('orders.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition duration-150">
                <svg class="-ml-1 mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Create order
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 group/container">
            @forelse($orders as $order)
                <div
                    x-show="activeTab === '{{ $order->status->value }}'"
                    class="group relative bg-gray-50 border border-gray-200 rounded-xl p-4 flex flex-col shadow-sm
                    transition-all duration-300 hover:scale-[1.02] hover:bg-white hover:shadow-xl
                    hover:border-indigo-300 group-hover/container:opacity-50 hover:!opacity-100"
                >

                    <div class="absolute top-2 right-2 flex space-x-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-10">
                        @if($order->status->value == 'active')
                            <form action="{{ route('orders.update', $order->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="paused">
                                <button type="submit"
                                        class="p-1.5 bg-white border border-gray-200 rounded-lg text-amber-500 hover:bg-amber-50 shadow-sm"
                                        title="Pause">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </form>
                        @elseif($order->status->value == 'paused')
                            <form action="{{ route('orders.update', $order->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="active">
                                <button type="submit"
                                        class="p-1.5 bg-white border border-gray-200 rounded-lg text-green-600 hover:bg-green-50 shadow-sm"
                                        title="Activate">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('orders.edit', $order->id) }}" class="p-1.5 bg-white border border-gray-200 rounded-lg text-blue-600 hover:bg-blue-50 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </a>
                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-1.5 bg-white border border-gray-200 rounded-lg text-red-600 hover:bg-red-50 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>

                    <div class="flex flex-col h-full">
                        <h3 class="font-bold text-gray-900 text-lg mb-3 pr-14 truncate" title="{{ $order->title }}">
                            {{ $order->title }}
                        </h3>

                        <div class="mb-2">
                            <span class="block text-xs text-gray-500 uppercase font-semibold">Accumulated</span>
                            <span class="text-indigo-600 font-bold text-lg">{{ number_format($order->current_amount, 2) }} $</span>
                        </div>

                        <div class="mb-3">
                            <span class="block text-xs text-gray-500 uppercase font-semibold">Threshold</span>
                            <span class="text-gray-700 font-medium">{{ number_format($order->free_shipping_threshold, 2) }} $</span>
                        </div>

                        <div class="mt-auto pt-3 border-t border-gray-200">
                            <span class="block text-xs text-gray-400 mb-1 font-semibold">Planning Date:</span>
                            <span class="text-sm text-gray-600 italic">
                                {{ $order->join_deadline_at ? \Carbon\Carbon::parse($order->join_deadline_at)->format('d.m.Y H:i') : 'No deadline' }}
                            </span>
                        </div>
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
