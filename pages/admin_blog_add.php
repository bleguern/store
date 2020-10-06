<?php  
/* V1.1
 * 
 * V1.1 : 20130624 : Major update
 * 
 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	if(!$_SESSION[SITE_ID]['admin_configuration_blog_enabled']) {
		header('Location: '.BASE_LINK.'/pages/index.php');
		exit();
	}
	
	if (!isset($_SESSION[SITE_ID]['connection_id'])) {
		Util::Init();
	}
	
	if(!Util::IsAllowed('admin_blog')) {
		header('Location: '.BASE_LINK.'/pages/not_allowed.php');
		exit();
	}
	
	$data = new Data();
?>
<?php echo Util::PageGetHtmlTop(); ?>
<HEAD>
<TITLE><?php echo SITE_TITLE; ?></TITLE>
<?php
echo Util::PageGetMeta();
?>
<LINK REL="SHORTCUT ICON" HREF="<?php echo BASE_LINK; ?>/images/ico/favicon.ico">
<LINK REL="STYLESHEET" href="<?php  

echo BASE_LINK.'/css/'.$_SESSION[SITE_ID]['admin_configuration_theme'].'.css';

?>" type="text/css"> 
<LINK REL="STYLESHEET" media="handheld , (max-width: 1000px)" href="<?php  

echo BASE_LINK.'/css/mobile.css';

?>" type="text/css">
<SCRIPT src="<?php echo BASE_LINK; ?>/scripts/jquery-latest.js" type="text/javascript"></SCRIPT>
<script src="<?php echo BASE_LINK; ?>/scripts/calendar.js.php" type="text/javascript"></script>
<SCRIPT src="<?php echo BASE_LINK; ?>/scripts/script.js.php" type="text/javascript"></SCRIPT>
<SCRIPT type="text/javascript">
<?php
echo Util::PageGetDocumentReadyTop();
?>

	var firstBlogImageUpload = document.getElementById("first_blog_image_upload");
	var blogImageUpload = document.getElementById("blog_image_upload");

    //if submit button is clicked
    $('#submit').click(function () {

        var checkProblem = false;
        var missingFields = false;
        
        //Get the data from all the fields
        var blog_active = $('input[id=blog_active]');
        var blog_text_lang = $('input[id=blog_text_lang]');
        var blog_text_title = $('input[id=blog_text_title]');
		var blog_text_value = $('textarea[id=blog_text_value]');
		var first_blog_image_id = $('input[id=first_blog_image_id]');
		var blog_image_id = $('input[id=blog_image_id]');
        var blog_active_select = $('select[id=blog_active_select]');
        var blog_text_lang_select = $('select[id=blog_text_lang_select]');
        var tag_list_value = $('input[id=tag_list_value]');
        var tag_value = $('input[id=tag_value]');
            
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
        var data = 'blog_active=' + blog_active.val() + '&blog_text_lang=' + blog_text_lang.val() +
        		   '&blog_text_title='  + blog_text_title.val() + '&blog_text_value=' + encodeURIComponent(blog_text_value.val().replace(/\n/g, "<br>")) +
        		   '&first_blog_image_id=' + first_blog_image_id.val() + '&blog_image_id=' + blog_image_id.val() + '&tag_list_value=' + tag_list_value.val();

        //show the loading sign
        //TO_DO
        //start the ajax
        $.ajax({
            //this is the php file that processes the data and send mail
            url: "<?php echo BASE_LINK; ?>/pages/_admin_blog_add.php",
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
                tag_value.attr('disabled', 'disabled');
                $('#image_upload_button').attr('disabled', 'disabled');
                $('#submit').attr('disabled', 'disabled');
                $('#tag_button').attr('disabled', 'disabled');
            }
        });
        //cancel the submit button default behaviours
        return false;
    });

    firstBlogImageUpload.addEventListener("change", function (evt) {
    	$('span[id=message]').html("<?php echo LOADING; ?>");
    	$('div[id=notification]').show();
    	var formdata = new FormData();
 		var i = 0, len = this.files.length, file;
		for ( ; i < len; i++ ) {
			file = this.files[i];
			if (!!file.type.match(/image.*/)) {
				if (formdata) {
					formdata.append("first_blog_image_upload[]", file);
				}
			}
		}
	
		$.ajax({
			url: "<?php echo BASE_LINK; ?>/pages/_admin_image_add.php?type=blog&is_first=1&id=0",
			type: "POST",
			contentType: 'multipart/form-data',
			data: formdata,
			processData: false,
			contentType: false,
			success: function (html) {
				html = html.split("|");
				
				$('input[id=first_blog_image_id]').val(html[0]);

                var list = document.getElementById("first_blog_image_list");

                var li_list = list.getElementsByTagName('li');
                if (li_list.length > 0) {
                    list.removeChild(li_list[0]);
                }

				$("#first_blog_image_list").append(html[1]);

				$('span[id=message]').html("<?php echo ITEM_IMAGE_LOADED; ?>");
				$('div[id=notification]').show();
			}
		});
	}, false);

    blogImageUpload.addEventListener("change", function (evt) {
    	$('span[id=message]').html("<?php echo LOADING; ?>");
    	$('div[id=notification]').show();
    	var formdata = new FormData();
		
 		var i = 0, len = this.files.length, file;
	
		for ( ; i < len; i++ ) {
			file = this.files[i];
			
			if (!!file.type.match(/image.*/)) {
				if (formdata) {
					formdata.append("blog_image_upload[]", file);
				}
			}
		}
	
		$.ajax({
			url: "<?php echo BASE_LINK; ?>/pages/_admin_image_add.php?type=blog&is_first=0&id=0",
			type: "POST",
			contentType: 'multipart/form-data',
			data: formdata,
			processData: false,
			contentType: false,
			success: function (html) {
				html = html.split("|");
				
				if ($('input[id=blog_image_id]').val() == '') {
					$('input[id=blog_image_id]').val(html[0]);
				} else {
					$('input[id=blog_image_id]').val($('input[id=blog_image_id]').val() + ';' + html[0]);
				}

				$("#blog_image_list").append(html[1]);

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
			tag_list_value.val(tag_list_value.val() + ';' + tag_value.val());
        	$("#tag_list").append('<li class="tag">' + tag_value.val() + '</li>');
        	tag_value.val("");
		}
	});

	$(".tag").click(function () {
		var id = $('input[id=id]');
		var tag_value = $(this).html();
		var tag_list_value = $("input[id=tag_list_value]");

		tag_list_value.val(tag_list_value.val().replace(tag_value + ';', ''));
		$(this).remove();
	});

<?php
    echo Util::PageGetDocumentReadyBottom();
?>

function deleteImage(id, filename) {
	var data = 'id=' + id + 
	   		   '&type=blog' + 
	   		   '&filename=' + filename;
	 
	$.ajax({
		url: "<?php echo BASE_LINK; ?>/pages/_admin_image_delete.php",
		type: "GET",
		data: data,
		cache: false,
		success: function (html) {
			var list = document.getElementById(id);
			var imageList = $('input[id=blog_image_id]').val().split(';');
			var newImageList = '';
			
			for (var i = 0; i < imageList.length; i++) {
				if (imageList[i] != id) {
					if (i == 0 ) {
						newImageList = imageList[i];
					} else {
						newImageList = newImageList + ';' + imageList[i];
					}
				}
			}

			list.parentNode.parentNode.parentNode.removeChild(list.parentNode.parentNode);
			$('input[id=blog_image_id]').val(newImageList);
			$('span[id=message]').html("<?php echo ITEM_IMAGE_DELETED; ?>");
			$('div[id=notification]').show();
		}
	});
	
	return false;
}

function deleteFirstImage(id, filename) {
	var data = 'id=' + id + 
			   '&type=blog' + 
			   '&filename=' + filename;
	 
	$.ajax({
		url: "<?php echo BASE_LINK; ?>/pages/_admin_image_delete.php",
		type: "GET",
		data: data,
		cache: false,
		success: function (html) {
			var list = document.getElementById("first_blog_image_list");

            var li_list = list.getElementsByTagName('li');
            if (li_list.length > 0) {
                list.removeChild(li_list[0]);
            }
			
			$("#first_blog_image_list").append('<li class="no_image"><img src="../images/index/question_little.jpg"></li>');

			$('input[id=first_blog_image_id]').val('');
			$('span[id=message]').html("<?php echo ITEM_IMAGE_DELETED; ?>");
			$('div[id=notification]').show();
		}
	});
	
	return false;
}

function updateImage(button) {
	var checkProblem = false;
    var missingFields = false;
    
	var offset = button.lastIndexOf("_");
	var item_id = button.substr(offset + 1, button.length - offset - 1);

	var image_copyright_link = $('input[id=image_copyright_link_' + item_id + ']');
	var image_copyright_title = $('input[id=image_copyright_title_' + item_id + ']');
	var image_copyright_date = $('input[id=image_copyright_date_' + item_id + ']');

    if (image_copyright_title.val()=='') {
    	image_copyright_title.addClass('missingvalue');
        checkProblem = true;
    	missingFields = true;
    } else image_copyright_title.removeClass('missingvalue');

    if (missingFields) {
    	$('span[id=message]').html('<?php echo MISSING_FIELDS_ERROR; ?>');
        $('div[id=notification]').show();
    }
    
    if (checkProblem) {
        return false;
    }

    var data = 'id=' + item_id + 
   	 		   '&type=blog' +
	   		   '&image_copyright_link=' + image_copyright_link.val() + 
	 		   '&image_copyright_title=' + image_copyright_title.val() + 
	 		   '&image_copyright_date=' + image_copyright_date.val();
	
    $.ajax({
        //this is the php file that processes the data and send mail
        url: "<?php echo BASE_LINK; ?>/pages/_admin_image_update.php",
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
			<a href="'.BASE_LINK.'/pages/index.php" title="'.MENU_HOME.'" rel="v:url" property="v:title" >'.MENU_HOME.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><a href="'.BASE_LINK.'/pages/admin.php" rel="v:url" property="v:title" >'.ADMIN_TITLE.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><a href="'.BASE_LINK.'/pages/admin_blog.php" rel="v:url" property="v:title" >'.BLOG_LIST_TITLE.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><span class="title"><a href="'.BASE_LINK.'/pages/admin_blog_add.php" rel="v:url" property="v:title" >'.BLOG_ADD_TITLE.'</A></span>
		</li>
	</ul>
</div>
<div id="main">
	<form method="POST" action="_admin_blog_add.php">
		<TABLE>
			<TR>
				<TD>
					<TABLE>
						<TR>
							<TD>'.BLOG_ACTIVE.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>';
			
	$active_selected = '1';

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
			
	$lang_selected = LANG;

	echo '<select id="blog_text_lang_select" name="blog_text_lang_select" onChange="javascript:updateSelect(\'blog_text_lang_select\')">';
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
							<TD><INPUT TYPE="text" ID="blog_text_title" NAME="blog_text_title" VALUE="" STYLE="width:300px" MAXLENGTH="300"></TD>
						</TR>
						<TR>
							<TD class="separator"></TD>
						</TR>
						<TR>
							<TD>'.BLOG_TEXT_VALUE.' :</TD>
							<TD class="field_separator"></TD>
							<TD><textarea cols="60" rows="10" ID="blog_text_value" NAME="blog_text_value"></textarea></TD>
						</TR>
					</TABLE>
				<TD>
			</TR>
        	<TR>
        		<TD>
					<TABLE>
						<TR>
							<TD>'.TAG.' :</TD>
							<TD class="field_separator"><INPUT TYPE="text" ID="tag_list_value" NAME="tag_list_value" VALUE="" class="hidden"></TD>
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
								<DIV ID="tag_list"></DIV>
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
								<ul id="first_blog_image_list">
									<li class="no_image"><img src="../images/index/question_little.jpg"></li>
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
											<input type="file" class="file" id="first_blog_image_upload" name="first_blog_image_upload" style="visibility:hidden;width:0px;" />
											<input type="button" id="first_blog_image_upload_button" onclick="$(\'#first_blog_image_upload\').click();" value="'.UPLOAD_MAIN_IMAGE.'" alt="'.UPLOAD_MAIN_IMAGE.'" />
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
											<ul id="blog_image_list">
					
											</ul>
					        			</TD>
									</TR>
						         </TABLE>
			        		</TD>
						</TR>
			        	<TR>
							<TD>
						<input type="file" class="file" id="blog_image_upload" name="blog_image_upload" style="visibility:hidden;width:0px;" />
						<input type="button" id="blog_image_upload_button" onclick="$(\'#blog_image_upload\').click();" value="'.UPLOAD_IMAGE.'" alt="'.UPLOAD_IMAGE.'" />
					</TD>
			</TR>
			<TR>
				<TD class="max_separator">
					<input type="hidden" id="blog_active" name="blog_active" value="'.$active_selected.'">
					<input type="hidden" id="blog_text_lang" name="blog_text_lang" value="'.$lang_selected.'">
					<input type="hidden" id="first_blog_image_id" name="first_blog_image_id" value="">
					<input type="hidden" id="blog_image_id" name="blog_image_id" value="">
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
								<INPUT TYPE="submit" ID="submit" NAME="submit" VALUE="'.BLOG_ADD_ADD.'" ALT="'.BLOG_ADD_ADD.'">
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