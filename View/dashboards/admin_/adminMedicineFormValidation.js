document.addEventListener("DOMContentLoaded", () => {
    const medicineForm = document.querySelector("#medicines form");

    medicineForm.addEventListener("submit", function(e) {
        const name = document.getElementById("medicine-name").value.trim();
        const type = document.getElementById("medicine-type").value;
        const strength = document.getElementById("medicine-strength").value.trim();
        const manufacturer = document.getElementById("medicine-manufacturer").value.trim();
        const status = document.getElementById("medicine-status").value;

        if(name === "" || type === "" || strength === "" || manufacturer === "" || status === ""){
            alert("All fields are required for adding a medicine.");
            e.preventDefault();
        }

        if(strength.length < 1 || isNaN(strength)){
            alert("Strength must be a valid number.");
            e.preventDefault();
        }
    });
});
