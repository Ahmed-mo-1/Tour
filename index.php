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



	<div style="position: absolute; bottom: 20px; right: 20px; display: flex; flex-direction: column; gap: 6px">
		<button id="changeFloor" class="nav-button fill">
			<?php include_once get_template_directory() . '/assets/svgs/floors.svg'; ?>
		</button>
		<label for="popup-toggle" id="" class="nav-button fill">
			<?php include_once get_template_directory() . '/assets/svgs/food.svg'; ?>
		</label>
		<button id="" class="nav-button fill">
			<?php include_once get_template_directory() . '/assets/svgs/share.svg'; ?>
		</button>
		<button id="" class="nav-button stroke">
			<?php include_once get_template_directory() . '/assets/svgs/user.svg'; ?>
		</button>
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






	<div style="position: absolute; bottom: 20px; left: 20px; display: flex; flex-direction: column; gap: 6px">
		<button class="nav-button fill">
			reserve
		</button>

	</div>



</div>

<?php
/*
echo do_shortcode('[rs_user_register]');
echo do_shortcode('[rs_user_login]');
echo do_shortcode('[rs_make_reservation]');
*/
?>


<?php //include_once get_template_directory() . '/rest.php';?>

<?php get_footer(); ?>