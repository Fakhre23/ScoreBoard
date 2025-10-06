<x-app-layout>
    <div class="flex h-screen">

        {{-- ******** Sidebar ******** --}}
        <aside class="w-64 bg-white border-r border-gray-200 p-6">
            <h2 class="text-2xl font-bold mb-8 text-gray-800">Student Dashboard</h2>

            <ul class="space-y-4">
                <li><a href="#" id="menuMyEvents"
                        class="block bg-gray-100 hover:bg-gray-200 rounded p-2 text-gray-800">Scores</a></li>
                <li><a href="{{ route('events.register') }}" id="menuRegisterEvents"
                        class="block bg-gray-100 hover:bg-gray-200 rounded p-2 text-gray-800">Register To Events</a></li>
                <li><a href="{{ route('leaderboard') }}" id="menuLeaderboard"
                        class="block bg-gray-100 hover:bg-gray-200 rounded p-2 text-gray-800">Leaderboard</a></li>
            </ul>
        </aside>

        {{-- ******** Main Content ******** --}}
        <main class="flex-1 min-h-screen bg-gray-100">
            <div class="w-full px-6 py-8">
                {{ $slot }}
            </div>
        </main>

    </div>
</x-app-layout>
