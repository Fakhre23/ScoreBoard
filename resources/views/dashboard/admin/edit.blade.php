{{-- resources/views/users/listUsers.blade.php --}}
<div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg p-6">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Edit Users</h2>
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
                <form method="POST" action="{{ route('users.update', $user->id) }}">
                    @csrf
                    @method('PUT')

                    {{-- Name --}}
                    <td class="py-3 px-4">
                        <input type="text" name="name" value="{{ $user->name }}" class="border rounded px-2 py-1 w-full">
                    </td>

                    {{-- Email --}}
                    <td class="py-3 px-4">
                        <input type="email" name="email" value="{{ $user->email }}" class="border rounded px-2 py-1 w-full">
                    </td>

                    {{-- Phone --}}
                    <td class="py-3 px-4">
                        <input type="text" name="phone" value="{{ $user->phone }}" class="border rounded px-2 py-1 w-full">
                    </td>

                    {{-- Role Dropdown --}}
                    <td class="py-3 px-4">
                        <select name="user_role" class="border rounded px-2 py-1 w-full">
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ $user->user_role == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                            @endforeach
                        </select>
                    </td>

                    {{-- University Dropdown --}}
                    <td class="py-3 px-4">
                        <select name="university_id" class="border rounded px-2 py-1 w-full">
                            @foreach($universities as $university)
                            <option value="{{ $university->id }}" {{ $user->university_id == $university->id ? 'selected' : '' }}>
                                {{ $university->name }}
                            </option>
                            @endforeach
                        </select>
                    </td>

                    {{-- Status Dropdown --}}
                    <td class="py-3 px-4">
                        <select name="is_active" class="border rounded px-2 py-1 w-full">
                            <option value="1" {{ $user->is_active ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Pending</option>
                        </select>
                    </td>

                    {{-- Actions --}}
                    <td class="py-3 px-4">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                            Save
                        </button>
                    </td>
                </form>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>