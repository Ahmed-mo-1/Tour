<?php 
	get_header(); 
?>

<?php

	$id = 1;  
	$wpdb->prefix = 'wp_';
	$restaurant = $wpdb->get_row(
		$wpdb->prepare("SELECT * FROM {$wpdb->prefix}rs_restaurants WHERE restaurant_id = %d", $id)
	);
	/*
	echo $restaurant->name;
	echo $restaurant->tour_id;
	echo $restaurant->email;
	echo $restaurant->location;
	*/


	//$tour_url = 'https://my.matterport.com/show?m=';
	$tour_url = get_template_directory_uri() . '/bundle/showcase.html?m=';
	$tour = $restaurant->tour_id;
	$applicationKey = '&applicationKey=crit9r5d4zduc09z4kihmcm7d';
	$tour_settings = '&nt=0&play=1&qs=1&brand=0&dh=0&tour=0&gt=0&views=0&hr=0&mls=2&mt=1&tagNav=0&pin=0&portal=1&f=1&fp=0&wh=0&kb=1&lp=0&title=0&vr=0&brand=0&nozoom=1';
	$iframe_url = $tour_url  . $tour . $applicationKey . $tour_settings;

?>

<div id="container" style="position: relative">
	<iframe src='<?php echo  $iframe_url;  ?>'	allowfullscreen frameborder="0" allow="xr-spatial-tracking" id="showcase-iframe"></iframe>



	<div style="position: absolute; bottom: 30px; right: 30px; display: flex; flex-direction: column; gap: 6px">
		<button id="changeFloor" class="nav-button fill">
			<?php include_once get_template_directory() . '/assets/svgs/floors.svg'; ?>
		</button>
		<label for="popup-toggle" id="" class="nav-button fill">
			<?php include_once get_template_directory() . '/assets/svgs/food.svg'; ?>
		</label>
		<button id="" class="nav-button fill">
			<?php include_once get_template_directory() . '/assets/svgs/share.svg'; ?>
		</button>
		<label for="popup-toggle2" class="nav-button stroke">
			<?php include_once get_template_directory() . '/assets/svgs/user.svg'; ?>
		</label>
		<button id="" class="nav-button fill">
			<?php include_once get_template_directory() . '/assets/svgs/more.svg'; ?>
		</button>
		<button id="" class="nav-button fill">
			<?php include_once get_template_directory() . '/assets/svgs/fullscreen.svg'; ?>
		</button>
	</div>






<input type="checkbox" id="popup-toggle" />
<label for="popup-toggle" class="popup-btn"></label>

<label for="popup-toggle"  class="popup-overlay">
  <label for="popup-toggle" class="popup-close"></label>
  <div class="popup-content">
    <p></p>
    <label for="popup-toggle" class="popup-close-btn"></label>
  </div>
</label>


<style>
#popup-toggle {
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

#popup-toggle:checked + .popup-btn + .popup-overlay {
  opacity: 1;
	visibility: visible
}

#popup-toggle:checked + .popup-btn + .popup-overlay .popup-content {
    bottom: 0px;
}

</style>





<input type="checkbox" id="popup-toggle2" />
<label for="popup-toggle2" class="popup-btn"></label>

<label for="popup-toggle2"  class="popup-overlay">
  <label for="popup-toggle2" class="popup-close"></label>
  <div class="popup-content">
    <?php 
		echo do_shortcode('[rs_user_register]'); 
		echo do_shortcode('[rs_user_login]');
		?>
    <label for="popup-toggle2" class="popup-close-btn"></label>
  </div>
</label>


<style>
#popup-toggle2 {
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

#popup-toggle2:checked + .popup-btn + .popup-overlay {
  opacity: 1;
	visibility: visible
}

#popup-toggle2:checked + .popup-btn + .popup-overlay .popup-content {
    bottom: 0px;
}

