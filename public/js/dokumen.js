// public/js/documents.js

document.addEventListener("DOMContentLoaded", function () {
    const kategoriFilter = document.getElementById("kategori-filter");
    const searchInput = document.getElementById("search-input");
    const searchBtn = document.getElementById("search-btn");

    init();
    function init() {
        // Add event listeners
        if (kategoriFilter) {
            kategoriFilter.addEventListener("change", handleFilterChange);
        }

        if (searchBtn) {
            searchBtn.addEventListener("click", handleSearch);
        }

        if (searchInput) {
            searchInput.addEventListener("keypress", function (e) {
                if (e.key === "Enter") {
                    handleSearch();
                }
            });

            // Auto search with delay
            let searchTimeout;
            searchInput.addEventListener("input", function () {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(handleSearch, 500);
            });
        }

        // Handle download buttons
        const downloadBtns = document.querySelectorAll(".download-btn");
        downloadBtns.forEach((btn) => {
            btn.addEventListener("click", handleDownload);
        });

        // Initialize pagination
        initializePagination();

        initializePageAnimations();
        
        monitorPerformance();
    }

    function handleFilterChange() {
        const kategori = kategoriFilter.value;
        const search = searchInput ? searchInput.value : "";

        updateURL({ kategori, search });
    }

    function handleSearch() {
        const kategori = kategoriFilter ? kategoriFilter.value : "all";
        const search = searchInput ? searchInput.value : "";

        updateURL({ kategori, search });
    }

    function updateURL(params) {
        const url = new URL(window.location);

        // Update URL parameters
        Object.keys(params).forEach((key) => {
            if (params[key] && params[key] !== "all") {
                url.searchParams.set(key, params[key]);
            } else {
                url.searchParams.delete(key);
            }
        });

        // Remove page parameter when filtering
        url.searchParams.delete("page");

        // Reload page with new parameters
        window.location.href = url.toString();
    }

    function handleDownload(e) {
        const btn = e.currentTarget;
        const originalText = btn.innerHTML;

        // Show loading state
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengunduh...';
        btn.disabled = true;

        // Reset button after 3 seconds (in case download doesn't trigger properly)
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }, 3000);
    }

    // pagination functionality
    function initializePagination() {
        const paginationLinks = document.querySelectorAll(
            ".pagination .page-link"
        );

        paginationLinks.forEach((link, index) => {
            // Add smooth hover animations
            link.addEventListener("mouseenter", function () {
                if (
                    !this.closest(".page-item").classList.contains(
                        "disabled"
                    ) &&
                    !this.closest(".page-item").classList.contains("active")
                ) {
                    this.style.transform = "translateY(-2px)";
                }
            });

            link.addEventListener("mouseleave", function () {
                if (!this.closest(".page-item").classList.contains("active")) {
                    this.style.transform = "translateY(0)";
                }
            });

            // Handle pagination clicks
            link.addEventListener("click", function (e) {
                const pageItem = this.closest(".page-item");

                if (
                    !pageItem.classList.contains("disabled") &&
                    !pageItem.classList.contains("active")
                ) {
                    // Show loading state
                    showPaginationLoading();

                    // Smooth scroll to top of table
                    const tableWrapper = document.querySelector(
                        ".documents-table-wrapper"
                    );
                    if (tableWrapper) {
                        setTimeout(() => {
                            tableWrapper.scrollIntoView({
                                behavior: "smooth",
                                block: "start",
                            });
                        }, 100);
                    }

                    // Preserve current filters in pagination
                    const url = new URL(this.href);
                    const currentUrl = new URL(window.location);

                    // Preserve search and kategori parameters
                    if (currentUrl.searchParams.get("search")) {
                        url.searchParams.set(
                            "search",
                            currentUrl.searchParams.get("search")
                        );
                    }
                    if (currentUrl.searchParams.get("kategori")) {
                        url.searchParams.set(
                            "kategori",
                            currentUrl.searchParams.get("kategori")
                        );
                    }

                    // Update href with preserved parameters
                    this.href = url.toString();
                }
            });
        });

        // Add pagination keyboard navigation
        document.addEventListener("keydown", function (e) {
            // Only handle pagination keys when not in input fields
            if (
                document.activeElement.tagName === "INPUT" ||
                document.activeElement.tagName === "SELECT"
            ) {
                return;
            }

            const currentPage = document.querySelector(
                ".pagination .page-item.active"
            );
            if (!currentPage) return;

            let targetLink = null;

            // Left arrow or 'p' for previous page
            if (e.key === "ArrowLeft" || e.key.toLowerCase() === "p") {
                const prevPage = currentPage.previousElementSibling;
                if (prevPage && !prevPage.classList.contains("disabled")) {
                    targetLink = prevPage.querySelector(".page-link");
                }
            }
            // Right arrow or 'n' for next page
            else if (e.key === "ArrowRight" || e.key.toLowerCase() === "n") {
                const nextPage = currentPage.nextElementSibling;
                if (nextPage && !nextPage.classList.contains("disabled")) {
                    targetLink = nextPage.querySelector(".page-link");
                }
            }
            // Home key for first page
            else if (e.key === "Home") {
                const firstPage = document.querySelector(
                    ".pagination .page-item:not(.disabled)"
                );
                if (firstPage && !firstPage.classList.contains("active")) {
                    targetLink = firstPage.querySelector(".page-link");
                }
            }
            // End key for last page
            else if (e.key === "End") {
                const pages = Array.from(
                    document.querySelectorAll(
                        ".pagination .page-item:not(.disabled)"
                    )
                );
                const lastPage = pages[pages.length - 1];
                if (lastPage && !lastPage.classList.contains("active")) {
                    targetLink = lastPage.querySelector(".page-link");
                }
            }

            if (targetLink) {
                e.preventDefault();
                targetLink.click();
            }
        });
    }

    function showPaginationLoading() {
        // Add loading state to pagination wrapper
        const paginationWrapper = document.querySelector(".pagination-wrapper");
        if (paginationWrapper) {
            paginationWrapper.style.opacity = "0.7";
            paginationWrapper.style.pointerEvents = "none";
        }

        // Show loading state on table
        showLoadingState();
    }

    function showLoadingState() {
        const tableWrapper = document.querySelector(".documents-table-wrapper");
        if (tableWrapper) {
            tableWrapper.classList.add("loading");
        }
    }

    // Format numbers in showing info
    const showingInfo = document.querySelector(".showing-info");
    if (showingInfo) {
        const text = showingInfo.textContent;
        const formattedText = text.replace(/\d+/g, function (match) {
            return parseInt(match).toLocaleString("id-ID");
        });
        showingInfo.textContent = formattedText;
    }

    // Add tooltips for truncated text
    const documentTitles = document.querySelectorAll(".document-title");
    documentTitles.forEach((title) => {
        if (title.scrollWidth > title.clientWidth) {
            title.setAttribute("title", title.textContent);
        }
    });

    // Search highlighting
    function highlightSearchTerm(text, term) {
        if (!term) return text;

        const regex = new RegExp(`(${term})`, "gi");
        return text.replace(regex, "<mark>$1</mark>");
    }

    // Apply search highlighting if search term exists
    const urlParams = new URLSearchParams(window.location.search);
    const searchTerm = urlParams.get("search");

    if (searchTerm) {
        documentTitles.forEach((title) => {
            const originalText = title.textContent;
            const highlightedText = highlightSearchTerm(
                originalText,
                searchTerm
            );
            if (highlightedText !== originalText) {
                title.innerHTML = highlightedText;
            }
        });
    }

    // Keyboard shortcuts
    document.addEventListener("keydown", function (e) {
        // Ctrl/Cmd + K to focus search
        if ((e.ctrlKey || e.metaKey) && e.key === "k") {
            e.preventDefault();
            if (searchInput) {
                searchInput.focus();
                searchInput.select();
            }
        }

        // Escape to clear search
        if (e.key === "Escape" && document.activeElement === searchInput) {
            searchInput.value = "";
            handleSearch();
        }
    });

    // Add keyboard shortcut info
    if (searchInput) {
        searchInput.setAttribute(
            "placeholder",
            searchInput.getAttribute("placeholder")
        );
    }

    // Handle browser back/forward buttons
    window.addEventListener("popstate", function (e) {
        // Reload page to ensure proper state
        window.location.reload();
    });

    // Page visibility handling for better UX
    document.addEventListener("visibilitychange", function () {
        if (document.hidden) {
            // Page is hidden, pause any ongoing operations
            const loadingElements = document.querySelectorAll(".loading");
            loadingElements.forEach((el) => {
                el.style.animationPlayState = "paused";
            });
        } else {
            // Page is visible, resume operations
            const loadingElements = document.querySelectorAll(".loading");
            loadingElements.forEach((el) => {
                el.style.animationPlayState = "running";
            });
        }
    });

    // Initialize page animations
    function initializePageAnimations() {
        // Animate filter section
        const filterSection = document.querySelector(".filter-section");
        if (filterSection) {
            filterSection.style.opacity = "0";
            filterSection.style.transform = "translateY(-20px)";
            setTimeout(() => {
                filterSection.style.transition = "all 0.5s ease";
                filterSection.style.opacity = "1";
                filterSection.style.transform = "translateY(0)";
            }, 100);
        }

        // Animate table wrapper
        const tableWrapper = document.querySelector(".documents-table-wrapper");
        if (tableWrapper) {
            tableWrapper.style.opacity = "0";
            tableWrapper.style.transform = "translateY(20px)";
            setTimeout(() => {
                tableWrapper.style.transition = "all 0.5s ease 0.2s";
                tableWrapper.style.opacity = "1";
                tableWrapper.style.transform = "translateY(0)";
            }, 200);
        }
    }

    // Performance monitoring
    function monitorPerformance() {
        if (window.performance && window.performance.mark) {
            window.performance.mark("pagination-init-start");

            // Mark when pagination is fully loaded
            setTimeout(() => {
                window.performance.mark("pagination-init-end");
                window.performance.measure(
                    "pagination-init",
                    "pagination-init-start",
                    "pagination-init-end"
                );
            }, 1000);
        }
    }

    // Initialize page animations and performance monitoring
    initializePageAnimations();
    monitorPerformance();
});
