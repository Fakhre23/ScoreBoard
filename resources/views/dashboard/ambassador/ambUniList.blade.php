<x-amb-layout>
    <div class="max-w-4xl mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">My University</h2>

        @foreach ($universities as $university)
            <div class="bg-white shadow-md rounded-lg p-6 mb-4">
                <h3 class="text-xl font-semibold text-blue-700 mb-2">{{ $university->name }}</h3>

                <p class="text-gray-600"><strong>Country:</strong> {{ $university->country }}</p>
                <p class="text-gray-600"><strong>Total Score:</strong> {{ $university->total_score }}</p>
                <p class="text-gray-600"><strong>Created at:</strong> {{ $university->created_at->format('d M Y') }}</p>
                <p class="text-gray-800 font-medium mt-3">👥 Number of Users: {{ $university->users_count }}</p>
            </div>
        @endforeach
    </div>
</x-amb-layout>
