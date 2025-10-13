document.addEventListener("DOMContentLoaded", () => {

    const menuButtons = document.querySelectorAll(".menu-btn");
    const sections = document.querySelectorAll(".content-section");

    menuButtons.forEach(btn => {
        btn.addEventListener("click", () => {
            const target = btn.getAttribute("data-target");

            menuButtons.forEach(b => b.classList.remove("active"));
            btn.classList.add("active");

            sections.forEach(sec => sec.classList.remove("active"));

            const activeSection = document.getElementById(target);
            if (activeSection) activeSection.classList.add("active");
        });
    });

    const logoutBtn = document.getElementById("logout-btn");
    logoutBtn.addEventListener("click", () => {
        if (confirm("Are you sure you want to logout?")) {
            window.location.href = "../../../Controller/logout.php"; // adjust path
        }
    });

    

document.addEventListener('DOMContentLoaded', function() {
    const menuButtons = document.querySelectorAll('.menu-btn');
    const contentSections = document.querySelectorAll('.content-section');
    
    menuButtons.forEach(button => {
        button.addEventListener('click', function() {
            const target = this.getAttribute('data-target');
            
            
            menuButtons.forEach(btn => btn.classList.remove('active'));
            contentSections.forEach(section => section.classList.remove('active'));
            
            
            this.classList.add('active');
            document.getElementById(target).classList.add('active');
        });
    });
});




function confirmLogout() {
    if (confirm('Are you sure you want to logout?')) {
        window.location.href = '../../Controller/logout.php';
    }
}

    if (medicineSelect) {
        fetch("/path/to/getMedicines.php")
            .then(res => res.json())
            .then(data => {
                data.forEach(med => {
                    const option = document.createElement("option");
                    option.value = med.name;
                    option.textContent = med.name;
                    medicineSelect.appendChild(option);
                });
            });
    }

});
