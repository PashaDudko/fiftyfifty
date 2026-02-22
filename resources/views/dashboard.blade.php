<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @if (session()->has('success'))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 2000)"
            x-show="show"
            x-transition.duration.500ms
            id="alert-success"
            class="fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded shadow-lg z-50"
        >
            {{ session('success') }}
        </div>
    @endif
    <x-slot name="telegram">
        <div class="row">
            <div class="col-12 mt-5">
                @unless(auth()->user()->telegram_id)
                    <script async src="https://telegram.org/js/telegram-widget.js?22"
                            data-telegram-login="{{config('services.telegram-bot-api.name')}}"
                            data-size="medium"
                            data-auth-url="{{route('callbacks.auth.telegram')}}"
                            data-request-access="write">
                    </script>
                @endunless
            </div>
        </div>
    </x-slot>

    <x-slot name="sidebar">
        @include('layouts.sidebar')
    </x-slot>

    <div class="bg-white p-6 shadow sm:rounded-lg" x-data="{ activeTab: 'available' }">
{{--        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4"> </div>--}}
        <x-dashboard-orders-tabs />

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 group/container">
            @forelse($orders as $order)
                @if ($order->user_id != auth()->id())
                    <div
                        x-show="activeTab == '{{ auth()->user()->subscribedOrders()->where('order_id', $order->id)->exists() ? 'subscribed' : 'available' }}'"
                        class="group relative bg-gray-50 border border-gray-200 rounded-xl p-4 flex flex-col shadow-sm
                        transition-all duration-300 hover:scale-[1.02] hover:bg-white hover:shadow-xl
                        hover:border-indigo-300"
                    >
                        <div class="flex flex-col h-full">
                            <h3 class="font-bold text-gray-900 text-lg mb-3 truncate" title="{{ $order->title }}">
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

                            <div class="flex items-center mb-3 pb-3 border-b border-gray-100">
                                <img class="h-9 w-9 rounded-full object-cover border-2 border-indigo-500 p-0.5"
                                     src="{{ asset('storage/' . $order->user->avatar) }}"
                                     alt="{{ $order->user->name }}"
                                     title="Author: {{ $order->user->name }}">
                                <div class="ml-2">
                                    <span class="block text-[10px] text-gray-400 uppercase font-bold leading-none">Created by</span>
                                    <span class="text-sm font-medium text-gray-700">{{ $order->user->name }}</span>
                                </div>
                            </div>

                            <div class="mb-4 flex items-center justify-between">
                                <div class="text-xs font-bold text-gray-400 uppercase tracking-tighter">
                                    Subscribers: {{ $order->subscribers_count }}
                                </div>

                                <div class="flex -space-x-2 overflow-hidden">
                                    @foreach($order->subscribers->take(5) as $subscriber)
                                        <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white object-cover"
                                             src="{{ asset('storage/' . $subscriber->avatar) }}"
                                             alt="{{ $subscriber->name }}"
                                             title="{{ $subscriber->name }}">
                                    @endforeach

                                    @if($order->subscribers_count > 5)
                                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-200 text-xs font-medium text-gray-600 ring-2 ring-white">
                                            +{{ $order->subscribers_count - 5 }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            @if(auth()->user()->subscribedOrders()->where('order_id', $order->id)->exists())
                                @php
                                    $currentAmount = auth()->user()->subscribedOrders->find($order->id)->pivot->amount;
                                @endphp

                                <div
                                    class="mt-2 mb-2 p-2 bg-indigo-50 rounded-lg border border-indigo-100"
                                    x-data="{ isEditing: false, newAmount: '{{ $currentAmount }}' }"
                                >
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <span class="block text-[10px] text-indigo-400 uppercase font-bold">Your contribution:</span>

                                            <span x-show="!isEditing" class="text-indigo-700 font-bold text-lg">
                    {{ number_format($currentAmount, 2) }} $
                </span>
                                        </div>

                                        <button
                                            x-show="!isEditing"
                                            @click="isEditing = true"
                                            class="text-indigo-400 hover:text-indigo-600 transition-colors"
                                            title="Edit amount"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </button>
                                    </div>

                                    <form
                                        x-show="isEditing"
                                        x-transition
                                        action="{{ route('orders.update-amount', [$order->id]) }}"
                                        method="POST"
                                        class="mt-2 space-y-2"
                                    >
                                        @csrf
                                        @method('PUT')

                                        <input
                                            type="number"
                                            name="amount"
                                            x-model="newAmount"
                                            step="0.01"
                                            min="0.01"
                                            required
                                            class="w-full px-2 py-1 text-sm border border-indigo-300 rounded focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                        >

                                        <div class="flex gap-2">
                                            <button type="submit" class="flex-1 bg-indigo-600 text-white text-[10px] font-bold py-1 rounded hover:bg-indigo-700 uppercase">
                                                Save
                                            </button>
                                            <button type="button" @click="isEditing = false" class="px-2 py-1 bg-white text-gray-500 text-[10px] border border-gray-200 rounded hover:bg-gray-50 uppercase">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @endif

                            <div class="mt-auto pt-3 border-t border-gray-200">
                                <span class="block text-xs text-gray-400 mb-1 font-semibold">Planning Date:</span>
                                <span class="text-sm text-gray-600 italic">
                                    {{ $order->join_deadline_at ? \Carbon\Carbon::parse($order->join_deadline_at)->format('d.m.Y H:i') : 'No deadline' }}
                                </span>
                            </div>
                            <div class="mt-4 pt-3">
                                @if($order->user_id != auth()->id())
                                    @if(!auth()->user()->subscribedOrders()->where('order_id', $order->id)->exists())
                                        <form action="{{ route('orders.join', [$order->id]) }}" method="POST" class="w-full space-y-3" x-data="{ showInput: false }">
                                            @csrf

                                            <div x-show="showInput" x-transition class="space-y-2">
                                                <label class="block text-xs font-bold text-gray-500 uppercase">Your Contribution ($)</label>
                                                <input
                                                    type="number"
                                                    name="amount"
                                                    step="0.01"
                                                    min="0.01"
                                                    required
                                                    placeholder="0.00"
                                                    class="w-full px-3 py-2 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm"
                                                >
                                            </div>

                                            <button
                                                type="button"
                                                x-show="!showInput"
                                                @click="showInput = true"
                                                class="w-full flex items-center justify-center px-4 py-2 bg-emerald-600 text-white text-sm font-bold rounded-lg hover:bg-emerald-700 transition-colors shadow-md"
                                            >
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Join
                                            </button>

                                            <div x-show="showInput" class="flex gap-2">
                                                <button
                                                    type="submit"
                                                    class="flex-1 bg-emerald-600 text-white text-sm font-bold py-2 rounded-lg hover:bg-emerald-700 shadow-md"
                                                >
                                                    Confirm
                                                </button>
                                                <button
                                                    type="button"
                                                    @click="showInput = false"
                                                    class="px-3 py-2 bg-gray-100 text-gray-600 text-sm rounded-lg hover:bg-gray-200"
                                                >
                                                    ✕
                                                </button>
                                            </div>
                                        </form>
                                    @else
                                        <form action="{{ route('orders.leave', [$order->id]) }}" method="POST" class="w-full">
                                            @csrf
                                            <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-white border-2 border-rose-500 text-rose-600 text-sm font-bold rounded-lg hover:bg-rose-50 transition-colors">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Leave
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500">There are no orders yet</p>
                </div>
            @endforelse
        </div>
    </div>

{{--    <div class="py-12">--}}
{{--        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">--}}
{{--            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">--}}
{{--                <div class="p-6 text-gray-900">--}}
{{--                    {{ __("You're logged in!") }}--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
</x-app-layout>
