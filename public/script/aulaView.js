document.addEventListener("DOMContentLoaded", () => {
    const selectElements = document.querySelectorAll(".equipo");
    selectElements.forEach(select => {
        select.addEventListener("change", () => {
            const form = select.closest("form");
            form.submit();
        });
    });
});