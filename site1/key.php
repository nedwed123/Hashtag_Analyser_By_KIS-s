<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Twitter Key</title>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <style type="text/css">
        ${demo.css}
        </style>
    </head>

<?php
session_start();
$word=$_SESSION['Key'];
$range=(int)$_SESSION['range'];
//echo $range;

$link = peb_connect("cat@food",  "abc");
if (!$link) {
//die('Could not connect: ' . peb_error());
Header("Location: http://site1.local/404.php");
}
$msg = peb_encode("[~s]", array( 
                                   array($word)
                                  )
                 ); 

$result=peb_rpc("twitter_server","getF",$msg,$link); 


$rs= peb_decode($result);


$msg=call_user_func_array('array_merge',$rs);

//print_r($msg);
//echo '<br/>';
if(count($msg)>2){
        $f=$msg[0]*-1;
       // print_r($f);
       // echo '<br/>';
        $s=$msg[1];
      //  print_r($s);
      //  echo '<br/>';
        $th=$msg[2];
      //  print_r($th);
}
 if(count($msg)<2){
            Header("Location: http://site1.local/404.php");

        }

        $max=max($th)+5;
        $min=min($s)-5;

peb_close($link);
session_destroy();

?>

<script type="text/javascript">
$(function () {
    var r = <?php echo json_encode($f) ?>;
        var f = <?php echo json_encode($s) ?>;
        var min = <?php echo $min; ?>;
        var max = <?php echo $max; ?>;
    var categories = ["day 0"];
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

            

            series: [{
                name: 'Re-Tweets',
                data: [r]
            }, {
                name: 'Favorites',
                data: [f]
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
