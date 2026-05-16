document.addEventListener("DOMContentLoaded", () => {
    const input = document.getElementById("tableSearch");
    const tbody = document.getElementById("booksTbody");
    let timer;

    if (!input || !tbody) return;

    input.addEventListener("keyup", () => {
        clearTimeout(timer);
        timer = setTimeout(async () => {
            const value = input.value.trim();
            const response = await fetch(`/?c=Knihy&a=search&q=${encodeURIComponent(value)}`);
            const data = await response.json();

            console.log(data);

            tbody.innerHTML = data.map(kniha => `
                <tr>
                    <td>${kniha.id}</td>
                    <td>${kniha.nazov}</td>
                    <td>${kniha.autor}</td>
                    <td><img src="/images/${kniha.fotka}" height="100"></td>
                </tr>
            `).join("");
        }, 300);
    });
});