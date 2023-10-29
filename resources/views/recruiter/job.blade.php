<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="storage/logo/office.png">
    <link rel="stylesheet" href="{{ asset('css/recruiter/job.css') }}">
    <link rel="stylesheet" href="{{ asset('css/recuiter/dashboard.css') }}">

    <title>job</title>
</head>

<body>
    @extends('recruiter.dashboard')
    @section('content')
    <div class="filter">
        <form id="feedbackFilterForm" action="{{route('feedback.search')}}" method="GET">
            @erfc
            <div class="form-group">
                <label for="name">User</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="form-group">
                <label for="dateRange">Time</label>
                <select class="form-control" id="dateRange" name="dateRange">
                    <option value="7">1 week</option>
                    <option value="14">2 weeks</option>
                    <option value="30">1 month</option>
                    <option value="60">2 month</option>
                    <option value="90">3 month</option>
                </select>
            </div>
            <div class="form-group">
                <label for="sortOrder">Sort</label>
                <select class="form-control" id="sortOrder" name="sortOrder">
                    <option value="asc">asc</option>
                    <option value="desc">desc</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Lọc</button>
            <button type="button" id="show-all-button"><i class="fa-solid fa-rotate-right"></i></button>
        </form>
    </div>
    <button id="addJobBtn" class="add-job-btn">Add Job</button>
    <div class="container">
        <div class="job">
            @foreach($jobs as $job)
            <li>
                <input type="checkbox" data-id="{{ $job->id }}">
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
                <p data-id="{{ $job->id }}">{{ $job->description }}</p>
                <div class="review">
                    <span class="time">Date: {{ \Carbon\Carbon::parse($job->created_at)->format('d/m/Y') }}
                    </span>
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
    <script>
    //Show all 
    const showAllButton = document.getElementById('show-all-button');
    showAllButton.addEventListener('click', function() {
        window.location.href = "{{ route('job.show') }}";
    });

    //form
    fetch('/api/companies')
        .then(response => response.json())
        .then(data => {
            const companySelect = document.getElementById('company_id');

            data.forEach(company => {
                const option = document.createElement('option');
                option.value = company.id;
                option.textContent = company.name;
                companySelect.appendChild(option);
            });
        });

    fetch('/api/categories')
        .then(response => response.json())
        .then(data => {
            const categorySelect = document.getElementById('category_id');

            data.forEach(category => {
                const option = document.createElement('option');
                option.value = category.id;
                option.textContent = category.name;
                categorySelect.appendChild(option);
            });
        });

    fetch('/api/tags')
        .then(response => response.json())
        .then(data => {
            const tagSelect = document.getElementById('tag_id');

            data.forEach(tag => {
                const option = document.createElement('option');
                option.value = tag.id;
                option.textContent = tag.name;
                tagSelect.appendChild(option);
            });
        });
    </script>
    <script src="{{ asset('js/recruiter/job.js') }}"></script>
    @endsection
</body>

</html>