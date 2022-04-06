<div class="row">
    <div class="col-md-10 col-md-offset-1 dashboard-center">
    <nav style="background-color: #ffffff" class="navbar navbar-inverse" role="navigation">
      <div class="navbar-header">
          <a href="<?php echo base_url() ?>">
            <div class="logosmall">
                <img src="<?php echo base_url() . 'public/img/logotype_atmaguru.svg'?>">
            </div>
          </a>
      </div>
      <div style="margin-top: 7px" class="collapse navbar-collapse" id="navbar-collapse-01">
        <ul class="nav navbar-nav">
          <li><a href="<?php echo base_url() . 'admin'; ?>">Панель управления</a></li>
          <li><a href="<?php echo base_url() . 'admin/ideas'; ?>">Идеи и комментарии</a></li>
          <li class="active"><a href="<?php echo base_url() . 'admin/users'; ?>">Управление пользователями</a></li>
          <?php if($_SESSION['phpback_isadmin'] == 3){ ?>
          <li><a href="<?php echo base_url() . 'admin/system'; ?>">Системные настройки</a></li>
          <?php } ?>
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
    <div>
      <h5>Управление пользователями</h5>
      <ul class="nav nav-tabs">
        <li id="table1" class="active"><a onclick="showtable2('newuserstable','table1');">Новые пользователи</a></li>
        <li id="table2"><a onclick="showtable2('bannedtable','table2');">Список заблокированных </a></li>
        <li id="table3"><a onclick="showtable2('bantable','table3');">Заблокировать</a></li>
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
                    <a href="<?php echo base_url() . 'admin/users/' . $user->id; ?>"><button type="submit" style="
                                        font-size: 15px;
	                                    color: #ffffff;
	                                    background-color: #ec7063;
	                                    padding: 8px 13px 8px 13px;
	                                    border: solid 1px #ec7063;
                                        border-radius: 20px">Заблокировать</button></a>
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
                    <a href="<?php echo base_url() . 'adminaction/unban/' . $user->id;?>"><button type="submit" style="font-size: 15px;
	                                    color: #ffffff;
	                                    background-color: #f1c40f;
	                                    padding: 8px 13px 8px 13px;
	                                    border: solid 1px #f1c40f;
                                        border-radius: 20px">Разбанить</button></a>
                  </div>
              </td>
            </tr>
              <?php endforeach; ?>
          </tbody>
        </table>
      <div id="bantable" style="display:none">
          <form role="form" method="post" action="<?php echo base_url() . 'adminaction/banuser'?>">
            <div class="form-group">
              <label>ID Пользователя</label>
              <input type="text" class="form-control" name="id" value="<?php if(isset($idban)) echo $idban;?>" style="width:130px" maxlength="9">
            </div>
            <div class="form-group">
              <label>Срок блокировки в днях</label>
              <input type="text" class="form-control" name="days" style="width:100px" maxlength="4"> (0 для блокировки навсегда)
            </div>
            <div class="form-group">
              <button name="banuser"type="submit" style="font-size: 15px;
                                                        color: #ffffff;
                                                        background-color: #ec7063;
                                                        padding: 8px 25px 8px 25px;
                                                        border: solid 1px #ec7063;
                                                        border-radius: 20px">Заблокировать</button>
            </div>
          </form>
      </div>
</div>
</div>
</div>
  </body>
  </html>
