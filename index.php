<?php get_header(); ?>



<style>
#custom-auth-container { max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; }
input { width: 100%; padding: 10px; margin: 10px 0; }
/*button { padding: 10px 15px; margin: 5px; cursor: pointer; }*/
.time-slots {
    display: grid;
    flex-wrap: wrap;
    gap: 5px;
    height: 340px;
    overflow: auto;
    grid-template-columns: repeat(4, 1fr);
}
.time-slot-btn { background: #f0f0f0; border: 1px solid #ccc; }
.time-slot-btn.selected { background: #4CAF50; color: white; }
#reservations-list li { padding: 10px; border: 1px solid #eee; margin: 5px 0; }
#message { margin: 10px 0; padding: 10px; }
.success { color: green; }
.error { color: red; }
</style>








<?php

	$wpdb->prefix = 'wp_';
	$restaurant = $wpdb->get_row(
		$wpdb->prepare("SELECT * FROM {$wpdb->prefix}tour_restaurant_info"));
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



<div id="video-label-container" class="tag-popup hidden">
    <button id="close-tag" class="tag-popup-close">×</button>

    <div class="tag-popup-content">
        <h2 class="tag-title"></h2>
        <p class="tag-description"></p>
        <div class="tag-media"></div>
    </div>
</div>





	<iframe src='<?php echo  $iframe_url;  ?>'	allowfullscreen frameborder="0" allow="xr-spatial-tracking" id="showcase-iframe"></iframe>



	<div style="position: absolute; bottom: 30px; right: 30px; display: flex; flex-direction: column; gap: 6px">
		<button id="changeFloor" class="nav-button fill">
			<?php include_once get_template_directory() . '/assets/svgs/floors.svg'; ?>
		</button>
		<label for="popup-toggle" id="" class="nav-button fill">
			<?php include_once get_template_directory() . '/assets/svgs/food.svg'; ?>
		</label>
		<button id="" onclick="shareContent()" class="nav-button fill">
			<?php include_once get_template_directory() . '/assets/svgs/share.svg'; ?>
		</button>
		<label for="popup-toggle2" class="nav-button stroke">
			<?php include_once get_template_directory() . '/assets/svgs/user.svg'; ?>
		</label>
		<button id="" class="nav-button fill">
			<?php include_once get_template_directory() . '/assets/svgs/more.svg'; ?>
		</button>
		<button id="" class="nav-button fill" onclick="toggleFullscreen()">
			<?php include_once get_template_directory() . '/assets/svgs/fullscreen.svg'; ?>
		</button>
	</div>


<script>

function shareContent() {
	const shareData = {
	  title: document.title,
	  text: 'Check out this page!',
	  url: window.location.href
	};

	if (navigator.share) {
	  navigator.share(shareData)
		.then(() => console.log('Content shared successfully!'))
		.catch((error) => console.error('Error sharing:', error));
	} else {
	  alert('Share not supported on this browser.');
	}
}

</script>



<input type="checkbox" id="popup-toggle" />
<label for="popup-toggle" class="popup-btn"></label>

<label for="popup-toggle"  class="popup-overlay">
  <label for="popup-toggle" class="popup-close"></label>
  <div class="popup-content">
<?php echo do_shortcode('[tour_food_grid]'); ?>

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



<?php include_once get_template_directory() .  "/components/account-popup.php" ; ?>




<?php include_once get_template_directory() .  "/components/nav/reservation-btn.php" ; ?>





</div>

<?php get_footer(); ?>