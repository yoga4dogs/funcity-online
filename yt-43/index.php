<?php
?>
<html style='
	background-image: url("../play/images/marbledark.jpg");
	background-size: cover;
	position: relative;
	height: 100%;
	font-family: MingLiU-ExtB, Microsoft Yi Baiti;'>
	<title>Youtube 4:3 Screen Filler</title>
	<center>
		<div style='
			background-image: url("../play/images/tile2.jpg");
			background-size: cover;
			box-shadow: 20px 20px 20px rgb(0 0 0);
			position: absolute;
			width: 400px;
			height: 400px;
			top: 45%;
			left: 50%;
			-ms-transform: translate(-50%, -50%);
			transform: translate(-50%, -50%);'>
			<div style='
				width: 500px;
				position: absolute;
				top: 50%;
				left: 50%;
				-ms-transform: translate(-50%, -50%);
				transform: translate(-50%, -50%);'>
				<h3>Youtube 4:3 Screen Filler</h3>
					<form action='viewer.php' method='GET' style='margin-bottom: 10px;'>
					<label>Video ID:</label>     <input type='text' name='video_link' autofocus/>
					<input type='submit' value='>>'/>
				</form>
				<i>youtube.com/watch?v=[Video ID]</i></br></br>
				Fullscreen: F11</br>
				Next Video: Ctrl + N</br>
				Slow Down: &lt;</br>
				Speed Up: &gt;</br></br>
				<a href='./viewer-pl.php' style='background-color: yellow;'>Playlist</a></br>
			</div>
		</div>