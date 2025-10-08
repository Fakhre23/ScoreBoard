@php
    $role = auth()->user()->user_role ?? null;

    // map role ids to blade layout component names
    $layout = match ($role) {
        1 => 'admin-layout', // admin
        4 => 'stu-layout', // student
        2 => 'amb-layout', // ambassador
        3 => 'vice-layout', // vice
        default => 'stu-layout',
    };
@endphp

<x-dynamic-component :component="$layout">
    <div class="max-w-6xl mx-auto p-8 bg-white shadow-md rounded-lg mt-6">
        <h2 class="text-2xl font-bold mb-6 text-gray-800"> Score History</h2>

        @if ($ScoreHistory->isEmpty())
            <p class="text-gray-600">No score records found.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 rounded-lg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-gray-700 font-semibold">#</th>
                            <th class="px-6 py-3 text-left text-gray-700 font-semibold">User Name</th>
                            <th class="px-6 py-3 text-left text-gray-700 font-semibold">Event</th>
                            <th class="px-6 py-3 text-left text-gray-700 font-semibold">Points</th>
                            <th class="px-6 py-3 text-left text-gray-700 font-semibold">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ScoreHistory as $index => $score)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-6 py-3 text-gray-800">{{ $index + 1 }}</td>
                                <td class="px-6 py-3 text-gray-800">
                                    {{ $score->user->name }}
                                </td>
                                <td class="px-6 py-3 text-gray-800">
                                    {{ $score->event->title ?? 'Unknown Event' }}
                                </td>
                                <td class="px-6 py-3 text-gray-800 font-semibold">
                                    {{ $score->points_earned ?? '0' }}
                                </td>
                                <td class="px-6 py-3 text-gray-800">
                                    {{ $score->created_at->format('d M Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-dynamic-component>
