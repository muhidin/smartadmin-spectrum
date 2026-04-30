document.addEventListener("DOMContentLoaded", function() {
    console.log("Swiper init script loaded");
    
    // Enhanced multi-level menu support
    const submenuItems = document.querySelectorAll('.menu-item-has-children');
    
    submenuItems.forEach(item => {
        const submenu = item.querySelector('.sub-menu');
        if (submenu) {
            // Prevent submenu from closing when clicking on items
            submenu.addEventListener('click', function(e) {
                e.stopPropagation();
            });
            
            // Force submenu visibility on hover for all levels
            item.addEventListener('mouseenter', function() {
                const allSubmenus = item.querySelectorAll('.sub-menu');
                allSubmenus.forEach(sub => {
                    sub.style.display = 'block';
                    sub.style.pointerEvents = 'auto';
                });
            });
            
            item.addEventListener('mouseleave', function() {
                const allSubmenus = item.querySelectorAll('.sub-menu');
                allSubmenus.forEach(sub => {
                    sub.style.display = 'none';
                });
            });
        }
    });
    
    // Handle multi-level hover transitions
    const allSubmenuItems = document.querySelectorAll('.sub-menu .menu-item-has-children');
    
    allSubmenuItems.forEach(item => {
        const submenu = item.querySelector('.sub-menu');
        if (submenu) {
            item.addEventListener('mouseenter', function() {
                submenu.style.display = 'block';
                submenu.style.pointerEvents = 'auto';
            });
            
            item.addEventListener('mouseleave', function() {
                submenu.style.display = 'none';
            });
        }
    });
    
    // Search toggle functionality (if search exists)
    const searchButton = document.querySelector('.search-button');
    const searchFormWrapper = document.querySelector('.search-form-wrapper');
    const searchInput = document.querySelector('.search-form-wrapper input[type="search"]');
    
    if (searchButton && searchFormWrapper) {
        searchButton.addEventListener('click', function(e) {
            e.preventDefault();
            const isExpanded = searchButton.getAttribute('aria-expanded') === 'true';
            
            if (isExpanded) {
                searchFormWrapper.style.display = 'none';
                searchButton.setAttribute('aria-expanded', 'false');
            } else {
                searchFormWrapper.style.display = 'block';
                searchButton.setAttribute('aria-expanded', 'true');
                
                // Focus on search input when opened
                if (searchInput) {
                    setTimeout(() => {
                        searchInput.focus();
                    }, 100);
                }
            }
        });
        
        // Close search form when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchFormWrapper.contains(e.target) && !searchButton.contains(e.target)) {
                searchFormWrapper.style.display = 'none';
                searchButton.setAttribute('aria-expanded', 'false');
            }
        });
        
        // Close search form on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && searchFormWrapper.style.display === 'block') {
                searchFormWrapper.style.display = 'none';
                searchButton.setAttribute('aria-expanded', 'false');
                searchButton.focus();
            }
        });
    }
    
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