<!DOCTYPE html>
<html>

	<head>
	<meta charset="utf-8">
		<link REL="SHORTCUT ICON" HREF="../images/icon.png">
        <meta http-equiv="X-UA-Compatible" content="chrome=1">
		<title>Instagram</title>
		
		<link rel="stylesheet" href="css/instagram_page.css" type="text/css">
		<link rel="stylesheet" href="css/socialMenu_Instagram.css" type="text/css"/>
		<link href='http://fonts.googleapis.com/css?family=Raleway:400,200' rel='stylesheet' type='text/css'> 
		<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/themes/smoothness/jquery-ui.css"> 
  		<link href="http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	</head>
			 					

<body onload='myInit()'>
		<script>

// stores the device context of the canvas we use to draw the outlines
// initialized in myInit, used in myHover and myLeave
var hdc;

// shorthand func
function byId(e){return document.getElementById(e);}

// takes a string that contains coords eg - "227,307,261,309, 339,354, 328,371, 240,331"
// draws a line from each co-ord pair to the next - assumes starting point needs to be repeated as ending point.
function drawPoly(coOrdStr)
{
    var mCoords = coOrdStr.split(',');
    var i, n;
    n = mCoords.length;

    hdc.beginPath();
    hdc.moveTo(mCoords[0], mCoords[1]);
    for (i=2; i<n; i+=2)
    {
        hdc.lineTo(mCoords[i], mCoords[i+1]);
    }
    hdc.lineTo(mCoords[0], mCoords[1]);
    hdc.stroke();
}

function drawRect(coOrdStr)
{
    var mCoords = coOrdStr.split(',');
    var top, left, bot, right;
    left = mCoords[0];
    top = mCoords[1];
    right = mCoords[2];
    bot = mCoords[3];
    hdc.strokeRect(left,top,right-left,bot-top); 
}

function myHover(element)
{
    var hoveredElement = element;
    var coordStr = element.getAttribute('coords');
    var areaType = element.getAttribute('shape');

    switch (areaType)
    {
        case 'polygon':
        case 'poly':
            drawPoly(coordStr);
			
            break;

        case 'rect':
            drawRect(coordStr);
    }
}

function myLeave()
{
    var canvas = byId('myCanvas');
    hdc.clearRect(0, 0, canvas.width, canvas.height);
}

function myInit()
{
    // get the target image
    var img = byId('img-imgmap201293016112');

    var x,y, w,h;

    // get it's position and width+height
    x = img.offsetLeft;
    y = img.offsetTop;
    w = img.clientWidth;
    h = img.clientHeight;

    // move the canvas, so it's contained by the same parent as the image
    var imgParent = img.parentNode;
    var can = byId('myCanvas');
    imgParent.appendChild(can);

    // place the canvas in front of the image
    can.style.zIndex = 1;

    // position it over the image
    can.style.left = x+'px';
    can.style.top = y+'px';

    // make same size as the image
    can.setAttribute('width', w+'px');
    can.setAttribute('height', h+'px');

    // get it's context
    hdc = can.getContext('2d');

    // set the 'default' values for the colour/width of fill/stroke operations
    hdc.fillStyle = 'lightgrey';
    hdc.strokeStyle = 'lightgrey';
	hdc.globalAlpha= 0.5;
	hdc.lineWidth = 15;
	
}

</script>
 

 <!--time bar -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js"></script>
<style>
#range {
  width: 412px;
  position: absolute;
  margin-left: 205px;
  margin-top: 60px;
  -webkit-transform: translate(-50%, -50%);
  -moz-transform: translate(-50%, -50%);
  -o-transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
  border: 0;
  height: 10px;
  background: #ededed;
  outline: none;
}

#range .ui-slider-handle {
  position: absolute;
  margin: -3px 0 0 -9px;
  -webkit-border-radius: 100%;
  border-radius: 100%;
  background: #348095;
  border: 0;
  height: 30px;
  width: 30px;
  outline: none;
  cursor: pointer;
}

#range .ui-slider-handle:hover,
#range .ui-slider-handle:focus {
  -webkit-transform: scale(1.1);
  -moz-transform: scale(1.1);
  -o-transform: scale(1.1);
  -ms-transform: scale(1.1);
  transform: scale(1.1);
}

#range .ui-slider-range { background: #348095; }

#range #currentVal {
  position: absolute;
  font-size: 12px;
  font-weight: bold;
  color: #348095;
  width: 412px;
  text-align: center;
  margin-top: -25px;
}
</style>

<script>
(function() {
$("#range").slider({
range: "min",
max: 5,
value: 0,
slide: function(e, ui) {
$("#currentVal").html(ui.value);
}
});
}).call(this);

