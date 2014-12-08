<html>
    <head>

<?php

$link = peb_pconnect("cat@food", "abc"); 

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

sleep(5);

$rs= peb_decode($result);

$msgS=call_user_func_array('array_merge',$rs);

$tags=$msgS;

$resultL=peb_rpc("server","likes_sweden",$msg,$link);

sleep(5);

$rsL=peb_decode($resultL);

$likes=$rsL[0];

?>
<p id="demo"></p>

<script type="text/javascript">
// use php implode function to build string for JavaScript array literal
var wordJ = <?php echo '["' . implode('", "', $tags) . '"]' ?>;

var s = <?php  echo (int)$likes  ?>;

for (var i = wordJ.length - 1; i >= 0; i--) {
    wordJ[i]=wordJ[i]+ " \n";
};

myFunction();

function myFunction() {
   document.getElementById('demo').innerHTML=wordJ.toString() +" <br> Number of likes is " + s;
}
</script>


</head>
</html>



