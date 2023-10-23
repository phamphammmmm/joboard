<div>
    <p>Name: {{ $application->user->name }}</p>
    <p>Email: {{ $application->user->email }}</p>
    <p>CV: <a href="{{ asset($application->cv) }}">Download CV</a></p>
    <p>Cover Letter: <a href="{{ asset($application->cover_letter) }}">Download Cover Letter</a></p>
</div>