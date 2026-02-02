<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Order: #{{ $order->id }} {{ $order->title }}
        </h2>
    </x-slot>

    <x-slot name="sidebar">
        @include('layouts.sidebar')
    </x-slot>

    <div class="bg-white p-6 shadow sm:rounded-lg">
        <form action="{{ route('orders.update', $order->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT') <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $order->title) }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="3"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $order->description) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="current_amount" class="block text-sm font-medium text-gray-700">Current amount</label>
                    <input type="number" step="0.01" name="current_amount" id="current_amount"
                           value="{{ old('current_amount', $order->current_amount) }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="free_shipping_threshold" class="block text-sm font-medium text-gray-700">Need amount for free shipping</label>
                    <input type="number" step="0.01" name="free_shipping_threshold" id="free_shipping_threshold"
                           value="{{ old('free_shipping_threshold', $order->free_shipping_threshold) }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="join_deadline_at" class="block text-sm font-medium text-gray-700">Planning date</label>
                    <input type="datetime-local" name="join_deadline_at" id="join_deadline_at"
                           value="{{ old('join_deadline_at', $order->join_deadline_at ? \Carbon\Carbon::parse($order->join_deadline_at)->format('Y-m-d\TH:i') : '') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="shop_id" class="block text-sm font-medium text-gray-700">Choose shop</label>
                    <select name="shop_id" id="shop_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Choose shop</option>
                        @foreach($shops as $shop)
                            <option value="{{ $shop->id }}" {{ old('shop_id', $order->shop_id) == $shop->id ? 'selected' : '' }}>
                                {{ $shop->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('shop_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-x-4 pt-6 border-t border-gray-100">
                <a href="{{ route('orders.index') }}"
                   class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 transition">
                    Cancel
                </a>

                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Update order
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
