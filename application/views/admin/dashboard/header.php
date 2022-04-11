<!--  PHPBack
Ivan Diaz <ivan@phpback.org>
Copyright (c) 2014 PHPBack
http://www.phpback.org
Released under the GNU General Public License WITHOUT ANY WARRANTY.
See LICENSE.TXT for details.  -->

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Панель администратора - Atmaguru Feedback</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="<?php echo base_url();?> /favicon.ico" sizes="16x16">

    <!-- Loading Bootstrap -->
    <link href="<?php echo base_url(); ?>public/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>public/bootstrap/css/prettify.css" rel="stylesheet">

    <!-- Loading Flat UI -->
    <link href="<?php echo base_url(); ?>public/css/flat-ui.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>public/css/docs.css" rel="stylesheet">

    <!-- Loading custom styles-->
    <link href="<?php echo base_url(); ?>public/css/all.css" rel="stylesheet">

    <link rel="shortcut icon" href="images/favicon.ico">
    <script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
        function showtable(tableid, tablelink){
            document.getElementById('newideastable').style.display = 'none';
            document.getElementById('allideastable').style.display = 'none';
            document.getElementById('commentstable').style.display = 'none';
            document.getElementById(tableid).style.display = '';

            document.getElementById("table1").className = "";
            document.getElementById("table2").className = "";
            document.getElementById("table3").className = "";
            document.getElementById(tablelink).className = "active";
        }
        function showtable2(tableid, tablelink){
            document.getElementById('bannedtable').style.display = 'none';
            document.getElementById('newuserstable').style.display = 'none';
            document.getElementById('bantable').style.display = 'none';
            document.getElementById(tableid).style.display = '';

            document.getElementById("table1").className = "";
            document.getElementById("table2").className = "";
            document.getElementById("table3").className = "";
            document.getElementById(tablelink).className = "active";
        }
        function showtable3(tableid, tablelink){
            document.getElementById('generaltable').style.display = 'none';
            document.getElementById('admintable').style.display = 'none';
            document.getElementById('categorytable').style.display = 'none';
            document.getElementById('typetable').style.display = 'none';
            document.getElementById('upgradetable').style.display = 'none';
            document.getElementById(tableid).style.display = '';

            document.getElementById("table1").className = "";
            document.getElementById("table2").className = "";
            document.getElementById("table3").className = "";
            document.getElementById("table4").className = "";
            document.getElementById("table5").className = "";
            document.getElementById(tablelink).className = "active";
        }
        function popup_sure(text, url) {
            if (confirm(text) == true) {
                window.location = url;
            }
        }
    </script>

    <style type="text/css">
        .logosmall{
            padding-top: 10px;
            padding-left: 10px;
            margin-right: 40px;
            padding-bottom: 10px;
        }
        .navbar{
            background-color: #34495E;
            margin-top: 5px;
        }
        .dashboard-center{
            background-color: #ECF0F1;
        }
        body{
            background-color: #ffffff;
        }
    </style>
    <script src="<?php echo base_url(); ?>public/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>public/js/bootstrap-select.js"></script>
    <script src="<?php echo base_url(); ?>public/js/bootstrap-switch.js"></script>
    <script src="<?php echo base_url(); ?>public/js/flatui-checkbox.js"></script>
    <script src="<?php echo base_url(); ?>public/js/flatui-radio.js"></script>
    <script src="<?php echo base_url(); ?>public/js/jquery.tagsinput.js"></script>
    <script src="<?php echo base_url(); ?>public/js/jquery.placeholder.js"></script>
    <script src="<?php echo base_url(); ?>public/bootstrap/js/application.js"></script>

    <script>
        $('.popover-with-html').popover({ html : true });
        $('.contentdiv').css('width', '100%').css('width', '-=400px');
    </script>

</head>
<body onload="<?php if(isset($toall) && $toall) echo "showtable('allideastable','table2');"; if(isset($idban)) echo "showtable2('bantable','table3');";?>">
<?php
function num_word($value, $words, $show = true)
{
    $num = $value % 100;
    if ($num > 19) {
        $num = $num % 10;
    }

    $out = ($show) ?  $value . ' ' : '';
    switch ($num) {
        case 1:  $out .= $words[0]; break;
        case 2:
        case 3:
        case 4:  $out .= $words[1]; break;
        default: $out .= $words[2]; break;
    }

    return $out;
}
function datetotext($date, $lang, $istime = false){
    $pre = explode(" ", $date);
    $datearr = explode('/', $pre[0]);
    $day = $datearr[0];
    $year = "20" . $datearr[2];

    $month = getMonthText($datearr[1], $lang);

    if($istime && !empty($pre[1])){
        return "$day $month $year $pre[1]";
    } else {
        return "$day $month $year";
    }
}
function getMonthText($month, $lang){
    switch ($month){
        case '01': $month = $lang['cal_january']; break;
        case '02': $month = $lang['cal_february']; break;
        case '03': $month = $lang['cal_march']; break;
        case '04': $month = $lang['cal_april']; break;
        case '05': $month = $lang['cal_mayl']; break;
        case '06': $month = $lang['cal_june']; break;
        case '07': $month = $lang['cal_july']; break;
        case '08': $month = $lang['cal_august']; break;
        case '09': $month = $lang['cal_september']; break;
        case '10': $month = $lang['cal_october']; break;
        case '11': $month = $lang['cal_november']; break;
        case '12': $month = $lang['cal_december']; break;
        default:   $month = $month; break;
    }
    return $month;
}
?>
