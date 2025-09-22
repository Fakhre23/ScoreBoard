{{-- resources/views/users/listUsers.blade.php --}}
<div class="max-w-7xl mx-auto p-6" x-data="{ fullscreen: false }">
    {{-- Card --}}
    <div :class="fullscreen ? 'fixed inset-0 z-50 m-0 p-6 bg-gray-50 overflow-auto' : 'bg-white shadow-md rounded-xl p-6'"
        class="transition-all duration-200">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-3">
            {{-- Page Title --}}
            <h2 class="text-2xl font-bold text-gray-800">User Management</h2>

            {{-- Buttons --}}
            <div class="flex gap-2">
                {{-- Expand/Collapse Table --}}
                <button @click="fullscreen = !fullscreen"
                    class="bg-blue-600 text-white px-4 py-1 rounded-lg hover:bg-blue-700 text-sm transition">
                    <span x-text="fullscreen ? 'Collapse' : 'Expand'"></span>
                </button>

                {{-- Create User --}}
                <a href="{{ route('users.create') }}"
                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded-lg shadow transition text-sm">
                    + Create User
                </a>
            </div>
        </div>

        {{-- Table Wrapper --}}
        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-600 text-xs uppercase">
                    <tr>
                        <th class="py-3 px-4">Name</th>
                        <th class="py-3 px-4">Email</th>
                        <th class="py-3 px-4">Phone</th>
                        <th class="py-3 px-4">Role</th>
                        <th class="py-3 px-4">University</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Created At</th>
                        <th class="py-3 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-3 px-4 font-medium text-gray-800">{{ $user->name }}</td>
                            <td class="py-3 px-4 text-gray-700">{{ $user->email }}</td>
                            <td class="py-3 px-4 text-gray-700">{{ $user->phone }}</td>

                            {{-- Role --}}
                            <td class="py-3 px-4">
                                <form method="POST" action="{{ route('users.changeRole', $user->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <select name="userRole"
                                        class="border rounded-lg px-3 py-1 text-gray-800 w-full sm:w-auto"
                                        onchange="this.form.submit()">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ $user->user_role == $role->id ? 'selected' : '' }}>
                                                {{ $role->id === 1 ? 'Admin' : ($role->id === 2 ? 'Ambassador' : ($role->id === 3 ? 'Vice Ambassador' : ($role->id === 4 ? 'Representative' : 'Viewer'))) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>

                            {{-- University --}}
                            <td class="py-3 px-4">
                                <form method="POST" action="{{ route('users.changeUniversity', $user->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <select name="university_id"
                                        class="border rounded-lg px-3 py-1 text-gray-800 w-full sm:w-auto"
                                        onchange="this.form.submit()">
                                        @foreach ($universities as $university)
                                            <option value="{{ $university->id }}"
                                                {{ $user->university_id == $university->id ? 'selected' : '' }}>
                                                {{ $university->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>

                            {{-- Status --}}
                            <td class="py-3 px-4">
                                <form method="POST" action="{{ route('users.statusUpdate', $user->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <select name="is_active"
                                        class="border rounded-lg px-3 py-1 text-gray-800 text-sm w-full sm:w-auto"
                                        onchange="this.form.submit()">
                                        <option value="1" {{ $user->is_active ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Pending
                                        </option>
                                    </select>
                                </form>
                            </td>

                            {{-- Created At --}}
                            <td class="py-3 px-4 text-gray-700">
                                {{ $user->updated_at?->format('Y-m-d') ?? '—' }}
                            </td>

                            {{-- Actions --}}
                            <td class="py-3 px-4">
                                <form method="POST" action="{{ route('users.delete', $user->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition">
                                        Delete
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
