<?php get_header(); ?>



<style>

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
		<label for="food-sidebar-toggle" id="" class="nav-button fill">
			<?php include_once get_template_directory() . '/assets/svgs/food.svg'; ?>
		</label>
		<button id="" onclick="shareContent()" class="nav-button fill">
			<?php include_once get_template_directory() . '/assets/svgs/share.svg'; ?>
		</button>
		<label for="popup-toggle2" class="nav-button stroke">
			<?php include_once get_template_directory() . '/assets/svgs/user.svg'; ?>
		</label>
		<label for="info-sidebar-toggle"  class="nav-button fill">
			<?php include_once get_template_directory() . '/assets/svgs/more.svg'; ?>
		</label>
		<button id="" class="nav-button fill" onclick="toggleFullscreen()">
			<?php include_once get_template_directory() . '/assets/svgs/fullscreen.svg'; ?>
		</button>
	</div>






<input type="checkbox" id="info-sidebar-toggle" />
<label for="info-sidebar-toggle" class="info-sidebar-overlay"></label>

<div class="info-sidebar">
<?php echo do_shortcode('[tour_restaurant_info]'); ?>
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






<input type="checkbox" id="food-sidebar-toggle" />
<label for="food-sidebar-toggle" class="food-sidebar-overlay"></label>

<div class="food-sidebar">
<?php echo do_shortcode('[tour_food_grid]'); ?>
</div>

 

<?php include_once get_template_directory() .  "/components/account-popup.php" ; ?>




<?php include_once get_template_directory() .  "/components/nav/reservation-btn.php" ; ?>





</div>
<!-- Disable right-click -->
<script>
//document.addEventListener('contextmenu', e => e.preventDefault());
</script>

<?php get_footer(); ?>