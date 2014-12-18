<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Twitter Compare</title>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <style type="text/css">
        ${demo.css}
        </style>
    </head>

<?php
session_start();
$word=$_SESSION['Key'];
$word2=$_SESSION['Key1'];

$link = peb_connect("cat@food",  "abc");
if (!$link) {
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
        //print_r($f);
        //echo '<br/>';
        $s=$msg[1];
        //print_r($s);
        //echo '<br/>';
        $th=$msg[2];
    //    print_r($th);
    //    echo '<br/>';
        echo '<br/>';
}
 if(count($msg)<2){
            Header("Location: http://site1.local/404.php");

        }
$msg2 = peb_encode("[~s]", array( 
                                   array($word2)
                                  )
                 ); 

$result2=peb_rpc("twitter_server","getF",$msg2,$link); 


$rs2= peb_decode($result2);


$msg3=call_user_func_array('array_merge',$rs2);

//print_r($msg);
//echo '<br/>';
if(count($msg3)>2){
        $f3=$msg3[0]*-1;
    //    print_r($f3);
    //    echo '<br/>';
        $s3=$msg3[1];
    //    print_r($s3);
    //    echo '<br/>';
        $th3=$msg3[2];
    //    print_r($th3);
}
 if(count($msg3)<2){
            Header("Location: http://site1.local/404.php");

        }

        


peb_close($link);

?>

<script type="text/javascript">
$(function () {
    var r = <?php echo json_encode($f) ?>;
        var f = <?php echo json_encode($s) ?>;
        
    var categories = ["day 0"];
    $(document).ready(function () {
        $('#container').highcharts({
            chart: {
                type: 'bar'
            },
            title: {
            text: 'Twitter Count | Word 2'
            },
            subtitle: {
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
                min: r-5,
                max: f+5
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

$(function () {
    var r3 = <?php echo json_encode($f3) ?>;
        var f3 = <?php echo json_encode($s3) ?>;
        
    var categories = ["day 0"];
    $(document).ready(function () {
        $('#container1').highcharts({
            chart: {
                type: 'bar'
            },
            title: {
            text: 'Twitter Count | Word 1'
            },
            subtitle: {
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
                min: r3-5,
                max: f3+5
            },

            plotOptions: {
                series: {
                    stacking: 'normal'
                }
            },

            

            series: [{
                name: 'Re-Tweets',
                data: [r3]
            }, {
                name: 'Favorites',
                data: [f3]
            }]
        });
    });

});
        </script>
    
<body>
<script src="js/highcharts.js"></script>
<script src="js/modules/exporting.js"></script>

<div id="container" align="right" style="float:right; min-width: 600px; max-width: 900px; height: 600px; margin: 0 auto" ></div>
<div id="container1" align="left" style="float:left; min-width: 600px; max-width: 900px; height: 600px; margin: 0 auto" ></div>
</body>
</html>
