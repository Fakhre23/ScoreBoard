<x-guest-layout>

    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-2xl p-8">
        <h2 class="text-3xl font-extrabold text-gray-900 mb-8 border-b pb-4"> 🎓 Create University</h2>

        <form method="POST" action="{{ route('universities.fromUser.store') }}" enctype="multipart/form-data"
            class="space-y-6">
            @csrf

            <!-- University Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700">University Name</label>
                <input type="text" name="name" id="name" required
                    class="mt-2 w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 p-3">
            </div>

            <!-- Country -->
            <div>
                <label for="country" class="block text-sm font-semibold text-gray-700">Country</label>
                <input type="text" name="country" id="country" required
                    class="mt-2 w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 p-3">
            </div>
            <!-- Submit -->
            <div class="pt-4 flex flex-col items-center">
                <button id="submit-university-btn" type="submit"
                    class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg transition-all duration-200 ease-in-out">
                    ✅ Submit University
                </button>

                <p class="mt-3 text-center text-sm text-gray-600">Your university will be reviewed by our team before
                    being published.</p>
            </div>

            <!-- Pending modal (hidden by default) -->
            <div id="pending-modal"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
                <div class="bg-white rounded-2xl p-6 max-w-sm w-full text-center shadow-lg">
                    <div class="text-3xl mb-2">⏳</div>
                    <h3 class="text-lg font-semibold">Submission pending</h3>
                    <p class="mt-2 text-sm text-gray-600">Thanks! Your university has been submitted and is pending
                        review.</p>
                    <div class="mt-4">
                        <button id="pending-ok-btn"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">OK</button>
                    </div>
                </div>
            </div>

            <script>
                (function() {
                    const btn = document.getElementById('submit-university-btn');
                    const modal = document.getElementById('pending-modal');
                    const okBtn = document.getElementById('pending-ok-btn');
                    const redirectUrl = "{{ route('register') }}";

                    if (!btn) return;

                    btn.addEventListener('click', function(e) {
                        // Prevent immediate navigation so user can see the popup
                        e.preventDefault();

                        // Show modal
                        modal.classList.remove('hidden');

                        // When user clicks OK, hide modal and go to register page
                        okBtn.addEventListener('click', function() {
                            modal.classList.add('hidden');
                            window.location.href = redirectUrl;
                        }, {
                            once: true
                        });

                        // Close modal and redirect when clicking outside the dialog
                        const outsideClickHandler = function(ev) {
                            if (ev.target === modal) {
                                modal.classList.add('hidden');
                                window.location.href = redirectUrl;
                            }
                        };
                        modal.addEventListener('click', outsideClickHandler, {
                            once: true
                        });

                        // Allow closing with Escape and redirect
                        const keyHandler = function(ev) {
                            if (ev.key === 'Escape') {
                                modal.classList.add('hidden');
                                window.location.href = redirectUrl;
                            }
                        };
                        document.addEventListener('keydown', keyHandler, {
                            once: true
                        });
                    });
                })();
            </script>

        </form>
    </div>
</x-guest-layout>
