document.addEventListener("DOMContentLoaded", function() {
    console.log("Swiper init script loaded");
    
    // Enhanced multi-level menu support with event delegation
    function setupMenuHover() {
        // Handle all menu items with children at any level
        const allMenuItemsWithChildren = document.querySelectorAll('.menu-item-has-children');
        
        allMenuItemsWithChildren.forEach(item => {
            const submenu = item.querySelector('.sub-menu');
            if (submenu) {
                // Prevent submenu from closing when clicking on items
                submenu.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
                
                // Enhanced hover handling for all levels
                item.addEventListener('mouseenter', function(e) {
                    e.stopPropagation();
                    // Show this item's submenu
                    submenu.style.display = 'block';
                    submenu.style.pointerEvents = 'auto';
                    submenu.style.zIndex = '99999';
                });
                
                item.addEventListener('mouseleave', function(e) {
                    e.stopPropagation();
                    // Hide this item's submenu
                    submenu.style.display = 'none';
                });
            }
        });
        
        // Additional event delegation for nested submenus
        document.addEventListener('mouseover', function(e) {
            const menuItem = e.target.closest('.menu-item-has-children');
            if (menuItem) {
                const submenu = menuItem.querySelector('.sub-menu');
                if (submenu) {
                    submenu.style.display = 'block';
                    submenu.style.pointerEvents = 'auto';
                }
            }
        });
        
        document.addEventListener('mouseout', function(e) {
            const menuItem = e.target.closest('.menu-item-has-children');
            if (menuItem) {
                const submenu = menuItem.querySelector('.sub-menu');
                if (submenu && !menuItem.contains(e.relatedTarget)) {
                    submenu.style.display = 'none';
                }
            }
        });
    }
    
    // Initialize menu hover functionality
    setupMenuHover();
    
    // Re-initialize if DOM changes (for dynamic content)
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList') {
                setupMenuHover();
            }
        });
    });
    
    observer.observe(document.body, {
        childList: true,
        subtree: true
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