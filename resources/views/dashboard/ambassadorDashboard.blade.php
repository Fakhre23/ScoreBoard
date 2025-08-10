{{-- resources/views/dashboard/ambassador.blade.php --}}
<x-app-layout>
    <div class="flex h-screen">

        {{-- Sidebar --}}
        <aside class="w-64 bg-white border-r border-gray-200 p-6">
            <h2 class="text-2xl font-bold mb-8 text-gray-800">Ambassador Panel</h2>

            <ul class="space-y-4">
                <li><a href="#" id="menuMyUniversity" class="block bg-gray-100 hover:bg-gray-200 rounded p-2 text-gray-800">My University</a></li>
                <li><a href="#" id="menuRepresentatives" class="block bg-gray-100 hover:bg-gray-200 rounded p-2 text-gray-800">Manage Representatives</a></li>
                <li><a href="#" id="menuEvents" class="block bg-gray-100 hover:bg-gray-200 rounded p-2 text-gray-800">Events</a></li>
                <li><a href="#" id="menuScoreSubmission" class="block bg-gray-100 hover:bg-gray-200 rounded p-2 text-gray-800">Submit Scores</a></li>
            </ul>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 p-10 overflow-auto bg-gray-50">
            <h1 class="text-3xl font-bold mb-6 text-gray-900" id="pageTitle">Ambassador Dashboard</h1>
            <div id="contentArea" class="text-gray-700">
                <p>Welcome Ambassador! Select a menu option.</p>
            </div>
        </main>
    </div>
</x-app-layout>