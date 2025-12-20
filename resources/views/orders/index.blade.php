<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Мої замовлення</h2>
    </x-slot>

    <x-slot name="sidebar">
        @include('layouts.sidebar')
    </x-slot>

    <div class="bg-white p-6 shadow sm:rounded-lg">
        @forelse($orders as $order)
            <div class="border-b py-2">{{ $order->title }} — {{ $order->price }} грн</div>
        @empty
            <p>У вас ще немає замовлень.</p>
        @endforelse
    </div>
</x-app-layout>
