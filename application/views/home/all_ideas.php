<?php
function buildGet($order='date', $type='desc', $page='1', $types=array(), $status=array()){
    $arr = [
        'order' => $order,
        'type' => $type,
        'page' => $page,
        'types' => $types,
        'status' => $status
    ];
    return http_build_query($arr);
}
?>
<div class="col-md-9">
    <?php echo  "<script>saveFormSearch(" . "'$order','$type','$page'," . json_encode($typesdata) . ',' . json_encode($status) . ")</script>"; ?>

    <div class="breadcrumb-wrapper"><ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Обратная связь</a></li>
            <li class="active"><?php echo $category->name; ?></li>
        </ol></div>
    <div>
        <h5 style="color:#2C3E50;"><?php echo $category->name; ?></h5>
        <span style="color:#34495E"><small><?php echo $category->description; ?></small></span>
    </div>

    <table id="ideastable" class="table table-condensed">
        <thead>
        <tr>
            <th><small><?php echo $lang['label_votes']; ?>
                    <a id="order-by--votes" href="#" onClick="redirect('<?php echo $category->url."?"?>'+buildGetSearch('votes','<?php echo ($type == 'desc' && $order == 'votes') ? 'asc' : 'desc'; ?>',<?php echo 1; ?>)); return false;">
                        <span class="glyphicon glyphicon-chevron-<?php echo ($type == 'desc' && $order == 'votes') ? 'down' : 'up'; ?>" style="margin-left:4px"></span>
                    </a>
                </small>
            </th>
            <th><small><?php echo $lang['label_title']; ?>
                    <a id="order-by--idea" href="#" onClick="redirect('<?php echo $category->url."?"?>'+buildGetSearch('title','<?php echo ($type == 'desc' && $order == 'title') ? 'asc' : 'desc'; ?>',<?php echo 1; ?>)); return false;">
                        <span class="glyphicon glyphicon-chevron-<?php echo ($type == 'desc' && $order == 'title') ? 'down' : 'up'; ?>" style="margin-left:4px"></span>
                    </a>
                </small>
            </th>
            <th><small><?php echo $lang['label_date'];  ?>
                    <a id="order-by--date" href="#" onClick="redirect('<?php echo $category->url."?"?>'+buildGetSearch('date','<?php echo ($type == 'desc' && $order == 'date') ? 'asc' : 'desc'; ?>',<?php echo 1; ?>)); return false;">
                        <span class="glyphicon glyphicon-chevron-<?php echo ($type == 'desc' && $order == 'date') ? 'down' : 'up'; ?>" style="margin-left:4px"></span>
                    </a>
                </small>
            </th>
            <th>
                <div class="dropdown">
                    <a style="color: black;font-size: 83%;line-height: 2.067;" href="#" data-toggle="dropdown" >Типы <span class="caret"></span></a>

                    <ul class="dropdown-menu" style="background-color: #fff; box-shadow: 0 0 3px">
                        <li class="dropdown-header">Выберите типы</li>
                        <div class="form-group" style="margin: 5px">
                            <?php foreach ($types as $t): ?>
                                <label class="checkbox">
                                    <input onchange="editSearchArr('types', this.id, this.checked, '<?php echo $t->id ?>')" type="checkbox" <?php $s = 'type-' . $t->id; if($form[$s]){ echo "checked='checked'"; } ?> id="<?php echo $t->id ?>" name="type-<?php echo $t->id;?>" data-toggle="checkbox">
                                    <?php echo $t->name; //editSearchArr('status', this.id, this.checked, <?php echo $t->id) ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                        <li role="separator" class="divider"></li>
                        <li><a style="color: black" href="<?php echo $category->url?>">Сбросить</a></li>
                        <li><a style="color: black" onClick="redirect('<?php echo $category->url."?"?>'+buildGetSearch(null,null,null)); return false;" href="#" >Применить</a></li>
                    </ul>
                </div>
            </th>
            <th>
                <div class="dropdown">
                    <a style="color: black;font-size: 83%;line-height: 2.067;" href="#" data-toggle="dropdown" >Статусы <span class="caret"></span></a>

                    <ul class="dropdown-menu" style="background-color: #fff; box-shadow: 0 0 3px">
                        <li class="dropdown-header">Выберите статусы</li>
                        <div class="form-group" style="margin: 5px">
                            <label class="checkbox">
                                <input onchange="editSearchArr('status', this.id, this.checked, 'completed')" type="checkbox" <?php if($form['status-completed']){ echo "checked='checked'"; } ?> id="<?php echo array_search("completed", $status) ?: 0 ?>" name="status-completed" data-toggle="checkbox">
                                Завершено
                            </label>
                            <label class="checkbox">
                                <input onchange="editSearchArr('status', this.id, this.checked, 'started')" type="checkbox" <?php if($form['status-started']){ echo "checked='checked'"; } ?> id="<?php echo array_search("started", $status) ?: 1 ?>" name="status-started"  data-toggle="checkbox">
                                Начато
                            </label>
                            <label class="checkbox">
                                <input onchange="editSearchArr('status', this.id, this.checked, 'planned')" type="checkbox" <?php if($form['status-planned']){ echo "checked='checked'"; } ?> id="<?php echo array_search("planned", $status) ?: 2 ?>" name="status-planned"  data-toggle="checkbox">
                                Планируется
                            </label>
                            <label class="checkbox">
                                <input onchange="editSearchArr('status', this.id, this.checked, 'considered')" type="checkbox" <?php if($form['status-considered']){ echo "checked='checked'"; }?> id="<?php echo array_search("considered", $status) ?: 3 ?>" name="status-considered" data-toggle="checkbox">
                                На рассмотрении
                            </label>
                            <label class="checkbox">
                                <input onchange="editSearchArr('status', this.id, this.checked, 'declined')" type="checkbox" <?php if($form['status-declined']){ echo "checked='checked'"; }?> id="<?php echo array_search("declined", $status) ?: 4 ?>" name="status-declined" data-toggle="checkbox">
                                Отклонено
                            </label>
                        </div>
                        <li role="separator" class="divider"></li>
                        <li><a style="color: black" href="<?php echo $category->url?>">Сбросить</a></li>
                        <li><a style="color: black" onClick="redirect('<?php echo $category->url."?"?>'+buildGetSearch(null,null,null)); return false;" href="#">Применить</a></li>
                    </ul>
                </div>
            </th>
        </tr>
        </thead>
    </table>

    <?php foreach ($ideas as $idea): ?>
        <div class="row">
            <div class="col-xs-4 col-sm-2">
                <div class="vote-count-box">
						<span style="color:#3498DB;"><b class="result-idea--votes">
						<?php if($idea->votes <= 99999) {
                            if($idea->votes < 1000) echo $idea->votes;
                            else echo number_format($idea->votes);
                        } elseif($idea->votes < 1000000){
                            echo (int) ($idea->votes / 1000); echo "K";
                        } else {
                            $t = (int) ($idea->votes / 1000000);
                            echo $t;
                            if((int) ($idea->votes / 100000) - $t*10 > 0)
                                echo "," . (((int) ($idea->votes / 100000)) - $t*10);
                            echo "M";
                        }?>
						</b></span>
                    <br><div style="margin-top:-10px;font-size:14px"><?php echo num_word($idea->votes, array('Голос','Голоса','Голосов'),false); ?></div>
                </div>
                <div class="vote-label">
						<span class="label label-<?php
                        switch ($idea->status) {
                            case 'considered':
                                echo 'default';
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
                        ?> result-idea--status" style="font-size:12px"><?php
                            switch ($idea->status) {
                                case 'considered':
                                    echo $lang['idea_considered'];
                                    break;
                                case 'declined':
                                    echo $lang['idea_declined'];
                                    break;
                                case 'started':
                                    echo $lang['idea_started'];
                                    break;
                                case 'planned':
                                    echo $lang['idea_planned'];
                                    break;
                                case 'completed':
                                    echo $lang['idea_completed'];
                                    break;
                            }
                            ?></span>
                </div>
            </div>
            <div class="col-xs-8 col-sm-10">
                <span class="label label-info result-idea--status" style="font-size:12px; margin-right: 10px">
                    <?php foreach ($types as $t){
                        if($t->id == $idea->typeid){
                            echo $t->name;
                            break;
                        }
                    } ?>
                </span>
                <a class="result-idea--title" href="<?= $idea->url;?>"><?= $idea->title; ?></a>
                <div style="margin-top:-10px">
                    <small class="result-idea--description">
                        <?php
                        if(strlen($idea->content) > 200){
                            echo substr($idea->content, 0, 200);
                            echo "...";
                        }
                        else{
                            echo $idea->content;
                        }
                        ?>
                    </small>
                </div>
                <div style="margin-top:-10px">
                    <ul class="nav-pills" style="list-style:none;margin-left:-40px">
                        <li><small class="result-idea--comments"><?php echo num_word($idea->comments, array('Комментарий', 'Комментария', 'Комментариев')); ?></small></li>
                        <li><small class="result-idea--comments"><?php echo " | " . datetotext($idea->date, $lang, true); ?></small></li>
                    </ul><br><br>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <ul class="pagination">
        <li><a class="pagination--previous" <?php if($page > 1) echo "onClick=\"redirect('".$category->url."?'"."+buildGetSearch(null,null,". ($page-1) . ")); return false;\""?> href="#">&laquo;</a></li>
        <?php for($i=1;$i<=$pages;$i++){ ?>
            <?php if($i == $page): ?>
                <li class="active"><a class="pagination--current" href=""><?php echo $i;?></a></li>
            <?php else:?>
                <li><a class="pagination--page" onClick="redirect('<?php echo $category->url."?"?>'+buildGetSearch(null,null,<?php echo $i?>)); return false;" href="#"><?php echo $i;?></a></li>
            <?php endif;?>

        <?php } ?>
        <li><a class="pagination--next" <?php if($page < $pages) echo "onClick=\"redirect('".$category->url."?'"."+buildGetSearch(null,null,". ($page+1) .")); return false;\""?> href="#">&raquo;</a></li>
    </ul>
</div>
