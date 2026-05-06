const searchInput = document.getElementById("tableSearch");
const tableRows = document.querySelectorAll("table tbody tr");

if (searchInput) {
    searchInput.addEventListener("keyup", () => {
        const value = searchInput.value.toLowerCase();
        tableRows.forEach(row => {
            const rowText = row.textContent.toLowerCase();
            row.style.display = rowText.includes(value) ? "" : "none";
        });
    });
}