<x-amb-layout>
    <div class="max-w-4xl mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">My University</h2>

        @foreach ($universities as $university)
            <div class="bg-white shadow-md rounded-lg p-6 mb-4">

                {{-- University Image --}}
                <div class="flex items-center mb-4">
                    @if ($university->UNI_photo)
                        <img src="{{ asset('./storage/university-photos/' . $university->UNI_photo) }}"
                            alt="University Image" class="w-16 h-16 rounded-full object-cover border border-gray-300">
                    @else
                        {{-- Default icon --}}
                        <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 14l9-5-9-5-9 5 9 5zm0 0v6m-7-3v3h14v-3" />
                            </svg>
                        </div>
                    @endif

                    <h3 class="text-xl font-semibold text-blue-700 ml-4">
                        {{ $university->name }}
                    </h3>
                </div>

                <p class="text-gray-600"><strong>Country:</strong> {{ $university->country }}</p>
                <p class="text-gray-600"><strong>Total Score:</strong> {{ $university->total_score }}</p>
                <p class="text-gray-600"><strong>Created at:</strong> {{ $university->created_at->format('d M Y') }}</p>
                <p class="text-gray-800 font-medium mt-3">
                    Number of Users: {{ $university->users_count }}
                </p>

                {{-- Upload Form --}}
                <form action="{{ route('university.uploadPhoto') }}" method="POST" enctype="multipart/form-data"
                    class="mt-4">

                    @csrf
                    <input type="hidden" name="university_id" value="{{ $university->id }}">

                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Upload University Image / File
                    </label>

                    <input type="file" name="UNI_photo" accept=".jpg,.jpeg,.png,.webp,.pdf"
                        class="block w-full border border-gray-300 rounded-md p-2">

                    @error('UNI_photo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <button type="submit"
                        class="mt-3 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm">
                        Upload
                    </button>
                </form>

            </div>
        @endforeach
    </div>
</x-amb-layout>
