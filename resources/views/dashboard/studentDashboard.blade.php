{{-- resources/views/dashboard/student.blade.php --}}
<x-app-layout>
    <div class="flex h-screen">

        {{-- Sidebar --}}
        <aside class="w-64 bg-white border-r border-gray-200 p-6">
            <h2 class="text-2xl font-bold mb-8 text-gray-800">Student Dashboard</h2>

            <ul class="space-y-4">
                <li><a href="#" id="menuMyEvents" class="block bg-gray-100 hover:bg-gray-200 rounded p-2 text-gray-800">My Events</a></li>
                <li><a href="#" id="menuLeaderboard" class="block bg-gray-100 hover:bg-gray-200 rounded p-2 text-gray-800">Leaderboard</a></li>
            </ul>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 p-10 overflow-auto bg-gray-50">
            <h1 class="text-3xl font-bold mb-6 text-gray-900" id="pageTitle">Student Dashboard</h1>
            <div id="contentArea" class="text-gray-700">
                <p>Welcome Student! Select a menu option.</p>
            </div>
        </main>
    </div>
</x-app-layout>