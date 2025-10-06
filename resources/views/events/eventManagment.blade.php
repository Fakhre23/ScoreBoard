{{-- resources/views/events/eventManagment.blade.php --}}
<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-6">

        {{-- Page Header --}}
        <h2 class="text-2xl font-bold mb-6 text-gray-800">
            Registered Users for Event: <span class="text-blue-600">{{ $event->title }}</span>
        </h2>

        {{-- Event Info --}}
        <div class="mb-6 bg-white shadow rounded-lg p-4">
            <p><strong>Description:</strong> {{ $event->description }}</p>
            <p><strong>Location:</strong> {{ $event->location }}</p>
            <p><strong>Date:</strong>
                {{ \Carbon\Carbon::parse($event->start_datetime)->format('d M Y H:i') }} -
                {{ \Carbon\Carbon::parse($event->end_datetime)->format('d M Y H:i') }}
            </p>
            <p><strong>Scope:</strong> {{ $event->scope }}</p>
            <p><strong>Participants:</strong>
                {{ $event->actual_participants }} / {{ $event->max_participants }}
            </p>
        </div>

        {{-- Registered Users Table --}}
        @if ($scoreClaims->isEmpty())
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-md">
                <p>No users registered for this event yet.</p>
            </div>
        @else
            <div class="overflow-x-auto bg-white shadow-md rounded-lg">
                <table class="min-w-full text-left text-gray-700">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-6 py-3 font-semibold">#</th>
                            <th class="px-6 py-3 font-semibold">User Name</th>
                            <th class="px-6 py-3 font-semibold">Email</th>
                            <th class="px-6 py-3 font-semibold">Role</th>
                            <th class="px-6 py-3 font-semibold">Attendance</th>
                            <th class="px-6 py-3 font-semibold">Points</th>
                            <th class="px-6 py-3 font-semibold">Registered At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($scoreClaims as $index => $claim)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 font-medium">
                                    {{ $users->find($claim->user_id)->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4">{{ $users->find($claim->user_id)->email ?? 'N/A' }}</td>
                                <td class="px-6 py-4">
                                    {{ $eventsRoles->find($claim->event_role_id)->name ?? 'No Role' }}
                                </td>
                                <td class="px-6 py-4" colspan="2">
                                    <form action="#" method="POST"
                                        class="flex items-center space-x-2">
                                        @csrf
                                        @method('PATCH')

                                        <select name="attendance_status" class="border rounded px-2 py-1">
                                            <option value="present"
                                                {{ $claim->attendance_status === 'present' ? 'selected' : '' }}>Present
                                            </option>
                                            <option value="absent"
                                                {{ $claim->attendance_status === 'absent' ? 'selected' : '' }}>Absent
                                            </option>
                                            <option value="late"
                                                {{ $claim->attendance_status === 'late' ? 'selected' : '' }}>Late
                                            </option>
                                            <option value="excused"
                                                {{ $claim->attendance_status === 'excused' ? 'selected' : '' }}>Excused
                                            </option>
                                        </select>

                                        <input type="number" name="points_earned" value="{{ $claim->points_earned }}"
                                            min="0" step="1" class="w-24 border rounded px-2 py-1" />

                                        <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                            Save
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($claim->created_at)->format('d M Y H:i') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
