
<?php

$word=$_POST["searchBox"];

$link = peb_connect("sally@xubuntu",  "abc");
if (!$link) {
    die('Could not connect: ' . peb_error());
     //Header("Location: http://site1.local/404.php");
}
$msg = peb_encode("[~s]", array( 
                                   array($word)
                                  )
                 ); 

$result=peb_rpc("server1","get",$msg,$link); 


$rs= peb_decode($result) ;

$msg=call_user_func_array('array_merge',$rs);

print_r($msg);

peb_close($link);

?>

 <script type="text/javascript">
var wordJ = <?php echo json_encode($msg) ?>;
alert(wordJ[0]);
if(wordJ.length==0){
window.location.replace("http://site1.local/image.php");
}
 </script>

 <div id="chrt-inst" >

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <style type="text/css">
${demo.css}
        </style>
        <script type="text/javascript">
$(function () {
    var categories = ["Language is " + wordJ[2]];
    $(document).ready(function () {
        $('#container').highcharts({
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Twitter retweets and Favourite Counts'
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
                min: -1500,
                max: 1000
            },

            plotOptions: {
                series: {
                    stacking: 'normal'
                }
            },

            tooltip: {
                formatter: function () {
                    return '<b>' + numJ + ', retweets'+ '</b><br/>'
                     + Highcharts.numberFormat(Math.abs(this.point.y), 0);
                }
            },

            series: [{
                name: 'Retweets',
                data: [-wordJ[0]]
            }, {
                name: 'Favourite Counts',
                data: [wordJ[1]]
            }]
        });
    });

});
        </script>
</div>

<script src="js/highcharts.js"></script>
<script src="js/modules/exporting.js"></script>
<div id="container" align="left" style="min-width: 1500px; max-width: 2000px; height: 1000px; margin: 0 auto  " ></div>
