

    <style>
        body {
            background-image: url('../play/images/marbledark.jpg');
            background-size: cover;
            font-family: MingLiU-ExtB, Microsoft Yi Baiti;
        }
        div.inline {
            float:left; 
        }
        div.main {
            width: 640;
            height: 400;
			padding: 2px;
        }
    </style>


	<div id="tileset_div">
		<img id="tileset" src="/bbs/ansi_charset.png" onload="hide_tileset()"/>
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
	    <canvas id="display" onclick="mouseclick(event)" oncontextmenu="mouserightclick(event)" onmousemove="mousemove(event)" onmousedown="mousedown(event)" onmouseup="mouseup(event)" width="480" height="300"></canvas>
    </div>
	
    <script>
		var canvas_div = document.getElementById("display");
        var canvas = canvas_div.getContext("2d");
		var page_data_div = document.getElementById("dom-target");
		var page_data = page_data_div.textContent.trim();
		
		// assumes 2 byte char
		var baud = 9600;
		var delay_ms = Math.floor(1000/(baud/10)*2);
		
		var iX = 0;
		var iY = 0;

        var terminal = {
			col: 60,
            row: 25
        };
        var character_size = {
			width: canvas_div.width/terminal.col,
            height: canvas_div.height/terminal.row
        };
		
		var tileset = {
			source: document.getElementById("tileset"),
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
			colon: [10,3],
			open_parentheses: [8,2],
			close_parentheses: [9,2],
			quote: [2,2],
			A: [1,4],
			B: [2,4],
			C: [3,4],
			D: [4,4],
			E: [5,4],
			F: [6,4],
			G: [7,4],
			H: [8,4],
			I: [9,4],
			J: [10,4],
			K: [11,4],
			L: [12,4],
			M: [13,4],
			N: [14,4],
			O: [15,4],
			P: [0,5],
			Q: [1,5],
			R: [2,5],
			S: [3,5],
			T: [4,5],
			U: [5,5],
			V: [6,5],
			W: [7,5],
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
			n: [14,6],
			o: [15,6],
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
			z: [10,7],
			0: [0,3],
			1: [1,3],
			2: [2,3],
			3: [3,3],
			4: [4,3],
			5: [5,3],
			6: [6,3],
			7: [7,3],
			8: [8,3],
			9: [9,3]
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
			if (iY == terminal.row-1) {
            	iY += 1;
			}
        }
		function mouserightclick(e) {
			return;
		}
        function mousemove(e){
            mouse.x = e.offsetX;	
            mouse.y = e.offsetY;	
            mouse.grid_x = Math.abs(Math.floor(mouse.x / character_size.width));
            mouse.grid_y = Math.abs(Math.floor(mouse.y / character_size.height));
        }

		function draw_rect(x, y, c, s) {
			canvas.fillStyle = c;
			canvas.fillRect(x, y, s, s);
		};
		function draw_char(x, y, input_char) {
			// non alpha chars to index names
			switch(input_char) {
				case " ":
					input_char = "space";
					break;
				case ",":
					input_char = "comma";
					break;
				case "-":
					input_char = "hyphen";
					break;
				case ".":
					input_char = "period";
					break;
				case "!":
					input_char = "exclamation";
					break;
				case "?":
					input_char = "question";
					break;
				case ":":
					input_char = "colon";
					break;
				case "(":
					input_char = "open_parentheses";
					break;
				case ")":
					input_char = "close_parentheses";
					break;
				case '"':
					input_char = "quote";
					break;
				case "\n":
					return "newline";
				default:
					input_char = input_char;
			}
				index = character_index[input_char];
				canvas.drawImage(tileset.source, index[0]*tileset.char_width, index[1]*tileset.char_height, tileset.char_width, tileset.char_height, x*character_size.width, y*character_size.height, character_size.width, character_size.height);
		}
		
		// add delay to character rendering
		const delay = ms => new Promise(res => setTimeout(res, ms));
        const update = async () => {
			// background/clear screen
			draw_rect(0, 0, "#FF00FF", canvas_div.width, canvas_div.height);
			
			iX = 0;
			iY = 0;
			
			for (let i = 0; i < page_data.length; ++i) {
				if (iY == terminal.row-1) {
					more_msg = "--(Click for MORE)--                                                                          ";
					for (let iM = 0; iM < more_msg.length; ++iM) {
						draw_char(iX, iY, more_msg[iM]);
						iX += 1 % terminal.col;
					}
					i -=1;
					iY += 0
				} else if (iY >= terminal.row) {
					draw_rect(0, 0, "#FF00FF", canvas_div.width, canvas_div.height);
					iX = 0;
					iY = 0; 
					i -= 1;
				} else
				// draw_char(iX, iY, page_data[i]);
				if (draw_char(iX, iY, page_data[i]) == "newline") {
					iX = 0;
					iY += 1;
				} else {
					iX += 1 % terminal.col;
					if (iX >= terminal.col-1) { 
						iX = 0;
						iY += 1; 
					}
				}

				await delay(delay_ms);
			}
        }

		function hide_tileset() {
			// lets tileset img load before hiding, prevents blank screen when img not in cache
			// then kicks off main/update loop
			document.getElementById("tileset_div").style["display"] = "none";
			update();
		}

    </script>


	