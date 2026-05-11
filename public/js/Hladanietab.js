/**
 * Trieda pre vyhľadávanie v tabuľke
 */
class Hladanietab {
    #searchInput;
    #tableRows;

    constructor() {
        this.#searchInput = document.getElementById("tableSearch");
        this.#tableRows = document.querySelectorAll("table tbody tr");

        if (this.#searchInput && this.#tableRows.length > 0) {
            this.#initializeSearch();
        } else {
            console.warn("SearchInput alebo tableRows sa nenašli!");
        }
    }

    #initializeSearch() {
        this.#searchInput.addEventListener("keyup", () => {
            this.#performSearch();
        });
    }

    #performSearch() {
        const value = this.#searchInput.value.toLowerCase();

        this.#tableRows.forEach(row => {
            const cells = row.querySelectorAll("td");
            const searchText = (
                cells[1]?.textContent + " " +
                cells[2]?.textContent
            ).toLowerCase();

            row.style.display = searchText.includes(value) ? "" : "none";
        });
    }
}

export {Hladanietab}