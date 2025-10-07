@php
    $role = auth()->user()->user_role ?? null;

    $layout = match ($role) {
        1 => 'admin-layout',
        4 => 'stu-layout',
        2 => 'amb-layout',
        3 => 'vice-layout',
        default => 'stu-layout',
    };
@endphp

<x-dynamic-component :component="$layout">
    <div class="max-w-7xl mx-auto p-6" 
         x-data="{ fullscreen: false, openEvent: null }">

        {{-- Main Card --}}
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

                    <a href="{{ route('events.queue') }}"
                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded-lg shadow transition text-sm">
                        View Queued Events
                    </a>

                    <a href="{{ route('events.create') }}"
                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded-lg shadow transition text-sm">
                        + Create Event
                    </a>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-100 text-gray-600 text-xs uppercase">
                        <tr>
                            <th class="py-3 px-4">Title</th>
                            <th class="py-3 px-4 text-center">Participants</th>
                            <th class="py-3 px-4 text-center">Scope</th>
                            <th class="py-3 px-4 text-center">University</th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4 text-center">Created</th>
                            @can('viewAny', App\Models\User::class)
                                <th class="py-3 px-4 text-center">Actions</th>
                            @endcan
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @foreach ($events as $event)
                            <tr class="hover:bg-gray-50 transition cursor-pointer"
                                @click="if (!$event.target.closest('button') && !$event.target.closest('a')) openEvent = {{ $event->id }}">

                                <td class="py-3 px-4 font-medium text-gray-800">{{ $event->title }}</td>
                                <td class="py-3 px-4 text-center text-green-700">{{ $event->actual_participants }}</td>
                                <td class="py-3 px-4 text-center">{{ $event->scope }}</td>
                                <td class="py-3 px-4 text-center">
                                    {{ $event->university?->name ?? (\App\Models\University::find($event->university_id)?->name ?? '—') }}
                                </td>

                                {{-- Status Badge --}}
                                <td class="py-3 px-4 text-center">
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

                                <td class="py-3 px-4 text-center">
                                    {{ $event->created_at ? strtoupper($event->created_at->format('j-M')) : '—' }}
                                </td>

                                <td class="py-3 px-4 text-center">
                                    <div class="flex gap-2 justify-center">
                                        @can('view', App\Models\User::class)
                                            <a href="{{ route('events.edit', $event->id) }}"
                                                class="bg-green-500 text-white px-3 py-1 rounded-lg hover:bg-green-600 transition text-sm">
                                                Edit
                                            </a>
                                        @endcan
                                        @can('viewAny', App\Models\User::class)
                                            <a href="{{ route('events.eventUsersManagement', $event->id) }}"
                                                class="bg-blue-400 text-white px-3 py-1 rounded-lg hover:bg-blue-500 transition text-sm">
                                                Manage
                                            </a>
                                        @endcan
                                        @can('view', App\Models\User::class)
                                            <form method="POST" action="{{ route('events.delete', $event->id) }}"
                                                onsubmit="return confirm('Are you sure you want to delete this event?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition text-sm">
                                                    Delete
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>

                            {{-- Popup Modal --}}
                            <div x-show="openEvent === {{ $event->id }}" 
                                @click.away="openEvent = null"
                                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40"
                                x-transition>
                                <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 relative">
                                    <button @click="openEvent = null"
                                        class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">&times;</button>

                                    <h3 class="text-xl font-bold text-gray-800 mb-4">
                                        {{ $event->title }}
                                    </h3>

                                    <div class="space-y-2 text-gray-700 text-sm">
                                        <p><strong>University:</strong> 
                                            {{ $event->university?->name ?? '—' }}
                                        </p>
                                        <p><strong>Created By:</strong> 
                                            {{ \App\Models\User::find($event->created_by)?->email ?? 'System' }}
                                        </p>
                                        <p><strong>Approved By:</strong> 
                                            {{ \App\Models\User::find($event->approved_by)?->email ?? '—' }}
                                        </p>
                                        <p><strong>Description:</strong> {{ $event->description ?? '—' }}</p>
                                        <p><strong>Approval Date:</strong> {{ $event->approval_date ?? '—' }}</p>
                                        <p><strong>Rejection Reason:</strong> {{ $event->rejection_reason ?? '—' }}</p>
                                        <p><strong>Updated At:</strong> {{ $event->updated_at ?? '—' }}</p>
                                        <p><strong>Location:</strong> {{ $event->location ?? '—' }}</p>
                                        <p><strong>Max Participants:</strong> {{ $event->max_participants ?? '—' }}</p>
                                        <p><strong>Start Date:</strong> {{ $event->start_datetime ?? '—' }}</p>
                                        <p><strong>End Date:</strong> {{ $event->end_datetime ?? '—' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-dynamic-component>
