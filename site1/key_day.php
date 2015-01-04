
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Twitter Days</title>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <style type="text/css">
        ${demo.css}
        </style>
    </head>

<?php

  session_start();
$word=$_SESSION['Key'];
$range=(int)$_SESSION['range1'];

$link = peb_connect("cat@food",  "abc");
if (!$link) {
Header("Location: http://site1.local/404.php");
//echo 'link error';
}
$msg = peb_encode("[~s~i]", array( 
                                   array($word,$range)
                                  )
                 ); 

$result=peb_rpc("twitter_server","getY",$msg,$link); 


$rs= peb_decode($result);


$msg=call_user_func_array('array_merge',$rs);

$ret = array();
$fav = array();
//echo $range;
echo '<br/>';

	$z=0;
	$x=0;
 for ($i = 0; $i < count($msg); ++$i) {

 	if(is_array($msg[$i]) && count($msg[$i])>2){
 		$b=$msg[$i];
 		$ret[$z]=($b[0]*-1);;
 		$fav[$x]=$b[1];
 		$z++;
 		$x++;

 	}else{
        $ret[$z]=0;
        $fav[$x]=0;
    }
      
}
        //print_r($ret);
        echo '<br/>';
        //print_r($fav);
   
        if($ret[0]==0 && count($ret)==1 && $fav[0]==0 && count($fav)==1){
            Header("Location: http://site1.local/404.php");
//echo 'if($ret[0]==0 && count($ret)==1 && $fav[0]==0 && count($fav)==1)';
    }
        $max=max($fav)+5;
        $min=min($ret)-5;

peb_close($link);
session_destroy();

?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Highcharts Example</title>

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>
<script type="text/javascript">
$(function () {
    var r = <?php echo json_encode($ret) ?>;
        var f = <?php echo json_encode($fav) ?>;
        var min = <?php echo $min; ?>;
        var max = <?php echo $max; ?>;

    var categories = [];
    $(document).ready(function () {
        $('#container').highcharts({
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Twitter API'
            },
            xAxis: [{
                categories: categories,
                reversed: false,
                labels: {
                    step: 1
                }
            }, { // mirror axis on right side
                opposite: true,
                reversed: false,
                categories: categories,
                linkedTo: 0,
                labels: {
                    step: 1
                }
            }],
            yAxis: {
                title: {
                    text: null
                },
                 labels: {
                    formatter: function () {
                        return (Math.abs(this.value));
                    }
                },
                min: min,
                max: max
            },

            plotOptions: {
                series: {
                    stacking: 'normal'
                }
            },

            tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + this.point.category + '</b><br/>' +
                      Highcharts.numberFormat(Math.abs(this.point.y), 0);
                }
            },

            series: [{
                name: 'Re-Tweets',
                data: r
            }, {
                name: 'Favorites',
                data: f
            }]
        });
    });

});
        </script>
    
<body>
<script src="js/highcharts.js"></script>
<script src="js/modules/exporting.js"></script>

<div id="container" style="min-width: 310px; max-width: 900px; height: 600px; margin: 0 auto"></div>
</body>
</html>
