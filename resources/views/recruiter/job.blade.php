<!DOCTYPE html>
<htm lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="storage/logo/office.png">
        <link rel="stylesheet" href="{{ asset('css/recruiter/job.css') }}">
        <link rel="stylesheet" href="{{ asset('css/recruiter/dashboard.css') }}">
        <title>job</title>
    </head>

    <body>
        @extends('recruiter.dashboard')
        @section('content')
        <div class="header">
            <div class="filter">
                <form id="feedbackFilterForm" action="{{route('job.show')}}" method="GET">
                    @csrf
                    <div class="form-group">
                        <select class="form-control" id="dateRange" name="dateRange">
                            <option value="" disabled selected>Week</option>
                            <option value="7">1 week</option>
                            <option value="14">2 weeks</option>
                            <option value="30">1 month</option>
                            <option value="60">2 month</option>
                            <option value="90">3 month</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="category_id" name="category_id" required>
                            <option value="" disabled selected>Category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="sortOrder" name="sortOrder">
                            <option value="" disabled selected>Sort</option>
                            <option value="asc">asc</option>
                            <option value="desc">desc</option>
                        </select>
                    </div>
                    <button type="submit" class="search-btn-primary">
                        <ion-icon name="search-outline"></ion-icon>
                    </button>
                    <button type="button" id="show-all-button">
                        <ion-icon name="refresh-outline"></ion-icon>
                    </button>
                </form>
            </div>
            <button id="addJobBtn" class="add-job-btn">Add Job</button>
        </div>

        <!-- Display data -->
        <div class="data-container">
            <div class="job">
                @foreach($jobs as $job)
                <li>
                    <div class="job-overall">
                        <div class="job-overall-primary">
                            <img src="{{$job->company->path}}" alt="" class="" data-id="{{ $job->id }}">
                            <div class="job-title">
                                <h2 data-id="{{ $job->id }}">{{ $job->title }}</h2>
                                <span data-id="{{ $job->id }}">Company: {{ $job->company->name }}</span>
                            </div>
                        </div>
                        <span class="salary">{{ number_format($job->salary, 0, ',', ',') }} $</span>
                    </div>
                    <p data-id="{{ $job->id }}" style="text-align: justify;">{{ $job->description }}</p>
                    <div class="review">
                        <span class="time">Date: {{ \Carbon\Carbon::parse($job->created_at)->format('d/m/Y') }}
                        </span>
                        <div class="action-buttons">
                            <button class="open-popup-button" data-id="{{ $job->id }}">
                                <img src="{{asset('storage/logo/draw.png')}}" alt="edit">
                            </button>
                            <form method="POST" action="">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure to delete?')">
                                    <img src="{{asset('storage/logo/trash.png')}}" alt="trash">
                                </button>
                            </form>
                        </div>
                    </div>
                </li>
                @endforeach
            </div>
        </div>

        <!-- Add popup -->
        <div class="popup-overlay" id="addJobPopup">
            <div class="popup-content">
                <h3 class="popup-title">Add Job</h3>
                <form id="addJobForm" method="POST" action="{{ route('job.create') }}" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-row-title">
                        <label for="title">title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>

                    <div class="form-row" style="display: flex;justify-content: space-between;">
                        <div class="form-col">
                            <label for="company_id">Company</label>
                            <select class="form-control" id="company_id" name="company_id" required>
                                <option value="">Select a company</option>
                                @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-col">
                            <label for="category_id">Category</label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="form-row">
                        <label for="tag_id">Tag</label>
                        <select class="form-control" id="tag_id" name="tag_id" required>
                            <option value="">Select a tag</option>
                            @foreach($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-row">
                        <label for="location">Location</label>
                        <input type="text" class="form-control" id="location" name="location" required>
                    </div>

                    <div class="form-row" style="display: flex;justify-content: space-between;">
                        <div class="form-col">
                            <label for="salary">Salary</label>
                            <input type="number" class="form-control" id="salary" name="salary" required>
                        </div>

                        <div class="form-col">
                            <label for="deadline">Deadline</label>
                            <input type="date" class="form-control" id="deadline" name="deadline" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                        <div class="format-toolbar">
                            <button class="format-button" data-command="bold">B</button>
                            <button class="format-button" data-command="italic">I</button>
                            <button class="format-button" data-command="underline">U</button>
                            <button class="format-button" data-command="insertOrderedList">OL</button>
                            <button class="format-button" data-command="insertUnorderedList">UL</button>
                            <button class="format-button" data-command="outdent">Outdent</button>
                            <button class="format-button" data-command="indent">Indent</button>
                            <button class="format-button" data-command="foreColor">Color</button>
                            <select class="font-select" data-command="fontName">
                                <option value="Arial">Arial</option>
                                <option value="Verdana">Verdana</option>
                                <option value="Times New Roman">Times New Roman</option>
                            </select>
                            <select class="font-size-select" data-command="fontSize">
                                <option value="12px">12</option>
                                <option value="14px">14</option>
                                <option value="16px">16</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" id="addJobPopupBtn" class="btn btn-primary">Add Job</button>
                </form>
            </div>
        </div>

        <!-- Update job -->
        <div class="popup-overlay" id="editJobPopup">
            <div class="popup-content">
                <h3 class="popup-title">Edit Job</h3>
                <form id="editJobForm" method="POST" action="{{ route('job.create') }}" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-row-title">
                        <label for="title">title</label>
                        <input type="text" class="form-control" id="editTitle" name="editTitle" required>
                    </div>

                    <div class="form-row" style="display: flex;justify-content: space-between;">
                        <div class="form-col">
                            <label for="company_id">Company</label>
                            <select class="form-control" id="company_id" name="company_id" required>
                                <option value="">Select a company</option>
                                @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-col">
                            <label for="category_id">Category</label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="form-row">
                        <label for="tag_id">Tag</label>
                        <select class="form-control" id="tag_id" name="tag_id" required>
                            <option value="">Select a tag</option>
                            @foreach($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-row">
                        <label for="location">Location</label>
                        <input type="text" class="form-control" id="location" name="location" required>
                    </div>

                    <div class="form-row" style="display: flex;justify-content: space-between;">
                        <div class="form-col">
                            <label for="salary">Salary</label>
                            <input type="number" class="form-control" id="salary" name="salary" required>
                        </div>

                        <div class="form-col">
                            <label for="deadline">Deadline</label>
                            <input type="date" class="form-control" id="deadline" name="deadline" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                        <div class="format-toolbar">
                            <button class="format-button" data-command="bold">B</button>
                            <button class="format-button" data-command="italic">I</button>
                            <button class="format-button" data-command="underline">U</button>
                            <button class="format-button" data-command="insertOrderedList">OL</button>
                            <button class="format-button" data-command="insertUnorderedList">UL</button>
                            <button class="format-button" data-command="outdent">Outdent</button>
                            <button class="format-button" data-command="indent">Indent</button>
                            <button class="format-button" data-command="foreColor">Color</button>
                            <select class="font-select" data-command="fontName">
                                <option value="Arial">Arial</option>
                                <option value="Verdana">Verdana</option>
                                <option value="Times New Roman">Times New Roman</option>
                            </select>
                            <select class="font-size-select" data-command="fontSize">
                                <option value="12px">12</option>
                                <option value="14px">14</option>
                                <option value="16px">16</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" id="addJobPopupBtn" class="btn btn-primary">Add Job</button>
                </form>
            </div>
        </div>

        <script>
        //Show all 
        const showAllButton = document.getElementById('show-all-button');
        showAllButton.addEventListener('click', function() {
            window.location.href = "{{ route('job.show') }}";
        });
        </script>
        <script src="{{ asset('js/recruiter/job.js') }}"></script>
        @endsection
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </body>

</htm