<div class="col-md-9" xmlns:color="http://www.w3.org/1999/xhtml">
    <div class="breadcrumb-wrapper"><ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Обратная связь</a></li>
            <li><a href="<?php echo base_url() . 'home/type/' . $idea->typeid . "/" . str_replace(" ", "-", $types[$idea->typeid]->name); ?>"><?php echo $types[$idea->typeid]->name;?></a></li>
            <li><a href="<?php echo base_url() . 'home/category/' . $idea->categoryid . "/" . str_replace(" ", "-", $categories[$idea->categoryid]->name); ?>"><?php echo $categories[$idea->categoryid]->name;?></a></li>
            <li class="active"><?php echo $idea->title; ?></li>
        </ol></div>

    <div class="row">
        <div class="col-xs-12 col-sm-2">
            <div class="vote-count-box view-idea-vote" style="min-width: 110px"">
            <span style="color:#3498DB;margin-top:-10px">
						<b><?php if($idea->votes <= 99999) {
                                if($idea->votes < 1000) echo $idea->votes;
                                else echo number_format($idea->votes);
                            } elseif($idea->votes < 1000000){
                                echo (int) ($idea->votes / 1000); echo "k";
                            } else {
                                echo (int) ($idea->votes / 1000000);
                                $t = (int) ($idea->votes / 1000000);
                                if((int) ($idea->votes / 100000) - $t*10 > 0)
                                    echo "," . (((int) ($idea->votes / 100000)) - $t*10);
                                echo "m";
                            }?>
							</b></span><br>
            <div style="margin-top:-10px"><small><?php echo num_word($idea->votes, array('Голос', 'Голоса', 'Голосов'), false)?></small></div>
        </div>
        <?php if(!($user_is_vote > 0)  && $idea->status != "completed" && $idea->status != 'declined'): ?>
            <a style="display: flex; margin-top: 10px; min-width: 110px; padding: 0;height: 40px;justify-content: center; align-items: center" href="<?php echo base_url() . "action/vote/1/" . $idea->id;?>" class="btn btn-primary">
                <img style="filter: invert(100%) sepia(100%) saturate(7%) hue-rotate(156deg) brightness(104%) contrast(102%); width: 20px;height: 20px" src="<?php echo base_url() . "public/img/thumbs-up.png" ?>" />
            </a>
        <?php endif; ?>
        <?php if($user_is_vote > 0 && $idea->status != "completed" && $idea->status != 'declined'): ?>
            <a style="display: flex; margin-top: 10px; min-width: 110px; padding: 0; height: 40px;justify-content: center; align-items: center; background-color:#e74c3c" href="<?php echo base_url() . "action/unvote/".$user_is_vote."/idea";?>" class="btn btn-primary">
                <img style="filter: invert(100%) sepia(100%) saturate(7%) hue-rotate(156deg) brightness(104%) contrast(102%); width: 20px;height: 20px" src="<?php echo base_url() . "public/img/thumbs-down.png" ?>" />
            </a>
        <?php endif; ?>
    </div>
    <div class="col-xs-12 col-sm-10">
        <h6 style="overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;"><?php echo $idea->title; ?></h6>
        <span style="overflow-wrap: break-word;word-wrap: break-word;word-break: break-word; style="color:#34495E"><small><?php echo $idea->content; ?></small></span>
        <?php if($idea->photo !== null && count(explode(";", $idea->photo)) != 1 ): ?>
            <div id="carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <?php for ($i = 0; $i < count(explode(";", $idea->photo)); $i++): ?>
                        <div style="background-color: black" class="item <?php if ($i == 1): echo "active" ?><?php endif; ?>">
                            <a href="<?php echo base_url() . explode(";", $idea->photo)[$i] ?>" data-lightbox="image-<?php echo $i ?>">
                                <div style="
                                        background-image: url('<?php echo base_url() . explode(";", $idea->photo)[$i] ?>');
                                        background-repeat: no-repeat;
                                        background-size: contain;
                                        background-position: center;
                                        width: 100%;
                                        height: 400px">
                                </div>
                            </a>
                        </div>
                    <?php endfor; ?>
                </div>
                <!-- Элементы управления -->
                <a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Предыдущий</span>
                </a>
                <a class="right carousel-control" href="#carousel" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Следующий</span>
                </a>
            </div>
            <!--            <a href="http://symfserver.jord/public/photo/f8b6c662cedfe8c8cead02e97723ba6d.png" data-lightbox="roadtrip">Image #2</a>-->
        <?php endif; ?>
        <?php if($idea->photo !== null && count(explode(";", $idea->photo)) == 1 ): ?>
            <div style="background-color: black" class="item active">
                <a href="<?php echo base_url() . $idea->photo ?>" data-lightbox="image-1">
                    <div style="
                            background-image: url('<?php echo base_url() . $idea->photo ?>');
                            background-repeat: no-repeat;
                            background-size: contain;
                            background-position: center;
                            width: 100%;
                            height: 400px">
                    </div>
                </a>
            </div>
        <?php endif; ?>
        <div>
            <small><span style="margin-top: 15px" class="glyphicon glyphicon-user"></span> <a href="<?php echo base_url() . 'home/profile/' . $idea->authorid . '/' . str_replace(" ", "-", $idea->user); ?>"><?php echo $idea->user; ?></a> <i><?php echo $lang['text_shared_this_idea']; ?></i> <span style='color:#555;margin-left:30px;'><?php echo $idea->date; ?></span></small>
            <?php if(!empty($idea->href) && isset($_SESSION['phpback_isadmin']) && $_SESSION['phpback_isadmin']) {
                echo "<br><small>Отправлено из: <a href='{$idea->href}'> {$idea->href} </a></small>";
            }?>
            <ul class="nav-pills" style="list-style:none;margin-left:-40px">
                <li style="padding-right:10px"><span class="label label-<?php
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
                        case 'new':
                            echo 'default';
                            break;
                    }
                    ?>"><small><?php
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
                                case 'new':
                                    echo $lang['idea_new'];
                                    break;
                            }
                            ?></small></span></li>
                <li style="padding-right:10px"><small><?php echo num_word($idea->comments, array('Комментарий', 'Комментария', 'Комментариев')); ?></small></li>
                <li style="padding-right:10px"><a href="<?php echo base_url() . 'home/category/' . $idea->categoryid . '/' . str_replace(" ", "-", $categories[$idea->categoryid]->name); ?>"><small><?php echo $categories[$idea->categoryid]->name;?></small></a></li>
            </ul>
        </div>
    </div>
