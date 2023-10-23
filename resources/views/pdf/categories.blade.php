<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Category</th>
            <th>Created_at</th>
            <th>Updated_at</th>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->created_at->format('d/m/Y') }}</td>
            <td>{{ $category->updated_at->format('d/m/Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>