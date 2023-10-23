<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/admin/feedback.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
    <title>Feedback</title>
</head>

<body>
    @extends('admin.dashboard')
    @section('content')
    <div class="header">
        <h1>Feedback Page</h1>
        <button class="add-feedback-btn" id="addFeedbackBtn">+ add feedback </button>
    </div>
    <div class="container">
        <div class="overview-stats">
            <div class="total-responses">
                <img src="{{asset('storage/avatar/avatar.jpg')}}" alt="office">
                <span>Feedback</span>
                <p class="total">{{$totalFeedback}}</p>
                <div class="general-variation">
                    <span class="percent">+13%</span>
                    <p>TOTAL RESPONSE</p>
                </div>
            </div>
            <div class="positive-responses">
                <img src="{{asset('storage/avatar/avatar.jpg')}}" alt="office">
                <span>Feedback</span>
                <p class="total">{{$totalFeedback}}</p>
                <div class="general-variation">
                    <span class="percent">+13%</span>
                    <p>TOTAL RESPONSE</p>
                </div>
            </div>
            <div class="negative-responses">
                <img src="{{asset('storage/avatar/avatar.jpg')}}" alt="office">
                <span>Feedback</span>
                <p class="total">{{$totalFeedback}}</p>
                <div class="general-variation">
                    <span class="percent">+13%</span>
                    <p>TOTAL RESPONSE</p>
                </div>
            </div>
            <div class="averageRating">
                <img src="{{asset('storage/avatar/avatar.jpg')}}" alt="office">
                <span>Feedback</span>
                <p class="total">{{$averageRating}} / 5 &#9733;</p>
                <div class="percent-rating">
                    <span class="percent">+13%</span>
                    <p>AVERAGE RATING</p>
                </div>
            </div>
        </div>
        <div class="overview-chart">
            <div class="detail-chart">
                <canvas id="starChart" style="display: block; height: 275px; width: 596px;"></canvas>
            </div>
            <div class="sentiment-chart">
                <canvas id="feedbackAnalysisChart" style="display: block;height: 275px;width: 400px;"></canvas>
            </div>
        </div>
        <div class="feedback-data">
            <div class="feedback-detail">

            </div>
            <div class="feedback-list">
                @if (!empty($feedback))
                <h2 style="padding: 20px 20px 0px;">NOTIFICATION</h2>
                <table>
                    <tbody class="content-feedback">
                        @foreach($feedback as $feedbackItem)
                        <tr class="feedback-item" data-feedback-id="{{ $feedbackItem->id }}">
                            <td class="preview">
                                <img src="{{ asset( $feedbackItem->user->path) }}" alt="path">
                            </td>
                            <td class="account-information">
                                <div class="name">{{ $feedbackItem->user->name }}</div>
                                <div class="comment">{{ $feedbackItem->comment }}</div>
                            </td>
                            <td>
                                <div class="rating">
                                    @for($i = 0; $i < $feedbackItem->rating; $i++)
                                        <span class="star">&#9733;</span>
                                        @endfor
                                </div>
                                <div class="time-post">
                                    <div class="day-post">
                                        <img src="{{asset('storage/logo/calendar.png')}}" alt="calendar">
                                        <div class="created_at">
                                            {{ \Carbon\Carbon::parse($feedbackItem->created_at)->format('D, j M') }}
                                        </div>
                                    </div>
                                    <div class="hour-post">
                                        <img src="{{asset('storage/logo/clock.png')}}" alt="clock">
                                        <div class="created_at">
                                            {{ \Carbon\Carbon::parse($feedbackItem->created_at)->format('H:i A') }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="action-buttons">
                                <form method="POST"
                                    action="{{ route('feedback.delete', ['id' => $feedbackItem->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure to delete?')"
                                        id="delete-feedback-btn">
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



    </div>

    <!-- add feedback -->
    <div class="popup-overlay" id="addFeedbackPopup">
        <div class="popup-content">
            <h3>Add Feedback</h3>
            <form id="addFeedbackForm" method="POST" action="{{ route('feedback.create') }}">
                @csrf
                @method('POST')
                <div class="form-row">
                    <label for="rating">Rating:</label>
                    <div class="star-rating">
                        <span class="star" onclick="rate(1, this)">&#9733;</span>
                        <span class="star" onclick="rate(2, this)">&#9733;</span>
                        <span class="star" onclick="rate(3, this)">&#9733;</span>
                        <span class="star" onclick="rate(4, this)">&#9733;</span>
                        <span class="star" onclick="rate(5, this)">&#9733;</span>
                        <span id="result"></span>
                    </div>
                </div>
                <div class="form-row">
                    <label for="comment">Comment:</label>
                    <textarea name="comment" id="comment" cols="30" rows="10" maxlength="100"></textarea>
                </div>
                <input type="hidden" name="rating" id="ratingInput" value="">
                <button type="submit" id="submit-feedback-btn">Submit</button>
            </form>
        </div>
    </div>
    <script src="{{asset('js/admin/feedback.js')}}"></script>
    @endsection
</body>

</html>