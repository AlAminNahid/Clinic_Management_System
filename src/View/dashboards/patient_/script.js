
document.querySelectorAll(".menu-btn").forEach(button => {
    button.addEventListener("click", () => {
        document.querySelectorAll(".menu-btn").forEach(btn => btn.classList.remove("active"));
        button.classList.add("active");

        document.querySelectorAll(".content-section").forEach(section => section.classList.remove("active"));

        const target = button.getAttribute("data-target");
        if (target) {
            document.getElementById(target).classList.add("active");
        }
    });
});



const logoutBtn = document.getElementById("logout-btn");
if (logoutBtn) {
    logoutBtn.addEventListener("click", () => {
        if (confirm("Are you sure you want to logout?")) {
            window.location.href = "../../../Controller/logout.php";
        }
    });
}