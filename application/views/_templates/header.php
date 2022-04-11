<!--  PHPBack
Ivan Diaz <ivan@phpback.org>
Copyright (c) 2014 PHPBack
http://www.phpback.org
Released under the GNU General Public License WITHOUT ANY WARRANTY.
See LICENSE.TXT for details.  -->
<!DOCTYPE html>
<html>
<head>
    <title><?= $title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="<?php echo base_url();?>/favicon.ico">

    <!-- Loading Bootstrap -->
    <link href="<?= base_url(); ?>public/js/lightbox/css/lightbox.css" rel="stylesheet" />
    <link href="<?= base_url(); ?>public/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="<?= base_url(); ?>public/bootstrap/css/prettify.css" rel="stylesheet">

    <!-- Loading Flat UI -->
    <link href="<?= base_url(); ?>public/css/flat-ui.css" rel="stylesheet">
    <!-- <link href="<?= base_url(); ?>public/css/demo.css" rel="stylesheet"> -->

    <!-- Loading custom styles-->
    <link href="<?php echo base_url(); ?>public/css/all.css" rel="stylesheet">

    <script type="text/javascript">
        function showtable(tableid, tablelink){
            if(document.getElementById("table1"))
                document.getElementById("table1").className = "";
            if(document.getElementById('activitytable'))
                document.getElementById('activitytable').style.display = 'none';

            document.getElementById('ideastable').style.display = 'none';
            document.getElementById('commentstable').style.display = 'none';
            document.getElementById(tableid).style.display = '';
            document.getElementById("table2").className = "";
            document.getElementById("table3").className = "";
            document.getElementById(tablelink).className = "active";
        }
        function showtable4(tableid, tablelink){
            document.getElementById('resetvotestable').style.display = 'none';
            document.getElementById('changepasswordtable').style.display = 'none';
            document.getElementById(tableid).style.display = '';
            document.getElementById("table4").className = "";
            document.getElementById("table5").className = "";
            document.getElementById(tablelink).className = "active";
        }
        function showstatus(status){
            document.getElementById("idea_completed").className = "";
            document.getElementById("idea_started").className = "";
            document.getElementById("idea_planned").className = "";
            document.getElementById("idea_considered").className = "";
            document.getElementById("idea_declined").className = "";

            if(status)
                document.getElementById("idea_"+status).className = "active";
            else
                document.getElementById("idea_all").className = "active";
        }
        function redirect(url) {
            window.location.href = url;
        }
        function popup_sure(text, url) {
            if (confirm(text) == true) {
                window.location = url;
            }
        }

        function checkFilledTextArea() {
            if (document.getElementById('checkField').value.trim() === ""){
                document.getElementById('checkField').value = "";
                alert("Вы не заполнили поле")
                return false
            } else {
                return true
            }
        }
    </script>
</head>
<body>
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
<div class="row header">
    <div class="pull-left header--title-container">
        <!--      <h4 id="header--title">--><?//= $title; ?><!--</h4>-->
        <a href="<?php echo base_url() ?>">
            <img src="<?php echo base_url() . 'public/img/logotype_atmaguru.svg'?>"/>
        </a>
    </div>
    <?php if(@isset($_SESSION['phpback_userid'])): ?>
        <div class="pull-right" style="padding-right:40px;">
            <a href="<?php echo base_url() . 'home/profile/' . $_SESSION['phpback_userid'].'/'.Display::slugify($_SESSION['phpback_username']); ?>">
                <button type="button" class="sub_username_profile_button" style="padding: 10px 25px 10px 25px"><?php echo $_SESSION['phpback_username']; ?></button>
            </a>
            <a href="<?php echo base_url() . 'action/logout'; ?>">
                <button type="button" class="sub_logout_button" style="padding: 10px 25px 10px 25px"><?php echo $lang['label_log_out']; ?></button>
            </a>
        </div>
    <?php else : ?>
        <div class="pull-right" style="padding-right:40px;">
            <a href="<?php echo base_url() . 'home/login'; ?>">
                <button type="button" class="sub_login_button_style" style="padding: 10px 25px 10px 25px"><?php echo $lang['label_log_in']; ?></button>
            </a>
        </div>
    <?php endif; ?>

</div>

<div class="container">
    <div class="row">
