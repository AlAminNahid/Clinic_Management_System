// Patient Dashboard Form Validation
class PatientValidation {
    constructor() {
        this.init();
    }

    init() {
        this.initializeEventListeners();
        this.setMinDateForAppointment();
        this.autoHideMessages();
    }

    initializeEventListeners() {
        // Profile form validation
        const profileForm = document.querySelector('form[action*="updateProfile"]');
        if (profileForm) {
            profileForm.addEventListener('submit', (e) => {
                if (!this.validateProfileForm(profileForm)) {
                    e.preventDefault();
                }
            });
        }

        // Appointment form validation
        const appointmentForm = document.querySelector('form[action*="bookAppointment"]');
        if (appointmentForm) {
            appointmentForm.addEventListener('submit', (e) => {
                if (!this.validateAppointmentForm(appointmentForm)) {
                    e.preventDefault();
                }
            });

            // Real-time validation for appointment fields
            this.initializeRealTimeValidation(appointmentForm);
        }

        // Input field real-time validation
        this.initializeInputValidation();
    }

    // Profile Form Validation
    validateProfileForm(form) {
        let isValid = true;
        this.clearErrorStates(form);

        const fields = {
            'FullName': { required: true, minLength: 2, maxLength: 100 },
            'Email': { required: true, type: 'email' },
            'PhoneNumber': { required: false, type: 'phone' },
            'Age': { required: false, type: 'number', min: 1, max: 120 },
            'Gender': { required: false },
            'Address': { required: false, maxLength: 255 },
            'Password': { required: false, minLength: 6 }
        };

        for (const [fieldName, rules] of Object.entries(fields)) {
            const field = form.querySelector(`[name="${fieldName}"]`);
            if (field) {
                const value = field.value.trim();
                
                // Required field validation
                if (rules.required && !value) {
                    this.showFieldError(field, `${this.getFieldLabel(fieldName)} is required`);
                    isValid = false;
                    continue;
                }

                // Skip further validation if field is empty and not required
                if (!value && !rules.required) continue;

                // Email validation
                if (rules.type === 'email' && !this.isValidEmail(value)) {
                    this.showFieldError(field, 'Please enter a valid email address');
                    isValid = false;
                }

                // Phone number validation
                if (rules.type === 'phone' && !this.isValidPhone(value)) {
                    this.showFieldError(field, 'Please enter a valid phone number');
                    isValid = false;
                }

                // Number validation
                if (rules.type === 'number') {
                    const numValue = parseInt(value);
                    if (isNaN(numValue)) {
                        this.showFieldError(field, 'Please enter a valid number');
                        isValid = false;
                    } else if (rules.min && numValue < rules.min) {
                        this.showFieldError(field, `Age must be at least ${rules.min}`);
                        isValid = false;
                    } else if (rules.max && numValue > rules.max) {
                        this.showFieldError(field, `Age cannot exceed ${rules.max}`);
                        isValid = false;
                    }
                }

                // Length validation
                if (rules.minLength && value.length < rules.minLength) {
                    this.showFieldError(field, `${this.getFieldLabel(fieldName)} must be at least ${rules.minLength} characters`);
                    isValid = false;
                }

                if (rules.maxLength && value.length > rules.maxLength) {
                    this.showFieldError(field, `${this.getFieldLabel(fieldName)} cannot exceed ${rules.maxLength} characters`);
                    isValid = false;
                }

                // Password strength validation
                if (fieldName === 'Password' && value) {
                    if (!this.isStrongPassword(value)) {
                        this.showFieldError(field, 'Password must be at least 6 characters with letters and numbers');
                        isValid = false;
                    }
                }
            }
        }

        return isValid;
    }

