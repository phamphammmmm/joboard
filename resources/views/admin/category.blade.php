<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/admin/category.css') }}">
    </style>
</head>

<body>
    @extends('admin.dashboard')
    @section('content')
    <div class="container">
        <div class="header">
            <h1>Category</h1>
            <div class="interac-btn">
                <div class="add-category-container">
                    <button id="addCategoryBtn" class="add-category-btn">Add Category</button>
                </div>
                <div class="export-category-container">
                    <button id="exportCategoryBtn" class="export-category-btn">
                        <a href="{{ route('category.export') }}" style="color:white">Export to PDF</a>
                    </button>
                </div>
            </div>
        </div>
        @if (!empty($categories))
        <div class="content-category">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Preview</th>
                        <th>Category</th>
                        <th>Created_at</th>
                        <th>Update_at</th>
                        <th class="actions">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                    <tr>
                        <td data-id="{{ $category->id }}">{{ $category->id }}</td>
                        <td class="path" data-id="{{ $category->id }}">
                            <img src="{{ asset( $category->path) }}" alt="path">
                        </td>
                        <td class="name" data-id="{{ $category->id }}">{{ $category->name }}</td>
                        <td>{{$category->created_at->format('m/d/Y')}}</td>
                        <td>{{$category->updated_at->format('m/d/Y')}}</td>
                        <td class="action-buttons">
                            <button class="edit-category-btn" data-id="{{ $category->id }}">
                                <img src="{{asset('storage/logo/draw.png')}}" alt="edit">
                            </button>
                            <form method="POST" action="">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure to delete?')">
                                    <img src="{{asset('storage/logo/trash.png')}}" alt="trash">
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p>No categories found.</p>
        @endif
    </div>

    <!-- Edit popup -->
    <div class="popup-overlay">
        <div class="popup-content">
            <h2>Edit Category</h2>
            <form id="editCategoryForm" action="{{ route('category.update') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('POST')
                <input type="hidden" id="category_id" name="category_id" value="">
                <div class="form-row">
                    <label for="name">Category:</label>
                    <input type="text" id="name" name="name" placeholder="Category Name">
                </div>
                <div class="form-row">
                    <label for="path">Preview:</label>
                    <input type="file" name="path" accept="image/*">
                </div>
                <button type="submit" id="save-button" class="save-button">Save</button>
            </form>
        </div>
    </div>

    <!-- Add popup -->
    <div class="popup-overlay" id="addCategoryPopup">
        <div class="popup-content">
            <h3>Add Category</h3>
            <form id="addCategoryForm" method="POST" action="{{ route('category.create') }}"
                enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="form-row">
                    <label for="name">Category:</label>
                    <input type="text" name="name" placeholder="Category Name">
                </div>
                <div class="form-row">
                    <label for="path">Preview:</label>
                    <input type="file" name="path" accept="image/*">
                </div>
                <button type="submit" id="addCategoryPopupBtn" class="add-button">Add Category</button>
            </form>
        </div>
    </div>
    @endsection
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="{{ asset('js/admin/category.js') }}"></script>
</body>

</html>