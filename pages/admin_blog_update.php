<?php  
/* V1.2
 * 
 * V1.1 : 20130524 : form link fix
 * V1.2 : 20130624 : Major update
 * 
 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	if(!$_SESSION[SITE_ID]['admin_configuration_blog_enabled']) {
		header('Location: index.php');
		exit();
	}
	
	if (!isset($_SESSION[SITE_ID]['connection_id'])) {
		Util::Init();
	}
	
	if(!Util::IsAllowed('admin_blog')) {
		header('Location: '.BASE_LINK.'/pages/not_allowed.php');
		exit();
	}
	
	$id = Util::GetPostValue('id');
	
	if($id == '') {
		header('Location: index.php');
		exit();
	}
	
	try {
		$data = new Data();
		
		$current = $data->BlogGet($id);
		$_REQUEST['blog_active'] = $current[1];
		
		$currentText =  $data->BlogGetText($id);
		$_REQUEST['blog_text_id'] = $currentText[0];
		$_REQUEST['blog_text_lang'] = $currentText[1];
		$_REQUEST['blog_text_title'] = $currentText[2];
		$_REQUEST['blog_text_value'] = $currentText[3];
		
		$firstImage = $data->BlogImageGetFirst($id);
		$imageList = $data->BlogImageGetList($id);
		$tagList = $data->BlogTagGetList($id);
	} catch (DataException $ex) {
		$_REQUEST['message'] = $ex->getMessage();
	}
?>
<?php echo Util::PageGetHtmlTop(); ?>
<HEAD>
<TITLE><?php echo SITE_TITLE; ?></TITLE>
<?php
echo Util::PageGetMeta();
?>
<LINK REL="SHORTCUT ICON" HREF="<?php echo BASE_LINK; ?>/images/ico/favicon.ico">
<LINK REL="STYLESHEET" href="../css/<?php  

$style = $_SESSION[SITE_ID]['admin_configuration_theme'];

echo $style.'.css';

?>" type="text/css"> 
<LINK REL="STYLESHEET" media="handheld , (max-width: 1000px)" href="../css/mobile.css" type="text/css">
<SCRIPT src="<?php echo BASE_LINK; ?>/scripts/jquery-latest.js" type="text/javascript"></SCRIPT>
<SCRIPT src="<?php echo BASE_LINK; ?>/scripts/script.js.php" type="text/javascript"></SCRIPT>
<SCRIPT type="text/javascript">
<?php
echo Util::PageGetDocumentReadyTop();
?>

	var firstImageUpload = document.getElementById("first_image_upload");
	var imageUpload = document.getElementById("image_upload");
	
    //if submit button is clicked
    $('#submit').click(function () {

        var checkProblem = false;
        var missingFields = false;
        //Get the data from all the fields
        var id = $('input[id=id]');
        var blog_active = $('input[id=blog_active]');
        var blog_text_id = $('input[id=blog_text_id]');
        var blog_text_lang = $('input[id=blog_text_lang]');
        var blog_text_title = $('input[id=blog_text_title]');
		var blog_text_value = $('textarea[id=blog_text_value]');
		var blog_active_select = $('select[id=blog_active_select]');
            
        //Simple validation to make sure user entered something
        //If error found, add hightlight class to the text field
        if (blog_active.val()=='') {
        	blog_active_select.addClass('missingvalue');
        	checkProblem = true;
        	missingFields = true;
        } else blog_active_select.removeClass('missingvalue');

        if (missingFields) {
        	$('span[id=message]').html('<?php echo MISSING_FIELDS_ERROR; ?>');
            $('div[id=notification]').show();
        }
        
        if (checkProblem) {
            return false;
        }
        
        //organize the data properly
        var data = 'id=' + id.val() + '&blog_active=' + blog_active.val() + '&blog_text_id=' + blog_text_id.val() +'&blog_text_lang=' + blog_text_lang.val() +
        		   '&blog_text_title='  + blog_text_title.val() + '&blog_text_value=' + encodeURIComponent(blog_text_value.val().replace(/\n/g, "<br>"));
       
        //show the loading sign
        //TO_DO
        //start the ajax
        $.ajax({
            //this is the php file that processes the data and send mail
            url: "_admin_blog_update.php",
            //GET method is used
            type: "GET",
            //pass the data        
            data: data,
            //Do not cache the page
            cache: false,
            //success
            success: function (html) {
                $('span[id=message]').html(html);
                $('div[id=notification]').show();
            }
        });
        //cancel the submit button default behaviours
        return false;
    });

  	//if delete button is clicked
    $('#delete').click(function () {
        
        //Get the data from all the fields
        var id = $('input[id=id]');
        var blog_text_title = $('input[id=blog_text_title]');
		var blog_text_value = $('textarea[id=blog_text_value]');
        var blog_active_select = $('select[id=blog_active_select]');
        var blog_text_lang_select = $('select[id=blog_text_lang_select]');

		var answer = confirm("<?php echo BLOG_DELETE_QUESTION; ?>");
		
        if (!answer) {
            return false;
        }
        
        //organize the data properly
        var data = 'id=' + id.val();
       
        //show the loading sign
        //TO_DO
        //start the ajax
        $.ajax({
            //this is the php file that processes the data and send mail
            url: "_admin_blog_delete.php",
            //GET method is used
            type: "GET",
            //pass the data        
            data: data,
            //Do not cache the page
            cache: false,
            //success
            success: function (html) {
                $('span[id=message]').html(html);
                $('div[id=notification]').show();

                blog_active_select.attr('disabled', 'disabled');
                blog_text_lang_select.attr('disabled', 'disabled');
                blog_text_title.attr('disabled', 'disabled');
                blog_text_value.attr('disabled', 'disabled');
                
                $('#submit').attr('disabled', 'disabled');
                $('#delete').attr('disabled', 'disabled');
            }
        });
        //cancel the submit button default behaviours
        return false;
    });

    firstImageUpload.addEventListener("change", function (evt) {
    	var id = $('input[id=id]');
    	$('span[id=message]').html("<?php echo LOADING; ?>");
    	$('div[id=notification]').show();
    	var formdata = new FormData();
 		var i = 0, len = this.files.length, file;
		for ( ; i < len; i++ ) {
			file = this.files[i];
			if (!!file.type.match(/image.*/)) {
				if (formdata) {
					formdata.append("first_image_upload[]", file);
				}
			}
		}
	
		$.ajax({
			url: "_admin_blog_add_image.php?id=" + id.val(),
			type: "POST",
			contentType: 'multipart/form-data',
			data: formdata,
			processData: false,
			contentType: false,
			success: function (html) {
				$('input[id=first_image_id]').val(html);

                var list = document.getElementById("first_image_list");

                var li_list = list.getElementsByTagName('li');
                if (li_list.length > 0) {
                    list.removeChild(li_list[0]);
                }

				$("#first_image_list").append('<li class="image"><img id="' + html + '" src="<?php echo IMAGE_LITTLE_LINK; ?>' + html + '" onClick="javascript:deleteImage(this.id);"></li>');

				$('span[id=message]').html("<?php echo ITEM_IMAGE_LOADED; ?>");
				$('div[id=notification]').show();
			}
		});
	}, false);

    imageUpload.addEventListener("change", function (evt) {
    	var id = $('input[id=id]');
    	$('span[id=message]').html("<?php echo LOADING; ?>");
    	$('div[id=notification]').show();
    	var formdata = new FormData();
		
 		var i = 0, len = this.files.length, file;
	
		for ( ; i < len; i++ ) {
			file = this.files[i];
			
			if (!!file.type.match(/image.*/)) {
				if (formdata) {
					formdata.append("image_upload[]", file);
				}
			}
		}
	
		$.ajax({
			url: "_admin_blog_add_image.php?id=" + id.val(),
			type: "POST",
			contentType: 'multipart/form-data',
			data: formdata,
			processData: false,
			contentType: false,
			success: function (html) {
				if ($('input[id=image_id]').val() == '') {
					$('input[id=image_id]').val(html);
				} else {
					$('input[id=image_id]').val($('input[id=image_id]').val() + ';' + html);
				}

				$("#image_list").append('<li class="image"><img id="' + html + '" src="<?php echo IMAGE_LITTLE_LINK; ?>' + html + '" onClick="javascript:deleteImage(this.id);"></li>');

				$('span[id=message]').html("<?php echo ITEM_IMAGE_LOADED; ?>");
				$('div[id=notification]').show();
			}
		});
	}, false);

    $("#tag_value").bind("keydown", function(l) {
    	if (l.keyCode == 13) {
			$("#tag_button").trigger( "click" );
		}
	});
			
	$("#tag_button").click(function () {
		var id = $('input[id=id]');
		var tag_value = $("input[id=tag_value]");
		var tag_list_value = $("input[id=tag_list_value]");
				
		if (tag_value.val() != '') {

			var data = 'id=' + id.val() + '&tag_value=' + tag_value.val();
		       
	        //start the ajax
	        $.ajax({
	            //this is the php file that processes the data and send mail
	            url: "_admin_blog_add_tag.php",
	            //GET method is used
	            type: "GET",
	            //pass the data        
	            data: data,
	            //Do not cache the page
	            cache: false,
	            //success
	            success: function () {
	            	tag_list_value.val(tag_list_value.val() + ';' + tag_value.val());
	            	$("#tag_list").append('<li class="tag">' + tag_value.val() + '</li>');
	            	tag_value.val("");
	            	$('span[id=message]').html("<?php echo ADMIN_BLOG_TAG_ADDED; ?>");
					$('div[id=notification]').show();
	            }
			});
		}
	});

	$(".tag").click(function () {
		var id = $('input[id=id]');
		var tag_value = $(this).html();

		var data = 'id=' + id.val() + '&tag_value=' + tag_value;
		       
        //start the ajax
        $.ajax({
            //this is the php file that processes the data and send mail
            url: "_admin_blog_delete_tag.php",
            //GET method is used
            type: "GET",
            //pass the data        
            data: data,
            //Do not cache the page
            cache: false,
            //success
            success: function () {
            	location.reload();
            }
		});
	});

