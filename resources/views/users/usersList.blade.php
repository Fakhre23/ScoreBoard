{{-- resources/views/users/listUsers.blade.php --}}
<div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg p-6">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">User Management</h2>
        <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">
            + Create User
        </a>
    </div>

    {{-- Users Table --}}
    <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="py-3 px-4 text-left font-semibold text-gray-600">Name</th>
                <th class="py-3 px-4 text-left font-semibold text-gray-600">Email</th>
                <th class="py-3 px-4 text-left font-semibold text-gray-600">Phone</th>
                <th class="py-3 px-4 text-left font-semibold text-gray-600">Role</th>
                <th class="py-3 px-4 text-left font-semibold text-gray-600">University</th>
                <th class="py-3 px-4 text-left font-semibold text-gray-600">Status</th>
                <th class="py-3 px-4 text-left font-semibold text-gray-600">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="border-b hover:bg-gray-50">
                {{-- Name --}}
                <td class="py-3 px-4 text-gray-800">{{ $user->name }}</td>

                {{-- Email --}}
                <td class="py-3 px-4 text-gray-800">{{ $user->email }}</td>

                {{-- Phone --}}
                <td class="py-3 px-4 text-gray-800">{{ $user->phone }}</td>

                {{-- Role Dropdown --}}
                <td class="py-3 px-4">
                    <select class="border rounded px-7 py-1 text-gray-800">
                        @foreach($roles as $role)
                        <option value="{{ $role->id }}"
                            {{ $user->user_role == $role->id ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                        @endforeach
                    </select>
                </td>

                {{-- University --}}
                <td class="py-3 px-4 text-gray-800">{{ $user->university_name }}</td>

                {{-- Status Badge --}}
                <td class="py-3 px-4">
                    @if($user->is_active)
                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Active</span>
                    @else
                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">Pending</span>
                    @endif
                </td>

                {{-- Actions --}}
                <td class="py-3 px-4">
                    <form method="POST" action="{{ route('users.delete', $user->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>