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



	<div style="position: absolute; bottom: 20px; right: 20px; ">
		<button id="changeFloor">Floor Change</button>
	</div>
</div>


<?php //include_once get_template_directory() . '/rest.php';?>

<?php get_footer(); ?>