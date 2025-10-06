<x-admin-layout class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-2xl p-8">
        <h2 class="text-3xl font-extrabold text-gray-900 mb-8 border-b pb-4">Create Event</h2>

        <form method="POST" action="{{ route('events.store') }}" class="space-y-6">
            @csrf

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-semibold text-gray-700">Event Title</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                    class="mt-2 w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 p-3">
                @error('title')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700">Description</label>
                <textarea name="description" id="description" rows="4" required
                    class="mt-2 w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 p-3">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Location -->
            <div>
                <label for="location" class="block text-sm font-semibold text-gray-700">Location</label>
                <input type="text" name="location" id="location" value="{{ old('location') }}" required
                    class="mt-2 w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 p-3">
                @error('location')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Start Datetime -->
            <div>
                <label for="start_datetime" class="block text-sm font-semibold text-gray-700">Start Date & Time</label>
                <input type="datetime-local" name="start_datetime" id="start_datetime"
                    value="{{ old('start_datetime') }}" required
                    class="mt-2 w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 p-3">
                @error('start_datetime')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- End Datetime -->
            <div>
                <label for="end_datetime" class="block text-sm font-semibold text-gray-700">End Date & Time</label>
                <input type="datetime-local" name="end_datetime" id="end_datetime" value="{{ old('end_datetime') }}"
                    required
                    class="mt-2 w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 p-3">
                @error('end_datetime')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Max Participants -->
            <div>
                <label for="max_participants" class="block text-sm font-semibold text-gray-700">Max Participants</label>
                <input type="number" name="max_participants" id="max_participants" min="1"
                    value="{{ old('max_participants') }}"
                    class="mt-2 w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 p-3">
                @error('max_participants')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Scope -->
            @can('view', App\Models\User::class)
                <div>
                    <label for="scope" class="block text-sm font-semibold text-gray-700">Scope</label>
                    <select name="scope" id="scope" required
                        class="mt-2 w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 p-3 bg-white">
                        <option value="Public" {{ old('scope') === 'Public' ? 'selected' : '' }}>Public</option>
                        <option value="University" {{ old('scope') === 'University' ? 'selected' : '' }}>University
                        </option>
                    </select>
                    @error('scope')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endcan

            <!-- University (only visible if scope = University) -->
            <div id="university-wrapper" style="display: none;">
                <label for="university_id" class="block text-sm font-semibold text-gray-700">University</label>
                <select name="university_id" id="university_id"
                    class="mt-2 w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 p-3 bg-white">
                    <option value="">-- Select University --</option>
                    @foreach ($universities as $university)
                        <option value="{{ $university->id }}"
                            {{ old('university_id') == $university->id ? 'selected' : '' }}>
                            {{ $university->name }}
                        </option>
                    @endforeach
                </select>
                @error('university_id')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            @can('view', App\Models\User::class)
                <div>
                    <label for="status" class="block text-sm font-semibold text-gray-700">Status</label>
                    <select name="status" id="status" required
                        class="mt-2 w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 p-3 bg-white">
                        <option value="Draft" {{ old('status') === 'Draft' ? 'selected' : '' }}>Draft</option>
                        <option value="PendingApproval" {{ old('status') === 'PendingApproval' ? 'selected' : '' }}>Pending
                            Approval</option>
                        <option value="Approved" {{ old('status') === 'Approved' ? 'selected' : '' }}>Approved</option>
                        <option value="Rejected" {{ old('status') === 'Rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="Completed" {{ old('status') === 'Completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    @error('status')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endcan

            <!-- Submit -->
            <div class="pt-4">
                <button type="submit"
                    class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg transition-all duration-200 ease-in-out">
                    ✅ Create Event
                </button>
            </div>
        </form>
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
</x-admin-layout>
