<div class="col-md-9">
	<small><ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>">Обратная связь</a></li>
        <li class="active"><?php echo $lang['label_post_new_idea']; ?></li>
  </ol></small>
	<?php if(@!isset($_SESSION['phpback_userid'])): ?>
	<p class="bg-danger" style="padding-left:20px;padding-top:5px;padding-bottom:5px;"><?php echo $lang['error_login_to_post']; ?></p>
	<?php else: ?>
	<?php if($error != "none"): ?>
	<p class="bg-danger" style="padding-left:20px;padding-top:5px;padding-bottom:5px;"><?php
	switch ($error) {
		case 'errortitle':
			echo $lang['error_title'];
			break;
		case 'errorcat':
			echo $lang['error_category'];
			break;
        case 'errortype':
            echo $lang['error_type'];
            break;
		case 'errordesc':
			echo $lang['error_description'];
			break;
	}?></p>
	<?php endif; ?>
	<form name="post-idea-form" method="post" action="<?php echo base_url() . 'action/newidea'?>">
	  <div class="form-group">
	    <label for="exampleInputEmail1"><?php echo $lang['label_idea_title']; ?></label>
	    <input type="text" class="form-control" name="title" value="<?php if(@isset($POST['title'])) echo $POST['title'];?>" minlength="9" max="100" required>
	  </div>
	  <div class="form-group">
	    <label><?php echo $lang['label_category']; ?></label>
	    <select class="form-control" name="category" required>
		  <option value=""><?php echo $lang['text_select_category']; ?></option>
		  <?php foreach ($categories as $cat):?>
		  <option value="<?php echo $cat->id;?>" <?php if(@isset($POST['catid']) && $POST['catid'] == $cat->id) echo 'selected="selected"';?>><?php echo $cat->name;?></option>
		  <?php endforeach; ?>
		</select>
	  </div>
      <div class="form-group">
          <label><?php echo $lang['label_type']; ?></label>
          <select class="form-control" name="type" required>
              <option value=""><?php echo $lang['text_select_type']; ?></option>
              <?php foreach ($types as $type):?>
                  <option value="<?php echo $type->id;?>" <?php if(@isset($POST['typeid']) && $POST['typeid'] == $type->id) echo 'selected="selected"';?>><?php echo $type->name;?></option>
              <?php endforeach; ?>
          </select>
      </div>
	  <div class="form-group">
	  <label><?php echo $lang['label_description'];?></label>
	    <textarea class="form-control" rows="4" name="description" minlength="20" max="1500" required><?php if(@isset($POST['desc'])) echo $POST['desc'];?></textarea>
	  </div>
      <form method="post" enctype="multipart/form-data" action="<?php echo base_url() . 'action/newidea'?>">
          <label style="
                    padding: 5px 25px 5px 25px;
                    font-size: 15px;
                    border-radius: 35px;
                    color: white;
                    background-color: #2C71F5;
               " for="upload-photo">Выбрать файл</label>
          <input hidden id="upload-photo" style="display: none" type="file" name="file" required>
	        <button type="submit" class="sub_post_idea_button_style pull-right"><?php echo $lang['label_submit'];?></button>
          <div style="width: 100%; height: 1px; background-color: red"></div>
      </form>
	</form>
	<?php endif; ?>
</div>
