<!DOCTYPE html>
<html lang="en">
<title>Denmark Everyday Hashtags Twitter</title>
  <head>
<?php

$link = peb_connect("cat@food", "abc"); 

if (!$link) { 
//    die('Could not connect: ' . peb_error()); 
    Header("Location: http://site1.local/404.php");
} 
$msg = peb_encode("[~s]", array( 
                                   array("hello")
                                  )
                 );
//The sender must include a reply address.  use ~p to format a link identifier to a valid Erlang pid.

$result=peb_rpc("server","tags_denemark",$msg,$link); 



$rs= peb_decode($result);


$msgS=call_user_func_array('array_merge',$rs);
if(count($msgS)>1){
$tags=$msgS;

$resultL=peb_rpc("server","likes_denemark",$msg,$link);



$rsL=peb_decode($resultL);

$likes=$rsL[0];
}else{
   Header("Location: http://site1.local/404.php");
}
peb_close($link);

?>	  
	  
    <meta charset="utf-8">
    <title>Flat UI Free</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Loading Bootstrap -->
    <link href="../../dist/css/vendor/bootstrap.min.css" rel="stylesheet">

    <!-- Loading Flat UI -->
    <link href="../../dist/css/flat-ui.css" rel="stylesheet">

    <link rel="shortcut icon" href="../../../images/icon.png">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="../../dist/js/vendor/html5shiv.js"></script>
      <script src="../../dist/js/vendor/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
      <h4>Denmark</h4>
      <div class="row">
        <div class="col-md-7 mtl">
          <h5 id="num"></h5>
          <h5 class="demo-panel-title">Tags Input</h5>
          <input id="demo" name="tagsinput-01" class="tagsinput" value=""  disabled />
          

          

        </div> <!-- /tags -->
      </div><!-- /.row -->
<script type="text/javascript">
// use php implode function to build string for JavaScript array literal
var wordJ = <?php echo '["' . implode('", "', $tags) . '"]' ?>;

var s = <?php  echo (int)$likes  ?>;

for (var i = wordJ.length - 1; i >= 0; i--) {
    wordJ[i]=wordJ[i]+ " \n";
};

myFunction();

function myFunction() {
document.getElementById('num').innerHTML="Total Number of likes is: "+s;
   document.getElementById('demo').value=wordJ.toString() ;
};
if(s<2){
      window.open("http://site1.local/404.php", "local", 'width=500,height=500, scrollbars=no');
//window.location.replace("http://site1.local/404.php");
}
</script>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../../dist/js/vendor/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../../dist/js/flat-ui.js"></script>

    <script src="../assets/js/application.js"></script>
    <script>

      $('input.tagsinput').tagsinput();

      $('input.tagsinput-typeahead').tagsinput('input').typeahead(null, {
        name: 'states',
        displayKey: 'word',
        source: states.ttAdapter()
      });

    </script>


  </body>
</html>