</script>




	<!--body of the whole page-->
		<!--main div which is included all the part of the body page-->
		<div id="div_main">


			<!--division of header part of the page ,top header-->
			<div id="div_topHeader">
			
				<!--top header of the page-->
				<header id="instagram_header">
				<div id="center_header">
					<h1 >Hashtag analyzer
						<img src="images/header.png" style="width:8px;height:33px" > 
         	 			<h3 >For people who like to research <h3>
					</h1>
					
				<!--close top header of the page-->
				</header>
			</div>
			<!--close division of the top header(id="div_topHeader")-->
			
	    	</div>


			<!--division of the background picture and white box inside the background-->
					<div id="background">
						<div id="transbox">
							<article>
								
										
								<h1><p>You can analyze any word you wish in the box below. Tip!</p>
								<p>Try to keep your words similar to trendy tags of the day in </p>
								<p>order to get relative data. You could find out trendy tags </p>
								<p>that people are using under recent tags..</p></h1>
							
							<!--search box div-->

							<div id="search">
								<form method="POST" action="">
								<label for="q" id="search-label"></label>
								 
								   <input required aria-labelledby="search-label" id="searchBox" placeholder="Search #..." type="search" name="searchBox" class="search-field" value=""> 
								   <input type="submit" value="Go" class="button" onclick="check()"></input>
								
							</div> 

							<!-- end search -->
							<!--time bar comment for now

								<div id="range">
								  <span id="currentVal">Now</span>
								</div>
								-->

							<!--checkbox-->
						    <div  id="checkBox_div">
								<table >
									<tr >
                              
									
									<!--like checkbox-->
									<td >
										   <input type="checkbox" name="Likes" value="Likes" id="Likes" class="css-checkbox" onclick="likes()" />
											<label for="Likes" class="css-label"><h1>Likes<h1></label>
											     
											    <span title="Check this box if you wish to view the number 
of likes for your desired hashtag (the one you
have typed in the serch field above)."><button id="boutton_i1">i</button></span>				
												
											</label>
										</td>
										<!--Media checkbox-->
										<td >
										   <input type="checkbox" name="MediaC" value="MediaC" id="MediaC" class="css-checkbox" onclick="media()" />
											<label for="MediaC" class="css-label"><h1>Media<h1></label>
											    
											       <span title="Check this box if you wish to view the pictures 
uploaded by users that have your desired 
hashtag (the one you have typed in the 
serch field above) tagged."><button id="boutton_i3">i</button></span>		
												
											</label>
										</td>
		<script type="text/javascript">
function likes(){

document.getElementById("MediaC").checked = false;
if(document.getElementById("searchBoxi").value.length>0){
	document.getElementById("Likes").checked=false;
	}
}

function media(){
document.getElementById("Likes").checked=false;
if(document.getElementById("searchBoxi").value.length>0){
	document.getElementById("MediaC").checked=false;
	}
}

function compare(){
document.getElementById("Likes").checked=false;
document.getElementById("MediaC").checked=false;

}

function check(){
	if(document.getElementById("Likes").checked==false && document.getElementById("MediaC").checked==false && document.getElementById("searchBox").value.length==0){
		alert("Please choose a checkbox!");
		}
	}

		</script>											   
									 </tr>
								</table>
							</div>

				<!--text area-->

							<!--search box div-->

							<div id="searchtext">

								 
								

								   <input  id="searchBoxi" placeholder="Search #..." type="search" name="searchBoxi" class="search-field" value="" onkeypress="compare()"> 
								   
								</form>
							</div> 
								
							    <div id="label">
								    <label for="compare" ><h1>Compare with<h1></label>
								</div>
							<div id="text">					  
								    <span title="Type in another hashtag to compare your primary 
