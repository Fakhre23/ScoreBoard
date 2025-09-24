{{-- resources/views/events/admin/listEvents.blade.php --}}
<div class="max-w-7xl mx-auto p-6" x-data="{ fullscreen: false, openId: null }">
    {{-- Card --}}
    <div :class="fullscreen ? 'fixed inset-0 z-50 m-0 p-6 bg-gray-50 overflow-auto' : 'bg-white shadow-md rounded-xl p-6'"
        class="transition-all duration-200">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-3">
            <h2 class="text-2xl font-bold text-gray-800">Event Management</h2>

            <div class="flex gap-2">
                <button @click="fullscreen = !fullscreen"
                    class="bg-blue-600 text-white px-4 py-1 rounded-lg hover:bg-blue-700 text-sm transition">
                    <span x-text="fullscreen ? 'Collapse' : 'Expand'"></span>
                </button>

                <a href="#"
                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded-lg shadow transition text-sm">
                    + Create Event
                </a>
            </div>
        </div>

        {{-- Table Wrapper --}}
        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-600 text-xs uppercase">
                    <tr>
                        <th class="py-3 px-4">Title</th>
                        <th class="py-3 px-4">Start</th>
                        <th class="py-3 px-4">Max Participants</th>
                        <th class="py-3 px-4">Scope</th>
                        <th class="py-3 px-4">University</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Created By</th>
                        <th class="py-3 px-4">Created At</th>
                        <th class="py-3 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($events as $event)
                        <tr class="hover:bg-gray-50 transition cursor-pointer"
                            @click="openId === {{ $event->id }} ? openId = null : openId = {{ $event->id }}">
                            <td class="py-3 px-4 font-medium text-gray-800">{{ $event->title }}</td>
                            <td class="py-3 px-4 text-gray-700">{{ $event->start_datetime }}</td>
                            <td class="py-3 px-4 text-gray-700">{{ $event->max_participants ?? '—' }}</td>
                            <td class="py-3 px-4 text-gray-700">{{ $event->scope }}</td>
                            <td class="py-3 px-4 text-gray-700">
                                {{ $event->university?->name ?? (\App\Models\University::find($event->university_id)?->name ?? '—') }}
                            </td>
                            <td class="py-3 px-4">
                                @php
                                    $status = $event->status ?? '—';
                                    $statusClasses = [
                                        'Draft' => 'bg-gray-200 text-gray-800',
                                        'PendingApproval' => 'bg-yellow-100 text-yellow-800',
                                        'Approved' => 'bg-green-100 text-green-800',
                                        'Rejected' => 'bg-red-100 text-red-800',
                                        'Completed' => 'bg-blue-100 text-blue-800',
                                    ];
                                    $badgeClass = $statusClasses[$status] ?? 'bg-gray-100 text-gray-800';
                                @endphp

                                <span class="inline-block px-3 py-1 rounded-full text-xs font-medium {{ $badgeClass }}">
                                    {{ $status }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-gray-700">
                                {{ $event->created_by?->name ?? (\App\Models\User::find($event->created_by)?->email ?? ($event->created_by ?? 'System')) }}
                            </td>
                            <td class="py-3 px-4 text-gray-700">{{ $event->created_at?->format('Y-m-d') ?? '—' }}</td>
                            <td class="py-3 px-4 flex gap-2">
                                <a href="#"
                                    class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600 transition">Edit</a>
                                <form method="POST" action="{{ route('events.delete', $event->id) }}"
                                    onsubmit="return confirm('Are you sure you want to delete this event?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition">Delete</button>
                                </form>
                            </td>
                        </tr>

                        {{-- Detail Row --}}
                        <tr x-show="openId === {{ $event->id }}" x-transition class="bg-gray-50">
                            <td colspan="11" class="py-3 px-4 text-gray-700 space-y-1">
                                <div><strong>Approved By:</strong> {{ $event->approved_by?->name ?? '—' }}</div>
                                <div><strong>Description:</strong> {{ $event->description ?? '—' }}</div>
                                <div><strong>Approval Date:</strong> {{ $event->approval_date ?? '—' }}</div>
                                <div><strong>Rejection Reason:</strong> {{ $event->rejection_reason ?? '—' }}</div>
                                <div><strong>Updated At:</strong> {{ $event->updated_at ?? '—' }}</div>
                                <div><strong>Location:</strong> {{ $event->location ?? '—' }}</div>
                                <div class="text-red-500"><strong>End Date:</strong> {{ $event->end_datetime ?? '—' }}</div>


                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
