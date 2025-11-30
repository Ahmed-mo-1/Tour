<?php

	include_once get_template_directory() . '/assets/js/sdk.php';
	include_once get_template_directory() . '/assets/js/floors.php';
	include_once get_template_directory() . '/assets/js/tags.php';

?>

<?php
	wp_footer();
?>

<script>

function toggleFullscreen() {

	if (!document.fullscreenElement) {

		container.requestFullscreen().catch(err => {
			alert(`Error attempting to enable fullscreen: ${err.message}`);
		});

	}

	else {
		document.exitFullscreen();
	}

}
</script>