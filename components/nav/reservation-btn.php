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
<label for="popup-toggle3" class="popup-btn"></label>

<label for="popup-toggle3"  class="popup-overlay">
  <label for="popup-toggle3" class="popup-close"></label>
  <div class="popup-content">
    <?php 
		echo do_shortcode('[rs_make_reservation]');
	?>
    <label for="popup-toggle3" class="popup-close-btn"></label>
  </div>
</label>


<style>
#popup-toggle3 {
  display: none;
}


.popup-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.6);
  opacity: 0;
	visibility: hidden;
  align-items: center;
  justify-content: center;
transition: 0.2s
}

.popup-content {
    background: #0000006b;
    padding: 20px;
    max-width: 400px;
    width: 100%;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    position: absolute;
    bottom: -500px;
    color: white;
    height: 70%;
    border-radius: 50px 50px 0 0;
    border: 1px solid #ccc;
    border-bottom: 0;
    transition: 0.2s;
    margin: auto;
    left: 50%;
    transform: translateX(-50%);
}

#popup-toggle3:checked + .popup-btn + .popup-overlay {
  opacity: 1;
	visibility: visible
}

#popup-toggle3:checked + .popup-btn + .popup-overlay .popup-content {
    bottom: 0px;
}

</style>