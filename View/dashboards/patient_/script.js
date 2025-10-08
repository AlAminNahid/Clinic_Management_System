// Patient Dashboard JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize dashboard
    initDashboard();
    
    // Set today's date as minimum for appointment date
    setMinDateForAppointment();
    
    // Add form validation
    initFormValidation();
});

// Initialize dashboard functionality
function initDashboard() {
    // Show default section (dashboard)
    showSection('dashboard');
    
    // Add active class to current section in URL hash
    const hash = window.location.hash.substring(1);
    if (hash && document.getElementById(hash)) {
        showSection(hash);
    }
}

// Show/hide sections
function showSection(sectionId) {
    // Hide all sections
    document.querySelectorAll('.section').forEach(section => {
        section.style.display = 'none';
        section.classList.remove('active');
    });
    
    // Show selected section
    const targetSection = document.getElementById(sectionId);
    if (targetSection) {
        targetSection.style.display = 'block';
        targetSection.classList.add('active');
    }
    
    // Update navigation active state
    document.querySelectorAll('.nav a').forEach(link => {
        link.classList.remove('active');
    });
    
    const activeLink = document.querySelector(`[data-target="${sectionId}"]`);
    if (activeLink) {
        activeLink.classList.add('active');
    }
    
    // Update URL hash
    window.location.hash = sectionId;
    
    // Smooth scroll to top
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Set minimum date for appointment booking (today)
function setMinDateForAppointment() {
    const dateInput = document.querySelector('input[type="date"][name="Date"]');
    if (dateInput) {
        const today = new Date().toISOString().split('T')[0];
        dateInput.setAttribute('min', today);
        
        // If no value set, set today's date as default
        if (!dateInput.value) {
            dateInput.value = today;
        }
    }
}

// Initialize form validation
function initFormValidation() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
            }
        });
    });
}

// Form validation function
function validateForm(form) {
    let isValid = true;
    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    
    // Clear previous error states
    clearErrorStates(form);
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            markFieldAsError(input, 'This field is required');
            isValid = false;
        }
        
        // Email validation
        if (input.type === 'email' && input.value.trim()) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(input.value)) {
                markFieldAsError(input, 'Please enter a valid email address');
                isValid = false;
            }
        }
        
        // Date validation for appointments
        if (input.type === 'date' && input.name === 'Date' && input.value) {
            const selectedDate = new Date(input.value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            if (selectedDate < today) {
                markFieldAsError(input, 'Appointment date cannot be in the past');
                isValid = false;
            }
        }
    });
    
    return isValid;
}

// Mark field as having error
function markFieldAsError(field, message) {
    field.style.borderColor = '#b02a2a';
    field.style.boxShadow = '0 0 0 3px rgba(176, 42, 42, 0.1)';
    
    // Create error message element
    const errorElement = document.createElement('div');
    errorElement.className = 'field-error';
    errorElement.style.color = '#b02a2a';
    errorElement.style.fontSize = '12px';
    errorElement.style.marginTop = '4px';
    errorElement.textContent = message;
    
    field.parentNode.appendChild(errorElement);
}

// Clear error states from form
function clearErrorStates(form) {
    const errorElements = form.querySelectorAll('.field-error');
    errorElements.forEach(element => element.remove());
    
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.style.borderColor = '';
        input.style.boxShadow = '';
    });
}

// Auto-hide success/error messages after 5 seconds
function autoHideMessages() {
    const messages = document.querySelectorAll('.success, .error');
    messages.forEach(message => {
        setTimeout(() => {
            message.style.opacity = '0';
            message.style.transition = 'opacity 0.5s ease';
            setTimeout(() => message.remove(), 500);
        }, 5000);
    });
}

// Initialize auto-hide for messages
if (document.querySelector('.success, .error')) {
    autoHideMessages();
}

// Enhanced appointment time validation
function validateAppointmentTime(timeInput, dateInput) {
    if (!timeInput || !dateInput) return;
    
    timeInput.addEventListener('change', function() {
        const selectedDate = new Date(dateInput.value);
        const selectedTime = this.value;
        
        if (selectedDate && selectedTime) {
            const selectedDateTime = new Date(selectedDate);
            const [hours, minutes] = selectedTime.split(':');
            selectedDateTime.setHours(parseInt(hours), parseInt(minutes));
            
            const now = new Date();
            
            // Check if selected time is in the past
            if (selectedDateTime < now) {
                markFieldAsError(this, 'Selected time is in the past');
            } else {
                clearErrorStates(this.form);
            }
        }
    });
}

// Initialize enhanced time validation
const timeInput = document.querySelector('input[type="time"][name="Time"]');
const dateInput = document.querySelector('input[type="date"][name="Date"]');
if (timeInput && dateInput) {
    validateAppointmentTime(timeInput, dateInput);
}

// Export functions for global access (if needed)
window.showSection = showSection;
window.validateForm = validateForm;