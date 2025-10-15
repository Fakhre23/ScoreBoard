<x-admin-layout>
    {{-- resources/views/universities/listUniversities.blade.php --}}
    <div class="max-w-7xl mx-auto bg-white shadow-md rounded-xl p-6">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-6">
            <!-- First block -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                <h2 class="text-2xl font-bold text-gray-800">University Management</h2>

            </div>

            <!-- Second block -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                <a href="{{ route('universities.notActive') }}"
                    class="bg-green-500 hover:bg-green-600 text-white px-5 py-2 rounded-lg shadow transition">
                    Queue University

                </a>
                <h2 class="text-2xl font-bold text-gray-800"></h2>
                <a href="{{ route('universities.create') }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-lg shadow transition">
                    + Create University
                </a>
            </div>
        </div>
        <div class="mb-4">
            <x-search-bar :action="route('universities.list')" placeholder="Search universities by name ,status" />
            {{-- the colon mean (im passing a variable or expression) --}}
        </div>


        {{-- Table Wrapper --}}
        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-600 text-xs uppercase">
                    <tr>
                        {{-- <th class="py-3 px-4">Logo</th> --}}
                        <th class="py-3 px-4">Name</th>
                        <th class="py-3 px-4">Country</th>
                        <th class="py-3 px-4">Total Score</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Created At</th>
                        <th class="py-3 px-4">Updated At</th>
                        <th class="py-3 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($universities->sortBy('created_at') as $university)
                        {{--  <tr class="hover:bg-gray-50 transition cursor-pointer"
                        onclick="window.location='{{ route('universities.show', $university->id) }}'">

                     
                        <td class="py-3 px-4">
                            @if ($university->UNI_photo)
                                <img src="{{ asset('storage/' . $university->UNI_photo) }}"
                                    alt="{{ $university->name }}" class="h-10 w-10 rounded-full object-cover">
                            @else
                                <span class="text-gray-400 italic">No Image</span>
                            @endif
                        </td> --}}


                        {{-- Name --}}
                        <td class="py-3 px-4 font-medium text-gray-800">{{ $university->name }}</td>

                        {{-- Country --}}
                        <td class="py-3 px-4 text-gray-700">{{ $university->country ?? '-' }}</td>

                        {{-- Total Score --}}
                        <td class="py-3 px-4 text-gray-700">{{ $university->total_score ?? 0 }}</td>

                        {{-- Status Dropdown --}}
                        <td class="py-3 px-4">
                            <form method="POST" action="{{ route('universities.statusUpdate', $university->id) }}">
                                @csrf
                                @method('PATCH')
                                <select name="UniversityStatus"
                                    class="border rounded-lg px-6 py-1 text-sm w-full sm:w-auto {{ $university->Status ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800' }}"
                                    onfocus="this.dataset.prev = this.value"
                                    onchange="if (!confirm('Are you sure you want to change the status?')) { this.value = this.dataset.prev; return; } this.form.submit();">
                                    <option value="1" {{ $university->Status ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !$university->Status ? 'selected' : '' }}>Pending</option>
                                </select>
                            </form>
                        </td>

                        {{-- Created At --}}
                        <td class="py-3 px-4 text-gray-700">
                            {{ $university->created_at->format('M d, Y') }}
                        </td>
                        {{-- updated at --}}
                        <td class="py-3 px-4 text-gray-700">
                            {{ $university->updated_at->format('M d, Y') }}
                        </td>

                        {{-- Actions --}}
                        <td class="py-3 px-4 flex gap-2">
                            {{-- Edit --}}
                            <a href="{{ route('universities.edit', $university->id) }}"
                                class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600 transition">
                                Edit
                            </a>

                            {{-- Delete --}}
                            <form method="POST" action="{{ route('universities.delete', $university->id) }}"
                                onsubmit="return confirm('Are you sure you want to delete this university?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition">
                                    Delete
                                </button>
                            </form>
                        </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