</div>

<?php if(isset($_SESSION['phpback_isadmin']) && $_SESSION['phpback_isadmin']): ?>
    <div class="row" style="margin-top: 10px; margin-bottom: 10px">
        <div class="col-md-10 col-md-offset-2">
            <ul class="nav-pills" style="list-style:none;margin-left:-40px;">
                <li>
                    <?php if($idea->status == 'new'): ?>
                        <a href="<?php echo base_url() . 'adminaction/approveidea/' . $idea->id; ?>"><button type="submit" class="btn btn-success btn-sm" style="width:130px; border-radius: 20px"><?php echo $lang['label_idea_approve']; ?></button></a>
                    <?php else: ?>
                        <div class="dropdown">
                            <button class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" style="width:130px;border-radius: 20px"><?php echo $lang['label_change_status']; ?></button>
                            <span class="dropdown-arrow dropdown-arrow-inverse"></span>
                            <ul class="dropdown-menu dropdown-inverse">
                                <?php if($idea->status != 'declined'): ?>
                                    <li><a href="<?php echo base_url() . "adminaction/ideastatus/declined/" . $idea->id;?>"><?php echo $lang['idea_declined']; ?></a></li>
                                <?php endif; ?>
                                <?php if($idea->status != 'considered'): ?>
                                    <li><a href="<?php echo base_url() . "adminaction/ideastatus/considered/" . $idea->id;?>"><?php echo $lang['idea_considered']; ?></a></li>
                                <?php endif; ?>
                                <?php if($idea->status != 'planned'): ?>
                                    <li><a href="<?php echo base_url() . "adminaction/ideastatus/planned/" . $idea->id;?>"><?php echo $lang['idea_planned']; ?></a></li>
                                <?php endif; ?>
                                <?php if($idea->status != 'started'): ?>
                                    <li><a href="<?php echo base_url() . "adminaction/ideastatus/started/" . $idea->id;?>"><?php echo $lang['idea_started']; ?></a></li>
                                <?php endif; ?>
                                <?php if($idea->status != 'completed'): ?>
                                    <li><a href="<?php echo base_url() . "adminaction/ideastatus/completed/" . $idea->id;?>"><?php echo $lang['idea_completed']; ?></a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </li>
                <li>
                    <button type="submit" class="btn btn-danger btn-sm" style="width:130px; border-radius: 20px;margin-left: 5px" <?php $temp = base_url() . 'adminaction/deleteidea/' . $idea->id;?> onclick="popup_sure('<?php echo $lang['text_sure_delete_idea']; ?>','<?php echo $temp; ?>');"><?php echo $lang['label_delete_idea']; ?></button>
                </li>
                <li>
                    <a href="<?php echo base_url() . 'admin/users/' . $idea->authorid; ?>" target="_blank"><button type="submit" class="btn btn-danger btn-sm" style="width:130px; border-radius: 20px;margin-left: 5px"><?php echo $lang['label_ban_user']; ?></button></a>
                </li>

            </ul>
        </div>
    </div>
