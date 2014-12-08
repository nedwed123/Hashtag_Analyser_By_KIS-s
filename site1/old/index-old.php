

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>

<meta charset="utf-8">
<link REL="SHORTCUT ICON" HREF="../images/icon.png">
        <meta http-equiv="X-UA-Compatible" content="chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="stylesheet" type="text/css" href="css/stylesheet.css" />
        <rel="stylesheet" type="text/css" link href="css/css.css">
    <link rel="stylesheet" type="text/css" href="css/style.css" />


  
  <script src="js/checkbox.js" type="text/javascript"></script> 


<!-- horizontal scroll bar -->
<style>
h1.visible {
    visibility: hidden;
}
input[type='range'] {
	-webkit-appearance: none;
	border-radius: 10px;
	box-shadow: inset 0 0 5px #333;
	background-color: #999;
	height: 15px;
  width: 550px;
	vertical-align: middle;
}
input[type='range']::-moz-range-track {
	 -moz-appearance: none;
	 border-radius: 10px;
	 box-shadow: inset 0 0 5px #333;
	 background-color: #999;
	 height: 15px;
}
input[type='range']::-webkit-slider-thumb {
	 -webkit-appearance: none !important;
	 border-radius: 40px;
	 background-color: #D93989;
	 box-shadow:inset 0 0 10px rgba(217, 57, 137,0.5);
	 border: 1px solid #999;
	 height: 38px;
	 width: 15px;
   
    

}
input[type='range']::-moz-range-thumb {
	 -moz-appearance: none;
	 border-radius: 60px;
	 background-color: #FFF;
	 box-shadow:inset 0 0 10px rgba(000,000,000,0.5);
	 border: 1px solid #999;
	 height: 60px;
	 width: 60px;
}
button {
    border: none;
    background-color: transparent;
    outline: none;
}
button:focus {
    border: none;
}
</style>

<style type='text/css'>body, a, a:link{cursor:url(cursors/cur102.cur), default;} a:hover {cursor:url(cursors/cur108.cur),wait;}</style>
</head>

 <script src="js/snow.js"></script>
<body>


    
        <header>
            <div id="SB"> <!-- search box -->
                <div class="inner">
                    <div id="demo-input">
                        <div id="tagbox">
                            Enter your desired #hashtag without any spaces.
                        </div>
                         <form method="POST" action="">
<label for="q" id="search-label"></label>
<input required aria-labelledby="search-label" id="searchBox" placeholder="Search #..." type="search" name="searchBox" class="search-field" value="">
<button id="sbutton" value="Search" type="submit"><img src="images/got.png" alt="Pictures" name="go" id="go" border="0" height="70" width="70"></button> <!--570x60-->
                                             
  </div>
    </div>    
      </div>
        </header>
            <div id="slider"> <!-- time slider -->
                <section class="clearfix" align="center">
                  <input type="range" min="0" max="5" value="0" step="1" onchange="rangevalue.value=value" name="range" value="Days" />
                  <output name="rangevalue" id="rangevalue"> Days</output> 
              </section>
            </div>
        		
            
            
<title>HashtagAnalyzer</title>
    </head>


<!--checkboxes -->
<section>

    
<div class="mainDive">

      <div id="boxSocialMedia">

       <h2 >Select your desired Social Media Source</h2>

        <p><input id="twitter" type="checkbox"  name="twitter"  value="twi"/>
            <label for="twitter" class="checkbox"> Twitter </p></label>

        <p><input id="instagram" type="checkbox"  name="instagram" value="instag"/>
            <label for="instagram" class="checkbox"> Instagram </label></p>
      </div>  
    
        <div id="boxCountry" class="boxcontry">
          <h2 class="h2Country">Select your desired twitter country</h2>
            <p><input id="denmark" type="checkbox" name="denmark" value="denmark"/>
               <label class="checkbox" for="denmark"> Denmark</label>

                 <input id="norway" type="checkbox" name="norway" value="norway"/>
         <label class="checkbox" for="norway"> Norway</p></label>

          <p><input id="finland" type="checkbox" name="finland" value="finland"/>
           <label class="checkbox" for="finland"> Finland    </label>

                    <input id="sweden" type="checkbox" name="sweden" value="sweden" />
           <label class="checkbox" for="sweden"> Sweden </label></p>
       </div>
         
         <div id="boxKindTwitter" class="boxKindTwitter">
           <h2>Select your desired twitter search criteria</h2>
            <p><input id="countFavorite" type="checkbox" name="countFavorite" value="countFavorite">
             <label class="checkbox" for="countFavorite"> Count Favorite</label>

             <input id="retweet" type="checkbox" name="retweet" value="retweet"/>
             <label class="checkbox" for="retweet"> ReTweets </p></label>
         </div>

         <div id="boxKindInstagram" class="boxKindInstagram">
           <h2>Select your desired instagram search criteria</h2>
             <p><input id="Likes" type="checkbox" name="Likes" value="Likes"/>
               <label class="checkbox" for="Likes"> Likes </label>

              <input id="shares" type="checkbox" name="MediaC" value="MediaC"/>
              <label class="checkbox" for="shares"> Media Count </label></p>
          </div>

    </div>

  


  <script type="text/javascript">


function init() {
var divElem1 = document.getElementById ( "boxKindTwitter" ) ;
 divElem1.style.visibility = "hidden" ;
 var divElem2 = document.getElementById ( "boxCountry" ) ;
divElem2.style.visibility = "hidden" ;
 var divElem3 = document.getElementById ('boxKindInstagram');
 divElem3.style.visibility = "hidden" ;
}

window.onload = init;

    var elem = document.getElementById('twitter');

  elem.addEventListener('click', function() {
  var divElem1 = document.getElementById('boxKindTwitter'); 
    if( this.checked){
      document.getElementById('instagram').checked = false;
      document.getElementById('Likes').checked = false;
      document.getElementById('shares').checked = false;
      document.getElementById('boxKindInstagram').style.visibility = "hidden" ;
        divElem1.style.visibility = "visible"  ; 
    }
    else{
        divElem1.style.visibility = "hidden"  ;
    }
    var divElem2 = document.getElementById('boxCountry'); 
    if( this.checked){
        divElem2.style.visibility = "visible"  ; 
    }
    else{
        divElem2.style.visibility = "hidden"  ;
    }
});

var elem2 = document.getElementById('instagram');

elem2.addEventListener('click', function() {
      var divElem3 = document.getElementById('boxKindInstagram'); 
    if( this.checked){
      document.getElementById('twitter').checked = false;
      document.getElementById('countFavorite').checked = false;
      document.getElementById( 'retweet').checked = false;
      document.getElementById('denmark').checked = false;
      document.getElementById('sweden').checked = false;
      document.getElementById('finland').checked = false;
      document.getElementById('norway').checked = false;
      document.getElementById('boxKindTwitter').style.visibility = "hidden" ;
      document.getElementById('boxCountry').style.visibility = "hidden" ;
        divElem3.style.visibility = "visible"  ; 
    }
    else{
        divElem3.style.visibility = "hidden"  ;
    }
});

</script>
    
<?php

session_start();
$_SESSION['MeidaC'] = $_POST["searchBox"];

if (isset($_POST['twitter']))
  echo '<META HTTP-EQUIV="Refresh" Content="0; URL=Likes.php">';    
 //   exit; 
elseif(isset($_POST['instagram']))
  echo '<META HTTP-EQUIV="Refresh" Content="0; URL=result.php">';    
exit; 

?>  

</form>



<p align="center">&nbsp;</p>
<p align="center">&nbsp;</p>

</section>



            
</body>
</html>