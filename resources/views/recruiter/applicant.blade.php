<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant</title>
    <link rel="stylesheet" href="{{ asset('css/recruiter/applicant.css') }}">
</head>

<body>
    @extends('recruiter.dashboard')
    @section('content')
    <div class="header-title">
        <div class="header">
            <h1>Applicant</h1>
            <p>Applicant Page</p>
        </div>
    </div>
    <div class="data-container">
        @if (!empty($applicantsInfo))
        <div class="content-applicant">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Applicant</th>
                        <th>Job Title</th>
                        <th>CV</th>
                        <th>Cover Letter</th>
                        <th class="actions">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applicantsInfo as $applicant)
                    <tr>
                        <td>{{ $applicant['id']}}</td>
                        <td>{{ $applicant['applicant'] }}</td>
                        <td>{{ $applicant['job_title'] }}</td>
                        <td>
                            <a href="{{ asset($applicant['cv']) }}" target="_blank">View CV</a>
                        </td>
                        <td>{{ $applicant['cover_letter'] }}</td>
                        <td class="action-buttons">
                            <button>
                                <a href="{{ asset($applicant['cv']) }}" download>
                                    <img src="{{asset('storage/logo/download.png')}}" alt="download">
                                </a>
                            </button>
                            <form method="POST" action="{!! route('recruiter.delete', ['id' => $applicant['id']]) !!}">
                                @csrf
                                @method('POST')
                                <button type="submit" onclick="return confirm('Are you sure to delete?')">
                                    <img src="{{asset('storage/logo/trash.png')}}" alt="trash">
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p>No applicants found.</p>
            @endif
        </div>
    </div>
    @endsection
    <script src="{{ asset('js/recruiter/job.js') }}"></script>
</body>

</html>