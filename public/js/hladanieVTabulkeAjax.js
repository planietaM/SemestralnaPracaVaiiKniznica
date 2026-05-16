document.addEventListener("DOMContentLoaded", () => {
    const input = document.getElementById("tableSearch");
    const tbody = document.getElementById("booksTbody");
    let timer;

    if (input == null || tbody == null) {
        return;
    }

    input.addEventListener("keyup", () => {
        clearTimeout(timer);
        timer = setTimeout(async () => {
            const zadavaneVeci = input.value.trim();
            const VratenePoleDat = await fetch(`/?c=Knihy&a=search&hladanyText=${encodeURIComponent(zadavaneVeci)}`);
            const data = await VratenePoleDat.json();

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