    // Appointment Form Validation
    validateAppointmentForm(form) {
        let isValid = true;
        this.clearErrorStates(form);

        const fields = {
            'DoctorID': { required: true },
            'Date': { required: true, type: 'futureDate' },
            'Time': { required: true, type: 'time' },
            'Reason': { required: true, minLength: 10, maxLength: 500 }
        };

        for (const [fieldName, rules] of Object.entries(fields)) {
            const field = form.querySelector(`[name="${fieldName}"]`);
            if (field) {
                const value = field.value.trim();
                
                if (rules.required && !value) {
                    this.showFieldError(field, `${this.getFieldLabel(fieldName)} is required`);
                    isValid = false;
                    continue;
                }

                if (!value) continue;

                // Future date validation
                if (rules.type === 'futureDate' && !this.isFutureDate(value)) {
                    this.showFieldError(field, 'Appointment date must be today or in the future');
                    isValid = false;
                }

                // Time validation
                if (rules.type === 'time' && !this.isValidTime(value)) {
                    this.showFieldError(field, 'Please select a valid time');
                    isValid = false;
                }

                // Reason length validation
                if (rules.minLength && value.length < rules.minLength) {
                    this.showFieldError(field, `Reason must be at least ${rules.minLength} characters`);
                    isValid = false;
                }

                if (rules.maxLength && value.length > rules.maxLength) {
                    this.showFieldError(field, `Reason cannot exceed ${rules.maxLength} characters`);
                    isValid = false;
                }
            }
        }

        // Additional validation: Check if date and time combination is in the future
        if (isValid) {
            const dateField = form.querySelector('[name="Date"]');
            const timeField = form.querySelector('[name="Time"]');
            
            if (dateField && timeField && dateField.value && timeField.value) {
                if (!this.isFutureDateTime(dateField.value, timeField.value)) {
                    this.showFieldError(timeField, 'Selected date and time must be in the future');
                    isValid = false;
                }
            }
        }

        return isValid;
    }

    // Real-time Validation for Forms
    initializeRealTimeValidation(form) {
        const fields = form.querySelectorAll('input, select, textarea');
        
        fields.forEach(field => {
            field.addEventListener('blur', () => {
                this.validateFieldInRealTime(field);
            });

            field.addEventListener('input', () => {
                this.clearFieldError(field);
            });
        });
    }

    // Input Field Real-time Validation
    initializeInputValidation() {
        // Email validation
        const emailFields = document.querySelectorAll('input[type="email"]');
        emailFields.forEach(field => {
            field.addEventListener('blur', () => {
                if (field.value && !this.isValidEmail(field.value)) {
                    this.showFieldError(field, 'Please enter a valid email address');
                }
            });
        });

        // Phone validation
        const phoneFields = document.querySelectorAll('input[name="PhoneNumber"]');
        phoneFields.forEach(field => {
            field.addEventListener('blur', () => {
                if (field.value && !this.isValidPhone(field.value)) {
                    this.showFieldError(field, 'Please enter a valid phone number');
                }
            });

            // Format phone number as user types
            field.addEventListener('input', (e) => {
                e.target.value = this.formatPhoneNumber(e.target.value);
            });
        });

        // Age validation
        const ageFields = document.querySelectorAll('input[name="Age"]');
        ageFields.forEach(field => {
            field.addEventListener('blur', () => {
                if (field.value) {
                    const age = parseInt(field.value);
                    if (isNaN(age) || age < 1 || age > 120) {
                        this.showFieldError(field, 'Please enter a valid age (1-120)');
                    }
                }
            });
        });
    }

    // Individual Field Real-time Validation
    validateFieldInRealTime(field) {
        const value = field.value.trim();
        const fieldName = field.name;

        if (!value) return;

        switch (fieldName) {
            case 'Email':
                if (!this.isValidEmail(value)) {
                    this.showFieldError(field, 'Please enter a valid email address');
                }
                break;

            case 'PhoneNumber':
                if (!this.isValidPhone(value)) {
                    this.showFieldError(field, 'Please enter a valid phone number');
                }
                break;

            case 'Age':
                const age = parseInt(value);
                if (isNaN(age) || age < 1 || age > 120) {
                    this.showFieldError(field, 'Please enter a valid age (1-120)');
                }
                break;

            case 'Password':
                if (value && !this.isStrongPassword(value)) {
                    this.showFieldError(field, 'Password must be at least 6 characters with letters and numbers');
                }
                break;

            case 'Reason':
                if (value.length < 10) {
                    this.showFieldError(field, 'Reason must be at least 10 characters');
                } else if (value.length > 500) {
                    this.showFieldError(field, 'Reason cannot exceed 500 characters');
                }
                break;
        }
    }