<?php
    echo Util::PageGetDocumentReadyBottom();
?>

function updateLangSelect()
{
	var blog_id = $('input[id=id]');
	var blog_text_id = $('input[id=blog_text_id]');
	var blog_text_lang = $('input[id=blog_text_lang]');
	var blog_text_title = $('input[id=blog_text_title]');
	var blog_text_value = $('textarea[id=blog_text_value]');

	var blog_text_lang_new_value = $('select[id=blog_text_lang_select]').val();
	blog_text_lang_new_value = blog_text_lang_new_value.substr(0, blog_text_lang_new_value.indexOf(','));
	
	var data = 'blog_id=' + blog_id.val() + '&blog_text_id=' + blog_text_id.val() 
			 + '&blog_text_lang=' + blog_text_lang.val() + '&blog_text_lang_new_value=' + blog_text_lang_new_value
			 + '&blog_text_title=' + blog_text_title.val() + '&blog_text_value=' + blog_text_value.val().replace(/\n/g, "<br>");
	
	$.ajax({
        //this is the php file that processes the data and send mail
        url: "_admin_blog_save_and_get_text.php",
         
        //GET method is used
        type: "GET",

        //pass the data        
        data: data,    
         
        //Do not cache the page
        cache: false,
         
        //success
        success: function (html) {
            var result = html.split('#');
            if (result.length == 4) {
            	blog_text_id.val(result[0]);
            	blog_text_title.val(result[2]);
            	blog_text_value.val(result[3].replace(/<br>/g, "\n"));
            } else {
            	blog_text_id.val('');
            	blog_text_title.val('');
            	blog_text_value.val('');
            }

            blog_text_lang.val(blog_text_lang_new_value);
        }      
    });
	
};

