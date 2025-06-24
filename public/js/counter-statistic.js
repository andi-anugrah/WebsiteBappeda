document.addEventListener("DOMContentLoaded", function () {
    // Counter animation function
    function animateCounters() {
        const counters = document.querySelectorAll(".counter");

        counters.forEach((counter) => {
            const target = parseFloat(
                counter.getAttribute("data-target").replace(",", ".")
            );
            const duration = 2000; // 2 detik
            const increment = target / (duration / 16); // 60fps
            let current = 0;

            const timer = setInterval(() => {
                current += increment;

                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }

                // Format angka sesuai dengan target asli
                let displayValue;
                if (target % 1 !== 0) {
                    // Jika ada desimal
                    displayValue = current.toFixed(2).replace(".", ",");
                } else {
                    // Jika bulat
                    displayValue = Math.floor(current).toLocaleString("id-ID");
                }

                counter.textContent = displayValue;
            }, 16);
        });
    }

    // Intersection Observer untuk trigger animation saat section terlihat
    const statisticsSection = document.querySelector(".statistics-section");

    if (statisticsSection) {
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        animateCounters();
                        observer.unobserve(entry.target);
                    }
                });
            },
            {
                threshold: 0.5,
            }
        );

        observer.observe(statisticsSection);
    }
});
