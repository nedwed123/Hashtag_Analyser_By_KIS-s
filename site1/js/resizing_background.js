// Cross-browser, cross-platform, self-resizing 
// web page background images. JavaScript code
// copyright 2006, 2007, 2008 Boutell.Com, Inc. 
//
// See http://www.boutell.com/newfaq/ for more information.
//
// Permission granted to use, republish, sell and otherwise
// benefit from this code as you see fit, provided you keep 
// this notice intact. You may remove comments below this line.
//
// END OF NOTICE
//
// INSTRUCTIONS: this WON'T WORK unless you do the following in the
// document that includes it.
//
// 1. Specify the right doctype at the top of your page:
//
//    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
//      "http://www.w3.org/TR/html4/strict.dtd">
//
// 2. In the <head> element of your page, bring in this code:
//
//    <script src="resizing_background.js">
//    </script>
//
// 3. Set the right event handlers in your body element
//    (you may call other functions too, use semicolons to separate):
//
//    <body onLoad="rbInit()" onResize="rbResize()">
//
// 4. Call rbOpen() immediately after your <body> element:
//
// <script>
// // For a centered image that scales up but keeps its proportions
// // (be sure to also set a background-color style on body):
// rbOpen(true);
// // For an image that fills the entire window, distorting if necessary: 
// rbOpen(false);
// </script>
//
// 5. If you have any absolutely positioned divs, put them
//    BEFORE rbOpen(), and make VERY SURE you set z-index explicitly
//    to 1 or higher for them, or the background will appear over
//    them. Hint: use a style sheet to make that less painful.
// 
// 6. Call rbClose() with the URL of YOUR background image,
//    just before your </body> element (relative URLs are fine):
//
//    <script>
//      rbClose("background.jpg");
//    </script>
//
// And that's all it takes! 
//
// WARNINGS: 
//
// 1. Internet Explorer versions prior to 7 will scroll jumpily.
//   IE 7 beta 2 scrolls smoothly, just like Firefox, Safari, and Opera.
//
// 2. There's a very small "fudge factor" in use for Opera, because
//   Opera doesn't support my Firefox trick to get the real size
//   of the usable client area OR the Internet Explorer clientWidth
//   method (Opera returns offsetWidth for clientWidth - that's
//   not right, Opera). So I assume a 16 pixel scrollbar vertically
//   and no scrollbar horizontally. Makes a very small difference.
//
// 3. Users with JavaScript disabled won't see a background.
//   Set a reasonable background color in your <body> element
//   as a fallback measure.

function rbIsIE()
{
	if (navigator.appName == 'Microsoft Internet Explorer') {
		return true;
	}
	return false;
}

function rbIsOpera()
{
	if (navigator.appName == 'Opera') {
		return true;
	}
	return false;
}

function rbSupportsFixed()
{
	if (navigator.appName == 'Microsoft Internet Explorer') {
		var agent = navigator.userAgent;
		var re = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
		var version;
		if (re.exec(agent) != null) {
			version = parseFloat(RegExp.$1);
		}
		if (version < 7.0) {
			return false;
		}
	}
	return true;
}

var rbCenter = false;

function rbInit()
{
	if (rbSupportsFixed()) {
		div = document.getElementById('rbBackgroundDiv');
		div.style.position = 'fixed';
	}	
	// I'd use onScroll, but that 
	// doesn't exist in standards mode
	setTimeout("rbReposition()", 50);
	rbResize();
}

var rbLastScrollTop = null;
var rbSimulateTop = 0;
 