</style>






	<div style="position: absolute; bottom: 30px; left: 30px; display: flex; flex-direction: column; gap: 6px">

	<div class="reservation-btn">
	<button class="popup-trigger" id="reservation-btn" data-translate="reservation-trigger-btn">
	<label for="popup-toggle3">Reserve Now</label>
	</button></div>

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







<?php
/*
echo do_shortcode('[rs_user_register]');
echo do_shortcode('[rs_user_login]');
echo do_shortcode('[rs_make_reservation]');
*/
?>


<?php //include_once get_template_directory() . '/rest.php';?>

<?php get_footer(); ?>














<style>

.open-now-btn {
margin: 0 auto;
padding: 1px;
background: #000;
text-align: center;
border-radius: 20px;
position: relative;
z-index: 10;
}

.open-now-btn button {
background: #000;
color:white;
}

.open-now-btn button:hover {
background: #000;
color:white;
letter-spacing : 1px;
}

@property --angle{
  syntax: "<angle>";
  initial-value: 0deg;
  inherits: false;
}

.open-now-btn::after, .open-now-btn::before{
  content: '';
  position: absolute;
  height: 100%;
  width: 100%;
  background-image: conic-gradient(from var(--angle), #0000, #00ff00, #0000, #00ff00, #0000) !important;
  top: 50%;
  left: 50%;
  translate: -50% -50%;
  z-index: -1;
  padding: 1px;
  border-radius: 20px;
  animation: 3s spin linear infinite;
}
.open-now-btn::before{
  filter: blur(1.5rem);
  opacity: 0.5;
}

.open-now-btn:hover::before{
  filter: blur(2rem);
  opacity: 0.7;
}

@keyframes spin{
  from{
    --angle: 0deg;
  }
  to{
    --angle: 360deg;
  }
}














.close-now-btn {
margin: 0 auto;
padding: 1px;
background: #000;
text-align: center;
border-radius: 20px;
position: relative;
z-index: 10;
}

.close-now-btn button {
background: #000;
color:white;
}

.close-now-btn button:hover {
background: #000;
color:white;
letter-spacing : 1px;
}

@property --angle{
  syntax: "<angle>";
  initial-value: 0deg;
  inherits: false;
}

.close-now-btn::after, .close-now-btn::before{
  content: '';
  position: absolute;
  height: 100%;
  width: 100%;
  background-image: conic-gradient(from var(--angle), #0000, #ff0000, #0000, #ff0000, #0000) !important;
  top: 50%;
  left: 50%;
  translate: -50% -50%;
  z-index: -1;
  padding: 1px;
  border-radius: 20px;
  animation: 3s spin linear infinite;
}
.close-now-btn::before{
  filter: blur(1.5rem);
  opacity: 0.5;
}

.close-now-btn:hover::before{
  filter: blur(2rem);
  opacity: 0.7;
}

@keyframes spin{
  from{
    --angle: 0deg;
  }
  to{
    --angle: 360deg;
  }
}








#reservation-btn {
margin: 0 auto;
padding: 8px 12px;
background: #000;
text-align: center;
border-radius: 20px;
position: relative;
z-index: 10;
border: none;
}


.reservation-btn {
margin: 0 auto;
padding: 1px;
background: #000;
text-align: center;
border-radius: 20px;
position: relative;
z-index: 10;
}

.reservation-btn button {
background: #000;
color:white;
}

.reservation-btn button:hover {
background: #000;
color:white;
letter-spacing : 1px;
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
  background-image: conic-gradient(from var(--angle), #0000, #ff0101, #0000, #ff0101, #0000) !important;
  top: 50%;
  left: 50%;
  translate: -50% -50%;
  z-index: -1;
  padding: 1px;
  border-radius: 20px;
  animation: 3s spin linear infinite;
}
.reservation-btn::before{
  filter: blur(1.5rem);
  opacity: 0.5;
}

.reservation-btn:hover::before{
  filter: blur(2rem);
  opacity: 0.7;
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
