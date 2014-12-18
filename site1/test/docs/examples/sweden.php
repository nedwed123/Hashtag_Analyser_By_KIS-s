<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <title>Sweden</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../dist/css/vendor/bootstrap.min.css" rel="stylesheet">
    <link href="../../dist/css/flat-ui.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../../images/icon.png">

</head>

<body>
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

$result=peb_rpc("server","tags_sweden",$msg,$link); 



$rs= peb_decode($result);


$msgS=call_user_func_array('array_merge',$rs);
if(count($msgS)>1 && !in_array("badrpc", $msgS)){

$tags=$msgS;
$resultL=peb_rpc("server","likes_sweden",$msg,$link);

$rsL=peb_decode($resultL);
if(!in_array("badrpc", $rsL))
$likes=$rsL[0];
else
Header("Location: http://site1.local/404.php");
}else{
  Header("Location: http://site1.local/404.php");
} 
  // Header("Location: http://site1.local/test/docs/examples/sweden.php");


peb_close($link);

?>	  
	  
    
    <div class="container">
      <h4>Sweden</h4>
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