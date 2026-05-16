document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("registraciaOverenieForm");
    const errorBox = document.getElementById("registraciaOverenieError");

    if (!form) return;

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const formData = new FormData(form);

        const response = await fetch(form.action, {
            method: "POST",
            body: formData,
            headers: {
                "X-Requested-With": "XMLHttpRequest"
            }
        });

        const data = await response.json();

        if (data.success) {
            window.location.href = data.redirect;
        } else {
            errorBox.textContent = data.message || "Registrácia zlyhala";
        }
    });
});