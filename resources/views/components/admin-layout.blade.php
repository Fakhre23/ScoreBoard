<x-app-layout>
    <div class="flex h-screen">

        {{-- ******** Sidebar ******** --}}
        <aside class="w-64 bg-white border-r border-gray-200 p-6">
            <h2 class="text-2xl font-bold mb-8 text-gray-800">Dashboard</h2>

            {{-- Main Navigation --}}
            <ul class="space-y-4">
                <li>
                    <a href=" {{ route('universities.list') }}" id="ListUniversities"
                        class="block bg-gray-100 hover:bg-gray-200 rounded p-2 text-gray-800">
                        Manage Universities
                    </a>
                </li>

                <li>
                    <a href="{{ route('users.list') }}" id="listUsers"
                        class="block bg-gray-100 hover:bg-gray-200 rounded p-2 text-gray-800">
                        Manage Users
                    </a>
                </li>

                <li>
                    <a href="{{ route('events.list') }}" id="menuEvents"
                        class="block bg-gray-100 hover:bg-gray-200 rounded p-2 text-gray-800">
                        Manage Events
                    </a>
                </li>

                <li>
                    <a href="#" id="menuScores"
                        class="block bg-gray-100 hover:bg-gray-200 rounded p-2 text-gray-800">
                        Scores
                    </a>
                </li>

                <li>
                    <a href="#" id="menuLeaderboard"
                        class="block bg-gray-100 hover:bg-gray-200 rounded p-2 text-gray-800">
                        Leaderboard
                    </a>
                </li>

                <li>
                    <a href="#" id="menuProfile"
                        class="block bg-gray-100 hover:bg-gray-200 rounded p-2 text-gray-800">
                        My Profile
                    </a>
                </li>
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