    // Validation Helper Methods
    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    isValidPhone(phone) {
        const phoneRegex = /^[\+]?[0-9\s\-\(\)]{10,}$/;
        return phoneRegex.test(phone.replace(/\s/g, ''));
    }

    formatPhoneNumber(phone) {
        // Remove all non-digit characters
        return phone.replace(/\D/g, '');
    }

    isStrongPassword(password) {
        return password.length >= 6 && /[a-zA-Z]/.test(password) && /\d/.test(password);
    }

    isFutureDate(dateString) {
        const selectedDate = new Date(dateString);
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        return selectedDate >= today;
    }

    isValidTime(timeString) {
        const timeRegex = /^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/;
        return timeRegex.test(timeString);
    }

    isFutureDateTime(dateString, timeString) {
        const selectedDateTime = new Date(`${dateString}T${timeString}`);
        const now = new Date();
        return selectedDateTime > now;
    }

    getFieldLabel(fieldName) {
        const labels = {
            'FullName': 'Full name',
            'Email': 'Email',
            'PhoneNumber': 'Phone number',
            'Age': 'Age',
            'Gender': 'Gender',
            'Address': 'Address',
            'Password': 'Password',
            'DoctorID': 'Doctor',
            'Date': 'Date',
            'Time': 'Time',
            'Reason': 'Reason'
        };
        return labels[fieldName] || fieldName;
    }

    // Error Handling Methods
    showFieldError(field, message) {
        this.clearFieldError(field);
        
        field.classList.add('error-field');
        field.style.borderColor = '#b02a2a';
        field.style.boxShadow = '0 0 0 3px rgba(176, 42, 42, 0.1)';
        
        const errorElement = document.createElement('div');
        errorElement.className = 'field-error-message';
        errorElement.style.cssText = `
            color: #b02a2a;
            font-size: 12px;
            margin-top: 4px;
            font-weight: 500;
        `;
        errorElement.textContent = message;
        
        field.parentNode.appendChild(errorElement);

        // Scroll to error field
        field.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    clearFieldError(field) {
        field.classList.remove('error-field');
        field.style.borderColor = '';
        field.style.boxShadow = '';
        
        const existingError = field.parentNode.querySelector('.field-error-message');
        if (existingError) {
            existingError.remove();
        }
    }

    clearErrorStates(form) {
        const errorFields = form.querySelectorAll('.error-field');
        errorFields.forEach(field => {
            this.clearFieldError(field);
        });
    }

    // Utility Methods
    setMinDateForAppointment() {
        const dateInput = document.querySelector('input[type="date"][name="Date"]');
        if (dateInput) {
            const today = new Date().toISOString().split('T')[0];
            dateInput.setAttribute('min', today);
            
            if (!dateInput.value) {
                dateInput.value = today;
            }

            // Update min date daily
            dateInput.addEventListener('focus', () => {
                const newToday = new Date().toISOString().split('T')[0];
                dateInput.setAttribute('min', newToday);
            });
        }
    }

    autoHideMessages() {
        const messages = document.querySelectorAll('.success, .error');
        messages.forEach(message => {
            setTimeout(() => {
                message.style.opacity = '0';
                message.style.transition = 'opacity 0.5s ease';
                setTimeout(() => {
                    if (message.parentNode) {
                        message.remove();
                    }
                }, 500);
            }, 5000);
        });
    }

    // Public method to validate specific form
    validateForm(form) {
        if (form.action.includes('updateProfile')) {
            return this.validateProfileForm(form);
        } else if (form.action.includes('bookAppointment')) {
            return this.validateAppointmentForm(form);
        }
        return true;
    }
}

// Initialize validation when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.patientValidation = new PatientValidation();
});

// Export for use in other files
if (typeof module !== 'undefined' && module.exports) {
    module.exports = PatientValidation;
}