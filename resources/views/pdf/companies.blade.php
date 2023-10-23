<!-- resources/views/pdf/companies.blade.php -->

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Company</th>
            <!-- Add more columns as needed -->
        </tr>
    </thead>
    <tbody>
        @foreach($companies as $company)
        <tr>
            <td>{{ $company->id }}</td>
            <td>{{ $company->name }}</td>
            <td>{{ $company->email }}</td>
            <td>{{ $company->description }}</td>
        </tr>
        @endforeach
    </tbody>
</table>