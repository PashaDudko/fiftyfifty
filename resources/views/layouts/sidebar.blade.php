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

</nav>
