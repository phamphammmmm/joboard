<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/client/display.css') }}">
    <title>Favortie</title>
</head>

<body>
    @extends('layout.layout')
    @section('content')
    <div class="container">
        <ul class="favorite-data">
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
                <p data-id="{{ $job->id }}">{{ $job->description }}</p>
                <div class="review">
                    <span class="time">Date: {{ \Carbon\Carbon::parse($job->created_at)->format('d/m/Y') }}
                    </span>
                    <button id="addApplicationBtn" class="add-application-btn" data-id="{{ $job->id }}">
                        Apply Now</button>
                </div>
            </li>
            @endforeach
        </ul>
    </div>

    <div class="popup-overlay" id="addApplicationPopup">
        <div class="popup-content">
            <h3>Application</h3>
            <form id="addApplicationForm" method="POST" action="{{ route('application.create') }}"
                enctype="multipart/form-data">
                @csrf
                @method('POST')
                <input type="hidden" name="job_id_input" id="job_id_input" value="{{$job->id}}">

                <div class="form-row">
                    <label for="cv">Enter your CV:</label>
                    <input type="file" name="cv" accept=".pdf, .doc, .docx">
                </div>
                <div class="form-row">
                    <label for="cover_letter">Cover Letter:</label>
                    <textarea name="cover_letter" placeholder="Your cover letter here"></textarea>
                </div>
                <button type="submit" id="addApplicationPopupBtn" class="add-button">Send</button>
            </form>
        </div>
    </div>
    @endsection
    <script src="{{asset('js/client/display.js')}}"></script>

</body>

</html>