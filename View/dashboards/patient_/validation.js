document.addEventListener("DOMContentLoaded", () => {

    // ===== Profile Form Validation =====
    const profileForm = document.querySelector(".profile-form form");
    if (profileForm) {
        profileForm.addEventListener("submit", (e) => {
            const fullname = profileForm.fullname.value.trim();
            const email = profileForm.email.value.trim();
            const phone = profileForm.phone.value.trim();
            const gender = profileForm.gender.value;
            const address = profileForm.address.value.trim();

            if (!fullname || !email || !phone || !gender || !address) {
                alert("Please fill all required fields in your profile.");
                e.preventDefault();
                return;
            }

            // Email format validation
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert("Please enter a valid email address.");
                e.preventDefault();
                return;
            }

            // Phone number validation (6-15 digits)
            const phonePattern = /^[0-9]{6,15}$/;
            if (!phonePattern.test(phone)) {
                alert("Please enter a valid phone number (6-15 digits).");
                e.preventDefault();
                return;
            }
        });
    }

    // ===== Appointment Form Validation =====
    const appointmentForm = document.querySelector(".appointment-form form");
    if (appointmentForm) {
        appointmentForm.addEventListener("submit", (e) => {
            const doctorId = appointmentForm.doctor.value;
            const appointmentDate = appointmentForm.appointment_date.value;
            const reason = appointmentForm.reason.value.trim();

            if (!doctorId || !appointmentDate || !reason) {
                alert("Please fill all required fields in the appointment form.");
                e.preventDefault();
                return;
            }

            // Optional: Date validation (cannot be past)
            const selectedDate = new Date(appointmentDate);
            const today = new Date();
            today.setHours(0,0,0,0); // set to midnight
            if (selectedDate < today) {
                alert("Please select a valid appointment date.");
                e.preventDefault();
                return;
            }

            // Reason length validation
            if (reason.length < 5) {
                alert("Please enter a valid reason for the appointment (at least 5 characters).");
                e.preventDefault();
                return;
            }
        });
    }

});
