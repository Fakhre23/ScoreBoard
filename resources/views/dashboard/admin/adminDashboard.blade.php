{{-- resources/views/layouts/dashboard.blade.php --}}
<x-app-layout>
    <div class="flex h-screen">

        {{-- ******** Sidebar ******** --}}
        <aside class="w-64 bg-white border-r border-gray-200 p-6">
            <h2 class="text-2xl font-bold mb-8 text-gray-800">Dashboard</h2>

            {{-- Main Navigation --}}
            <ul class="space-y-4">
                <li>
                    <a href="{{ route('universities.list') }}" id="ListUniversities"
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
                    <a href="{{ route('users.scoreHistory') }}" id="menuScores"
                        class="block bg-gray-100 hover:bg-gray-200 rounded p-2 text-gray-800">
                        Scores
                    </a>
                </li>
                <li>
                    <a href="{{ route('leaderboard') }}" id="menuLeaderboard"
                        class="block bg-gray-100 hover:bg-gray-200 rounded p-2 text-gray-800">
                        Leaderboard
                    </a>
                </li>
                <li>
                    <a href="" id="menuProfile"
                        class="block bg-gray-100 hover:bg-gray-200 rounded p-2 text-gray-800">
                        My Profile
                    </a>
                </li>


        </aside>

        {{-- ********  Main Content ********  --}}

        <div class=" flex-1 p-10 overflow-auto">


            {{-- ********   Area where content will be injected ********   --}}
            <div id="contentArea">
                <p class="text-gray-600">Please select an option from the sidebar.</p>
            </div>
        </div>



    </div>




    {{-- ********  AJAX and Interactivity //// (ChatGPT do that not me) ********  --}}
    <script>
        /* document.getElementById('listUsers').addEventListener('click', function() {
                                                        fetch('usersList')
                                                            .then(response => response.text())
                                                            .then(html => {
                                                                document.getElementById('contentArea').innerHTML = html;
                                                            });
                                                    });

                                                    document.getElementById('ListUniversities').addEventListener('click', function() {
                                                        fetch('universitiesList')
                                                            .then(response => response.text())
                                                            .then(html => {
                                                                document.getElementById('contentArea').innerHTML = html;
                                                            });
                                                    });

                                                    document.getElementById('menuEvents').addEventListener('click', function() {
                                                        fetch('eventsList')
                                                            .then(response => response.text())
                                                            .then(html => {
                                                                document.getElementById('contentArea').innerHTML = html;
                                                            });
                                                    });/*
    </script>
</x-app-layout>
