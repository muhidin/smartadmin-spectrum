document.addEventListener("DOMContentLoaded", function() {
    console.log("Swiper init script loaded");
    const sliderElement = document.querySelector(".hero-slider");
    console.log("Slider element:", sliderElement);
    console.log("Slider classes:", sliderElement ? sliderElement.className : "No element found");

    if (sliderElement) {
        // Detect slider effect from class
        let effect = 'slide'; // default

        // Check for effect classes
        if (sliderElement.classList.contains('slider-fade')) {
            effect = 'fade';
            console.log("Detected fade effect");
        } else if (sliderElement.classList.contains('slider-cube')) {
            effect = 'cube';
            console.log("Detected cube effect");
        } else if (sliderElement.classList.contains('slider-flip')) {
            effect = 'flip';
            console.log("Detected flip effect");
        } else if (sliderElement.classList.contains('slider-slide')) {
            effect = 'slide';
            console.log("Detected slide effect");
        }

        console.log("Initializing Swiper with effect:", effect);

        const swiperConfig = {
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            speed: 800,
        };

        // Add effect-specific configuration
        if (effect === 'fade') {
            swiperConfig.effect = 'fade';
            swiperConfig.fadeEffect = {
                crossFade: true
            };
        } else if (effect === 'cube') {
            swiperConfig.effect = 'cube';
            swiperConfig.cubeEffect = {
                slideShadows: false,
                shadow: false,
                shadowOffset: 0,
                shadowScale: 1
            };
            swiperConfig.speed = 800;
            swiperConfig.grabCursor = false;
            swiperConfig.allowTouchMove = true;
        } else if (effect === 'flip') {
            swiperConfig.effect = 'flip';
            swiperConfig.flipEffect = {
                slideShadows: true,
                limitRotation: true
            };
        } else {
            // slide effect (default)
            swiperConfig.effect = 'slide';
        }

        const swiper = new Swiper(".hero-slider", swiperConfig);
        console.log("Swiper initialized with effect:", effect, swiper);
    } else {
        console.log("Slider element not found");
    }
});