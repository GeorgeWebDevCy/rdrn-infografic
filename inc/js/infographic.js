document.addEventListener('DOMContentLoaded', () => {
    let currentIndex = 0;
    const images = document.querySelectorAll('.infographic-image');

    window.showNextImage = function() {
        if (currentIndex < images.length - 1) {
            images[currentIndex].classList.add('hidden');
            currentIndex++;
            images[currentIndex].classList.remove('hidden');
        }
    }
});
