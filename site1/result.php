<html>
<head>
<meta charset="utf-8">
        <link REL="SHORTCUT ICON" HREF="../images/icon.png">
        <meta http-equiv="X-UA-Compatible" content="chrome=1">
        <title>Media Count Instagram</title>
        <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>

<body>
<?php 
session_start();                        
?>

<?php                     
$word=$_SESSION['Test'];
$link = peb_connect("cat@food", "abc"); 
if (!$link) { 

    Header("Location: http://site1.local/404.php");
} 


$msg = peb_encode("[~s]", array( 
                                   array($word)
                                  )
                 ); 


$result=peb_rpc("server","getM",$msg,$link); 


$rs= peb_decode($result) ;



$msg=call_user_func_array('array_merge',$rs);

$arr=$msg;
$wo=array();


$num=array();

$x=0;
$z=0;
$length = count($arr);
for ($i = 0; $i < $length; $i++) {
    if($i % 2 ==0 ){
  $wo[$x]=$arr[$i];
  $x++;
                    }
if($i % 2 !=0 ){
$num[$z]=$arr[$i];
$z++;
}
        }

peb_close($link); 
?>


<script type="text/javascript">
// use php implode function to build string for JavaScript array literal
var wordJ = <?php echo '["' . implode('", "', $wo) . '"]' ?>;
var numJ = <?php echo json_encode($num) ?>;



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
            text: 'Instagram Media Count'
        },
        subtitle: {
            text: 'Intagram API'
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
                text: 'Count (hunderds)',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' Hunderds'
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
            name: 'Number',
            data: numJ
        }]
    });
});

</script>


<div id="crow">
    <script src="js/highcharts.js"></script> 
    <script src="js/modules/exporting.js"></script>
    <div id="container" align="left" style="min-width: 800px; max-width: 1500px; height: 1000px; margin: 0 auto" ></div>
</div>


</body>
</html>
