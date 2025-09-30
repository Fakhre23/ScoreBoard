{{-- resources/views/events/registerEvents.blade.php --}}
<div class="max-w-7xl mx-auto py-10 px-6">

    <h2 class="text-2xl font-bold mb-6 text-gray-800">
        Events you can register
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
                        <th class="px-6 py-3 font-semibold">Max Participants</th>
                        <th class="px-6 py-3 font-semibold">Scope</th>
                        <th class="px-6 py-3 font-semibold">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($userEvent as $index => $event)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-medium">{{ $event->title }}</td>
                            <td class="px-6 py-4">{{ Str::limit($event->description, 50) }}</td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</td>
                            <td class="px-6 py-4">{{ $event->max_participants }}</td>

                            <td class="px-6 py-4">
                                {{ optional($event->scope)->name ?? ($event->scope ?? 'N/A') }}
                            </td>

                            {{-- Register button --}}
                            <td class="px-6 py-4">
                                <form action="{{ route('events.register', ['event' => $event->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                                        Register
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
