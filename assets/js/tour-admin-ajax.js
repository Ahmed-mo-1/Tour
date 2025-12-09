jQuery(document).ready(function($){
    // Load reservations
    function loadReservations(){
        $.post(tour_admin_ajax.ajax_url, {action:'tour_admin_get_reservations', nonce:tour_admin_ajax.nonce}, function(res){
            if(res.success){
                let html = '';
                res.data.forEach(r=>{
                    html += `
                        <div class="admin-reservation" data-id="${r.id}">
                            <p>User: ${r.user_email}</p>
                            <p>Date: <input type="date" class="res-date" value="${r.reservation_date}"></p>
                            <p>Time: <input type="time" class="res-time" value="${r.reservation_time}"></p>
                            <p>Members: <input type="number" class="res-members" value="${r.member_count}" min="1"></p>
                            <p>Status: 
                                <select class="res-status">
                                    <option value="pending" ${r.status=='pending'?'selected':''}>Pending</option>
                                    <option value="confirmed" ${r.status=='confirmed'?'selected':''}>Confirmed</option>
                                    <option value="cancelled" ${r.status=='cancelled'?'selected':''}>Cancelled</option>
                                    <option value="completed" ${r.status=='completed'?'selected':''}>Completed</option>
                                </select>
                            </p>
                            <button class="update-reservation">Update</button>
                        </div><hr>`;
                });
                $('#tour-admin-reservations').html(html);
            } else {
                $('#tour-admin-reservations').html('<p>'+res.data.message+'</p>');
            }
        });
    }

    loadReservations();

    // Update reservation
    $(document).on('click', '.update-reservation', function(){
        let $res = $(this).closest('.admin-reservation');
        let data = {
            action:'tour_admin_update_reservation',
            nonce: tour_admin_ajax.nonce,
            res_id: $res.data('id'),
            reservation_date: $res.find('.res-date').val(),
            reservation_time: $res.find('.res-time').val(),
            member_count: $res.find('.res-members').val(),
            status: $res.find('.res-status').val()
        };
        $.post(tour_admin_ajax.ajax_url, data, function(response){
            alert(response.success ? response.data.message : response.data.message);
            loadReservations(); // refresh after update
        });
    });

    // Auto refresh every 10 seconds for new reservations
    setInterval(loadReservations, 10000);
});
