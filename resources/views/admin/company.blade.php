<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/admin/company.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
    <title>Company</title>
</head>

<body>
    @extends('admin.dashboard')
    @section('content')
    <div class="header-title">
        <div class="header">
            <h1>Company</h1>
            <div class="add-Company-container">
                <button id="addCompanyBtn" class="add-company-btn">Add Company</button>
            </div>
        </div>
        <p>Company Page</p>
    </div>
    <div class="navigation-navbar">
        <div class="search">
            <div class="search-input">
                <form action="{{ route('company.search') }}" method="GET" id="search-form">
                    <button type="submit" id="search-icon-btn">
                        <ion-icon name="search-outline" role="img" class="md hydrated" style="margin: 0px 5px;">
                        </ion-icon>
                    </button>
                    <input type="text" name="search" placeholder="Search">
                </form>
            </div>
            <select name="time-created" class="time-created">
                @foreach($companies as $company)
                <option value="{{ $company->created_at }}">
                    {{ $company->created_at->format('Y-m-d H:i:s') }}
                </option>
                @endforeach
            </select>
            <button type="button" id="show-all-button">
                <ion-icon name="refresh-outline"></ion-icon>
            </button>
        </div>
        <div class="import">
            <ion-icon name="download-outline"></ion-icon>
            <a href="{{ route('company.export') }}" style="color:white">Export to PDF</a>
        </div>
    </div>
    </div>
    <div class="container">
        @if (!empty($companies))
        <div class="content-company">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Preview</th>
                        <th>Company</th>
                        <th>Email</th>
                        <th>Description</th>
                        <th>Created_at</th>
                        <th>Update_at</th>
                        <th class="actions">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($companies as $company)
                    <tr>
                        <td data-id="{{ $company->id }}">{{ $company->id }}</td>
                        <td class="path" data-id="{{ $company->id }}">
                            <img src="{{ asset( $company->path) }}" alt="path">
                        </td>
                        </td>
                        <td class="name" data-id="{{ $company->id }}">{{ $company->name }}</td>
                        <td class="email" data-id="{{$company->id}}">{{$company->email}}</td>
                        <td class="description" data-id="{{$company->id}}">{{$company->description}}</td>
                        <td>{{$company->created_at->format('d/m/Y')}}</td>
                        <td>{{$company->updated_at->format('d/m/Y')}}</td>
                        <td class="action-buttons">
                            <button class="edit-company-btn" data-id="{{$company->id}}">
                                <img src="{{asset('storage/logo/draw.png')}}" alt="edit">
                            </button>
                            <form method="POST" action="{{ route('company.delete', ['id' => $company->id]) }}">
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
    <div class="popup-overlay" id="editCompanyPopup">
        <div class="popup-content">
            <h2>Edit company</h2>
            <form id="editCompanyForm" action="{{ route('company.update') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('POST')
                <input type="hidden" id="company_id" name="company_id" value="">
                <div class="form-row">
                    <label for="name">Company:</label>
                    <input type="text" id="name" name="name" placeholder="Company Name">
                </div>
                <div class="form-row">
                    <label for="email">Email:</label>
                    <input type="text" name="email" id="email" placeholder="Companys email">
                </div>
                <div class="form-row">
                    <label for="description">Description:</label>
                    <input type="text" name="description" id="description" placeholder="Description">
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
    <div class="popup-overlay" id="addCompanyPopup">
        <div class="popup-content">
            <h3>Add Company</h3>
            <form id="addCompanyForm" method="POST" action="{{ route('company.create') }}"
                enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="form-row">
                    <label for="name">Company:</label>
                    <input type="text" name="name" placeholder="Company Name">
                </div>
                <div class="form-row">
                    <label for="email">Email:</label>
                    <input type="text" name="email" placeholder="Company Email">
                </div>
                <div class="form-row">
                    <label for="description">Description:</label>
                    <input type="text" name="description" placeholder="Company Description">
                </div>
                <div class="form-row">
                    <label for="path">Preview:</label>
                    <input type="file" name="path" accept="image/*">
                </div>
                <button type="submit" id="addCompanyPopupBtn" class="add-button">Add Company</button>
            </form>
        </div>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="{{ asset('js/admin/company.js') }}"></script>
    <script>
    //Show all data
    document.addEventListener('DOMContentLoaded', function() {
        const showAllButton = document.getElementById('show-all-button');
        showAllButton.addEventListener('click', function() {
            window.location.href = "{{ route('company.show') }}";
        });
    });
    </script>
    @endsection
</body>

</html>