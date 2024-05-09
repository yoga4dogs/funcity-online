<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=windows-1252"><title>[root@localhost ~]#</title>
    <link rel="shortcut icon" type="image/jpg" href="../images/smile.gif">

    <style>
        body {
            color: white;
            background-image: url('../play/images/marbledark.jpg');
            background-size: cover;
            font-family: MingLiU-ExtB, Microsoft Yi Baiti;
        }
        div.inline {
            float:left; 
        }

        div.main {
            background-color: rgb(0 0 0 / 0.5); 
            position: absolute; 
            width: 1280px;
            height: 768px;
            top: 50%;
            left: 50%;
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }
    </style>

</head>
<body>
	<div style="display: none;">
		<img id="tileset" src="ansi_charset.png" />
	</div>
	<div id="dom-target" style="display: none;">
		<?php
			$lines=file('text');
			foreach ($lines as $line) {
				echo htmlspecialchars($line);
			}
		?>
	</div>

    <div class="main">
	    <canvas id="display" onclick="mouseclick(event)" onmousemove="mousemove(event)" onmousedown="mousedown(event)" onmouseup="mouseup(event)" width="1280" height="768"></canvas>
    </div>

    <script>
        var canvas_div = document.getElementById('display');
        var canvas = canvas_div.getContext("2d");
		var data_div = document.getElementById("dom-target");
		var page_data = data_div.textContent.trim();
		console.log(page_data);

        var display = {
            col: 40,
            row: 24
        };
        var character = {
            width: canvas_div.width/display.col,
            height: canvas_div.height/display.row
        };
		
		var tileset = {
			source: document.getElementById('tileset'),
			source_width: 256,
			source_height: 256,
			x_tiles: 16,
			y_tiles: 16,
			char_width: 16,
			char_height: 16
		};
		
		var character_index = {
			space: [0,0],
			comma: [12,2],
			hyphen: [13,2],
			period: [14,2],
			exclamation: [1,2],
			question: [15,3],
			A: [1,4],
			B: [2,4],
			C: [3,4],
			D: [4,4],
			E: [5,4],
			F: [4,4],
			G: [5,4],
			H: [8,4],
			I: [9,4],
			J: [10,4],
			K: [11,4],
			L: [12,4],
			M: [13,4],
			O: [14,4],
			P: [0,5],
			Q: [1,5],
			R: [2,5],
			S: [3,5],
			T: [4,5],
			U: [5,5],
			V: [4,5],
			W: [5,5],
			X: [8,5],
			Y: [9,5],
			Z: [10,5],
			a: [1,6],
			b: [2,6],
			c: [3,6],
			d: [4,6],
			e: [5,6],
			f: [6,6],
			g: [7,6],
			h: [8,6],
			i: [9,6],
			j: [10,6],
			k: [11,6],
			l: [12,6],
			m: [13,6],
			o: [14,6],
			p: [0,7],
			q: [1,7],
			r: [2,7],
			s: [3,7],
			t: [4,7],
			u: [5,7],
			v: [6,7],
			w: [7,7],
			x: [8,7],
			y: [9,7],
			z: [10,7]
		};

        var mouse = {
            x: canvas_div.width/2,
            y: canvas_div.height/2,
            grid_x: 0,
            grid_y: 0, 
            button: 0
        };

        function mousedown(e) {
            mouse.button = 1;
        }
        function mouseup(e) {
            mouse.button = 0;
        }
        function mouseclick(e){
            return;
        }
        function mousemove(e){
            mouse.x = e.offsetX;	
            mouse.y = e.offsetY;	
            mouse.grid_x = Math.abs(Math.floor(mouse.x / character.width));
            mouse.grid_y = Math.abs(Math.floor(mouse.y / character.height));
        }
		
		function draw(x, y, c, s) {
			canvas.fillStyle = c;
			canvas.fillRect(x, y, s, s);
		};

		function draw_char(x, y, index) {
			canvas.drawImage(tileset.source, index[0]*tileset.char_width, index[1]*tileset.char_height, tileset.char_width, tileset.char_height, x*character.width, y*character.height, character.width, character.height);
		}

        function update() {
			
			if (mouse.button == 0) {
                for (let iY = 0; iY < display.row; iY++) {
                    for (let iX = 0; iX < display.col; iX++) {
                        var keys = Object.keys(character_index);
                        draw_char(iX, iY, character_index[keys[ keys.length * Math.random() << 0]]);
                        // draw_char(iX, iY, character_index.a);
                    }
                }
            }
			
            setTimeout(() => requestAnimationFrame(update), 50);
        }

		console.log(character);

        update();

    </script>


	