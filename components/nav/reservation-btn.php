<style>

#reservation-btn {
	padding: 8px 12px;
	background: #000;
	color: white;
	text-align: center;
	border-radius: 20px;
	border: none;
}


.reservation-btn {
	border-radius: 20px;
	position: relative;
	z-index: 0;
}


@property --angle{
	syntax: "<angle>";
	initial-value: 0deg;
	inherits: false;
}

.reservation-btn::after, .reservation-btn::before{
	content: '';
	position: absolute;
	height: 100%;
	width: 100%;
	top: 50%;
	left: 50%;
	translate: -50% -50%;
	z-index: -1;
	padding: 2px;
	background-image: conic-gradient(from var(--angle), #0000, #ff0101, #0000, #ff0101, #0000) !important;
	border-radius: 20px;
	animation: 3s spin linear infinite;
}

.reservation-btn::before{
	filter: blur(10px);
	opacity: 0.5;
}

.reservation-btn:hover::before{
	filter: blur(20px);
	opacity: 1;
}

@keyframes spin{
	from{
		--angle: 0deg;
	}
	to{
		--angle: 360deg;
	}
}





</style>























	<div style="position: absolute; bottom: 30px; left: 30px; display: flex; flex-direction: column; gap: 6px">

		<div class="reservation-btn">
			<button class="popup-trigger" id="reservation-btn" data-translate="reservation-trigger-btn">
				<label for="popup-toggle3">Reserve Now</label>
			</button>
		</div>

	</div>






































<input type="checkbox" id="popup-toggle3" />
<label for="popup-toggle3" class="sidebar-overlay"></label>

<div class="sidebar">

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
			</div>

</div>


<style>
/* Hide the checkbox */
#popup-toggle3 {
  display: none;
}

/* Sidebar */
.sidebar {
  position: fixed;
  top: 0;
  left: -350px;
  width: 350px;
  height: 100%;
  background: #222;
  color: white;
  padding: 20px;
  box-shadow: 2px 0 10px rgba(0,0,0,0.3);
  transition: left 0.3s ease;
  z-index: 1001;
}

/* Overlay (label that acts as backdrop) */
.sidebar-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(0, 0, 0, 0.4);
  display: none;
  z-index: 1000;
  cursor: pointer;
}

/* Open button */
.sidebar-open-btn {
  cursor: pointer;
  padding: 10px 20px;
  background: #333;
  color: white;
  font-size: 18px;
  display: inline-block;
  position: relative;
  z-index: 999;
}

/* Show sidebar and overlay when checkbox is checked */
#popup-toggle3:checked ~ .sidebar {
  left: 0;
}

#popup-toggle3:checked ~ .sidebar-overlay {
  display: block;
}


</style>