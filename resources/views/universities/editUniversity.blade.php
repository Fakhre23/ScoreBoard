<x-app-layout>

    <div class="max-w-7xl mx-auto bg-white shadow-md rounded-xl p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Edit University</h2>

        <form method="POST" action="{{ route('universities.edit', $university->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="name" value="{{ $university->name }}" required
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-opacity-50">
            </div>

            <div class="mb-4">
                <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                <input type="text" name="country" id="country" value="{{ $university->country }}" required
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-opacity-50">
            </div>

            <div class="mb-4">
                <label for="total_score" class="block text-sm font-medium text-gray-700">Total Score</label>
                <input type="number" name="total_score" id="total_score" value="{{ $university->total_score }}"
                    required
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-opacity-50">
            </div>

            <div class="mb-4">
                <label for="photo" class="block text-sm font-medium text-gray-700">Logo</label>
                <input type="file" name="photo" id="photo"
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-opacity-50">
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow transition">
                    Update University
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