function deleteImage(image) {
	var data = 'image=' + image;
	 
	$.ajax({
		url: "_admin_blog_delete_image.php",
		type: "GET",
		data: data,
		cache: false,
		success: function (html) {
			var list = document.getElementById(id);
			var imageList = $('input[id=image_id]').val().split(';');
			var newImageList = '';
			
			for (var i = 0; i < imageList.length; i++) {
				if (imageList[i] != image) {
					if (i == 0 ) {
						newImageList = imageList[i];
					} else {
						newImageList = newImageList + ';' + imageList[i];
					}
				}
			}
			
			list.parentNode.parentNode.removeChild(list.parentNode);
			$('input[id=image_id]').val(newImageList);
			$('span[id=message]').html("<?php echo ITEM_IMAGE_DELETED; ?>");
			$('div[id=notification]').show();
		}
	});
	
	return false;
}

function deleteImage(image) {
	var data = 'image=' + image;
	 
	$.ajax({
		url: "_admin_blog_delete_image.php",
		type: "GET",
		data: data,
		cache: false,
		success: function (html) {
			var list = document.getElementById(id);
			
			list.parentNode.parentNode.removeChild(list.parentNode);
			
			$("#first_image_list").append('<li class="no_image"><img src="../images/index/question_little.jpg"></li>');

			$('input[id=first_image_id]').val('');
			$('span[id=message]').html("<?php echo ITEM_IMAGE_DELETED; ?>");
			$('div[id=notification]').show();
		}
	});
	
	return false;
}

