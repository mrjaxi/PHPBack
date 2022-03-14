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
          <li><a href="<?php echo base_url() . 'admin'; ?>">Панель управления</a></li>
          <li><a href="<?php echo base_url() . 'admin/ideas'; ?>">Идеи и комментарии</a></li>
          <li class="active"><a href="<?php echo base_url() . 'admin/users'; ?>">Управление пользователями</a></li>
          <?php if($_SESSION['phpback_isadmin'] == 3){ ?>
          <li><a href="<?php echo base_url() . 'admin/system'; ?>">Системные настройки</a></li>
          <?php } ?>
        </ul>
          <p class="navbar-text navbar-right">Авторизован как <span style="color:#27AE60"><?php echo $_SESSION['phpback_username']; ?></span><a href="<?php echo base_url() . 'action/logout'; ?>"><button type="button" class="btn btn-danger btn-xs" style="margin-left:10px;">Выйти</button></a></p>

      </div><!-- /.navbar-collapse -->
    </nav><!-- /navbar -->
    <div>
      <h5>Управление пользователями</h5>
      <ul class="nav nav-tabs">
        <li id="table1" class="active"><a onclick="showtable2('newuserstable','table1');">Новые пользователи</a></li>
        <li id="table2"><a onclick="showtable2('bannedtable','table2');">Список заблокированных </a></li>
        <li id="table3"><a onclick="showtable2('bantable','table3');">Заблокировать пользователя</a></li>
      </ul>
        <table id="newuserstable" class="table table-condensed" style="">
          <thead>
                <tr>
                  <th>ID</th>
                  <th>Имя</th>
                  <th>Email</th>
                  <th>Голосов</th>
                  <th></th>
                </tr>
            </thead>
              <tbody>
            <?php foreach ($users as $user): ?>
              <?php $freename = Display::slugify($user->name); ?>
            <tr>
              <td>
                <a href="<?php echo base_url() . 'home/profile/' . $user->id. '/' . $freename; ?>" target="_blank">#<?php echo $user->id;?></a>
              </td>
              <td>
                <?php echo $user->name; ?>
              </td>
              <td>
                <?php echo $user->email; ?>
              </td>
              <td>
                <?php echo $user->votes; ?>
              </td>
              <td>
                  <div class="pull-right">
                    <a href="<?php echo base_url() . 'admin/users/' . $user->id; ?>"><button type="submit" class="btn btn-danger btn-sm" style="width:130px">Заблокировать пользователя</button></a>
                  </div>
              </td>
            </tr>
              <?php endforeach; ?>
          </tbody>
        </table>
        <table id="bannedtable" class="table table-condensed" style="display:none">
          <thead>
                <tr>
                  <th>ID</th>
                  <th>Имя</th>
                  <th>Email</th>
                  <th>До (d/m/y)</th>
                  <th></th>
                </tr>
            </thead>
              <tbody>
            <?php foreach ($banned as $user): ?>
              <?php $freename = str_replace(" ", "-", $user->name); ?>
            <tr>
              <td>
                <a href="<?php echo base_url() . 'home/profile/' . $user->id . '/' . $freename; ?>" target="_blank">#<?php echo $user->id;?></a>
              </td>
              <td>
                <?php echo $user->name; ?>
              </td>
              <td>
                <?php echo $user->email; ?>
              </td>
              <td>
                <?php
                  if($user->banned == -1) echo "Banned indefinitely.";
                  else{
                    $d = $user->banned % 100;
                    $m = ((int) ($user->banned / 100)) % 100;
                    $y = (int)($user->banned / 10000);
                    echo "Banned until $d/$m/$y";
                  }
                ?>
              </td>
              <td>
                  <div class="pull-right">
                    <a href="<?php echo base_url() . 'adminaction/unban/' . $user->id;?>"><button type="submit" class="btn btn-warning btn-sm" style="width:130px">Разбанить</button></a>
                  </div>
              </td>
            </tr>
              <?php endforeach; ?>
          </tbody>
        </table>
      <div id="bantable" style="display:none">
          <form role="form" method="post" action="<?php echo base_url() . 'adminaction/banuser'?>">
            <div class="form-group">
              <label>User ID</label>
              <input type="text" class="form-control" name="id" value="<?php if(isset($idban)) echo $idban;?>" style="width:130px" maxlength="9">
            </div>
            <div class="form-group">
              <label>Срок запрета в днях</label>
              <input type="text" class="form-control" name="days" style="width:100px" maxlength="4"> (0 for indefinitely ban)
            </div>
            <div class="form-group">
              <button name="banuser"type="submit" class="btn btn-primary">Заблокировать</button>
            </div>
          </form>
      </div>
</div>
</div>
</div>
  </body>
  </html>
