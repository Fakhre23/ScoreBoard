<x-admin-layout class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="w-full max-w-6xl mx-auto px-4 py-8" x-data="{ fullscreen: false }">
        {{-- Header --}}
        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center gap-3">

                <h2 class="text-2xl font-bold text-gray-800">Queued Universities</h2>
                <a href="{{ route('adminDashboard') }}"
                    class="px-3 py-1 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 text-sm">
                    Back
                </a>
            </div>

            {{-- Expand Card Button --}}
            <button type="button" @click="fullscreen = !fullscreen"
                class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                <span x-text="fullscreen ? 'Collapse' : 'Expand'"></span>
            </button>
        </div>

        {{-- Card --}}
        <div :class="fullscreen ? 'fixed inset-0 z-50 m-0 p-6 bg-gray-50 overflow-auto' : ''"
            class="bg-white shadow-md rounded-lg p-4 w-full transition-all duration-200">

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-left text-sm">
                    <thead class="bg-gray-100 text-gray-800">
                        <tr>
                            <th class="px-3 py-2">ID</th>
                            <th class="px-3 py-2">Name</th>
                            <th class="px-3 py-2">Country</th>
                            <th class="px-3 py-2">Score</th>
                            <th class="px-3 py-2">Status</th>
                            <th class="px-3 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($universities as $university)
                            <tr x-data="{ open: false }" class="hover:bg-gray-50 transition">
                                <td class="px-3 py-2">{{ $university->id }}</td>
                                <td class="px-3 py-2 font-semibold">{{ $university->name }}</td>
                                <td class="px-3 py-2">{{ $university->country }}</td>
                                <td class="px-3 py-2">{{ $university->total_score }}</td>

                                {{-- Status Dropdown --}}
                                <td class="px-3 py-2">
                                    <form method="POST"
                                        action="{{ route('universities.statusUpdate', $university->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <select name="UniversityStatus" onchange="this.form.submit()"
                                            class="border rounded px-2 py-1 w-32 text-sm {{ $university->status ? 'bg-green-50 border-green-400 text-green-800' : 'bg-red-50 border-red-400 text-red-800' }}">
                                            <option value="1" {{ $university->status ? 'selected' : '' }}
                                                class="text-green-800">Active</option>
                                            <option value="0" {{ !$university->status ? 'selected' : '' }}
                                                class="text-red-800">Pending</option>
                                        </select>
                                    </form>
                                </td>

                                {{-- Actions --}}
                                <td class="px-3 py-2">
                                    <div class="flex gap-2">
                                        <a href="{{ route('universities.edit', $university->id) }}"
                                            class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs">Edit</a>

                                    </div>
                                </td>
                            </tr>

                            {{-- Details row --}}
                            <tr x-show="open" x-cloak class="bg-gray-50 text-sm">
                                <td colspan="6" class="px-3 py-2">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                                        <div>
                                            <strong>About:</strong>
                                            <p>{{ $university->description ?? 'No description.' }}</p>
                                        </div>
                                        <div>
                                            <strong>Website:</strong>
                                            <p>
                                                @if ($university->website)
                                                    <a href="{{ $university->website }}" target="_blank"
                                                        class="text-blue-600">
                                                        {{ $university->website }}
                                                    </a>
                                                @else
                                                    —
                                                @endif
                                            </p>
                                        </div>
                                        <div>
                                            <strong>Meta:</strong>
                                            <p>
                                                Created: {{ $university->created_at->format('M d, Y') ?? '—' }}<br>
                                                Updated: {{ $university->updated_at->diffForHumans() ?? '—' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-3 py-10 text-center text-gray-500">
                                    No queued universities found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>
