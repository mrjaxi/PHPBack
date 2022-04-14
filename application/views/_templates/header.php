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
        var Search = {
            order: '',
            type: '',
            page: '',
            types: Array(),
            status: Array()
        }
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
        function saveFormSearch(order='date', type='desc', page='1', types=[], status=[]) {
            Search['order'] = order;
            Search['type'] = type;
            Search['page'] = page;
            Search['types'] = types;
            Search['status'] = status;
            console.log("order:"+ Search['order'] + "\ntype:" + Search['type'] + "\npage:" + Search['page'] + "\ntypes:" + JSON.stringify(Search['types']) + "\nstatus:" + JSON.stringify(Search['status']))
        }
        function editSearchParam(param, value) {
            switch(param){
                case 'order':
                case 'type':
                case 'page':
                    Search[param] = value;
                    break;
            }
            console.log("order:"+ Search['order'] + "\ntype:" + Search['type'] + "\npage:" + Search['page'] + "\ntypes:" + JSON.stringify(Search['types']) + "\nstatus:" + JSON.stringify(Search['status']))
        }
        function editSearchArr(param, id, checked, value) {
            // alert(id)
            // id = Number(id)
            switch(param) {
                case 'types':
                    if (checked == false) {
                        delete Search['types'][Search['types'].indexOf(value)]
                        console.log(JSON.stringify(Search['types']))
                    } else {
                        Search['types'].push(value)
                    }
                    break;
                case 'status':
                    if (checked == false) {
                        delete Search['status'][Search['status'].indexOf(value)]
                        console.log(JSON.stringify(Search['status']))
                    } else {
                        Search['status'].push(value)
                    }
                    break;
            }
            console.log("types:" + JSON.stringify(Search['types']) + "\nstatus:" + JSON.stringify(Search['status']))
            // console.log(Object.values(Search['types']))
        }
        function objectifyForm(formArray) {
            var returnArray = {};
            for (var i = 0; i < formArray.length; i++){
                returnArray[formArray[i]['name']] = formArray[i]['value'];
            }
            return returnArray;
        }
        function buildGetSearch(order, type, page) {
            const params = new URLSearchParams({
                'order': order==null ? Search['order'] : order,
                'type':  type==null ? Search['type'] : type,
                'page':  page==null ? Search['page'] : page,
                'types': JSON.stringify(Object.values(Search['types'])),
                'status': JSON.stringify(Object.values(Search['status']))
            })
            const str = params.toString();
            return str;
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
