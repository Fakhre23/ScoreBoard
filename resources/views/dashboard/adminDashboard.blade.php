{{-- resources/views/layouts/dashboard.blade.php --}}
<x-app-layout>
    <div class="flex h-screen">

        {{-- ******** Sidebar ******** --}}
        <aside class="w-64 bg-white border-r border-gray-200 p-6">
            <h2 class="text-2xl font-bold mb-8 text-gray-800">Dashboard</h2>

            {{-- Main Navigation --}}
            <ul class="space-y-4">
                <li>
                    <a href="#" id="menuHome" class="block bg-gray-100 hover:bg-gray-200 rounded p-2 text-gray-800">
                        Universities
                    </a>
                </li>
                <li>
                    <a href="#" id="menuHome" class="block bg-gray-100 hover:bg-gray-200 rounded p-2 text-gray-800">
                        Users
                    </a>
                </li>

                <li>
                    <a href="#" id="menuEvents" class="block bg-gray-100 hover:bg-gray-200 rounded p-2 text-gray-800">
                        Scores
                    </a>
                </li>
                <li>
                    <a href="#" id="menuScores" class="block bg-gray-100 hover:bg-gray-200 rounded p-2 text-gray-800">
                        Events
                    </a>
                </li>

                <!-- {{-- Extra Features --}}
            <h2 class="text-2xl font-bold mt-10 mb-6 text-gray-800">Features</h2>
            <ul class="space-y-4"> -->

                <li>
                    <a href="#" id="menuLeaderboard" class="block bg-gray-100 hover:bg-gray-200 rounded p-2 text-gray-800">
                        Leaderboard
                    </a>
                </li>
                <li>
                    <a href="#" id="menuProfile" class="block bg-gray-100 hover:bg-gray-200 rounded p-2 text-gray-800">
                        My Profile
                    </a>
                </li>
            </ul>
        </aside>

        {{-- ******** Main Content ******** --}}
        <main class="flex-1 p-10 overflow-auto bg-gray-50">
            {{-- Header --}}
            <h1 class="text-3xl font-bold mb-6 text-gray-900" id="pageTitle">Welcome</h1>

            {{-- Dynamic Content Area --}}
            <div id="contentArea" class="text-gray-700">
                <p>Select an option from the sidebar to begin.</p>
            </div>
        </main>
    </div>

    {{-- ******** AJAX Logic ******** --}}
    <script>
        const loadContent = (url, title) => {
            fetch(url)
                .then(res => res.text())
                .then(html => {
                    document.getElementById('contentArea').innerHTML = html;
                    document.getElementById('pageTitle').innerText = title;
                })
                .catch(err => {
                    document.getElementById('contentArea').innerHTML = '<p class="text-red-600">Error loading content.</p>';
                });
        };

        // Menu click handlers
        document.getElementById('menuHome').addEventListener('click', () => loadContent('/dashboard/home', 'Home'));
        document.getElementById('menuUniversities').addEventListener('click', () => loadContent('/dashboard/universities', 'Universities'));
        document.getElementById('menuEvents').addEventListener('click', () => loadContent('/dashboard/events', 'Events'));
        document.getElementById('menuScores').addEventListener('click', () => loadContent('/dashboard/scores', 'Scores'));
        document.getElementById('menuLeaderboard').addEventListener('click', () => loadContent('/dashboard/leaderboard', 'Leaderboard'));
        document.getElementById('menuProfile').addEventListener('click', () => loadContent('/dashboard/profile', 'My Profile'));
    </script>
</x-app-layout>