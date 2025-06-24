let scrollToTopBtn = document.getElementById("scrollToTopBtn");

// Tampilkan tombol saat halaman di-scroll ke bawah
window.onscroll = function () {
    if (document.documentElement.scrollTop > 300) {
        scrollToTopBtn.style.display = "block";
    } else {
        scrollToTopBtn.style.display = "none";
    }
};

// Fungsi untuk kembali ke atas saat tombol diklik
scrollToTopBtn.addEventListener("click", function () {
    window.scrollTo({
        top: 0,
        behavior: "smooth",
    });
});
