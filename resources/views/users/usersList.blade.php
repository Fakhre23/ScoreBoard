{{-- resources/views/users/listUsers.blade.php --}}
<div class="max-w-7xl mx-auto bg-white shadow-md rounded-xl p-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-3">
        <h2 class="text-2xl font-bold text-gray-800">User Management</h2>
        <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-lg shadow transition">
            + Create User
        </a>
    </div>

    {{-- Table Wrapper (for responsiveness) --}}
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
                    <th class="py-3 px-4">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($users as $user)
                    <tr class="hover:bg-gray-50 transition">
                        {{-- Name --}}
                        <td class="py-3 px-4 font-medium text-gray-800">{{ $user->name }}</td>

                        {{-- Email --}}
                        <td class="py-3 px-4 text-gray-700">{{ $user->email }}</td>

                        {{-- Phone --}}
                        <td class="py-3 px-4 text-gray-700">{{ $user->phone }}</td>

                        {{-- Role Dropdown --}}
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

                        {{-- University Dropdown --}}
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

                        {{-- Status Badge --}}
                        <td class="py-3 px-4">
                            <form method="POST" action="{{ route('users.statusUpdate', $user->id) }}">
                                @csrf
                                @method('PATCH')
                                <select name="is_active"
                                    class="border rounded-lg px-3 py-1 text-gray-800 text-sm w-full sm:w-auto"
                                    onchange="this.form.submit()">
                                    <option value="1" {{ $user->is_active ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Pending</option>
                                </select>
                            </form>
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
