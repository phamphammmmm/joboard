<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="storage/logo/circle.png">
    <link rel="stylesheet" href="{{ asset('css/client/job.css') }}">
    <title>Job</title>

</head>

<body>
    @extends('layout.layout')
    @section('title', 'Trang chủ')
    @section('content')
    <div class="container">
        <div class="col-4">
            <div class="row-options">
                <div class="btn-options">
                    <button>Best Matches</button>
                    <button>Featured</button>
                    <button>Most Recent</button>
                </div>
            </div>
            <div class="row-job">
                @if (!empty($job))
                @foreach($job as $jobItem)
                <div class="row">
                    <div class="job-information">
                        <img src="{{asset($jobItem->company->path)}}" alt="">
                        <div class="overview">
                            <p class="job-title" data-id="{{$jobItem->id}}">{{$jobItem->title}}</p>
                            <p class="job-description" data-id="{{$jobItem->id}}">{{$jobItem->description}}</p>
                        </div>
                        <form action="{{ route('favorite.create')}}" method="POST">
                            @csrf
                            <input type="hidden" id="job_id" name="job_id" value="{{$jobItem->id}}">
                            <button type="submit">
                                <ion-icon name="bookmark-outline"></ion-icon>
                            </button>
                        </form>
                    </div>
                    <div class="skill">
                        <button>
                            <a href="">{{$jobItem->tag->name}}</a>
                        </button>
                        <button>
                            <a href="">{{$jobItem->tag->name}}</a>
                        </button>
                        <button>
                            <a href="">{{$jobItem->tag->name}}</a>
                        </button>
                    </div>
                    <div class="review-job">
                        <div class="review">
                            <span class="star">&#9733;</span>
                            <span class="star">&#9733;</span>
                            <span class="star">&#9733;</span>
                            <span class="star">&#9733;</span>
                            <span class="star">&#9733;</span>
                        </div>
                        <div class="proposal">
                            <p>proposals:10 to 15</p>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
        <div class="col-5">
            <div class="search">
                <div class="search-content"></div>
                <button>
                    <ion-icon name="search-outline"></ion-icon>
                </button>
            </div>
            <div class="job-detail">

            </div>
        </div>
    </div>

    <!-- popup -->
    <div class="popup-overlay" id="addApplicationPopup">
        <div class="popup-content">
            <h3>Application</h3>
            <form id="addApplicationForm" method="POST" action="{{ route('application.create') }}"
                enctype="multipart/form-data">
                @csrf
                @method('POST')
                <input type="hidden" name="job_id_input" id="job_id_input" value="">

                <div class="form-row">
                    <label for="cv">CV:</label>
                    <input type="file" name="cv" accept=".pdf, .doc, .docx">
                </div>
                <div class="form-row">
                    <label for="cover_letter">Cover Letter:</label>
                    <textarea name="cover_letter" placeholder="Your cover letter here"></textarea>
                </div>
                <button type="submit" id="addApplicationPopupBtn" class="add-application-btn">Send</button>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {

        const latestJobId = document.querySelector('.row').querySelector('.job-title').dataset.id;
        fetchJobDetail(latestJobId);

        const jobRows = document.querySelectorAll('.row');
        jobRows.forEach(function(row) {
            row.addEventListener('click', function() {
                const jobId = row.querySelector('.job-title').dataset.id;
                fetchJobDetail(jobId);
            });
        });

        const addApplicationButtons = document.querySelectorAll('.add-application-btn');
        const popupOverlay = document.querySelector('.popup-overlay');
        const addApplicationForm = document.getElementById('addApplicationForm');

        popupOverlay.addEventListener('click', (event) => {
            if (event.target === popupOverlay) {
                popupOverlay.style.display = 'none';
            }
        });

        addApplicationButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const applicationId = button.getAttribute('data-id');
                console.log(applicationId);
                popupOverlay.style.display = 'block';
            });
        });

        function fetchJobDetail(jobId) {
            fetch('/api/jobs/' + jobId) // Địa chỉ API của bạn
                .then(response => response.json())
                .then(data => {
                    displayJobDetail(data);
                })
                .catch(error => console.error('Error:', error));
        }

        function displayJobDetail(jobDetail) {
            const jobDetailContainer = document.querySelector('.job-detail');
            const job_id_input = document.getElementById('job_id');
            if (job_id_input) {
                job_id_input.value = jobDetail.id
            };

            jobDetailContainer.innerHTML = `
            <div class="detail-job-primary">
                <div class="detail-job-information">
                    <div class="job-header">
                         <img src="${jobDetail.path}" alt="avatar">
                        <p class="title-primary">${jobDetail.title}</p>
                    </div>
                        <form action=" {{ route('favorite.create')}}" method="POST">
                            @csrf
                            <input type="hidden" id="job_id" name="job_id" value="${jobDetail.id}">
                            <button type="submit">
                                <ion-icon name="bookmark-outline"></ion-icon>
                            </button>
                        </form>
                </div>

                <p class="title-primary">Job detail</p>
                <pre><code style="font-family:Poppins; word-wrap: break-word;">
            ${jobDetail.description}
                    </code>
                </pre>
                <div class="requirement">
                        <p class="title-primary">Skills and Expertise</p>
                        <div class="skill">
                            <button>
                            <a href="">${jobDetail.tag}</a>
                            </button>
                        </div>
                </div>
                <div class="detail-job-primnary">
                        <p class="title">Detail job</p>
                        <div class="detail">
                            <div class="review">
                                <p>5.00 of 48 reviews</p>
                                <div class="rating">
                                    <span class="star">&#9733;</span>
                                    <span class="star">&#9733;</span>
                                    <span class="star">&#9733;</span>
                                    <span class="star">&#9733;</span>
                                    <span class="star">&#9733;</span>
                                    <span id="result"></span>
                                </div>
                            </div>
                            <div class="deadline">
                                <p>Deadline</p>
                                <p>${jobDetail.deadline}</p>
                            </div>
                            <div class="salary">
                                <p>$${jobDetail.salary}+ total spent</p>
                                <div class="verified">
                                    <img src="storage/logo/verified.png" alt="vertified">
                                    <p>project Verified</p>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="apply-btn-primary">
                    <div class="input-CV">
                        <input type="text" placholder="https://www.joboard.com/n">
                        <button class="copy-btn-primary">
                            <ion-icon name="copy-outline" style="color: #8A8A8A;"></ion-icon>
                        </button>
                    </div>
                    <button id="addApplicationBtn" class="add-application-btn" data-id="${jobDetail.id}">Apply Now</button>
                </div>
                </div>
        `;
        }
    });
    </script>
    <script src="{{asset('js/client/job.js')}}"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    @endsection
</body>

</html>