document.addEventListener("DOMContentLoaded", () =>{
    const buttons = document.querySelectorAll(".menu-btn");
    const sections = document.querySelectorAll(".content-section");

    buttons.forEach(button => {
        button.addEventListener("click", () => {
            buttons.forEach(btn => btn.classList.remove("active"));
            button.classList.add("active");

            sections.forEach(sections => sections.classList.remove("active"));

            const targetId = button.getAttribute("data-target");
            document.getElementById(targetId).classList.add("active");
        });
    });

    window.confirmLogout = function() {
        if(confirm("Are you sure you want to log out?")){
            window.location.href = "../../../Controller/logout.php";
        }
    }
});