function rbResize()
{
	// We're in "standards mode," so we must use
	// document.documentElement, not document.body, in IE.
	var width;
	var height;
	var x, y, w, h;
	if (rbIsIE()) {
		// All modern versions of IE, including 7, give the
		// usable page dimensions here.
		width = parseInt(document.documentElement.clientWidth); 	
		height = parseInt(document.documentElement.clientHeight); 	
	} else if (rbIsOpera()) {
		// This is slightly off: the width and height will include
		// scrollbar space we can't really use. Compensate by
		// subtracting 16 pixels of scrollbar space from the width
		// (standard in Opera). Firefox has an equivalent but
		// more serious problem because such a mistake in Firefox
		// will break mouse clicks on the scrollbar in 
		// Mac Firefox (yes, really!). Fortunately, in Firefox,
		// we can use a third method that gives accurate results
		// (see below).
		width = parseInt(window.innerWidth) - 16;
		// If there is a horizontal scrollbar this will be
		// 16 pixels off in Opera. I can live with that.
		// You don't design layouts with
		// horizontal scrollbars, do you? (Shudder)
		height = parseInt(window.innerHeight);
	} else {
		// Other non-IE browsers give the usable page dimensions here.
		// We grab the info by discovering the visible dimensions 
		// of a hidden 100% x 100% div. Opera doesn't like this
		// method any more than IE does. Fun!
		testsize = document.getElementById('rbTestSizeDiv');
		width = testsize.scrollWidth;
		height = testsize.scrollHeight;
	}
	div = document.getElementById('rbBackgroundDiv');
	img = document.getElementById('rbBackground');
	if (rbCenter) {
		if (img.width == 0) {
			// We don't know the width yet, the image
			// hasn't loaded. Set a timer to try again.
			setTimeout("rbResize()", 1000);
			return;
		}
		w = width;
		h = width * (img.height / img.width);
		x = 0;
		y = (height - h) / 2;	
		if (y < 0) {
			h = height;
			w = height * (img.width / img.height);
			y = 0;
			x = (width - w) / 2;
		}
	} else {
		x = 0;
		y = 0;
		w = width;
		h = height;
	}
	// HTML 4.0 Strict makes the px suffix mandatory
	// We have floating point numbers, trim them and add px
	div.style.left = parseInt(x) + "px";
	if (rbSupportsFixed()) {
	  div.style.top = parseInt(y) + "px";
        } else {
          rbSimulateTop = parseInt(y);
        }
	img.style.width = parseInt(w) + "px";
	img.style.height = parseInt(h) + "px";
	div.style.visibility = 'visible';
	rbLastScrollTop = null;
	rbReposition();
}

function rbReposition()
{
	if (rbSupportsFixed()) {
		return;
	}
	// Make sure we do this again
	setTimeout("rbReposition()", 50);
	// Standards mode, must use documentElement
	body = document.documentElement;
	var scrollTop = body.scrollTop;
	// No scroll since last check
	if (scrollTop == rbLastScrollTop) {
		return;
	}
	rbLastScrollTop = scrollTop;
	div = document.getElementById('rbBackgroundDiv');
	var rbBodyDiv = document.getElementById('rbBodyDiv');
	var pos = 0;
	// Don't make the user scroll just to see the background itself
	var max = rbBodyDiv.offsetHeight - rbBodyDiv.clientHeight;
	if (max < 0) {
		max = 0;
	}
	if (scrollTop <= max)
	{
		pos = scrollTop;
	} else {
		pos = max;
	}
	if (pos < 0) {
		pos = 0;
	}
	div.style.top = pos + rbSimulateTop;
}

function rbOpen(center)
{
	rbCenter = center;
	document.write("<div id='rbBodyDiv' style='position: relative; z-index: 2'>\n");
}

function rbClose(image)
{
	document.write("</div>\n");
	str = "<div " +
		"id='rbBackgroundDiv' " +
		"style='position: absolute; " +
		"  visibility: hidden; " +
		"  top: 0px; " +
		"  left: 0px; " +
		"  z-index: 0'>" +
		"  <img src='" + image + "' id='rbBackground'>" +
		"</div>\n";
	document.write(str);
	document.write("<div " +
		"id='rbTestSizeDiv' " +
		"style='width: 100%; " +
		"  height: 100%; " +
		"  position: fixed; " +
		"  left: 0; " +
		"  top: 0; " +
		"  visibility: hidden; " +
		"  z-index: -1'></div>\n");
}

