// Form validation for patient dashboard
class PatientValidation {
    // Profile form validation
    static validateProfileForm() {
        const fullName = document.getElementById('fullName').value.trim();
        const phoneNumber = document.getElementById('phoneNumber').value.trim();
        const age = document.getElementById('age').value;
        const gender = document.getElementById('gender').value;
        const address = document.getElementById('address').value.trim();

        let errors = [];

        // Full name validation
        if (fullName.length < 2) {
            errors.push('Full name must be at least 2 characters long');
        }

        // Phone number validation
        const phoneRegex = /^[0-9+\-\s()]{10,}$/;
        if (!phoneRegex.test(phoneNumber)) {
            errors.push('Please enter a valid phone number');
        }

        // Age validation
        if (age < 0 || age > 150) {
            errors.push('Please enter a valid age');
        }

        // Gender validation
        if (!gender) {
            errors.push('Please select a gender');
        }

        // Address validation
        if (address.length < 10) {
            errors.push('Address must be at least 10 characters long');
        }

        return errors;
    }

    // Appointment form validation
    static validateAppointmentForm() {
        const doctor = document.getElementById('doctor').value;
        const appointmentDate = document.getElementById('appointmentDate').value;
        const appointmentTime = document.getElementById('appointmentTime').value;
        const reason = document.getElementById('reason').value.trim();

        let errors = [];

        // Doctor selection
        if (!doctor) {
            errors.push('Please select a doctor');
        }

        // Date validation
        if (!appointmentDate) {
            errors.push('Please select an appointment date');
        } else {
            const selectedDate = new Date(appointmentDate);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            if (selectedDate < today) {
                errors.push('Appointment date cannot be in the past');
            }
        }

        // Time validation
        if (!appointmentTime) {
            errors.push('Please select an appointment time');
        } else {
            const selectedTime = appointmentTime.split(':');
            const hours = parseInt(selectedTime[0]);
            if (hours < 8 || hours > 17) {
                errors.push('Appointments are only available between 8:00 AM and 5:00 PM');
            }
        }

        // Reason validation
        if (reason.length < 10) {
            errors.push('Please provide a detailed reason for your appointment (at least 10 characters)');
        }

        return errors;
    }

    // Display validation errors
    static displayErrors(errors, formId) {
        // Remove existing error messages
        const existingErrors = document.querySelectorAll('.error-message');
        existingErrors.forEach(error => error.remove());

        // Add new error messages
        errors.forEach(error => {
            const errorElement = document.createElement('div');
            errorElement.className = 'error-message';
            errorElement.style.cssText = `
                color: #dc3545;
                font-size: 0.9rem;
                margin-top: 0.25rem;
                padding: 0.5rem;
                background: #f8d7da;
                border: 1px solid #f5c6cb;
                border-radius: 4px;
            `;
            errorElement.textContent = error;
            
            const form = document.getElementById(formId);
            form.insertBefore(errorElement, form.firstChild);
        });

        return errors.length === 0;
    }

    // Real-time validation
    static initializeRealTimeValidation() {
        // Profile form real-time validation
        const profileInputs = document.querySelectorAll('#profileForm input, #profileForm select, #profileForm textarea');
        profileInputs.forEach(input => {
            input.addEventListener('blur', function() {
                const errors = PatientValidation.validateProfileForm();
                if (errors.length > 0) {
                    this.style.borderColor = '#dc3545';
                } else {
                    this.style.borderColor = '#28a745';
                }
            });
        });

        // Appointment form real-time validation
        const appointmentInputs = document.querySelectorAll('#appointmentForm input, #appointmentForm select, #appointmentForm textarea');
        appointmentInputs.forEach(input => {
            input.addEventListener('blur', function() {
                const errors = PatientValidation.validateAppointmentForm();
                if (errors.length > 0) {
                    this.style.borderColor = '#dc3545';
                } else {
                    this.style.borderColor = '#28a745';
                }
            });
        });
    }
}

// Initialize validation when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    PatientValidation.initializeRealTimeValidation();

    // Profile form submission with validation
    const profileForm = document.getElementById('profileForm');
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const errors = PatientValidation.validateProfileForm();
            if (PatientValidation.displayErrors(errors, 'profileForm')) {
                // If no errors, proceed with form submission
                updateProfile();
            }
        });
    }

    // Appointment form submission with validation
    const appointmentForm = document.getElementById('appointmentForm');
    if (appointmentForm) {
        appointmentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const errors = PatientValidation.validateAppointmentForm();
            if (PatientValidation.displayErrors(errors, 'appointmentForm')) {
                // If no errors, proceed with form submission
                bookAppointment();
            }
        });
    }
});