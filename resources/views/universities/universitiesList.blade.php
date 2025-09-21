<div class="container">
    <h1>Universities List</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($universities as $university)
                <tr>
                    <td>{{ $university->id }}</td>
                    <td>{{ $university->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
