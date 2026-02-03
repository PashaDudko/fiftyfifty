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

    <div class="bg-white p-6 shadow sm:rounded-lg" x-data="{ activeTab: 'active' }">
{{--        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4"> </div>--}}
        <x-order-status-tabs />
        @forelse($orders as $order)
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500">There are no orders yet</p>
            </div>
        @endforelse

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
