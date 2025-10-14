@props(['action', 'placeholder' => 'Search...'])

<form method="GET" action="{{ $action }}" class="flex items-center gap-2 mb-6">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ $placeholder }}"
        class="w-full sm:w-64 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition">
        Search
    </button>
    @if (request('search'))
        <a href="{{ $action }}" class="text-gray-500 text-sm hover:underline ml-2">Clear</a>
    @endif
</form>
