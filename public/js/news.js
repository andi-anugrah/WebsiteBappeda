// News Page JavaScript
document.addEventListener("DOMContentLoaded", function () {
    // Smooth scroll to top when pagination is clicked
    const paginationLinks = document.querySelectorAll(".pagination .page-link");
    paginationLinks.forEach((link) => {
        link.addEventListener("click", function (e) {
            // Small delay to allow page navigation
            setTimeout(() => {
                window.scrollTo({
                    top: 0,
                    behavior: "smooth",
                });
            }, 100);
        });
    });

    // Add loading effect for news items
    const newsItems = document.querySelectorAll(".news-item");
    const observerOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px",
    };

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add("animate-in");
            }
        });
    }, observerOptions);

    newsItems.forEach((item) => {
        observer.observe(item);
    });

    // Add click analytics (optional)
    const readMoreButtons = document.querySelectorAll(".btn-read-more");
    readMoreButtons.forEach((button) => {
        button.addEventListener("click", function (e) {
            const newsTitle =
                this.closest(".news-content").querySelector(
                    ".news-title"
                ).textContent;
            console.log("News clicked:", newsTitle);

            // You can add Google Analytics or other tracking here
            // gtag('event', 'news_click', {
            //     'event_category': 'News',
            //     'event_label': newsTitle
            // });
        });
    });

    // Responsive pagination adjustment
    function adjustPagination() {
        const pagination = document.querySelector(".custom-pagination");
        if (pagination && window.innerWidth < 480) {
            pagination.classList.add("pagination-sm");
        } else if (pagination) {
            pagination.classList.remove("pagination-sm");
        }
    }

    // Initial adjustment
    adjustPagination();

    // Adjust on window resize
    window.addEventListener("resize", adjustPagination);

    // Add hover effect for news items
    newsItems.forEach((item) => {
        item.addEventListener("mouseenter", function () {
            this.style.transform = "translateY(-3px)";
        });

        item.addEventListener("mouseleave", function () {
            this.style.transform = "translateY(0)";
        });
    });

    // Lazy loading for images (if needed)
    const images = document.querySelectorAll(".news-image img");
    const imageObserver = new IntersectionObserver(function (entries) {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const img = entry.target;
                if (img.dataset.src) {
                    img.src = img.dataset.src;
                    img.removeAttribute("data-src");
                    imageObserver.unobserve(img);
                }
            }
        });
    });

    images.forEach((img) => {
        if (img.dataset.src) {
            imageObserver.observe(img);
        }
    });

    // Add search functionality (optional enhancement)
    function initSearch() {
        const searchInput = document.getElementById("news-search");
        if (searchInput) {
            searchInput.addEventListener("input", function (e) {
                const searchTerm = e.target.value.toLowerCase();
                const newsItems = document.querySelectorAll(".news-item");

                newsItems.forEach((item) => {
                    const title = item
                        .querySelector(".news-title")
                        .textContent.toLowerCase();
                    if (title.includes(searchTerm)) {
                        item.style.display = "flex";
                    } else {
                        item.style.display = "none";
                    }
                });
            });
        }
    }

    initSearch();

    // Add print functionality
    function initPrint() {
        const printButton = document.getElementById("print-news");
        if (printButton) {
            printButton.addEventListener("click", function () {
                window.print();
            });
        }
    }

    initPrint();

    // Performance monitoring
    function measurePerformance() {
        if ("performance" in window) {
            window.addEventListener("load", function () {
                setTimeout(function () {
                    const loadTime =
                        performance.timing.loadEventEnd -
                        performance.timing.navigationStart;
                    console.log("Page load time:", loadTime + "ms");
                }, 0);
            });
        }
    }

    measurePerformance();
});
