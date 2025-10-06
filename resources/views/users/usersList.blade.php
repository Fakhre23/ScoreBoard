<x-admin-layout>
    <div class="max-w-full mx-auto p-4" x-data="{ fullscreen: false }">
        {{-- ******** Compact Header Section ******** --}}
        <div class="flex justify-between items-center mb-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">User Management</h2>
                <p class="text-gray-500 text-xs">Manage user roles, universities, and access permissions.</p>
            </div>

            <div class="flex gap-2">
                <button @click="fullscreen = !fullscreen"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs transition-all shadow">
                    <span x-text="fullscreen ? 'Collapse' : 'Expand'"></span>
                </button>

                @can('view', App\Models\User::class)
                    <a href="{{ route('users.create') }}"
                        class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded shadow text-xs">
                        + Add User
                    </a>
                @endcan
            </div>
        </div>

        {{-- ******** Compact Table Section ******** --}}
        <div :class="fullscreen ? 'fixed inset-0 z-50 bg-gray-50 p-4 overflow-hidden' : ''"
            class="transition-all duration-200">
            <div class="bg-white shadow rounded-lg border border-gray-200 overflow-hidden">
                <table class="w-full text-xs text-gray-700">
                    <thead class="bg-gray-50 text-gray-600 uppercase tracking-wide">
                        <tr>
                            <th class="py-2 px-2 text-left">Name</th>
                            <th class="py-2 px-2 text-left">Email</th>
                            <th class="py-2 px-2 text-left">Phone</th>
                            <th class="py-2 px-2 text-left">Role</th>
                            <th class="py-2 px-2 text-left">University</th>
                            <th class="py-2 px-2 text-left">Status</th>
                            <th class="py-2 px-2 text-left">Date</th>
                            <th class="py-2 px-2 text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @foreach ($users as $user)
                            <tr class="hover:bg-gray-25 transition">
                                {{-- Name --}}
                                <td class="py-2 px-2 font-medium text-gray-800 max-w-[120px] truncate">
                                    <span title="{{ $user->name }}">{{ $user->name }}</span>
                                </td>

                                {{-- Email --}}
                                <td class="py-2 px-2 max-w-[150px] truncate">
                                    <span title="{{ $user->email }}">{{ $user->email }}</span>
                                </td>

                                {{-- Phone --}}
                                <td class="py-2 px-2 max-w-[100px] truncate">{{ $user->phone }}</td>

                                {{-- Role Dropdown --}}
                                <td class="py-2 px-2">
                                    <form method="POST" action="{{ route('users.changeRole', $user->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <select name="userRole"
                                            class="border rounded px-2 py-1 text-xs w-full max-w-[100px]"
                                            onchange="if(confirm('Change role for {{ $user->name }}?')) this.form.submit();">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}"
                                                    {{ $user->user_role == $role->id ? 'selected' : '' }}>
                                                    {{ $role->id === 1 ? 'Admin' : ($role->id === 2 ? 'Ambassador' : ($role->id === 3 ? 'Vice Amb.' : ($role->id === 4 ? 'Rep.' : 'Viewer'))) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </td>

                                {{-- University Dropdown --}}
                                <td class="py-2 px-2">
                                    <form method="POST" action="{{ route('users.changeUniversity', $user->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <select name="university_id"
                                            class="border rounded px-2 py-1 text-xs w-full max-w-[120px]"
                                            onchange="if(confirm('Change university for {{ $user->name }}?')) this.form.submit();">
                                            @foreach ($universities as $university)
                                                <option value="{{ $university->id }}"
                                                    {{ $user->university_id == $university->id ? 'selected' : '' }}
                                                    title="{{ $university->name }}">
                                                    {{ Str::limit($university->name, 15) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </td>

                                {{-- Status --}}
                                <td class="py-2 px-2">
                                    <form method="POST" action="{{ route('users.statusUpdate', $user->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <select name="is_active"
                                            class="rounded px-2 py-1 text-xs border w-full max-w-[80px]
                                            {{ $user->is_active ? 'bg-green-50 border-green-300 text-green-700' : 'bg-red-50 border-red-300 text-red-700' }}"
                                            onchange="if(confirm('Change status for {{ $user->name }}?')) this.form.submit();">
                                            <option value="1" {{ $user->is_active ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Pending
                                            </option>
                                        </select>
                                    </form>
                                </td>

                                {{-- Created At --}}
                                <td class="py-2 px-2 text-gray-600 text-xs">
                                    {{ $user->created_at?->format('m/d/y') ?? '—' }}
                                </td>

                                {{-- Actions --}}
                                <td class="py-2 px-2 text-center">
                                    <form method="POST" action="{{ route('users.delete', $user->id) }}"
                                        onsubmit="return confirm('Delete {{ $user->name }} permanently?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs transition-all">
                                            Del
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>
