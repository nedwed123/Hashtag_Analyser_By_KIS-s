
<html>
<meta charset="utf-8">
        <link REL="SHORTCUT ICON" HREF="../images/icon.png">
        <meta http-equiv="X-UA-Compatible" content="chrome=1">
        <title>Compare</title>
</head>

<body>
<?php
session_start();
$word=$_SESSION['Test'];
$word2=$_SESSION['Test1'];
$link = peb_connect("cat@food", "abc"); 
if (!$link) { 
//    die('Could not connect: ' . peb_error()); 
    Header("Location: http://site1.local/404.php");
} 


$msg = peb_encode("[~s,~s]", array( 
                                   array($word,$word2)
                                  )
                 ); 
//The sender must include a reply address.  use ~p to format a link identifier to a valid Erlang pid.

$result=peb_rpc("server","compare",$msg,$link); 

$rs= peb_decode($result);

$msg=call_user_func_array('array_merge',$rs);

$Result1=array_values($msg[0]);
$Result2=array_values($msg[1]);

$wo=array();


$num=array();

$x=0;
$z=0;
$length = count($Result1);
for ($i = 0; $i < $length; $i++) {
    if($i % 2 ==0 ){
  $wo[$x]=$Result1[$i];
  $x++;
                    }
if($i % 2 !=0 ){
$num[$z]=$Result1[$i];
$z++;
}
        }

$wo2=array();


$num2=array();

$x1=0;
$z1=0;
$length = count($Result2);
for ($i = 0; $i < $length; $i++) {
    if($i % 2 ==0 ){
  $wo2[$x1]=$Result2[$i];
  $x1++;
                    }
if($i % 2 !=0 ){
$num2[$z1]=$Result2[$i];
$z1++;
}
        }
       
peb_close($link);

?>

<script type="text/javascript">
// use php implode function to build string for JavaScript array literal
var wordJ = <?php echo '["' . implode('", "', $wo) . '"]' ?>;
var numJ = <?php echo json_encode($num) ?>;

var wordJ2 = <?php echo '["' . implode('", "', $wo2) . '"]' ?>;
var numJ2 = <?php echo json_encode($num2) ?>;


if(numJ.length==0){
window.location.replace("http://site1.local/404.php");
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
            text: 'Instagram Media Count | Word 2'
        },
        subtitle: {
            text: 'Intagram API'
        },
        xAxis: {
            categories: wordJ2,
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
            data: numJ2
        }]
    });
});

$(function () {
    $('#container1')
    .highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Instagram Media Count | Word 1'
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
    <div id="container" align="right" style="float:right; min-width: 600px; max-width: 900px; height: 1000px; margin: 0 auto" ></div>
    <div id="container1" align="left" style="float:left; min-width: 600px; max-width: 900px; height: 1000px; margin: 0 auto" ></div>
</div>



</body>
</html>