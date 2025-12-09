jQuery(document).ready(function($) {
    const $container = $('#custom-auth-container');
    const ajax_url = CustomAuth.ajax_url;

    /**
     * Show loading overlay with custom message
     */
    function showLoadingOverlay(message) {
        message = message || 'Loading...';
        
        // Remove existing overlay if any
        $('.auth-loading-overlay').remove();
        
        // Create and append new overlay
        const $overlay = $('<div class="auth-loading-overlay">' +
            '<div class="auth-loading-spinner"></div>' +
            '<div class="auth-loading-text">' + message + '</div>' +
            '</div>');
        
        $('body').append($overlay);
        
        // Trigger animation
        setTimeout(function() {
            $overlay.addClass('active');
        }, 10);
    }

    /**
     * Hide loading overlay
     */
    function hideLoadingOverlay() {
        const $overlay = $('.auth-loading-overlay');
        $overlay.removeClass('active');
        
        setTimeout(function() {
            $overlay.remove();
        }, 300);
    }

    /**
     * Attaches handlers to the dynamically loaded content.
     */
    function attachHandlers() {
        // --- AUTH Handlers (Existing) ---
        $('#custom-auth-form').off('submit').on('submit', handleFormSubmission);
        $('#custom-logout-button').off('click').on('click', handleLogout); 

        // --- RESERVATION Handlers (NEW) ---
        // 1. Time Slot Selection
        $container.off('click', '.time-slot-btn').on('click', '.time-slot-btn', handleTimeSlotSelection);

        // 2. Reservation Form Submission (New or Edit)
        $container.off('submit', '#reservation-form').on('submit', handleReservationFormSubmission);

        // 3. Edit Button
        $container.off('click', '.edit-reservation-btn').on('click', '.edit-reservation-btn', handleEditReservation);

        // 4. Cancel Button
        $container.off('click', '.cancel-reservation-btn').on('click', '.cancel-reservation-btn', handleCancelReservation);
    }

    /**
     * Function to fetch and render the initial content. (EXISTING)
     */
    function fetchContent() {
        $.ajax({
            url: ajax_url,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'custom_get_content' 
            },
            beforeSend: function() {
                $container.html('<p style="text-align:center;">Loading content...</p>');
            },
            success: function(response) {
                if (response.success && response.data.content) {
                    $container.html(response.data.content);
                    attachHandlers();
                } else {
                    $container.html('<p style="color:red;">Error fetching content from backend.</p>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Fetch error:', status, error);
                $container.html('<p style="color:red;">Network error while fetching content.</p>');
            }
        });
    }

    /**
     * Handles the unified form submission (Login or Register).
     */
    function handleFormSubmission(e) {
        e.preventDefault();
        
        const $form = $(this);
        const $submitBtn = $form.find('button[type="submit"]');
        const $messageDiv = $('#auth-status-message');
        const originalBtnText = $submitBtn.text();
        
        // Get form data including nonce
        const formData = $form.serialize() + '&action=custom_auth_process';
        
        $.ajax({
            url: ajax_url,
            type: 'POST',
            dataType: 'json',
            data: formData,
            beforeSend: function() {
                $submitBtn.prop('disabled', true).text('Processing...');
                $messageDiv.text('').hide();
            },
            success: function(response) {
                // Always re-enable button
                $submitBtn.prop('disabled', false).text(originalBtnText);

                if (response.success) {
                    // Success - show message
                    $messageDiv.css('color', 'green').text(response.data.message).fadeIn();
                    
                    // Show loading overlay
                    showLoadingOverlay('Logging you in...');
                    
                    // Force a full page reload after short delay
                    setTimeout(function() {
                        window.location.reload();
                    }, 800);
                } else {
                    // Failure - show error message
                    $messageDiv.css('color', 'red').text(response.data.message).fadeIn();
                    
                    // Update form with fresh nonce if provided
                    if (response.data.content) {
                        $container.html(response.data.content);
                        attachHandlers();
                        
                        // Re-display the error message
                        $('#auth-status-message').css('color', 'red').text(response.data.message).show();
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('Form submission error:', status, error, xhr.responseText);
                $submitBtn.prop('disabled', false).text(originalBtnText);
                
                // If we get a 400 error (bad request), it might be a nonce issue - refresh page
                if (xhr.status === 400 || xhr.status === 403) {
                    $messageDiv.css('color', 'red').text('Session expired. Refreshing page...').fadeIn();
                    showLoadingOverlay('Refreshing page...');
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                } else {
                    $messageDiv.css('color', 'red').text('Network error occurred. Please try again.').fadeIn();
                }
            }
        });
    }
    
    /**
     * Handles the AJAX Logout process.
     */
    function handleLogout(e) {
        e.preventDefault();
        
        const $button = $(this);
        const $messageDiv = $('#auth-status-message');
        const logout_nonce = $('#custom_logout_nonce').val();
        
        // Validate nonce exists
        if (!logout_nonce) {
            $messageDiv.css('color', 'red').text('Security token missing. Please refresh the page.').fadeIn();
            return;
        }
        
        $.ajax({
            url: ajax_url,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'custom_logout_process',
                custom_logout_nonce: logout_nonce
            },
            beforeSend: function() {
                $button.prop('disabled', true).text('Logging out...');
                $messageDiv.text('').hide();
            },
            success: function(response) {
                if (response.success) {
                    // Show success message briefly
                    $messageDiv.css('color', 'green').text(response.data.message).fadeIn();
                    
                    // Show loading overlay
                    showLoadingOverlay('Logging you out...');
                    
                    // Force a full page reload after short delay
                    setTimeout(function() {
                        window.location.reload();
                    }, 800);
                } else {
                    // Error handling
                    $button.prop('disabled', false).text('Logout');
                    const errorMsg = response.data && response.data.message ? response.data.message : 'Logout failed.';
                    $messageDiv.css('color', 'red').text(errorMsg).fadeIn();
                    
                    // Update content if provided (fresh nonce)
                    if (response.data && response.data.content) {
                        $container.html(response.data.content);
                        attachHandlers();
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('Logout error:', status, error, xhr.responseText);
                $button.prop('disabled', false).text('Logout');
                $messageDiv.css('color', 'red').text('Network error during logout. Please try again.').fadeIn();
            }
        });
    }


    // -----------------------------------------------------------------
    // --- NEW RESERVATION FUNCTIONS ---
    // -----------------------------------------------------------------

    /**
     * Handles the click on a time slot button.
     */
    function handleTimeSlotSelection() {
        const $button = $(this);
        const time = $button.data('time');
        const $form = $button.closest('#reservation-form');

        // Clear previous selection
        $form.find('.time-slot-btn').removeClass('selected');

        // Set current selection
        $button.addClass('selected');
        $form.find('#res_time').val(time);
    }

    /**
     * Handles the unified reservation form submission (New or Edit).
     */
    function handleReservationFormSubmission(e) {
        e.preventDefault();

        const $form = $(this);
        const $submitBtn = $form.find('#reserve-submit-btn');
        const $messageDiv = $form.find('#reservation-form-message');
        const originalBtnText = $submitBtn.text();
        
        // Check if a time slot is selected
        if ($form.find('#res_time').val() === '') {
             $messageDiv.css('color', 'red').text('Please select a time slot.').fadeIn();
             return;
        }

        // Get the action from the form's hidden input
        const formAction = $form.find('input[name="action"]').val();
        
        // Build the data object explicitly
        const formData = {
            action: formAction,
            res_date: $form.find('#res_date').val(),
            res_time: $form.find('#res_time').val(),
            member_count: $form.find('#member_count').val(),
            tour_reservation_nonce: $form.find('#tour_reservation_nonce').val()
        };
        
        // Add reservation_id if editing - check both data attribute AND hidden input
        const reservationIdFromData = $form.data('reservation-id');
        const reservationIdFromInput = $form.find('input[name="reservation_id"]').val();
        const reservationId = reservationIdFromInput || reservationIdFromData;
        
        const isEdit = reservationId && reservationId !== '' && reservationId !== '0';
        
        if (isEdit) {
            formData.reservation_id = reservationId;
        }

        console.log('Submitting reservation with data:', formData); // Debug log

        $.ajax({
            url: ajax_url,
            type: 'POST',
            dataType: 'json',
            data: formData,
            beforeSend: function() {
                $submitBtn.prop('disabled', true).text('Saving...');
                $messageDiv.text('').hide();
            },
            success: function(response) {
                $submitBtn.prop('disabled', false).text(originalBtnText);

                if (response.success) {
                    $messageDiv.css('color', 'green').text(response.data.message).fadeIn();
                    
                    // Update the reservation list
                    if (response.data.list_content) {
                        $('#user-reservations-list').replaceWith(response.data.list_content);
                    }
                    
                    // Update the form with fresh nonce
                    if (response.data.form_content) {
                        $('#reservation-form').replaceWith(response.data.form_content);
                        attachHandlers();
                    }
                    
                } else {
                    $messageDiv.css('color', 'red').text(response.data.message).fadeIn();
                }
            },
            error: function(xhr, status, error) {
                console.error('Reservation error:', status, error, xhr.responseText);
                $submitBtn.prop('disabled', false).text(originalBtnText);
                
                // If we get a 400/403 error, it might be a nonce issue - fetch fresh content
                if (xhr.status === 400 || xhr.status === 403) {
                    $messageDiv.css('color', 'red').text('Session expired. Refreshing form...').fadeIn();
                    setTimeout(function() {
                        fetchContent();
                    }, 1000);
                } else {
                    $messageDiv.css('color', 'red').text('Network error occurred.').fadeIn();
                }
            }
        });
    }

    /**
     * Handles the Edit Reservation button click. Fetches the edit form.
     */
    function handleEditReservation() {
        const reservation_id = $(this).data('id');
        const $messageDiv = $('#reservation-form-message');
        $messageDiv.text('').hide();

        $.ajax({
            url: ajax_url,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'tour_get_edit_form',
                reservation_id: reservation_id
            },
            beforeSend: function() {
                // Optionally disable all buttons
                $('.edit-reservation-btn, .cancel-reservation-btn').prop('disabled', true);
            },
            success: function(response) {
                $('.edit-reservation-btn, .cancel-reservation-btn').prop('disabled', false);
                if (response.success && response.data.form_content) {
                    // Replace the new reservation form with the edit form
                    $('#reservation-form').replaceWith(response.data.form_content);
                    
                    // The 'attachHandlers' will re-bind the submit event to the new form
                    attachHandlers(); 
                    
                    $messageDiv.css('color', 'blue').text(`Editing Reservation #${reservation_id}`).fadeIn();

                } else {
                    $messageDiv.css('color', 'red').text('Failed to load edit form.').fadeIn();
                }
            },
            error: function() {
                 $('.edit-reservation-btn, .cancel-reservation-btn').prop('disabled', false);
                 $messageDiv.css('color', 'red').text('Network error loading edit form.').fadeIn();
            }
        });
    }

    /**
     * Handles the Cancel Reservation button click.
     */
    function handleCancelReservation() {
        if (!confirm('Are you sure you want to cancel this reservation?')) {
            return;
        }

        const reservation_id = $(this).data('id');
        const $item = $(this).closest('.reservation-item');
        const $messageDiv = $('#reservation-form-message');
        const res_nonce = $('#tour_reservation_nonce').val(); // Get reservation nonce from the form

        $.ajax({
            url: ajax_url,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'tour_cancel_reservation',
                reservation_id: reservation_id,
                tour_reservation_nonce: res_nonce
            },
            beforeSend: function() {
                $item.css('opacity', 0.5);
            },
            success: function(response) {
                $item.css('opacity', 1);
                if (response.success) {
                    $messageDiv.css('color', 'green').text(response.data.message).fadeIn();
                    // Update the reservation list
                    if (response.data.list_content) {
                        $('#user-reservations-list').replaceWith(response.data.list_content);
                    }
                } else {
                    $messageDiv.css('color', 'red').text(response.data.message).fadeIn();
                }
            },
            error: function() {
                $item.css('opacity', 1);
                $messageDiv.css('color', 'red').text('Network error during cancellation.').fadeIn();
            }
        });
    }

    // Initialize: Load the content and form when the document is ready
    fetchContent();
});