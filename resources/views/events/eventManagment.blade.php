<x-admin-layout>
    <div class="h-screen flex flex-col p-4">
        {{-- Header Section - Fixed Height --}}
        <div class="flex-shrink-0 mb-4">
            <h2 class="text-xl font-bold text-gray-800 mb-2">
                Event: <span class="text-blue-600">{{ Str::limit($event->title, 40) }}</span>
            </h2>

            {{-- Event Info - Compact --}}
            <div class="bg-white shadow rounded p-3 text-sm">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                    <div><strong>Location:</strong> {{ Str::limit($event->location, 15) }}</div>
                    <div><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->start_datetime)->format('M d, Y') }}
                    </div>
                    <div><strong>Scope:</strong> {{ $event->scope }}</div>
                    <div><strong>Participants:</strong> {{ $event->actual_participants }}/{{ $event->max_participants }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Table Section - Fills Remaining Height --}}
        @if ($scoreClaims->isEmpty())
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded">
                <p>No users registered for this event yet.</p>
            </div>
        @else
            <div class="flex-1 overflow-hidden bg-white shadow rounded border">
                <div class="h-full overflow-auto">
                    <table class="w-full text-xs">
                        <thead class="bg-gray-100 text-gray-600 sticky top-0">
                            <tr>
                                <th class="py-2 px-2 text-left font-medium">#</th>
                                <th class="py-2 px-2 text-left font-medium">User Name</th>
                                <th class="py-2 px-2 text-left font-medium">Email</th>
                                <th class="py-2 px-2 text-left font-medium">Role</th>
                                <th class="py-2 px-2 text-left font-medium">Date</th>
                                <th class="py-2 px-2 text-left font-medium">Points</th>
                                <th class="py-2 px-2 text-left font-medium">Status</th>
                                <th class="py-2 px-2 text-left font-medium">Action</th>

                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($scoreClaims as $index => $claim)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-2 px-2">{{ $index + 1 }}</td>
                                    <td class="py-2 px-2 font-medium truncate max-w-24">
                                        <div title="{{ $users->find($claim->user_id)->name ?? 'N/A' }}">
                                            {{ Str::limit($users->find($claim->user_id)->name ?? 'N/A', 15) }}
                                        </div>
                                    </td>
                                    <td class="py-2 px-2 truncate max-w-32">
                                        <div title="{{ $users->find($claim->user_id)->email ?? 'N/A' }}">
                                            {{ Str::limit($users->find($claim->user_id)->email ?? 'N/A', 20) }}
                                        </div>
                                    </td>
                                    <td class="py-2 px-2">
                                        {{ $eventsRoles->find($claim->event_role_id)->name ?? 'No Role' }}
                                    </td>
                                    <td class="py-2 px-2 text-xs">
                                        {{ \Carbon\Carbon::parse($claim->created_at)->format('m/d/y H:i') }}
                                    </td>
                                    <td class="py-2 px-2" colspan="3">
                                        <form action="{{ route('events.updateRegisteredEventStatus', $claim->id) }}"
                                            method="POST" class="flex items-center space-x-1"
                                            onsubmit="return confirm('Update status for this user?');">
                                            @csrf
                                            @method('PATCH')

                                            <select name="attendance_status" class="border rounded px-1 py-1 text-xs">
                                                <option value="Registered"
                                                    {{ $claim->attendance_status === 'Registered' ? 'selected' : '' }}>
                                                    Registered
                                                </option>
                                                <option value="Attended"
                                                    {{ $claim->attendance_status === 'Attended' ? 'selected' : '' }}>
                                                    Attended
                                                </option>
                                                <option value="NoShow"
                                                    {{ $claim->attendance_status === 'NoShow' ? 'selected' : '' }}>
                                                    NoShow
                                                </option>
                                            </select>

                                            <input type="number" name="points_earned"
                                                value="{{ $claim->points_earned }}" min="0" step="1"
                                                class="w-16 border rounded px-1 py-1 text-xs" />

                                            <button type="submit"
                                                class="bg-blue-600 text-white px-2 py-1 rounded text-xs hover:bg-blue-700">
                                                Save
                                            </button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</x-admin-layout>
