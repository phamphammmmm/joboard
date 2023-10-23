<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="storage/logo/user (1).png">
    <link rel="stylesheet" href="{{ asset('css/admin/manage.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
    <title>Manage</title>
</head>

<body>
    @extends('admin.dashboard')
    @section('content')
    <div class="overview">
        <div class="statistics-user">
            <div class="new-user">
                <h3>New members:</h3>
                <h1>{{ $newUsers }}</h1>
            </div>
            <div class="total-user">
                <h3>Total members:</h3>
                <h1>{{ $totalUsers }}</h1>
            </div>
        </div>

        <div class="chart">
            <canvas id="lineChart" style="display: block;height: 290px;width: 860px;"></canvas>
        </div>
    </div>
    <div class="container">
        <div class="user-container">
            <!-- <form action="" method="POST"> -->
            @csrf
            <div
                style="padding: 0px 15px;display: flex;justify-content: space-between;align-items: flex-end;align-items: center;">
                <div class="member">
                    <h3>Members</h3>
                    <button id="addUserBtn" class="add-btn">+</button>
                </div>
                <button class="export-user-btn">
                    <a href="{{route('manage.export')}}" style="color:white;">Export to PDF</a>
                </button>
            </div>
            <div class="search-group">
                <div class="filter">

                </div>
                <form class="search-section" action="{{ route('manage.search') }}" method="GET" id="search-form">
                    @csrf
                    @method('GET')
                    <input type="text" name="search" placeholder="Start searching">
                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
                <button type="button" id="show-all-button"><i class="fa-solid fa-rotate-right"></i></button>
            </div>
            <!-- </form> -->

            @if(!$users->isEmpty())
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>User</th>
                        <th>Name</th>
                        <th>Major</th>
                        <th>Type</th>
                        <th>Erolled</th>
                        <th class="actions">Actions</th>
                    </tr>
                </thead>
                <tbody class="info_user">
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <input type="checkbox">
                        </td>
                        <td class="preview">
                            <img src="{{ asset( $user->path) }}" alt="path">
                        </td>
                        <td>
                            <div class="account-information">
                                <div class="name" data-id="{{ $user->id }}">{{ $user->name }}</div>
                                <div class="email" data-id="{{ $user->id }}">{{ $user->email}}</div>
                            </div>
                        </td>
                        <td>
                            <div class="major" data-id="{{ $user->id }}">{{ $user->major}}</div>
                        </td>
                        <td>
                            <div class="type" data-id="{{ $user->id }}">{{ $user->type }}</div>
                        </td>
                        <td>
                            <div class="created_at" data-id="{{ $user->id }}">{{ $user->created_at->format('m/d/Y')}}
                            </div>
                        </td>
                        <td class="action-buttons">
                            <button class="open-popup-button" data-id="{{ $user->id }}">
                                <img src="{{asset('storage/logo/draw.png')}}" alt="edit">
                            </button>
                            <form method="POST" action="{{ route('manage.delete', ['id' => $user->id]) }}">
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
            @endif
        </div>
    </div>

    <!-- Add popup -->
    <div class="popup-overlay" id="addUserPopup">
        <div class="popup-content">
            <h2>Add Member</h2>
            <form action="{{ route('manage.create') }}" method="POST" id="addUserForm" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <label for="name">Username:</label>
                <input type="text" name="name" id="name">

                <label for="fullname">Fullname:</label>
                <input type="text" name="fullname" id="fullname">

                <label for="email">Email*</label>
                <input type="text" name="email" id="email" placeholder="Email">

                <button type="submit" id="add-btn-save" name="addmember">Save</button>
            </form>
        </div>
    </div>

    <!-- Edit popup -->
    <div class="popup-overlay-edit" id="editUserPopup">
        <div class="popup-content">
            <h2>Edit User</h2>
            <form id="edit-user-form" method="POST" action="{{ route('manage.update') }}" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <input type="hidden" name="editUserId" value="" id="editUserId">

                <label for="name">Username:</label>
                <input type="text" name="name" id="editName">

                <label for="fullname">Fullname:</label>
                <input type="text" name="fullname" id="editFullname">

                <label for="email">Email*</label>
                <input type="text" name="email" id="editEmail" placeholder="Email">

                <label for="major">Major:</label>
                <input type="text" name="major" id="editMajor">

                <label for="type">Type*</label>
                <select name="type" id="editType">
                    <option value="admin">Admin</option>
                    <option value="moderator">Moderator</option>
                    <option value="recruiter">Recruiter</option>
                    <option value="seeker">Seeker</option>
                </select>

                <button type="submit" class="save-button">Save</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    //Show all users
    const showAllButton = document.getElementById('show-all-button');
    showAllButton.addEventListener('click', function() {
        window.location.href = "{{ route('manage') }}";
    });

    Chart.plugins.register({
        beforeInit: function(chart) {
            chart.data.labels.forEach(function(e, i, a) {
                if (e.includes('T')) {
                    a[i] = moment(e);
                }
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Fetch registration data
        fetch('/api/registration-chart-data')
            .then(response => response.json())
            .then(data => {
                const labels = data.map(item => item.date);
                const registrations = data.map(item => item.registrations);

                const ctx = document.getElementById('lineChart').getContext('2d');
                const chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Daily Registrations',
                            data: registrations,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                type: 'time',
                                time: {
                                    unit: 'day'
                                }
                            },
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
    });
    </script>
    <script src="{{ asset('js/admin/manage.js') }}"></script>
    @endsection
</body>

</html>