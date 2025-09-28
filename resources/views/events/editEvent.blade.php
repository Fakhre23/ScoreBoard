<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Edit Event</h2>

                <form method="POST" action="{{ route('events.update', $eventToEdit->id) }}">
                    @csrf
                    @method('PATCH')

                    <!-- Title -->
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 font-medium mb-2">Title</label>
                        <input type="text" name="title" id="title"
                            value="{{ old('title', $eventToEdit->title) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
                            required>
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                        <textarea name="description" id="description" rows="3" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">{{ old('description', $eventToEdit->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div class="mb-4">
                        <label for="location" class="block text-gray-700 font-medium mb-2">Location</label>
                        <input type="text" name="location" id="location"
                            value="{{ old('location', $eventToEdit->location) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
                            required>
                        @error('location')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Start Datetime -->
                    <div class="mb-4">
                        <label for="start_datetime" class="block text-gray-700 font-medium mb-2">Start Date &
                            Time</label>
                        <input type="datetime-local" name="start_datetime" id="start_datetime"
                            value="{{ old('start_datetime', $eventToEdit->start_datetime ? \Carbon\Carbon::parse($eventToEdit->start_datetime)->format('Y-m-d\TH:i') : '') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
                            required>
                        @error('start_datetime')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- End Datetime -->
                    <div class="mb-4">
                        <label for="end_datetime" class="block text-gray-700 font-medium mb-2">End Date & Time</label>
                        <input type="datetime-local" name="end_datetime" id="end_datetime"
                            value="{{ old('end_datetime', $eventToEdit->end_datetime ? \Carbon\Carbon::parse($eventToEdit->end_datetime)->format('Y-m-d\TH:i') : '') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
                            required>
                        @error('end_datetime')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Max Participants -->
                    <div class="mb-4">
                        <label for="max_participants" class="block text-gray-700 font-medium mb-2">Max
                            Participants</label>
                        <input type="number" name="max_participants" id="max_participants"
                            value="{{ old('max_participants', $eventToEdit->max_participants) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                        @error('max_participants')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Scope -->
                    <div class="mb-4">
                        <label for="scope" class="block text-gray-700 font-medium mb-2">Scope</label>
                        <select name="scope" id="scope"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
                            required>
                            <option value="Public"
                                {{ old('scope', $eventToEdit->scope) == 'Public' ? 'selected' : '' }}>Public</option>
                            <option value="University"
                                {{ old('scope', $eventToEdit->scope) == 'University' ? 'selected' : '' }}>University
                            </option>
                        </select>
                        @error('scope')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- University -->
                    <div class="mb-4" id="university-wrapper">
                        <label for="university_id" class="block text-gray-700 font-medium mb-2">University</label>
                        <select name="university_id" id="university_id"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Select University --</option>
                            @foreach ($universities as $university)
                                <option value="{{ $university->id }}"
                                    {{ old('university_id', $eventToEdit->university_id) == $university->id ? 'selected' : '' }}>
                                    {{ $university->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('university_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="mb-4">
                        <label for="status" class="block text-gray-700 font-medium mb-2">Status</label>
                        <select name="status" id="status"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
                            required>
                            @foreach (['Draft', 'PendingApproval', 'Approved', 'Rejected', 'Completed'] as $s)
                                <option value="{{ $s }}"
                                    {{ old('status', $eventToEdit->status) == $s ? 'selected' : '' }}>
                                    {{ $s }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between">
                        <a href="{{ route('adminDashboard') }}"
                            class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">Cancel</a>
                        <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">Update
                            Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Toggle university field -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const scope = document.getElementById('scope');
            const uniWrapper = document.getElementById('university-wrapper');
            const uniSelect = document.getElementById('university_id');

            function toggleUniversity() {
                if (scope.value === 'University') {
                    uniWrapper.style.display = '';
                    uniSelect.required = true;
                } else {
                    uniWrapper.style.display = 'none';
                    uniSelect.required = false;
                    uniSelect.value = '';
                }
            }

            scope.addEventListener('change', toggleUniversity);
            toggleUniversity();
        });
    </script>
</x-app-layout>
