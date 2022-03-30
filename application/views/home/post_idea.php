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
        case 'largefile':
            echo $lang['error_large_file'];
            break;
        case 'errorfiletype':
            echo $lang['error_type_uploaded_file'];
            break;
	}?></p>
	<?php endif; ?>
	<form name="post-idea-form" enctype="multipart/form-data" method="post" action="<?php echo base_url() . 'action/newidea'?>">
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
        <label id="upload-label" style="display: none"><?php echo $lang['uploaded_files']; ?></label>
        <div class="upload-filename" style="
            width: 100%; min-height: 50px;
            border: solid 2px #bdc3c7; border-radius: 6px;
            flex-direction: column; padding: 8px 12px;
            margin-bottom: 20px; display: none;">

        </div>
        <label style="
                padding: 5px 25px 5px 25px;
                font-size: 15px;
                border-radius: 35px;
                color: white;
                background-color: #2C71F5;
           " for="upload-photo">Выбрать файл</label>
        <input multiple class="upload-file-type" hidden id="upload-photo" style="display: none" type="file" name="file[]">
        <button type="submit" class="sub_post_idea_button_style pull-right"><?php echo $lang['label_submit'];?></button>
    </form>
	<?php endif; ?>
</div>

<script>
    let count = 0;
    let imageElements = [];

    // function removeElement(id){
    //     let imageDeleteElement = document.getElementById("image-item-" + id);
    //     imageDeleteElement.parentNode.removeChild(imageDeleteElement);
    //     imageElements.pop();
    //
    //     let markedElement = document.getElementById('upload-photo');
    //     markedElement.files[1].name
    //
    //     let inputObject = document.querySelector(".upload-filename");
    //     let uploadLabel = document.querySelector("#upload-label");
    //
    //     if (imageElements.length > 0){
    //         inputObject.style.setProperty("display", "flex");
    //         uploadLabel.style.removeProperty("display");
    //     } else {
    //         uploadLabel.style.setProperty("display", "none");
    //         inputObject.style.setProperty("display", "none")
    //     }
    //
    //     console.log(markedElement.files)
    // }

    document.getElementById('upload-photo').addEventListener('change', function(){
        if( this.value ){
            for (let i = 0; i < imageElements.length; i++){
                let removeElement = document.getElementById(imageElements[i])
                removeElement.parentNode.removeChild(removeElement)
            }

            imageElements = [];
            count = 0;

            console.log(this.files)

            for (let i = 0; i < this.files.length; i++){
                imageElements.push("image-item-" + (i + 1));
            }

            let inputObject = document.querySelector(".upload-filename");
            let uploadLabel = document.querySelector("#upload-label");

            if (imageElements.length > 0){
                inputObject.style.setProperty("display", "flex")
                uploadLabel.style.removeProperty("display");
            } else {
                uploadLabel.style.setProperty("display", "none");
                inputObject.style.setProperty("display", "none")
            }

            for (let j = 0; j < this.files.length; j++) {
                let innerSpanElement = document.createElement("div");
                count += 1;
                innerSpanElement.setAttribute("id", "image-item-" + count)

                innerSpanElement.style.cssText = "display: flex; justify-content: space-between; align-items: center";

                innerSpanElement.innerHTML = "<span>" + this.files[j].name + "</span>";

            // <div id='delete-button-" + count + "'" +
            //     "style='display: flex; justify-content: center; align-items: center; width: 25px;" +
            //     " height: 25px; background-color: #ec7063; border-radius: 100px'><img style='width: 12px; height: 12px' src='http://symfserver.jord/public/img/delete_cross.png'></div>

                inputObject.append(innerSpanElement);
            }
        }
    });
</script>