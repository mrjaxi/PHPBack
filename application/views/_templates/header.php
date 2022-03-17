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
    <link href="<?= base_url(); ?>public/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="<?= base_url(); ?>public/bootstrap/css/prettify.css" rel="stylesheet">

    <!-- Loading Flat UI -->
    <link href="<?= base_url(); ?>public/css/flat-ui.css" rel="stylesheet">
    <!-- <link href="<?= base_url(); ?>public/css/demo.css" rel="stylesheet"> -->

    <!-- Loading custom styles-->
    <link href="<?php echo base_url(); ?>public/css/all.css" rel="stylesheet">

  <script type="text/javascript">
  function showtable(tableid, tablelink){
      document.getElementById('activitytable').style.display = 'none';
      document.getElementById('ideastable').style.display = 'none';
      document.getElementById('commentstable').style.display = 'none';
      document.getElementById(tableid).style.display = '';
      document.getElementById("table1").className = "";
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
      }
  }
  </script>
</head>
<body>
  <div class="row header">
    <div class="pull-left header--title-container">
<!--      <h4 id="header--title">--><?//= $title; ?><!--</h4>-->
        <img src="<?php echo base_url() . 'public/img/logotype_atmaguru.svg'?>"/>
    </div>
    <?php if(@isset($_SESSION['phpback_userid'])): ?>
    <div class="pull-right" style="padding-right:40px;">
        <a href="<?php echo base_url() . 'home/profile/' . $_SESSION['phpback_userid'].'/'.Display::slugify($_SESSION['phpback_username']); ?>">
            <button type="button" class="sub_username_profile_button"><?php echo $_SESSION['phpback_username']; ?></button>
        </a>
          <a href="<?php echo base_url() . 'action/logout'; ?>">
            <button type="button" class="sub_logout_button"><?php echo $lang['label_log_out']; ?></button>
          </a>
    </div>
    <?php else : ?>
    <div class="pull-right" style="padding-right:40px;">
      <a href="<?php echo base_url() . 'home/login'; ?>">
          <button type="button" class="sub_login_button_style"><?php echo $lang['label_log_in']; ?></button>
      </a>
    </div>
    <?php endif; ?>

  </div>
  
  <div class="container">
  <div class="row">
