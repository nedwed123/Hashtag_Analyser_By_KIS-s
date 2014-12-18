
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Twitter Norway</title>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <style type="text/css">
        ${demo.css}
        </style>
    </head>

<?php

$word="ru";

$link = peb_connect("cat@food",  "abc");
if (!$link) {
//die('Could not connect: ' . peb_error());
Header("Location: http://site1.local/404.php");
}
$msg = peb_encode("[~s]", array( 
                                   array($word)
                                  )
                 ); 

$result=peb_rpc("twitter_server","getX",$msg,$link); 


$rs= peb_decode($result);


$msg=call_user_func_array('array_merge',$rs);
//print_r($msg);
echo '<br/>';
$ret = array();
$fav = array();

	$z=0;
	$x=0;
 for ($i = 0; $i < count($msg); ++$i) {
 	if(is_array($msg[$i]) && count($msg[$i])>2){
 		$b=$msg[$i];
 		$ret[$z]=($b[0]*-1);
 		$fav[$x]=$b[1];
 		$z++;
 		$x++;
 		
		}
}

//	print_r($ret);
//	echo '<br/>';
// 	print_r($fav);

    $max=max($fav)+5;
    $min=min($ret)-5;

peb_close($link);

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
		var r = <?php echo json_encode($ret) ?>;
		var f = <?php echo json_encode($fav) ?>;
		var min = <?php echo $min; ?>;
        var max = <?php echo $max; ?>;
$(function () {
    var categories = [];
    $(document).ready(function () {
        $('#container').highcharts({
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Norway Everyday Hashtags'
            },
            subtitle: {
                text: 'twitter API'
            },
            xAxis: [{
                categories: [
                ]
            },
            { // mirror axis on right side
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
                        return (Math.abs(this.value)) ;
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
                name: 'retweets',
                data: r
            }, {
                name: 'favorite counts',
                data: f
            }]
        });
    });

});
		</script>
	</head>
	<body>
<script src="js/highcharts.js"></script>
<script src="js/modules/exporting.js"></script>

<div id="container" style="min-width: 310px; max-width: 900px; height: 600px; margin: 0 auto"></div>

	</body>
</html>
