//Add feedback popup
document.addEventListener('DOMContentLoaded', () => {
    // Lấy tham chiếu đến các phần tử
    const addFeedbackBtn = document.getElementById('addFeedbackBtn');
    const addFeedbackPopup = document.getElementById('addFeedbackPopup');
    const addFeedbackForm = document.getElementById('addFeedbackForm');

    // Xử lý sự kiện click để mở/đóng popup
    addFeedbackBtn.addEventListener('click', () => {
        addFeedbackPopup.style.display = 'block';
    });

    addFeedbackPopup.addEventListener('click', (event) => {
        if (event.target === addFeedbackPopup) {
            addFeedbackPopup.style.display = 'none';
        }
    });

});

// display star rating
function rate(stars, star) {
    const starsArray = document.querySelectorAll('.star');

    for (let i = 0; i < starsArray.length; i++) {
        if (i < stars) {
            starsArray[i].classList.add('active');
        } else {
            starsArray[i].classList.remove('active');
        }
    }

    document.getElementById('result').innerText = `( ${stars} )`;
    document.getElementById('ratingInput').value = stars; // Set giá trị rating
}

//display chart
document.addEventListener('DOMContentLoaded', function () {
    // Fetch feedback data
    fetch('/api/feedback')
        .then(response => response.json())
        .then(data => {
            const labels = data.map(item => item.date);
            const ratings = data.map(item => item.rating);

            const ctx = document.getElementById('starChart').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Daily Feedback',
                        data: ratings,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2
                    }]
                },
                options: {
                    scales: {
                        x: {
                            type: 'time',
                            time: {
                                unit: 'day'
                            },
                            title: {
                                display: true,
                                text: 'Time'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            min: 1, // Đặt giá trị tối thiểu của trục y
                            max: 5, // Đặt giá trị tối đa của trục y
                            stepSize: 1, // Đặt bước giữa các mốc
                            title: {
                                display: true,
                                text: 'Rating'
                            }
                        }
                    }
                }
            });
        });
});

const feedbackAnalysis = {
    positive: 50, // Số lượng phản hồi tích cực
    negative: 30 // Số lượng phản hồi tiêu cực
};
const ctx = document.getElementById('feedbackAnalysisChart').getContext('2d');

const chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Positive', 'Negative'],
        datasets: [{
            label: 'Feedback Analysis',
            data: [feedbackAnalysis.positive, feedbackAnalysis.negative],
            backgroundColor: [
                'rgba(75, 192, 192, 0.2)', // Màu cho tích cực
                'rgba(255, 99, 132, 0.2)' // Màu cho tiêu cực
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(255, 99, 132, 1)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: false, // Bắt đầu từ giá trị được chỉ định
                min: 10, // Giá trị tối thiểu của trục y
                stepSize: 1, // Bước giữa các mốc trên trục y
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const feedbackItems = document.querySelectorAll('.feedback-item');

    feedbackItems.forEach(item => {
        item.addEventListener('click', function () {
            const feedbackId = this.dataset.feedbackId;
            const feedbackDetail = document.querySelector('.feedback-detail');

            fetch(`/api/feedback/${feedbackId}`)
                .then(response => response.json())
                .then(data => {
                    const rating = data.rating;

                    feedbackDetail.innerHTML = `
                        <div class="feedback-info">
                            <div class="content-header">
                                <img src="${data.path}">
                                <div class="user-info">
                                    <h3 class="name">${data.name}</h3>
                                    <p class="email">${data.email}</p>
                                </div>
                            </div>
                            <p class="major">${data.major}</p>
                            <p class="content-comment">${data.comment}</p>
                            <p style="font-weight:bold;">Detail Feedback</p>
                            <div class="overrall-feedback">
                                <div class="rating"></div>
                                <div class="time">
                                    <p class="created-at">${data.created_at}</p>
                                </div>
                            </div>
                        </div>
                    `;

                    const ratingContainer = document.querySelector('.rating');

                    for (let i = 0; i < rating; i++) {
                        const starElement = document.createElement('span');
                        starElement.className = 'star';
                        starElement.innerHTML = '&#9733;';

                        ratingContainer.appendChild(starElement);
                    }

                    //set time to format
                    const createdAtElement = document.querySelector('.created-at');
                    const createdAtString = data.created_at;

                    const createdAtDate = new Date(createdAtString);

                    const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

                    const dayOfWeekCreated = daysOfWeek[createdAtDate.getUTCDay()];
                    const dayOfMonthCreated = createdAtDate.getUTCDate();
                    const monthCreated = months[createdAtDate.getUTCMonth()];

                    const formattedDateCreated = `${dayOfWeekCreated}, ${dayOfMonthCreated} ${monthCreated}`;

                    createdAtElement.textContent = formattedDateCreated;

                });
        });
    });
});
