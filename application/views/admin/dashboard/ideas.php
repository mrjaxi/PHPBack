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
                    <li class="active"><a href="<?php echo base_url() . 'admin/ideas'; ?>">Идеи и комментарии</a></li>
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
        <div>
            <h5>Идеи и комментарии</h5>
            <ul class="nav nav-tabs">
                <li id="table1" class="active"><a onclick="showtable('newideastable','table1');">Новые идеи <span class="badge"><?php echo $newideas_num;?></span></a></li>
                <li id="table2"><a onclick="showtable('allideastable','table2');">Все идеи </a></li>
                <li id="table3"><a onclick="showtable('commentstable','table3');">Выбрать комментарий</a></li>
            </ul>
            <div id="listing">
                <table id="newideastable" class="table table-condensed" style="">
                    <thead>
                    <tr>
                        <th>Идея</th>
                        <th>Тип</th>
                        <th>Категория</th>
                        <th>Комментарии</th>
                        <th>Голоса</th>
                        <th>Дата</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($newideas as $idea): ?>
                        <?php $freename = Display::slugify($idea->title); ?>
                        <tr class="<?php
                        switch ($idea->status) {
                            case 'considered':
                                echo 'active';
                                break;
                            case 'declined':
                                echo 'danger';
                                break;
                            case 'started':
                                echo 'success';
                                break;
                            case 'planned':
                                echo 'warning';
                                break;
                            case 'completed':
                                echo 'info';
                                break;
                        }
                        ?>">
                            <td>
                                <a href="<?php echo base_url() . 'home/idea/' . $idea->id . "/" . $freename;?>" target="_blank"><?php echo $idea->title; ?></a>
                            </td>
                            <td>
                                <?php echo $types[$idea->typeid]->name; ?>
                            </td>
                            <td>
                                <?php echo $categories[$idea->categoryid]->name; ?>
                            </td>
                            <td><?php echo num_word($idea->comments, array('Комментарий', 'Комментария', 'Комментариев')); ?>
                            </td>
                            <td>
                                <?php echo num_word($idea->votes, array('Голос', 'Голоса', 'Голосов')); ?>
                            </td>
                            <td>
                                <?php echo datetotext($idea->date, $lang, true); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <div id="allideastable" class="row" style="display:none" >
                    <div class="col-md-4">
                        <form role="form" method="post" action="<?php echo base_url() . 'admin/ideas';?>">
                            <input type="hidden" name="search" value="1">
                            <table>
                                <thead>
                                <tr>
                                    <td>
                                        <label>Статус</label>
                                    </td>
                                    <td>
                                        <label>Категории</label>
                                    </td>
                                    <td>
                                        <label>Типы</label>
                                    </td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label class="checkbox">
                                                <input type="checkbox" <?php if($form['status-completed']): ?>checked="checked" <?php endif; ?> name="status-completed" data-toggle="checkbox">
                                                Завершено
                                            </label>
                                            <label class="checkbox">
                                                <input type="checkbox" <?php if($form['status-started']): ?>checked="checked" <?php endif; ?> name="status-started"  data-toggle="checkbox">
                                                Начато
                                            </label>
                                            <label class="checkbox">
                                                <input type="checkbox" <?php if($form['status-planned']): ?>checked="checked" <?php endif; ?> name="status-planned"  data-toggle="checkbox">
                                                Планируется
                                            </label>
                                            <label class="checkbox">
                                                <input type="checkbox" <?php if($form['status-considered']): ?>checked="checked" <?php endif; ?> name="status-considered" data-toggle="checkbox">
                                                На рассмотрении
                                            </label>
                                            <label class="checkbox">
                                                <input type="checkbox" <?php if($form['status-declined']): ?>checked="checked" <?php endif; ?> name="status-declined" data-toggle="checkbox">
                                                Отклонено
                                            </label>
                                        </div>
                                    </td>
                                    <td style="padding-left:10px;width:250px;vertical-align:top">
                                        <div class="form-group">
                                            <?php foreach ($categories as $category): ?>
                                                <label class="checkbox">
                                                    <input type="checkbox" <?php $s = 'category-' . $category->id; if($form[$s]): ?>checked="checked" <?php endif; ?> name="category-<?php echo $category->id;?>" data-toggle="checkbox">
                                                    <?php echo $category->name; ?>
                                                </label>
                                            <?php endforeach; ?>
                                        </div>
                                    </td>
                                    <td style="padding-left:10px;width:250px;vertical-align:top">
                                        <div class="form-group">
                                            <?php foreach ($types as $type): ?>
                                                <label class="checkbox">
                                                    <input type="checkbox" <?php $s = 'type-' . $type->id; if($form[$s]): ?>checked="checked" <?php endif; ?> name="type-<?php echo $type->id;?>" data-toggle="checkbox">
                                                    <?php echo $type->name; ?>
                                                </label>
                                            <?php endforeach; ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <select class="form-control" name="orderby">
                                            <option value="votes">Порядок по голосам</option>
                                            <option value="id" <?php if($form['orderby'] == 'id') echo 'selected=""';?> >Порядок по дате</option>
                                            <option value="title" <?php if($form['orderby'] == 'title') echo 'selected=""';?>>Порядок по названию</option>
                                        </select>
                                    </td>
                                    <td style="padding-left:10px;">
                                        <label class="checkbox">
                                            <input type="checkbox" <?php if($form['isdesc']) echo 'checked=""';?> name="isdesc" data-toggle="checkbox">
                                            Упорядочение по убыванию
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top:5px;padding-bottom:10px">
                                        <button type="submit" class="btn btn-primary" style="width:160px">Поиск</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                    <div class="col-md-7">
                        <table class="table table-condensed" style="font-size:15px;width:100%">
                            <thead>
                            <tr>
                                <th>Идея</th>
                                <th>Тип</th>
                                <th>Категория</th>
                                <th>Голосов</th>
                                <th>Дата</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($ideas as $idea): ?>
                                <?php $freename = Display::slugify($idea->title); ?>
                                <tr class="<?php
                                switch ($idea->status) {
                                    case 'considered':
                                        echo 'active';
                                        break;
                                    case 'declined':
                                        echo 'danger';
                                        break;
                                    case 'started':
                                        echo 'success';
                                        break;
                                    case 'planned':
                                        echo 'warning';
                                        break;
                                    case 'completed':
                                        echo 'info';
                                        break;
                                }
                                ?>">
                                    <td>
                                        <a href="<?php echo base_url() . 'home/idea/' . $idea->id . "/" . $freename;?>" target="_blank"><?php echo $idea->title; ?></a>
                                    </td>
                                    <td>
                                        <?php echo $types[$idea->typeid]->name; ?>
                                    </td>
                                    <td>
                                        <?php echo $categories[$idea->categoryid]->name; ?>
                                    </td>
                                    <td>
                                        <?php echo num_word($idea->votes, array('Голос', 'Голоса', 'Голосов')); ?>
                                    </td>
                                    <td>
                                        <?php echo datetotext($idea->date, $lang, true); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <table id="commentstable" class="table table-condensed" style="display:none;font-size:15px;">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Комментарий</th>
                        <th>Выбран</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($flags as $comment) : ?>
                        <tr>
                            <td>
                                Комментарий: #<?php echo $comment['id'];?>
                                <br>Пользователь:
                                <a href="<?php echo base_url() . 'admin/users/' . $comment['userid'];?>">#<?php echo $comment['userid'];?></a>
                                <br>Идея:
                                <a href="<?php echo base_url() . 'home/idea/' . $comment['ideaid'];?>" target="_blank">#<?php echo $comment['userid'];?></a>
                            </td>
                            <td>
                                <samp>
                                    <?php echo $comment['content'];?>
                                </samp>
                            </td>
                            <td>
                    <span style="font-size:17px;">Выбран <span class="badge"><?php echo $comment['votes']; ?></span><span style="font-size:17px;"> раз</span>
                    <div class="pull-right">
                      <button name="Delete votes" type="submit" class="btn btn-warning btn-sm" style="min-width:130px" <?php $temp = base_url() . 'adminaction/deletecomment/' . $comment['id']; ?> onclick="popup_sure('Вы уверены, что хотите удалить этот комментарий?','<?php echo $temp; ?>');">Удалить комментарий</button>
                      <?php if($_SESSION['phpback_isadmin'] > 1): ?><a href="<?php echo base_url() . 'admin/users/' . $comment['userid']; ?>"><button type="submit" class="btn btn-danger btn-sm" style="width:130px">Заблокировать</button></a><?php endif;?>
                    </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>
