<div class="row">
    <div class="col-md-10 col-md-offset-1 dashboard-center">
    <nav style="background-color: #ffffff" class="navbar navbar-inverse" role="navigation">
      <div class="navbar-header">
        <div class="logosmall">
          <img src="<?php echo base_url() . 'public/img/logotype_atmaguru.svg'?>">
        </div>
      </div>
      <div style="margin-top: 7px" class="collapse navbar-collapse" id="navbar-collapse-01">
        <ul class="nav navbar-nav">           
          <li class="active"><a href="#">Панель управления</a></li>
          <li><a href="<?php echo base_url() . 'admin/ideas'; ?>">Идеи и комментарии</a></li>
          <?php if($_SESSION['phpback_isadmin'] > 1){?>
          <li><a href="<?php echo base_url() . 'admin/users'; ?>">Управление пользователями</a></li>
          <?php if($_SESSION['phpback_isadmin'] == 3){ ?>
          <li><a href="<?php echo base_url() . 'admin/system'; ?>">Системные настройки</a></li>
          <?php } } ?>
        </ul>
          <p class="navbar-text navbar-right">Авторизован как
              <a href="<?php echo base_url() . 'home/profile/' . $_SESSION['phpback_userid'].'/'.Display::slugify($_SESSION['phpback_username']); ?>">
                  <button class="sub_admin_name_button">
                      <?php echo $_SESSION['phpback_username']; ?>
                  </button>
              </a>
              <a href="<?php echo base_url() . 'action/logout'; ?>">
                  <button type="button" class="sub_admin_logout_button">Выйти</button>
              </a>
          </p>
      </div><!-- /.navbar-collapse -->
    </nav><!-- /navbar -->
    <div class="row">
      <table class="table table-condensed" style="font-size:15px;width:80%;margin-left:10%;">
            <thead>
            <tr>
              <th>Журнал</th>
              <th>Дата</th>
            </tr>
         </thead>
          <tbody>
            <?php foreach ($logs as $log): ?>
            <tr>
            <td><?php echo $log->content; ?></td>
            <td><?php echo $log->date; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
  </div>
</div>
</div>
  </body>
  </html>
