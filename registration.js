/**
 * registration.js
 * Client-Side Form Validation for Registration
 * 
 * Purpose: Validates user input before form submission
 * Validates: Name, Email, Password, Confirm Password, Phone
 * Used by: index.html registration form
 */

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function () {
    // Get reference to the registration form
    const form = document.forms['regForm'];
    
    if (!form) {
        console.warn('Registration form not found on this page');
        return;
    }

    // Add submit event listener to validate before submission
    form.addEventListener('submit', function (e) {
        const errors = [];
        
        // Get form field values
        const name = form.name.value.trim();
        const email = form.email.value.trim();
        const password = form.password.value;
        const confirm = form.confirmPassword.value;
        const phone = form.phone.value.trim();

        // Validate Name - must not be empty
        if (!name) {
            errors.push('❌ Name is required.');
        } else if (name.length < 2) {
            errors.push('❌ Name must be at least 2 characters long.');
        }

        // Validate Email - must not be empty and match email pattern
        if (!email) {
            errors.push('❌ Email is required.');
        } else {
            // Simple email regex pattern
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                errors.push('❌ Please enter a valid email address (e.g., user@example.com).');
            }
        }

        // Validate Password - minimum 6 characters
        if (!password) {
            errors.push('❌ Password is required.');
        } else if (password.length < 6) {
            errors.push('❌ Password must be at least 6 characters long.');
        }

        // Validate Confirm Password - must match password
        if (!confirm) {
            errors.push('❌ Please confirm your password.');
        } else if (password !== confirm) {
            errors.push('❌ Passwords do not match. Please re-enter.');
        }

        // Validate Phone - must be exactly 10 digits
        if (!phone) {
            errors.push('❌ Phone number is required.');
        } else if (!/^\d{10}$/.test(phone)) {
            errors.push('❌ Phone number must be exactly 10 digits (numbers only).');
        }

        // If there are validation errors, prevent form submission and show errors
        if (errors.length > 0) {
            e.preventDefault();
            
            // Display errors in a formatted alert
            alert('⚠️ Please fix the following errors:\n\n' + errors.join('\n'));
            
            // Focus on first input field for user convenience
            form.name.focus();
            
            return false;
        }

        // All validations passed - form will submit
        return true;
    });

    // Optional: Real-time validation feedback (show as user types)
    // Add 'input' event listeners for instant feedback
    
    const emailField = form.email;
    if (emailField) {
        emailField.addEventListener('blur', function() {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (this.value && !emailPattern.test(this.value)) {
                this.style.borderColor = '#ef4444';
            } else {
                this.style.borderColor = '#10b981';
            }
        });
    }

    const confirmField = form.confirmPassword;
    if (confirmField) {
        confirmField.addEventListener('input', function() {
            if (this.value && this.value !== form.password.value) {
                this.style.borderColor = '#ef4444';
            } else if (this.value === form.password.value) {
                this.style.borderColor = '#10b981';
            }
        });
    }

    const phoneField = form.phone;
    if (phoneField) {
        phoneField.addEventListener('input', function() {
            // Remove non-digit characters as user types
            this.value = this.value.replace(/\D/g, '');
            
            // Validate length
            if (this.value.length === 10) {
                this.style.borderColor = '#10b981';
            } else if (this.value.length > 0) {
                this.style.borderColor = '#ef4444';
            }
        });
    }
});

/**
 * Additional validation function that can be called from HTML
 * Usage: <form onsubmit="return validateForm()">
 */
function validateForm() {
    const form = document.forms['regForm'];
    const errors = [];
    
    const name = form.name.value.trim();
    const email = form.email.value.trim();
    const password = form.password.value;
    const confirm = form.confirmPassword.value;
    const phone = form.phone.value.trim();

    if (!name) errors.push('Name is required.');
    if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) errors.push('Valid email is required.');
    if (!password || password.length < 6) errors.push('Password must be at least 6 characters.');
    if (password !== confirm) errors.push('Passwords do not match.');
    if (!/^\d{10}$/.test(phone)) errors.push('Phone must be 10 digits.');

    if (errors.length > 0) {
        alert('Please fix the following errors:\n\n' + errors.join('\n'));
        return false;
    }
    
    return true;
}
