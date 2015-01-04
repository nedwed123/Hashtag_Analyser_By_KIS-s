<html>
<head>
<meta charset="utf-8">
		<link REL="SHORTCUT ICON" HREF="../images/icon.png">
        <meta http-equiv="X-UA-Compatible" content="chrome=1">
		<title>MapReduce Recent Count Twitter</title>
</head>

<body>
<?php 
session_start();	
mb_internal_encoding('UTF-8');

?>

<?php
$word=$_SESSION['Test'];

$link = peb_connect("cat@food", "abc"); 
if (!$link) { 
//    die('Could not connect: ' . peb_error()); 
    Header("Location: http://site1.local/404.php");
//echo'link error';
} 


$msg = peb_encode("[~s]", array( 
                                   array($word)
                                  )
                 ); 
//print_r($msg);
//The sender must include a reply address.  use ~p to format a link identifier to a valid Erlang pid.

$result=peb_rpc("server","count_tags",$msg,$link); 

$rs= peb_decode($result) ;


$msg=call_user_func_array('array_merge',$rs);

$arr=$msg;
$wo=array();

$indexF=array();

$num=array();

$x=0;
$z=0;
$length = count($arr);
for ($i = 0; $i < $length; $i++) {
    if($i % 2 ==0 ){

  $wo[$x]=mb_strtolower($arr[$i]);

  $x++;
                    }
if($i % 2 !=0 ){
$num[$z]=$arr[$i];
$z++;

}

        }
        $index=array();
        for($a=0; $a<count($wo); $a++){ 
        	if(preg_match('/^[a-zA-Z ]*$/', $wo[$a]) ==0){
        		$index[$a]=$a;
        	}
        }

        $c=0;
         for($b=0; $b<count($wo); $b++){ 
         	if(empty($index[$b])==0){
         		$indexF[$c]=$index[$b];
         		$c++;
         	}
        }

        for($b=0; $b<count($indexF); $b++){ 
         	unset($wo[$indexF[$b]]); 
         	unset($num[$indexF[$b]]);
        }

?>

<script type="text/javascript">
// use php implode function to build string for JavaScript array literal
var wordJ = <?php echo '["' . implode('", "', $wo) . '"]' ?>;
var numJ = <?php echo '[' . implode(', ', $num) . ']' ?>;
var s = <?php  echo (int)$show  ?>;


if(numJ.length==0){
	 Header("Location: http://site1.local/404.php");
//echo'error if(numJ.length==0)';
}
</script>




<script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" align="center">
$(function () {
    $('#container')
    .highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Twitter Recent Media Count'
        },
        subtitle: {
            text: 'Twitter API'
        },
        xAxis: {
            categories: wordJ,
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Count (tens)',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' times'
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 100,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
        	color:'#348095',
            name: 'occurrences',
            data: numJ
        }]
    });
});

</script>


<div id="crow">
    <script src="js/highcharts.js"></script> 
    <script src="js/modules/exporting.js"></script>
    <div id="container" align="left" style="min-width: 800px; max-width: 1500px; height: 5000px; margin: 0 auto" ></div>
</div>



</body>
</html>
