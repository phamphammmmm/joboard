<!-- resources/views/pdf/companies.blade.php -->

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Fullname</th>
            <th>Birthday</th>
            <th>Email</th>
            <th>Major</th>
            <th>Type</th>
            <th>Location</th>
            <th>Social-network</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->fullname }}</td>
            <td>{{ $user->birthday }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->major }}</td>
            <td>{{ $user->type }}</td>
            <td>{{ $user->location }}</td>
            <td>{{ $user->social_network }}</td>
            <td>{{ $user->description }}</td>
        </tr>
        @endforeach
    </tbody>
</table>