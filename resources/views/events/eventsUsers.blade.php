{{-- resources/views/events/registerEvents.blade.php --}}
<div class="max-w-7xl mx-auto py-10 px-6">

    {{-- Page Header --}}
    <h2 class="text-2xl font-bold mb-6 text-gray-800">
        Approved Events for Your University
    </h2>

    {{-- Check if events exist --}}
    @if ($userEvent->isEmpty())
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-md">
            <p>No approved events available at the moment.</p>
        </div>
    @else
        {{-- Events Table --}}
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full text-left text-gray-700">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3 font-semibold">#</th>
                        <th class="px-6 py-3 font-semibold">Event Name</th>
                        <th class="px-6 py-3 font-semibold">Description</th>
                        <th class="px-6 py-3 font-semibold">Date</th>
                        <th class="px-6 py-3 font-semibold">Scope</th>
                        <th class="px-6 py-3 font-semibold">Max Participants</th>
                        <th class="px-6 py-3 font-semibold">Actual Participants</th>
                        <th class="px-6 py-3 font-semibold">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($userEvent as $index => $event)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-medium">{{ $event->title }}</td>
                            <td class="px-6 py-4">{{ Str::limit($event->description, 50) }}</td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($event->start_datetime)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">{{ $event->scope }}</td>
                            <td class="px-6 py-4 text-red-500">{{ $event->max_participants }}</td>
                            <td class="px-6 py-4 text-green-500">{{ $event->actual_participants }}</td>
                            <td class="px-6 py-4">
                                @if ($event->actual_participants >= $event->max_participants)
                                    <button disabled
                                        class="bg-gray-300 text-white px-4 py-2 rounded cursor-not-allowed">
                                        Full
                                    </button>
                                    {{--    @elseif ($scoreClaims->where('user_id', auth()->id())->where('event_id', $event->id)->exists())
                                    <button disabled
                                        class="bg-gray-300 text-white px-4 py-2 rounded cursor-not-allowed">
                                        Registered
                                    </button> --}}
                                @else
                                    <a href="{{ route('events.registerUser', $event->id) }}"
                                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                                        Register
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
