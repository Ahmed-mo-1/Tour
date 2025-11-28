<html>
  <head>
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />

     <script type="importmap">
      {
        "imports": {
          "MP_SDK": "https://api.matterport.com/sdk/bootstrap/3.0.0-0-g0517b8d76c/sdk.es6.js?applicationKey=crit9r5d4zduc09z4kihmcm7d"
        }
      }
    </script>

<style>
* {padding: 0; margin: 0; box-sizing: border-box}
#container{
width: 100%;
height: 100dvh;
position : relative
}

iframe {
width: 100%;
height: 100%;
zoom: 3
}

.nav-button {
	width: 40px;
	height: 40px; 
	aspect-ratio: 1;
	background-color: rgba(0, 0, 0, 0.2);
	backdrop-filter: blur(30px);
	-webkit-backdrop-filter: blur(30px);
	border: 1px solid #ccc;
	padding: 8px;
	border-radius: 50px;
	cursor: pointer;
	transition: 0.2s;
}

.nav-button:hover{
	scale: 1.1
}
.nav-button svg {
	width: 100%;
	height: auto;
	filter: brightness(0) invert(1)
}

</style>
  </head>
  <body>



<?php
	wp_head();



?>