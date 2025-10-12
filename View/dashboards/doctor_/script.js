document.addEventListener("DOMContentLoaded", () => {

    // Sidebar Menu Buttons
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

    // Logout
    const logoutBtn = document.getElementById("logout-btn");
    logoutBtn.addEventListener("click", () => {
        if (confirm("Are you sure you want to logout?")) {
            window.location.href = "../../../Controller/logout.php"; // adjust path
        }
    });

    // Load patients and medicines dynamically
    const patientSelect = document.getElementById("patient-id");
    const medicineSelect = document.getElementById("medicine-name");

    if (patientSelect) {
        fetch("/path/to/getPatients.php")
            .then(res => res.json())
            .then(data => {
                data.forEach(patient => {
                    const option = document.createElement("option");
                    option.value = patient.id;
                    option.textContent = patient.name;
                    patientSelect.appendChild(option);
                });
            });
    }

    // Menu navigation
document.addEventListener('DOMContentLoaded', function() {
    const menuButtons = document.querySelectorAll('.menu-btn');
    const contentSections = document.querySelectorAll('.content-section');
    
    menuButtons.forEach(button => {
        button.addEventListener('click', function() {
            const target = this.getAttribute('data-target');
            
            // Remove active class from all buttons and sections
            menuButtons.forEach(btn => btn.classList.remove('active'));
            contentSections.forEach(section => section.classList.remove('active'));
            
            // Add active class to current button and section
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
