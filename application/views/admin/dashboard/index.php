<div class="row">
    <div class="col-md-10 col-md-offset-1 dashboard-center">
    <nav class="navbar navbar-inverse" role="navigation">
      <div class="navbar-header">
        <div class="logosmall">
          <img src="<?php echo base_url() . 'public/img/logo_small_free.png'?>">
        </div>
      </div>
      <div class="collapse navbar-collapse" id="navbar-collapse-01">
        <ul class="nav navbar-nav">           
          <li class="active"><a href="#">Dashboard</a></li>
          <li><a href="<?php echo base_url() . 'admin/ideas'; ?>">Идеи и комментарии</a></li>
          <?php if($_SESSION['phpback_isadmin'] > 1){?>
          <li><a href="<?php echo base_url() . 'admin/users'; ?>">Управление пользователями</a></li>
          <?php if($_SESSION['phpback_isadmin'] == 3){ ?>
          <li><a href="<?php echo base_url() . 'admin/system'; ?>">Системные настройки</a></li>
          <?php } } ?>
        </ul>
          <p class="navbar-text navbar-right">Авторизован как <span style="color:#27AE60"><?php echo $_SESSION['phpback_username']; ?></span><a href="<?php echo base_url() . 'action/logout'; ?>"><button type="button" class="btn btn-danger btn-xs" style="margin-left:10px;">Выйти</button></a></p>
           
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
