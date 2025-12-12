<div style="position: absolute; bottom: 30px; left: 30px; display: flex; flex-direction: column; gap: 6px">
	<label for="popup-toggle3" class="reservation-btn">
			<div class="popup-trigger" id="reservation-btn" >Reserve Now</div>
	</label>
</div>


<input type="checkbox" id="popup-toggle3" />
<label for="popup-toggle3" class="sidebar-overlay"></label>

<div class="sidebar">

		<div id="auth-section2">
			<label class="openLoginPage" for="popup-toggle2" onclick="openLoginPage()">login first</label>
		</div>


            <div id="user-section2" style="display:none;">
                <h3>New Reservation</h3>
                <form id="reservation-form">
                    <input type="date" name="res_date" required min="<?php echo date('Y-m-d'); ?>">
                    <input type="number" name="member_count" placeholder="Guests" min="1" required>
                    <div class="time-slots" id="time-slots"></div>
                    <input type="hidden" name="res_time" id="res_time" required>
                    <input type="hidden" name="reservation_id" id="reservation_id">
                    <?php wp_nonce_field('tour_reservation_nonce_action', 'tour_reservation_nonce'); ?>
                    <button type="submit">Book Reservation</button>
                </form>
				<label class="openLoginPage" for="popup-toggle2" onclick="openLoginPage()">reservations</label>
			</div>

</div>
