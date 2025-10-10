// Patient Dashboard Validation
class PatientValidation {
    
    // Profile form validation
    static validateProfileForm() {
        const fullName = document.getElementById('fullname').value.trim();
        const phoneNumber = document.getElementById('phone').value.trim();
        const age = document.getElementById('age').value;
        const gender = document.getElementById('gender').value;
        const address = document.getElementById('address').value.trim();

        let errors = [];

        // Clear previous error styles
        this.clearErrorStyles('profileForm');

        // Full name validation
        if (fullName.length < 2) {
            errors.push('Full name must be at least 2 characters long');
            this.markFieldError('fullname');
        }

        // Phone number validation
        const phoneRegex = /^[+]?[0-9\s\-()]{10,}$/;
        if (!phoneRegex.test(phoneNumber)) {
            errors.push('Please enter a valid phone number');
            this.markFieldError('phone');
        }

        // Age validation
        const ageNum = parseInt(age);
        if (isNaN(ageNum) || ageNum < 1 || ageNum > 120) {
            errors.push('Please enter a valid age (1-120)');
            this.markFieldError('age');
        }

        // Gender validation
        if (!gender) {
            errors.push('Please select a gender');
            this.markFieldError('gender');
        }

        // Address validation
        if (address.length < 10) {
            errors.push('Address must be at least 10 characters long');
            this.markFieldError('address');
        }

        // Display errors if any
        if (errors.length > 0) {
            this.displayErrors(errors, 'profileForm');
            return false;
        }

        return true;
    }

    // Appointment form validation
    static validateAppointmentForm() {
        const doctor = document.getElementById('doctor').value;
        const appointmentDate = document.getElementById('appointment-date').value;
        const appointmentTime = document.getElementById('appointment-time').value;
        const reason = document.getElementById('reason').value.trim();

        let errors = [];

        // Clear previous error styles
        this.clearErrorStyles('appointmentForm');

        // Doctor selection
        if (!doctor) {
            errors.push('Please select a doctor');
            this.markFieldError('doctor');
        }

        // Date validation
        if (!appointmentDate) {
            errors.push('Please select an appointment date');
            this.markFieldError('appointment-date');
        } else {
            const selectedDate = new Date(appointmentDate);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            if (selectedDate < today) {
                errors.push('Appointment date cannot be in the past');
                this.markFieldError('appointment-date');
            }
        }

        // Time validation
        if (!appointmentTime) {
            errors.push('Please select an appointment time');
            this.markFieldError('appointment-time');
        } else {
            const selectedTime = appointmentTime.split(':');
            const hours = parseInt(selectedTime[0]);
            const minutes = parseInt(selectedTime[1]);
            
            // Check if time is within reasonable hours (8 AM to 6 PM)
            if (hours < 8 || hours > 18 || (hours === 18 && minutes > 0)) {
                errors.push('Appointments are only available between 8:00 AM and 6:00 PM');
                this.markFieldError('appointment-time');
            }
        }

        // Reason validation
        if (reason.length < 10) {
            errors.push('Please provide a detailed reason for your appointment (at least 10 characters)');
            this.markFieldError('reason');
        }

        // Display errors if any
        if (errors.length > 0) {
            this.displayErrors(errors, 'appointmentForm');
            return false;
        }

        return true;
    }

    // Mark field as error
    static markFieldError(fieldId) {
        const field = document.getElementById(fieldId);
        if (field) {
            field.classList.add('input-error');
        }
    }

    // Clear error styles from form
    static clearErrorStyles(formId) {
        const form = document.getElementById(formId);
        if (!form) return;
        
        const errorFields = form.querySelectorAll('.input-error');
        errorFields.forEach(field => field.classList.remove('input-error'));
        
        // Remove existing error messages
        const existingErrors = form.querySelectorAll('.error-message');
        existingErrors.forEach(error => error.remove());
    }

    // Display validation errors
    static displayErrors(errors, formId) {
        const form = document.getElementById(formId);
        if (!form) return;
        
        errors.forEach(error => {
            const errorElement = document.createElement('div');
            errorElement.className = 'error-message';
            errorElement.textContent = error;
            form.insertBefore(errorElement, form.firstChild);
        });
    }

    // Real-time validation
    static initializeRealTimeValidation() {
        // Profile form real-time validation
        const profileForm = document.getElementById('profileForm');
        if (profileForm) {
            const profileInputs = profileForm.querySelectorAll('input, select, textarea');
            profileInputs.forEach(input => {
                input.addEventListener('blur', function() {
                    PatientValidation.clearErrorStyles('profileForm');
                    PatientValidation.validateProfileForm();
                });
                
                input.addEventListener('input', function() {
                    this.classList.remove('input-error');
                });
            });
        }

        // Appointment form real-time validation
        const appointmentForm = document.getElementById('appointmentForm');
        if (appointmentForm) {
            const appointmentInputs = appointmentForm.querySelectorAll('input, select, textarea');
            appointmentInputs.forEach(input => {
                input.addEventListener('blur', function() {
                    PatientValidation.clearErrorStyles('appointmentForm');
                    PatientValidation.validateAppointmentForm();
                });
                
                input.addEventListener('input', function() {
                    this.classList.remove('input-error');
                });
            });
        }
    }
}

// Initialize real-time validation when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    PatientValidation.initializeRealTimeValidation();
});