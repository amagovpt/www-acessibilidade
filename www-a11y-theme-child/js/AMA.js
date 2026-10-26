window.onload = function() {
    const myCarouselElement = document.querySelector('#AMA-home-carousel')

    if (myCarouselElement) {
        // Carousel options
        const carousel = new bootstrap.Carousel(myCarouselElement, {
            interval: false,
            touch: false,
            wrap: true,
            keyboard: true,
        })

    }

};
