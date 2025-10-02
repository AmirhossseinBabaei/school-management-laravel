// Enhanced Form Handler for CRUD Operations
$(document).ready(function() {
    
    // Enhanced form submission handler
    $('form').on('submit', function(e) {
        var form = $(this);
        var submitBtn = form.find('button[type="submit"]');
        var originalBtnText = submitBtn.html();
        
        // Prevent double submission
        if (submitBtn.prop('disabled')) {
            e.preventDefault();
            return false;
        }
        
        // Validate form
        if (!form[0].checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
            form.addClass('was-validated');
            
            // Show validation errors
            showValidationErrors(form);
            return false;
        }
        
        // Show loading state
        submitBtn.prop('disabled', true);
        submitBtn.html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>در حال پردازش...');
        
        // Add form class
        form.addClass('was-validated');
        
        // Store original button text for potential restoration
        submitBtn.data('original-text', originalBtnText);
        
        // If form submission fails, restore button after 3 seconds
        setTimeout(function() {
            if (submitBtn.prop('disabled')) {
                submitBtn.prop('disabled', false);
                submitBtn.html(originalBtnText);
            }
        }, 3000);
    });
    
    // Handle form errors (if any)
    $('form').on('form:error', function(e, errors) {
        var form = $(this);
        var submitBtn = form.find('button[type="submit"]');
        
        // Restore button
        submitBtn.prop('disabled', false);
        submitBtn.html(submitBtn.data('original-text') || 'ارسال');
        
        // Show errors
        showFormErrors(form, errors);
    });
    
    // Handle form success
    $('form').on('form:success', function(e, response) {
        var form = $(this);
        var submitBtn = form.find('button[type="submit"]');
        
        // Restore button
        submitBtn.prop('disabled', false);
        submitBtn.html(submitBtn.data('original-text') || 'ارسال');
        
        // Show success message
        if (response.message) {
            showAlert(response.message, 'success');
        }
    });
    
    // Function to show validation errors
    function showValidationErrors(form) {
        var invalidFields = form.find(':invalid');
        
        invalidFields.each(function() {
            var field = $(this);
            var feedback = field.siblings('.invalid-feedback');
            
            if (feedback.length === 0) {
                feedback = $('<div class="invalid-feedback"></div>');
                field.after(feedback);
            }
            
            feedback.text(field[0].validationMessage || 'این فیلد الزامی است');
        });
    }
    
    // Function to show form errors
    function showFormErrors(form, errors) {
        // Clear previous errors
        form.find('.is-invalid').removeClass('is-invalid');
        form.find('.invalid-feedback').remove();
        
        // Show new errors
        $.each(errors, function(field, messages) {
            var fieldElement = form.find('[name="' + field + '"]');
            if (fieldElement.length) {
                fieldElement.addClass('is-invalid');
                var feedback = $('<div class="invalid-feedback"></div>');
                feedback.text(Array.isArray(messages) ? messages[0] : messages);
                fieldElement.after(feedback);
            }
        });
    }
    
    // Enhanced alert function
    window.showAlert = function(message, type = 'info', duration = 5000) {
        var alertClass = 'alert-' + type;
        var iconClass = getIconForType(type);
        
        var alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
                 style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;" role="alert">
                <i class="${iconClass} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        
        $('body').append(alertHtml);
        
        setTimeout(function() {
            $('.alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, duration);
    };
    
    // Get appropriate icon for alert type
    function getIconForType(type) {
        var icons = {
            'success': 'fa-solid fa-check-circle',
            'danger': 'fa-solid fa-exclamation-circle',
            'warning': 'fa-solid fa-exclamation-triangle',
            'info': 'fa-solid fa-info-circle'
        };
        return icons[type] || icons['info'];
    }
    
    // Auto-save functionality for forms (optional)
    $('form[data-auto-save]').on('input change', function() {
        var form = $(this);
        var formData = form.serialize();
        var saveUrl = form.data('auto-save-url');
        
        if (saveUrl) {
            clearTimeout(form.data('auto-save-timeout'));
            form.data('auto-save-timeout', setTimeout(function() {
                $.post(saveUrl, formData)
                    .done(function(response) {
                        console.log('Auto-saved successfully');
                    })
                    .fail(function() {
                        console.log('Auto-save failed');
                    });
            }, 2000)); // Save after 2 seconds of inactivity
        }
    });
    
    // Confirm delete with SweetAlert2 style
    $('.btn-delete').on('click', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var title = $(this).data('title') || 'حذف';
        var text = $(this).data('text') || 'آیا مطمئن هستید که می‌خواهید این مورد را حذف کنید؟';
        
        if (confirm(text)) {
            window.location.href = url;
        }
    });
    
    // File upload preview
    $('input[type="file"]').on('change', function() {
        var input = $(this);
        var preview = input.siblings('.file-preview');
        
        if (preview.length && this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                preview.html('<img src="' + e.target.result + '" class="img-thumbnail" style="max-width: 200px;">');
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
    
    // Form reset handler
    $('button[type="reset"]').on('click', function() {
        var form = $(this).closest('form');
        var submitBtn = form.find('button[type="submit"]');
        
        // Restore button state
        submitBtn.prop('disabled', false);
        submitBtn.html(submitBtn.data('original-text') || 'ارسال');
        
        // Clear validation
        form.removeClass('was-validated');
        form.find('.is-invalid').removeClass('is-invalid');
        form.find('.invalid-feedback').remove();
    });
    
});

// Global form utilities
window.FormUtils = {
    // Reset form to initial state
    resetForm: function(formSelector) {
        var form = $(formSelector);
        form[0].reset();
        form.removeClass('was-validated');
        form.find('.is-invalid').removeClass('is-invalid');
        form.find('.invalid-feedback').remove();
        
        var submitBtn = form.find('button[type="submit"]');
        submitBtn.prop('disabled', false);
        submitBtn.html(submitBtn.data('original-text') || 'ارسال');
    },
    
    // Validate form manually
    validateForm: function(formSelector) {
        var form = $(formSelector);
        return form[0].checkValidity();
    },
    
    // Get form data as object
    getFormData: function(formSelector) {
        var form = $(formSelector);
        var formData = {};
        
        form.find('input, select, textarea').each(function() {
            var field = $(this);
            var name = field.attr('name');
            var value = field.val();
            
            if (name) {
                if (field.attr('type') === 'checkbox') {
                    formData[name] = field.is(':checked');
                } else if (field.attr('type') === 'radio') {
                    if (field.is(':checked')) {
                        formData[name] = value;
                    }
                } else {
                    formData[name] = value;
                }
            }
        });
        
        return formData;
    }
};
