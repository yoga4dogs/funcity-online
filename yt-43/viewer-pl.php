<?php
$max = 17;

echo "
<title>Youtube 4:3 Screen Filler</title>
<body style='overflow: hidden; background-color: black;'>
<iframe
	width=200%
	height=100%
	src='https://www.youtube.com/embed?listType=playlist&list=PLEkXLv94R7v9R4PgN3RrgB0LVkb58CLsq&mute=1&index=".rand(0,$max)."'
	title='YouTube video player'
	frameborder='0'
	allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share'
	allowfullscreen
	style='margin-left: -50%;'
>
</iframe>";
