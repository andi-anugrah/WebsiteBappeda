const totalPages = 5;
let currentPage = 1;

function renderPagination() {
    const container = document.getElementById("pagination");
    container.innerHTML = "";

    // Tombol Sebelumnya
    const prev = document.createElement("button");
    prev.innerHTML = "&lsaquo;";
    prev.disabled = currentPage === 1;
    prev.onclick = () => {
        if (currentPage > 1) {
            currentPage--;
            renderPagination();
        }
    };
    container.appendChild(prev);

    // Tombol Nomor Halaman
    for (let i = 1; i <= totalPages; i++) {
        const btn = document.createElement("button");
        btn.textContent = i;
        if (i === currentPage) {
            btn.classList.add("active");
        }
        btn.onclick = () => {
            currentPage = i;
            renderPagination();
        };
        container.appendChild(btn);
    }

    // Tombol Berikutnya
    const next = document.createElement("button");
    next.innerHTML = "&rsaquo;";
    next.disabled = currentPage === totalPages;
    next.onclick = () => {
        if (currentPage < totalPages) {
            currentPage++;
            renderPagination();
        }
    };
    container.appendChild(next);
}