</SCRIPT>
</HEAD>
<?php 
echo '<BODY>
'.Util::PageGetBodyTop().'
<div id="content">
<div id="notification"';
if(isset($_REQUEST['message']) && ($_REQUEST['message'] != '')) {
	echo ' style="display:block;"><span id="message">'.$_REQUEST['message'];
} else {
	 echo '><span id="message">';
}

echo '</span><a class="close" href="javascript:void(0)" onclick="$(\'div[id=notification]\').hide();return false;"></a></div>
<div id="title" xmlns:v="http://rdf.data-vocabulary.org/#">
	<ul class="crumb admin_blog_crumb" itemprop="breadcrumb">
		<li typeof="v:Breadcrumb">
			<a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/index.php" title="'.MENU_HOME.'" rel="v:url" property="v:title" >'.MENU_HOME.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin.php" rel="v:url" property="v:title" >'.ADMIN_TITLE.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin_blog.php" rel="v:url" property="v:title" >'.BLOG_LIST_TITLE.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><span class="title"><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin_blog_update.php?id='.$id.'" rel="v:url" property="v:title" >'.BLOG_UPDATE_TITLE.'</A></span> | <a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin_blog_add.php" >'.BLOG_ADD_TITLE.'</A>
		</li>
	</ul>
</div>
<div id="main">
	<form method="POST" action="_admin_blog_update.php">
		<TABLE>
			<TR>
				<TD>
					<TABLE>
						<TR>
							<TD>'.BLOG_ACTIVE.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>';
			
	$active_selected = $_REQUEST['blog_active'];

	echo '<select id="blog_active_select" name="blog_active_select" onChange="javascript:updateSelect(\'blog_active_select\')">';
	echo $data->DisplayBooleanList($active_selected);
	echo '</select>';
			
						echo '</TD>
						</TR>
						<TR>
							<TD class="separator"></TD>
						</TR>
						<TR>
							<TD>'.BLOG_TEXT_LANG.' :</TD>
							<TD class="field_separator"></TD>
							<TD>';
			
	$lang_selected = $_REQUEST['blog_text_lang'];

	echo '<select id="blog_text_lang_select" name="blog_text_lang_select" onChange="javascript:updateLangSelect()">';
	echo $data->ValueTextLangDisplayList($lang_selected);
	echo '</select>';

						echo '</TD>
						</TR>
						<TR>
							<TD class="separator"></TD>
						</TR>
						<TR>
							<TD>'.BLOG_TEXT_TITLE.' :</TD>
							<TD class="field_separator"></TD>
							<TD><INPUT TYPE="text" ID="blog_text_title" NAME="blog_text_title" VALUE="'.$_REQUEST['blog_text_title'].'" STYLE="width:300px" MAXLENGTH="300"></TD>
						</TR>
						<TR>
							<TD class="separator"></TD>
						</TR>
						<TR>
							<TD>'.BLOG_TEXT_VALUE.' :</TD>
							<TD class="field_separator"></TD>
							<TD><textarea cols="60" rows="10" ID="blog_text_value" NAME="blog_text_value">'.str_replace("<br>", "\n", $_REQUEST['blog_text_value']).'</textarea></TD>
						</TR>
					</TABLE>
				<TD>
			</TR>
        	<TR>
        		<TD>
					<TABLE>
						<TR>
							<TD>'.TAG.' :</TD>
							<TD class="field_separator"><INPUT TYPE="text" ID="tag_list_value" NAME="tag_list_value" VALUE="';

	if ($tagList != NULL && (count($tagList) > 0)) {
		foreach($tagList as $tag) {
			echo $tag[0].';';
		}
	}

								echo '" class="hidden"></TD>
							<TD>
								<INPUT TYPE="text" ID="tag_value" NAME="tag_value" VALUE="" class="medium" MAXLENGTH="50">
			        			<input type="button" ID="tag_button" NAME="tag_button" value="'.ADD.'" alt="'.ADD.'" />
							</TD>
        				</TR>
					</TABLE>
				</TD>
			</TR>
            <TR>
        		<TD>
					<TABLE>
						<TR>
							<TD>'.TAG_LIST.' :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<DIV ID="tag_list">';

	if ($tagList != NULL && (count($tagList) > 0)) {
		foreach($tagList as $tag) {
			echo '<li class="tag">'.$tag[0].'</li>';
		}
	}

								echo '</DIV>
							</TD>
        				</TR>
					</TABLE>
				</TD>
			</TR>
		</TABLE>
	<div id="subtitle">
 		<span class="subtitle">'.ITEM_PHOTO_GALLERY.'</span></TD>
	</div>
         <TABLE>
			<TR>
        		<TD>
					<TABLE>
						<TR>
							<TD>'.ITEM_MAIN_PHOTO.' :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<ul id="first_image_list">';
			if ($firstImage != NULL && (count($firstImage) > 1)) {
				echo '<li class="image"><img id="'.$firstImage[1].'.'.$firstImage[2].'" src="'.IMAGE_LITTLE_LINK.$firstImage[1].'.'.$firstImage[2].'" onClick="javascript:deleteImage(this.id);"></li>';
			} else {
				echo '<li class="no_image"><img src="../images/index/question_little.jpg"></li>';
			}
								echo '
								</ul>
			                </TD>
						</TR>
			         </TABLE>
			         <TABLE>
						<TR>
							<TD>
								<TABLE>
									<TR>
										<TD>
											<input type="file" class="file" id="first_image_upload" name="first_image_upload" style="visibility:hidden;width:0px;" />
											<input type="button" onclick="$(\'#first_image_upload\').click();" value="'.UPLOAD_MAIN_IMAGE.'" alt="'.UPLOAD_MAIN_IMAGE.'" />
										</TD>
			        				</TR>
								</TABLE>
							</TD>
						</TR>
        			</TABLE>
			         <TABLE>
						<TR>
							<TD>
								<TABLE>
									<TR>
										<TD>'.ITEM_OTHER_PHOTO.' :</TD>
										<TD class="field_separator"></TD>
										<TD>
								<ul id="image_list">';
			if ($imageList != NULL && (count($imageList) > 0)) {
				foreach($imageList as $image) {
					echo '<li class="image"><img id="'.$image[1].'.'.$image[2].'" src="'.IMAGE_LITTLE_LINK.$image[1].'.'.$image[2].'" onClick="javascript:deleteImage(this.id);"></li>';	
				}
			}
								echo '
								</ul>
						        		</TD>
									</TR>
						         </TABLE>
			        		</TD>
						</TR>
			        	<TR>
							<TD>
								<input type="file" class="file" id="image_upload" name="image_upload" style="visibility:hidden;width:0px;" />
								<input type="button" onclick="$(\'#image_upload\').click();" value="'.UPLOAD_IMAGE.'" alt="'.UPLOAD_IMAGE.'" />
							</TD>
						</TR>
			<TR>
				<TD class="max_separator">
					<input type="hidden" id="id" name="id" value="'.$id.'">
					<input type="hidden" id="blog_active" name="blog_active" value="'.$current[1].'">
					<input type="hidden" id="blog_text_id" name="blog_text_id" value="'.$currentText[0].'">
					<input type="hidden" id="blog_text_lang" name="blog_text_lang" value="'.$currentText[1].'">
					<input type="hidden" id="first_image_id" name="first_image_id" value="';
				if ($firstImage != NULL) {
					echo $firstImage[1].'.'.$firstImage[2];
				}
												echo '">
					<input type="hidden" id="image_id" name="image_id" value="">
				</TD>
			</TR>
			<TR>
				<TD>
					<TABLE class="normal">
						<TR>
							<TD>'.MANDATORY_FIELDS.'</TD>
						</TR>
						<TR>
							<TD>
								<INPUT TYPE="submit" ID="submit" NAME="submit" VALUE="'.BLOG_UPDATE_UPDATE.'" ALT="'.BLOG_UPDATE_UPDATE.'">
								<INPUT TYPE="submit" ID="delete" NAME="delete" VALUE="'.BLOG_DELETE_DELETE.'" ALT="'.BLOG_DELETE_DELETE.'">
								<INPUT TYPE="button" ID="back" NAME="back" VALUE="'.BACK.'" ALT="'.BACK.'" OnClick="javascript:history.back();">
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
		</TABLE>
	</form>
</div></div>'.Util::PageGetBottom().'
</BODY>
</HTML>';

?>