<?php endif; ?>

<?php foreach ($comments as $comment) : ?>
    <div class="row">
        <div id="comment<?php echo $comment->id; ?>" class="col-md-10 col-md-offset-2">
            <div class="comment-box">
                <span class="glyphicon glyphicon-comment" style="margin-right:5px"></span>
                <a href="<?php echo base_url() . 'home/profile/' . $comment->userid . '/' . str_replace(" ", "-", $comment->user); ?>"><?php echo $comment->user; ?></a>
                <span style="margin-left:15px;color:#555"><?php echo $comment->date; ?></span>
                <span style="margin-left:15px;margin-right:5px">
							<?php if(isset($_SESSION['phpback_isadmin']) && $_SESSION['phpback_isadmin']): ?>
                                <?php $temp = base_url() . 'adminaction/deletecomment/' . $comment->id; ?>
                                <a style="color:#E25F5F" href="#" onclick="popup_sure('<?php echo $lang['text_sure_delete_comment']; ?>','<?php echo $temp; ?>');"><i><small><?php echo $lang['label_delete_comment']; ?></small></i></a>
                            <?php else: ?>
                                <a style="color:#E25F5F" href="<?php echo base_url() . 'action/flag/'. $comment->id . '/' . $idea->id . '/' . str_replace(" ", "-", $idea->title);?>"><i><small><?php echo $lang['text_flag_comment']; ?></small></i></a>
                            <?php endif;?>
							</span>
                <div style="overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;" class="comment-text">
                    <?php echo $comment->content;?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php if(isset($_SESSION['phpback_userid'])): ?>
    <div class="row">
        <div class="col-md-10 col-md-offset-2" style="margin-top:10px">
            <form role="form" method="post" action="<?php echo base_url() . 'action/comment/' . $idea->id; ?>" onsubmit="return checkFilledTextArea()" >
                <div class="form-group">
                    <label>Оставить комментарий</label>
                    <textarea id="checkField" class="form-control" rows="4" name="content"></textarea>
                </div>
                <input type="hidden" name="ideaname" value="<?php echo str_replace(" ", "-", $idea->title); ?>">
                <button id="buttonSend" type="submit" name="commentbutton" class="btn btn-default" style="background-color: #2C71F5"><?php echo $lang['label_submit']; ?></button>
            </form>
        </div>
    </div>
<?php endif; ?>
</div>

<script src="<?= base_url(); ?>public/js/lightbox/js/lightbox-plus-jquery.js"></script>
<script src="<?= base_url(); ?>public/js/lightbox/js/lightbox.js"></script>
<script>
    lightbox.option({
        'resizeDuration': 150,
        'wrapAround': true
    })
</script>