hashtag with. Remember: It may be that you enter a 
hashtag that has never been used by any user. In that 
case you will be redirected to the not found page."><h1  class="label-textarea">  ..................................................................................</h1></span>	
								       
											       <button id="boutton_i2">i</button>				
									
																				    		
						     </div>
							<!-- end search -->
							<!--social box-->
							<div >
							  <link href='http://fonts.googleapis.com/css?family=Raleway:400,200' rel='stylesheet' type='text/css'> 

							  <link href="http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

							  <div class="social">
							          <ul>
							          		
							          		<li><a href="http://site1.local/index.php">Home<i class="fa fa-home"></i></a></li>
							          		<li><a href="http://site1.local/instagram.php">Instagram <i class="fa fa-instagram"></i></a></li>
							             	<li><a href="http://site1.local/twitter.php">Twitter <i class="fa fa-twitter"></i></a></li>
							             	<li><a href="http://site1.local/comments.php">Comments<i class="fa fa-comment"></i></a></li>

							          </ul>
							      </div>
							       				       
							  </div>
								</form>
						    </article>

						    
									  <!--map-->
	 						<div id="map">

								<canvas id='myCanvas'></canvas>     <!-- gets re-positioned in myInit(); -->
										<center>
											<img src="http://www.image-maps.com/m/private/38325/37498-opmwbt.jpg" usemap="#imgmap_css_container_imgmap201293016112" class="imgmap_css_container" 
											title="choose a country" alt="imgmap201293016112" id="img-imgmap201293016112" style="height: 400px; width: 600px;">
											<map id="imgmap201293016112" name="imgmap_css_container_imgmap201293016112">

											    <area shape="poly" onmouseover="myHover(this);" onmouseout="myLeave();" coords="371,51,385,53,387,67,394,63,394,58,398,56,399,51,387,50,390,46,395,41,381,34,
											    373,39,372,33,367,35,361,45,359,37,353,53,352,41,348,38,339,53,324,55,315,71,311,65,304,69,298,77,284,92,274,113,265,113,249,146,248,153,218,185,225,190,221,
											    197,211,193,192,208,187,209,187,217,179,215,167,221,164,220,158,237,185,236,179,248,160,243,158,261,171,254,164,264,155,272,153,277,161,275,155,287,165,300,
											    164,307,188,305,206,289,212,289,210,277,215,276,215,283,220,289,231,285,229,275,242,265,240,247,239,245,245,240,239,228,240,219,239,213,240,204,239,196,248,
											    184,260,183,257,171,263,156,265,141,270,136,274,130,281,121,281,117,282,108,291,101,299,92,311,89,318,77,326,75,332,81,348,80,354,83,357,75,359,59" 
											    href="http://site1.local/test/docs/examples/norway.php" alt="imgmap201293016112-0" title="NORWAY" class="imgmap201293016112-area" 
											    id="imgmap201293016112-area-0">

											    <area shape="poly" onmouseover="myHover(this);" onmouseout="myLeave();" coords="366,266,399,248,403,250,406,247,413,249,443,197,444,193,439,184,428,175,429,167,
											    421,161,419,152,415,152,414,145,411,141,414,133,398,110,402,96,395,87,391,88,387,84,387,68,386,65,386,61,386,56,373,51,359,59,361,68,354,81,347,79,334,81,327,
											    71,317,77,329,86,336,88,345,104,347,113,351,119,350,128,354,134,371,149,373,162,370,162,366,165,365,169,343,199,341,197,339,199,335,211,342,233,341,247,358,258" 
											    href="http://site1.local/test/docs/examples/finland.php" alt="imgmap201293016112-1" title="FINLAND" class="imgmap201293016112-area" 
											    id="imgmap201293016112-area-1">
											   
											   <area shape="poly" onmouseover="myHover(this);" onmouseout="myLeave();" coords="202,333,203,325,209,321,209,309,202,313,200,319,180,323,174,
											   350,179,351,184,357,182,363,190,369,194,365,192,361,192,355,196,351,201,349,201,347,206,344,206,341,210,339,212,336,212,334" 
											   href="http://site1.local/test/docs/examples/denmark.php" alt="imgmap201293016112-2" title="DENMARK" class="imgmap201293016112-area" 
											   id="imgmap201293016112-area-2">
											   
											   <area shape="poly" onmouseover="myHover(this);" onmouseout="myLeave();" coords="215,352,222,361,229,368,232,360,233,357,234,352,231,345,224,345" 
											   href="http://site1.local/test/docs/examples/denmark.php" alt="imgmap201293016112-2" title="DENMARK" class="imgmap201293016112-area" 
											   id="imgmap201293016112-area-2-2">
											    
												<area shape="poly" onmouseover="myHover(this);" onmouseout="myLeave();" coords="353,135,350,129,351,122,346,109,341,95,335,86,329,87,318,
												77,315,89,299,88,293,103,287,100,282,111,281,121,273,129,272,137,266,141,266,157,259,168,260,180,247,185,241,193,240,203,238,213,240,221,
												239,229,244,237,239,245,243,264,230,275,229,288,224,289,241,337,236,343,240,359,258,358,259,351,267,343,281,344,288,299,288,293,304,
												283,307,280,305,276,311,269,299,259,288,270,282,261,291,248,292,227,294,223,293,213,327,168,326,158,330,153,326,149,337,137" 
												href="http://site1.local/test/docs/examples/sweden.php" alt="imgmap201293016112-3" title="SWEDEN" class="imgmap201293016112-area" 
												id="imgmap201293016112-area-3">
											    
												<area shape="poly" onmouseover="myHover(this);" onmouseout="myLeave();" coords="308,310,314,307,321,319,309,325" 
												href="http://site1.local/test/docs/examples/sweden.php" alt="imgmap201293016112-area-4" title="SWEDEN" class="imgmap201293016112-area" 
												id="imgmap201293016112-area-4">
											    

											</map>
									</center>
								</div>				
						    </div>
						</div>


					</div>

		    </div>
		  
		 </div>
		 					<?php
		 					session_start();
		 					?>
		 					
		 					<?php
							$_SESSION['Test'] = $_POST["searchBox"];
							$_SESSION['Test1']= $_POST["searchBoxi"];

							if (isset($_POST['Likes'])){
  								echo '<META HTTP-EQUIV="Refresh" Content="0; URL=http://site1.local/Likes.php">';}
							 //   exit; 
							elseif(isset($_POST['MediaC']))
							 	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=http://site1.local/result.php">';    
							 elseif(strlen($_POST["searchBox"])>0 && strlen($_POST["searchBoxi"])>0)
							 	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=http://site1.local/compare.php">';
							
							?>  
	</body>
</html>

