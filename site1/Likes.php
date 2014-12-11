
<html>
<head>
<meta charset="utf-8">
		<link REL="SHORTCUT ICON" HREF="../images/icon.png">
        <meta http-equiv="X-UA-Compatible" content="chrome=1">
		<title>Likes</title>
</head>

<body>
<?php 
session_start();						
?>

<?php						
$word=$_SESSION['Test'];
//$word="love";
//$word="گربه";
$link = peb_connect("cat@food", "abc"); 
if (!$link) { 
//    die('Could not connect: ' . peb_error()); 
    Header("Location: http://site1.local/404.php");
} 


$msg = peb_encode("[~s]", array( 
                                   array($word)
                                  )
                 ); 
//The sender must include a reply address.  use ~p to format a link identifier to a valid Erlang pid.

$result=peb_rpc("server","get",$msg,$link); 

$rs= peb_decode($result) ;



$msg=call_user_func_array('array_merge',$rs);
if(count($msg)>1 && !in_array("badrpc", $msg)){

//print_r($rs);
$NumOfLikes=$msg[0];
$ImagesSrc=array_values($msg[1]);
$Images=array_values($msg[2]);
}else{
	 Header("Location: http://site1.local/404.php");
}
peb_close($link);
?>

<?php
if(count($msg)>1 && !in_array("badrpc", $msg)){

echo "</head><body><ul class='coldsoup' align='center'>";
echo "<li><span style='font-size:22px'> The Instagram word <b><font color='red'>" .$word. "</font></b> that you've searched has been liked <b><font color='red'>" .$NumOfLikes. "</font></b> times </span></li>";
echo "</ul>";
$x= count($Images);

for($i=0; $i<$x;$i++){

if($i % 3==0){
echo"<br></br>";}

	//echo $Images[$i];
	
	echo "<a target='_blank' href='$ImagesSrc[$i]'><img src='$Images[$i]' width='412' height='412' style='border-color: darkcyan' border='3'/></a>";
}

}?>






<!--     <a href="'".myImage1[i]."'" target="_blank" rel="nofollow"> </a>-->


</body>
</html>
