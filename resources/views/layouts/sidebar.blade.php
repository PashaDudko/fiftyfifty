<nav class="flex flex-col space-y-2">
    <a href="{{ route('dashboard') }}"
       class="px-4 py-2 rounded-lg transition {{ request()->routeIs('dashboard') ? 'text-blue-600 bg-blue-50 font-semibold border-l-4 border-blue-500' : 'text-gray-700 hover:bg-gray-100' }}">
        🏠 Dashboard
    </a>
    <a href="{{ route('orders.index') }}"
       class="px-4 py-2 rounded-lg transition {{ request()->routeIs('orders.*') ? 'text-blue-600 bg-blue-50 font-semibold border-l-4 border-blue-500' : 'text-gray-700 hover:bg-gray-100' }}">
        📦 My Orders
    </a>

    <a href="#"
       class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">
        📬 Messages
    </a>

{{--    <hr class="my-2 border-gray-200">--}}
    @role('admin')
        <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
            Admin Area
        </div>
        <a href="/admin" class="px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg transition flex items-center gap-2">
            🛡️ Admin Panel
        </a>
    @endrole

</nav>
