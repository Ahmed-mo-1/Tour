jQuery(document).ready(function($) {
    const $container = $('#custom-auth-container');
    const ajax_url = CustomAuth.ajax_url;

    /**
     * Attaches all dynamic handlers to the content.
     * Must be called whenever the content of $container is replaced/updated.
     */
    function attachHandlers() {
        // --- AUTH Handlers ---
        // Handles Login/Register Form Submission
        $('#custom-auth-form').off('submit').on('submit', handleFormSubmission);
        // Handles AJAX Logout
        $('#custom-logout-button').off('click').on('click', handleLogout); 

        // --- RESERVATION Handlers ---
        // 1. Handles the selection of a time slot button
        $container.off('click', '.time-slot-btn').on('click', '.time-slot-btn', handleTimeSlotSelection);

        // 2. Handles the Reservation Form submission (New or Edit)
        $container.off('submit', '#reservation-form').on('submit', handleReservationFormSubmission);

        // 3. Handles opening the Edit Form
        $container.off('click', '.edit-reservation-btn').on('click', '.edit-reservation-btn', handleEditReservation);

        // 4. Handles the Cancellation process
        $container.off('click', '.cancel-reservation-btn').on('click', '.cancel-reservation-btn', handleCancelReservation);
    }

    /**
     * Fetches and renders the initial content block (Login Form or User Dashboard).
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

    // -----------------------------------------------------------------
    // --- AUTHENTICATION FUNCTIONS ---
    // -----------------------------------------------------------------

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
                
                // Update content with new logged-in view
                if (response.data.content) {
                    setTimeout(function() {
                        $container.html(response.data.content);
                        attachHandlers();
                        
                        // Show the success message in the new content
                        $('#auth-status-message').css('color', 'green').text(response.data.message).show();
                    }, 500);
                }
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
            
            // If we get a 400 error (bad request), it might be a nonce issue - fetch fresh content
            if (xhr.status === 400 || xhr.status === 403) {
                $messageDiv.css('color', 'red').text('Session expired. Refreshing form...').fadeIn();
                setTimeout(function() {
                    fetchContent();
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
/**
 * Handles the AJAX Logout process. (EXISTING)
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
            if (response.success && response.data.content) {
                // Replace with logged-out view immediately
                $container.html(response.data.content);
                attachHandlers(); 
                
                // Show success message in new content
                $('#auth-status-message').css('color', 'green').text(response.data.message).show();
                
                // IMPORTANT: Fetch fresh content after a moment to ensure nonce is refreshed
                setTimeout(function() {
                    fetchContent();
                }, 1000);
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
    // --- RESERVATION FUNCTIONS ---
    // -----------------------------------------------------------------

    /**
     * Handles the click on a time slot button, updating the hidden input.
     */
    function handleTimeSlotSelection() {
        const $button = $(this);
        const time = $button.data('time');
        const $form = $button.closest('#reservation-form');

        // Clear previous selection and set current
        $form.find('.time-slot-btn').removeClass('selected');
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
     * Handles the Edit Reservation button click. Fetches the edit form via AJAX.
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
                // Temporarily disable buttons to prevent double-click
                $('.edit-reservation-btn, .cancel-reservation-btn').prop('disabled', true);
            },
            success: function(response) {
                $('.edit-reservation-btn, .cancel-reservation-btn').prop('disabled', false);
                if (response.success && response.data.form_content) {
                    // Replace the new reservation form with the edit form
                    $('#reservation-form').replaceWith(response.data.form_content);
                    
                    attachHandlers(); // Re-bind handlers to the new form
                    
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
        
        // Get reservation nonce from the hidden field of the reservation form
        const res_nonce = $('#reservation-form #tour_reservation_nonce').val(); 

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
                $item.addClass('is-cancelling');
            },
            success: function(response) {
                $item.removeClass('is-cancelling');
                if (response.success) {
                    $messageDiv.css('color', 'green').text(response.data.message).fadeIn();
                    
                    // Update the reservation list
                    if (response.data.list_content) {
                        $('#user-reservations-list').replaceWith(response.data.list_content);
                        attachHandlers();
                    }
                } else {
                    $messageDiv.css('color', 'red').text(response.data.message).fadeIn();
                }
            },
            error: function() {
                $item.removeClass('is-cancelling');
                $messageDiv.css('color', 'red').text('Network error during cancellation.').fadeIn();
            }
        });
    }

    // Initialize: Load the content and form when the document is ready
    fetchContent();
});