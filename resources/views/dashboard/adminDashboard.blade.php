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
                    <a href="#" id="listUsers" class="block bg-gray-100 hover:bg-gray-200 rounded p-2 text-gray-800">
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

        {{-- ********  Main Content ********  --}}

        <div class="flex-1 p-10 overflow-auto">
        

            {{-- ********   Area where content will be injected ********   --}}
            <div id="contentArea">
                <p class="text-gray-600">Please select an option from the sidebar.</p>
            </div>
        </div>



    </div>




    {{-- ********  AJAX and Interactivity //// (ChatGPT do that not me) ********  --}}
    <script>
        document.getElementById('listUsers').addEventListener('click', function() {
            fetch('listUsers')
                .then(response => response.text())
                .then(html => {
                    document.getElementById('contentArea').innerHTML = html;
                });
        });
    </script>
</x-app-layout>