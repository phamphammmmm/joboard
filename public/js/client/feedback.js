// display star rating
document.addEventListener('DOMContentLoaded', function () {
    const ratingContainers = document.querySelectorAll('.rating');

    ratingContainers.forEach(ratingContainer => {
        const rating = ratingContainer.dataset.rating;

        for (let i = 0; i < rating; i++) {
            const starElement = document.createElement('span');
            starElement.className = 'star star-yellow'; // Thêm class 'star-yellow' vào sao
            starElement.innerHTML = '&#9733;';

            ratingContainer.appendChild(starElement);
        }
    });
});