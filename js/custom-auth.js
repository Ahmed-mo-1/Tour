jQuery(document).ready(function($) {
    const ajax = CustomAuth.ajax_url;
    
    // INIT
    initApp();

    function initApp() {
        if (CustomAuth.is_logged_in) {
            showUserSection();
            loadReservations();
            generateTimeSlots();
        }
        attachHandlers();
    }

    // FETCH FRESH CONTENT FROM BACKEND
    function refreshFromBackend(callback) {
        $.post(ajax, { action: 'get_fresh_content' }, function(res) {
            if (res.success) {
                // Update global state
                CustomAuth.is_logged_in = res.data.is_logged_in;
                CustomAuth.user_name = res.data.user_name;
                
                // Update all nonces
                $('#custom_auth_nonce').val(res.data.nonces.auth);
                $('#custom_logout_nonce').val(res.data.nonces.logout);
                $('#tour_reservation_nonce').val(res.data.nonces.reservation);
                
                if (callback) callback();
            }
        });
    }

    function attachHandlers() {
        // Remove old handlers first
        $('#custom-auth-form').off('submit');
        $('#custom-logout-button').off('click');
        $('#reservation-form').off('submit');
        $(document).off('click', '.time-slot-btn');
        $(document).off('click', '.edit-res');
        $(document).off('click', '.cancel-res');

        // AUTH SUBMIT
        $('#custom-auth-form').on('submit', function(e) {
            e.preventDefault();
            const $btn = $(this).find('button');
            $btn.prop('disabled', true).text('Processing...');
            
            $.post(ajax, $(this).serialize() + '&action=custom_auth_process', function(res) {
                if (res.success) {
                    showMessage(res.data.message, 'success');
                    // Wait 1 second then fetch fresh backend data
                    setTimeout(function() {
                        refreshFromBackend(function() {
                            showUserSection();
                            loadReservations();
                            generateTimeSlots();
                            attachHandlers();
                        });
                    }, 1000);
                } else {
                    showMessage(res.data.message, 'error');
                    $btn.prop('disabled', false).text('Submit');
                }
            });
        });

        // LOGOUT
        $('#custom-logout-button').on('click', function() {
            const $btn = $(this);
            $btn.prop('disabled', true).text('Logging out...');
            
            $.post(ajax, {
                action: 'custom_logout_process',
                custom_logout_nonce: $('#custom_logout_nonce').val()
            }, function(res) {
                if (res.success) {
                    showMessage(res.data.message, 'success');
                    // Wait 1 second then fetch fresh backend data
                    setTimeout(function() {
                        refreshFromBackend(function() {
                            showAuthSection();
                            attachHandlers();
                        });
                    }, 1000);
                } else {
                    $btn.prop('disabled', false).text('Logout');
                }
            });
        });

        // RESERVATION SUBMIT
        $('#reservation-form').on('submit', function(e) {
            e.preventDefault();
            const rid = $('#reservation_id').val();
            const action = rid ? 'tour_edit_reservation' : 'tour_new_reservation';
            
            $.post(ajax, $(this).serialize() + '&action=' + action, function(res) {
                showMessage(res.data.message, res.success ? 'success' : 'error');
                if (res.success) {
                    loadReservations();
                    $('#reservation-form')[0].reset();
                    $('#reservation_id').val('');
                    $('.time-slot-btn').removeClass('selected');
					$('#popup-toggle3').prop('checked', false);
					$('#popup-toggle2').prop('checked', true);
                }
            });
        });

        // TIME SLOT SELECT
        $(document).on('click', '.time-slot-btn', function() {
            $('.time-slot-btn').removeClass('selected');
            $(this).addClass('selected');
            $('#res_time').val($(this).data('time'));
        });

        // EDIT RESERVATION
        $(document).on('click', '.edit-res', function() {
            const res = $(this).data('res');
            $('[name="res_date"]').val(res.reservation_date);
            $('[name="member_count"]').val(res.member_count);
            $('#reservation_id').val(res.id);
					$('#popup-toggle2').prop('checked', false);
					$('#popup-toggle3').prop('checked', true);
            $('.time-slot-btn[data-time="' + res.reservation_time + '"]').click();
            $('html, body').animate({ scrollTop: $('#reservation-form').offset().top }, 500);
        });

        // CANCEL RESERVATION
        $(document).on('click', '.cancel-res', function() {
            if (!confirm('Cancel this reservation?')) return;
            $.post(ajax, {
                action: 'tour_cancel_reservation',
                reservation_id: $(this).data('id'),
                tour_reservation_nonce: $('#tour_reservation_nonce').val()
            }, function(res) {
                showMessage(res.data.message, 'success');
                loadReservations();
            });
        });
    }

    // FUNCTIONS
    function showUserSection() {
        $('#auth-section').hide();
        $('#auth-section2').hide();
        $('#user-section').show();
        $('#user-section2').show();
        $('#user-display-name').text(CustomAuth.user_name);
    }

    function showAuthSection() {
        $('#user-section').hide();
        $('#user-section2').hide();
        $('#auth-section').show();
        $('#auth-section2').show();
        $('#custom-auth-form')[0].reset();
        $('#reservations-list').empty();
    }

    function loadReservations() {
        $.post(ajax, { action: 'get_reservations' }, function(res) {
            const list = $('#reservations-list');
            list.empty();
            if (res.data.reservations.length) {
                res.data.reservations.forEach(r => {
                    const actions = r.status !== 'cancelled' ? 
                        `<button class="edit-res" data-res='${JSON.stringify(r)}'>Edit</button>
                         <button class="cancel-res" data-id="${r.id}">Cancel</button>` : '';
                    list.append(`<li>${r.reservation_date} at ${r.reservation_time} - ${r.member_count} guests (${r.status}) ${actions}</li>`);
                });
            } else {
                list.append('<li>No reservations</li>');
            }
        });
    }

    function generateTimeSlots() {
        const slots = $('#time-slots');
        for (let h = 10; h <= 22; h++) {
            for (let m = 0; m < 60; m += 15) {
                const time = `${h.toString().padStart(2,'0')}:${m.toString().padStart(2,'0')}:00`;
                const display = `${h}:${m.toString().padStart(2,'0')}`;
                slots.append(`<button type="button" class="time-slot-btn" data-time="${time}">${display}</button>`);
            }
        }
    }

    function showMessage(msg, type) {
        $('#message').html(msg).attr('class', type).show();
        setTimeout(() => $('#message').fadeOut(), 3000);
    }
});