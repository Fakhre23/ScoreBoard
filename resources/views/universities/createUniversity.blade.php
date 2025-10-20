<x-admin-layout class="min-h-screen flex items-center justify-center bg-gray-50">


    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-2xl p-8">
        <h2 class="text-3xl font-extrabold text-gray-900 mb-8 border-b pb-4"> Create University</h2>

        <form method="POST" action="{{ route('universities.store') }}" enctype="multipart/form-data" class="space-y-6">
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
            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-semibold text-gray-700">Status</label>
                <select name="status" id="status" required
                    class="mt-2 w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 p-3 bg-white">
                    <option value="1">Active</option>
                    <option value="0">Pending</option>
                </select>
            </div>

            <!-- University Logo -->
            <div>
                <label for="photo" class="block text-sm font-semibold text-gray-700">University Logo</label>
                <input type="file" name="photo" id="photo"
                    class="mt-2 w-full text-sm text-gray-700 border border-gray-300 rounded-xl cursor-pointer shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 p-2 bg-gray-50">
            </div>

            <!-- Submit -->
            <div class="pt-4">
                <button type="submit"
                    class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg transition-all duration-200 ease-in-out">
                    ✅ Create University
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
