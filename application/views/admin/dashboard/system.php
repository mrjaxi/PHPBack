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
                    <li><a href="<?php echo base_url() . 'admin'; ?>">Панель управления</a></li>
                    <li><a href="<?php echo base_url() . 'admin/ideas'; ?>">Идеи и комментарии</a></li>
                    <li><a href="<?php echo base_url() . 'admin/users'; ?>">Управление пользователями</a></li>
                    <li class="active"><a href="<?php echo base_url() . 'admin/system'; ?>">Системные настройки</a></li>
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
            <h5>Системные настройки</h5>
            <ul class="nav nav-tabs">
                <li id="table1" class="active"><a onclick="showtable3('generaltable','table1');">Общие настройки</a></li>
                <li id="table2"><a onclick="showtable3('admintable','table2');">Создать администратора</a></li>
                <li id="table3"><a onclick="showtable3('categorytable','table3');">Категории</a></li>
                <li id="table4"><a onclick="showtable3('typetable','table4');">Типы</a></li>
                <li id="table5"><a onclick="showtable3('upgradetable','table5');">Обновить версию</a></li>
            </ul>
            <div id="generaltable">
                <form role="form" method="post" action="<?php echo base_url() . 'adminaction/editsettings'?>">
                    <?php foreach ($settings as $setting): ?>
                        <div class="form-group">
                            <label><?php echo $setting->name ?></label>
                            <input type="text" class="form-control" name="setting-<?php echo $setting->id; ?>" value="<?php echo $setting->value; ?>" style="width:300px">
                        </div>
                    <?php endforeach; ?>
                    <div class="form-group">
                        <button name="submit-changes" type="submit" class="btn btn-primary">Принять изменения</button>
                    </div>
                </form>
            </div>
            <div id="admintable" style="display:none">
                <table class="table table-condensed" style="">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>Email</th>
                        <th>Уровень администратора</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($adminusers as $user): ?>
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
                                <?php echo $user->isadmin; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <form role="form" method="post" action="<?php echo base_url() . 'adminaction/editadmin'?>">
                    <div class="form-group">
                        <label>ID пользователя</label>
                        <input type="text" class="form-control" name="id" style="width:300px">
                    </div>
                    <div class="form-group">
                        <label>Уровень администратора</label>
                        <select class="form-control" name="level" style="width:300px">
                            <option value="0">Нет прав администрирования</option>
                            <option value="1">Идеи и комментарии (уровень 1)</option>
                            <option value="2">Уровень 1 + управление пользователями (Уровень 2)</option>
                            <option value="3">Полные права администрирования (Уровень 3)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button name="submit-create-admin" type="submit" class="btn btn-primary">Принять изменения</button>
                    </div>
                </form>
            </div>
            <div id="upgradetable" style="display:none">
                <div class="alert alert-<?php echo ($isLastVersion) ? 'success' : 'warning'; ?>" role="alert">Вы используете PHPBack v<?php echo $version; ?><br />
                    <?php if($isLastVersion): ?>
                        Вы используете последнюю версию PHPBack.
                    <?php else: ?>
                        Пожалуйста, обновите PHPBack до версии v<?php echo $lastVersion; ?><br /><br />
                        <a href="<?php echo base_url(); ?>adminaction/upgrade" class="btn btn-primary">Обновить</a><br />
                        <span style="font-size:13px;">(это может занять некоторое время)</span>
                    <?php endif;?>
                    <br /><br />
                    Пожалуйста, посетите <a href="http://www.phpback.org/" target="_blank">PHPBack.org</a> для большей информации.
                </div>
            </div>
            <div id="categorytable" style="display:none">
                <h4>Добавить новую категорию</h4>
                <form role="form" method="post" action="<?php echo base_url() . 'adminaction/addcategory'?>">
                    <div class="form-group">
                        <label>Название категории</label>
                        <input type="text" class="form-control" name="name" style="width:300px">
                        <small>(поместить название существующей категории, чтобы изменить ее описание)</small>
                    </div>
                    <div class="form-group">
                        <label>Описание категории</label>
                        <textarea class="form-control" name="description" style="width:300px"></textarea>
                    </div>
                    <div class="form-group">
                        <button name="add-category" type="submit" class="btn btn-primary">Добавить категорию</button>
                    </div>
                </form>
                <h4>Удалить категорию</h4>
                <form role="form" method="post" action="<?php echo base_url() . 'adminaction/deletecategory'?>">
                    <div class="form-group">
                        <label>Выбрать категорию для удаления</label>
                        <select class="form-control" name="catid" style="width:300px">
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo $cat->id; ?>"><?php echo $cat->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label name="delete-ideas" class="checkbox" for="checkbox1">
                            <input type="checkbox" value="" id="checkbox1" name="ideas" data-toggle="checkbox">
                            Удалить идеи категории
                        </label>
                    </div>
                    <div class="form-group">
                        <button name="delete-category" type="submit" class="btn btn-primary">Удалить категорию</button>
                    </div>
                </form>
                <h4>Изменить название</h4>
                <form role="form" name="update-form" method="post" action="<?php echo base_url() . 'adminaction/updatecategories'?>">
                    <?php foreach ($categories as $cat): ?>
                        <div class="form-group">
                            <input type="text" class="form-control" name="category-<?php echo $cat->id;?>" style="width:300px" value="<?php echo $cat->name;?>">
                        </div>
                    <?php endforeach; ?>
                    <div class="form-group">
                        <button name="update-names" type="submit" class="btn btn-primary">Изменить название</button>
                    </div>
                </form>
            </div>
            <div id="typetable" style="display:none">
                <h4>Добавить новый Тип</h4>
                <form role="form" method="post" action="<?php echo base_url() . 'adminaction/addtype'?>">
                    <div class="form-group">
                        <label>Название Типа</label>
                        <input type="text" class="form-control" name="name" style="width:300px">
                        <small>(поместить название существующего типа, чтобы изменить его описание)</small>
                    </div>
                    <div class="form-group">
                        <label>Описание Типа</label>
                        <textarea class="form-control" name="description" style="width:300px"></textarea>
                    </div>
                    <div class="form-group">
                        <button name="add-type" type="submit" class="btn btn-primary">Добавить Тип</button>
                    </div>
                </form>
                <h4>Удалить Тип</h4>
                <form role="form" method="post" action="<?php echo base_url() . 'adminaction/deletetype'?>">
                    <div class="form-group">
                        <label>Выбрать Тип для удаления</label>
                        <select class="form-control" name="typeid" style="width:300px">
                            <?php foreach ($types as $type): ?>
                                <option value="<?php echo $type->id; ?>"><?php echo $type->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label name="delete-ideas" class="checkbox" for="checkbox1">
                            <input type="checkbox" value="" id="checkbox1" name="ideas" data-toggle="checkbox">
                            Удалить идеи типа
                        </label>
                    </div>
                    <div class="form-group">
                        <button name="delete-type" type="submit" class="btn btn-primary">Удалить Тип</button>
                    </div>
                </form>
                <h4>Изменить название</h4>
                <form role="form" name="update-form" method="post" action="<?php echo base_url() . 'adminaction/updatetypes'?>">
                    <?php foreach ($types as $type): ?>
                        <div class="form-group">
                            <input type="text" class="form-control" name="type-<?php echo $type->id;?>" style="width:300px" value="<?php echo $type->name;?>">
                        </div>
                    <?php endforeach; ?>
                    <div class="form-group">
                        <button name="update-names" type="submit" class="btn btn-primary">Изменить название</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
