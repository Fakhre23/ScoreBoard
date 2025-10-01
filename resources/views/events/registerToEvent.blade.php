{{-- resources/views/events/registerToEvent.blade.php --}}
<x-app-layout>
    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-6">
                    @if (isset($event))
                        {{-- Event card --}}
                        <div class="mb-6">
                            <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $event->title ?? 'Untitled Event' }}
                            </h1>

                            @if (!empty($event->description))
                                <p class="text-gray-600 mb-4 leading-relaxed">{{ $event->description }}</p>
                            @endif

                            <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-6 text-sm text-gray-500">
                                @if (!empty($event->date))
                                    <div class="flex items-center mb-2 sm:mb-0">
                                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3M3 11h18M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2z" />
                                        </svg>
                                        <span>{{ optional($event->date)->format('F j, Y H:i') ?? $event->date }}</span>
                                    </div>
                                @endif

                                @if (!empty($event->location))
                                    <div class="flex items-center mb-2 sm:mb-0">
                                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 11c1.657 0 3-1.567 3-3.5S13.657 4 12 4 9 5.567 9 7.5 10.343 11 12 11z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 21s8-4.5 8-10.5S14.418 3 12 3 4 6 4 10.5 12 21 12 21z" />
                                        </svg>
                                        <span>{{ $event->location }}</span>
                                    </div>
                                @endif

                                @if (!empty($event->capacity))
                                    <div class="flex items-center">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                            Capacity: {{ $event->capacity }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Registration form --}}
                        <form method="POST" action="{{ route('events.storeUserEvent', $event->id ?? $event) }}"
                            class="space-y-4">
                            @csrf

                            <div>
                                <label for="role_id" class="block text-sm font-medium text-gray-700">Choose your
                                    role</label>
                                @php
                                    // Prefer $eventsRoles from your controller, fall back to $roles or $event->roles
                                    $rolesList = $eventsRoles ?? ($roles ?? ($event->roles ?? collect()));
                                @endphp

                                @if ($rolesList->isEmpty())
                                    <div
                                        class="mt-2 text-sm text-yellow-700 bg-yellow-50 border border-yellow-100 p-3 rounded">
                                        No roles available for this event.
                                    </div>
                                @else
                                    <div class="relative mt-2">
                                        <select name="role_id" id="role_id"
                                            class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('role_id') border-red-500 @enderror"
                                            aria-describedby="role-help">
                                            <option value="">-- Select role --</option>

                                            @foreach ($rolesList as $role)
                                                <option value="{{ $role->id }}"
                                                    {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                                    {{ $role->name }}{{ isset($role->description) ? ' — ' . $role->description : '' }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                                                aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M10 3a1 1 0 01.832.445l5 7a1 1 0 01-.832 1.555H5a1 1 0 01-.832-1.555l5-7A1 1 0 0110 3z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>

                                    @error('role_id')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror

                                    <p id="role-help" class="mt-2 text-xs text-gray-500">Select the role you want to
                                        register for. If you need a different role, contact the organizer.</p>
                                @endif
                            </div>

                            <div class="pt-4 border-t border-gray-100 flex justify-end">
                                <a href="{{ url()->previous() }}"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 mr-2">
                                    Cancel
                                </a>

                                <button type="submit"
                                    class="inline-flex items-center px-5 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    Register
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="p-6 bg-yellow-50 border border-yellow-100 rounded">
                            <p class="text-yellow-800">Event not found.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
