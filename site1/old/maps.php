<!DOCTYPE html>
<html>
<head>
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

<style>

canvas
{
    pointer-events: none;       /* make the canvas transparent to the mouse - needed since canvas is position infront of image */
    position: absolute;
}
</style>

<title></title>
</head>
<body onload='myInit()'>
    <canvas id='myCanvas'></canvas>     <!-- gets re-positioned in myInit(); -->
<center>
<img src='http://www.image-maps.com/m/private/38325/37498-opmwbt.jpg' usemap='#imgmap_css_container_imgmap201293016112' class='imgmap_css_container' title='choose a country' 
alt='imgmap201293016112' id='img-imgmap201293016112' />
<map id='imgmap201293016112' name='imgmap_css_container_imgmap201293016112'>

    <area shape="poly" onmouseover='myHover(this);' onmouseout='myLeave();' coords="495,76,513,80,516,100,525,94,525,87,531,84,532,76,516,75,520,69,527,62,508,51,497,58,496,50,489,53,
    481,67,479,56,470,79,469,62,464,57,452,79,432,83,420,106,414,97,405,104,397,116,378,138,365,169,353,170,332,219,330,230,290,277,300,285,294,296,281,290,256,312,249,313,249,326,
    239,322,223,332,218,330,210,355,246,354,239,372,213,365,210,391,228,381,219,396,206,408,204,416,215,412,207,431,220,450,218,460,251,458,274,434,283,434,280,415,287,414,287,425,
    293,434,308,428,305,412,322,397,320,371,319,368,327,360,318,342,320,328,319,320,320,306,319,294,331,276,347,274,343,256,350,234,353,211,360,204,365,195,374,182,374,176,376,162,
    388,151,398,138,414,134,424,116,435,112,442,121,464,120,472,124,476,112,478,89" 
    href="http://site1.local/test/docs/examples/norway.php" alt="imgmap201293016112-0" title="NORWAY" class="imgmap201293016112-area" id="imgmap201293016112-area-0" />

    <area shape="poly" onmouseover='myHover(this);' onmouseout='myLeave();' coords="488,399,532,372,537,375,541,371,550,373,591,296,592,290,585,276,570,263,572,250,561,242,558,228,553,228,
    552,217,548,211,552,200,531,165,536,144,526,130,521,132,516,126,516,102,515,98,515,91,515,84,497,77,478,88,481,102,472,122,463,119,445,121,436,107,423,116,439,129,448,132,460,
    156,462,169,468,178,466,192,472,201,494,224,497,243,493,243,488,247,487,254,457,298,454,296,452,299,447,317,456,350,455,370,477,387" 
    href="http://site1.local/test/docs/examples/finland.php" alt="imgmap201293016112-1" title="FINLAND" class="imgmap201293016112-area" id="imgmap201293016112-area-1" />
   
   <area shape="poly" onmouseover='myHover(this);' onmouseout='myLeave();' coords="269,500,270,487,278,481,278,464,269,469,266,479,240,484,232,525,238,526,245,535,243,545,253,553,259,548,256,541,
   256,532,261,526,268,523,268,520,275,516,275,511,280,508,283,504,283,501" href="http://site1.local/test/docs/examples/denmark.php" alt="imgmap201293016112-2" title="DENMARK" class="imgmap201293016112-area" 
   id="imgmap201293016112-area-2" />
   
   <area shape="poly" onmouseover='myHover(this);' onmouseout='myLeave();' coords="287,528,296,541,305,552,309,540,310,535,312,528,308,517,299,517" href="http://site1.local/test/docs/examples/denmark.php" 
   alt="imgmap201293016112-2" title="DENMARK" class="imgmap201293016112-area" id="imgmap201293016112-area-2-2" />
    
	<area shape="poly" onmouseover='myHover(this);' onmouseout='myLeave();' coords="470,202,466,194,468,183,461,164,454,143,446,129,439,131,424,116,420,133,399,132,390,154,383,150,376,166,375,181,
    364,194,362,205,354,212,354,236,345,252,346,270,329,278,321,289,320,304,317,320,320,331,318,344,325,356,319,368,324,396,307,412,305,432,299,434,321,505,314,515,320,539,344,537,345,527,356,
    514,375,516,384,448,384,439,405,425,409,420,406,414,414,403,399,388,384,405,376,392,388,372,389,340,392,334,391,320,436,252,435,237,440,229,434,224,449,205" 
    href="http://site1.local/test/docs/examples/sweden.php" alt="imgmap201293016112-3" title="SWEDEN" class="imgmap201293016112-area" id="imgmap201293016112-area-3" />
    
	<area shape="poly" onmouseover='myHover(this);' onmouseout='myLeave();' coords="411,465,419,460,428,479,412,488" href="http://site1.local/test/docs/examples/sweden.php" 
    alt="imgmap201293016112-area-4" title="SWEDEN" class="imgmap201293016112-area" id="imgmap201293016112-area-4" />
    

</map>
</center>