// Custom JavaScript for School Management System

$(document).ready(function() {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Initialize popovers
    $('[data-toggle="popover"]').popover();
    
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
    
    // Form validation
    $('form').on('submit', function(e) {
        var form = $(this);
        var submitBtn = form.find('button[type="submit"]');
        
        // Check if form is valid
        if (form[0].checkValidity() === false) {
            e.preventDefault();
            e.stopPropagation();
            form.addClass('was-validated');
            return false;
        }
        
        // Add loading state to submit button
        if (submitBtn.length) {
            submitBtn.prop('disabled', true);
            submitBtn.html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>در حال پردازش...');
        }
        
        form.addClass('was-validated');
    });
    
    // Sidebar toggle
    $('[data-widget="pushmenu"]').on('click', function() {
        $('body').toggleClass('sidebar-collapse');
    });
    
    // Fullscreen toggle
    $('[data-widget="fullscreen"]').on('click', function() {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen();
        } else {
            document.exitFullscreen();
        }
    });
    
    // Data table enhancements
    if ($.fn.DataTable) {
        $('.data-table').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Persian.json"
            },
            "responsive": true,
            "pageLength": 25,
            "order": [[0, "desc"]]
        });
    }
    
    // Confirm delete actions
    $('.btn-delete').on('click', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        if (confirm('آیا مطمئن هستید که می‌خواهید این مورد را حذف کنید؟')) {
            window.location.href = url;
        }
    });
    
    // Auto-refresh notifications
    setInterval(function() {
        // You can implement AJAX call here to refresh notifications
        console.log('Checking for new notifications...');
    }, 30000); // Check every 30 seconds
    
    // Smooth scrolling for anchor links
    $('a[href^="#"]').on('click', function(event) {
        var target = $(this.getAttribute('href'));
        if (target.length) {
            event.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 100
            }, 1000);
        }
    });
    
    // Initialize animations on scroll
    $(window).on('scroll', function() {
        $('.animate-on-scroll').each(function() {
            var elementTop = $(this).offset().top;
            var elementBottom = elementTop + $(this).outerHeight();
            var viewportTop = $(window).scrollTop();
            var viewportBottom = viewportTop + $(window).height();
            
            if (elementBottom > viewportTop && elementTop < viewportBottom) {
                $(this).addClass('animate__animated animate__fadeInUp');
            }
        });
    });
    
    // Initialize all animations on page load
    $('.animate-on-scroll').addClass('animate__animated animate__fadeInUp');
    
    // Accordion functionality for sidebar
    $('.accordion-button').on('click', function() {
        var target = $(this).data('bs-target');
        var accordion = $(this).closest('.accordion');
        
        // Close all other accordion items
        accordion.find('.accordion-collapse').not(target).removeClass('show');
        accordion.find('.accordion-button').not(this).addClass('collapsed');
        
        // Add smooth animation
        $(target).on('shown.bs.collapse', function() {
            $(this).find('.nav-link').each(function(index) {
                $(this).css({
                    'animation-delay': (index * 0.1) + 's',
                    'animation': 'fadeInUp 0.5s ease forwards'
                });
            });
        });
    });
    
    // Enhanced accordion with localStorage
    $('.accordion-button').on('click', function() {
        var target = $(this).data('bs-target');
        var accordionId = $(this).closest('.accordion').attr('id');
        
        // Save current state
        localStorage.setItem('accordion_' + accordionId, target);
    });
    
    // Restore accordion state on page load
    $('.accordion').each(function() {
        var accordionId = $(this).attr('id');
        var savedTarget = localStorage.getItem('accordion_' + accordionId);
        
        if (savedTarget) {
            $(savedTarget).addClass('show');
            $('[data-bs-target="' + savedTarget + '"]').removeClass('collapsed');
        }
    });
});

// Global functions
window.showAlert = function(message, type = 'info') {
    var alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            <i class="fas fa-info-circle me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    
    $('.content-wrapper').prepend(alertHtml);
    
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
};

window.confirmAction = function(message, callback) {
    if (confirm(message)) {
        callback();
    }
};

window.loading = function(show = true) {
    if (show) {
        $('body').append('<div id="loading-overlay" class="loading-overlay"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>');
    } else {
        $('#loading-overlay').remove();
    }
};

// Add loading overlay styles
$('<style>')
    .prop('type', 'text/css')
    .html(`
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        
        .loading-overlay .spinner-border {
            width: 3rem;
            height: 3rem;
        }
    `)
    .appendTo('head');