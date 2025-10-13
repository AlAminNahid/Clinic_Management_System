document.addEventListener("DOMContentLoaded", () => {

    const profileForm = document.querySelector(".profile-form form");
    if (profileForm) {
        profileForm.addEventListener("submit", (e) => {
            const fullname = profileForm.fullname.value.trim();
            const email = profileForm.email.value.trim();
            const phone = profileForm.phone.value.trim();
            const specialization = profileForm.specialization.value.trim();
            const visitFee = profileForm.visit_fee.value.trim();

            if (!fullname || !email || !phone || !specialization || !visitFee) {
                alert("Please fill all required fields in your profile.");
                e.preventDefault();
                return;
            }

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert("Please enter a valid email address.");
                e.preventDefault();
                return;
            }

            const phonePattern = /^[0-9]{6,15}$/;
            if (!phonePattern.test(phone)) {
                alert("Please enter a valid phone number (6-15 digits).");
                e.preventDefault();
                return;
            }
        });
    }

    const prescriptionForm = document.querySelector(".medicine-form form");
    if (prescriptionForm) {
        prescriptionForm.addEventListener("submit", (e) => {
            const patientId = prescriptionForm.patient_id.value;
            const medicine = prescriptionForm.medicine.value.trim();
            const dosage = prescriptionForm.dosage.value.trim();
            const duration = prescriptionForm.duration.value.trim();

            if (!patientId || !medicine || !dosage || !duration) {
                alert("Please fill all required fields in the prescription form.");
                e.preventDefault();
                return;
            }

            if (dosage.length < 2) {
                alert("Please enter a valid dosage.");
                e.preventDefault();
                return;
            }

            if (duration.length < 1) {
                alert("Please enter a valid duration.");
                e.preventDefault();
                return;
            }
        });
    }

});
