<?php
echo "
<title>Youtube 4:3 Screen Filler</title>
<body style='overflow: hidden; background-color: black;'>
<iframe
        width=200%
        height=100%
        src='https://www.youtube.com/embed/{$_GET['video_link']}?rel=0&amp;&mute=1'
        title='YouTube video player'
        frameborder='0'
        allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share'
        allowfullscreen 
		style='margin-left: -50%;'
>
</iframe>";