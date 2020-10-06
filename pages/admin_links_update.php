<?php  
/* V1.1
 * 
 * V1.1 : 20130624 : Major update
 * 
 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	if (!isset($_SESSION[SITE_ID]['connection_id'])) {
		Util::Init();
	}
	
	if(!Util::IsAllowed('admin_links')) {
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
		
		$current = $data->LinksGet($id);
		$_REQUEST['links_active'] = $current[1];
		$_REQUEST['links_link'] = $current[2];
		$_REQUEST['links_title'] = $current[3];
		$_REQUEST['links_image_number'] = $current[4];
		$_REQUEST['links_image_type'] = $current[5];
		
		$currentText =  $data->LinksGetText($id);
		$_REQUEST['links_text_id'] = $currentText[0];
		$_REQUEST['links_text_lang'] = $currentText[1];
		$_REQUEST['links_text_value'] = $currentText[2];
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

	var imageUpload = document.getElementById("image_upload");
	
    //if submit button is clicked
    $('#submit').click(function () {

    	var checkProblem = false;
        var missingFields = false;
        //Get the data from all the fields
        var id = $('input[id=id]');
        var links_active = $('input[id=links_active]');
        var links_link = $('input[id=links_link]');
        var links_title = $('input[id=links_title]');
        var links_text_id = $('input[id=links_text_id]');
        var links_text_lang = $('input[id=links_text_lang]');
		var links_text_value = $('textarea[id=links_text_value]');
		var image_id = $('input[id=image_id]');
        var links_active_select = $('select[id=links_active_select]');
            
        //Simple validation to make sure user entered something
        //If error found, add hightlight class to the text field
        if (links_active.val()=='') {
        	links_active_select.addClass('missingvalue');
        	checkProblem = true;
        	missingFields = true;
        } else links_active_select.removeClass('missingvalue');

        if (links_link.val()=='') {
        	links_link.addClass('missingvalue');
        	checkProblem = true;
        	missingFields = true;
        } else links_link.removeClass('missingvalue');

        if (links_title.val()=='') {
        	links_title.addClass('missingvalue');
        	checkProblem = true;
        	missingFields = true;
        } else links_title.removeClass('missingvalue');

        if (missingFields) {
        	$('span[id=message]').html('<?php echo MISSING_FIELDS_ERROR; ?>');
            $('div[id=notification]').show();
        }
        
        if (checkProblem) {
            return false;
        }
        
        //organize the data properly
        var data = 'id=' + id.val() + '&links_active=' + links_active.val() + '&links_link='  + encodeURIComponent(links_link.val()) + '&links_title='  + links_title.val() + '&links_text_id=' + links_text_id.val() +'&links_text_lang=' + links_text_lang.val() +
        		   '&links_text_value=' + encodeURIComponent(links_text_value.val().replace(/\n/g, "<br>")) +
        		   '&image_id=' + image_id.val();
       
        //show the loading sign
        //TO_DO
        //start the ajax
        $.ajax({
            //this is the php file that processes the data and send mail
            url: "_admin_links_update.php",
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
        var links_link = $('input[id=links_link]');
        var links_title = $('input[id=links_title]');
		var links_text_value = $('textarea[id=links_text_value]');
        var links_active_select = $('select[id=links_active_select]');
        var links_text_lang_select = $('select[id=links_text_lang_select]');

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
            url: "_admin_links_delete.php",
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

                links_active_select.attr('disabled', 'disabled');
                links_link.attr('disabled', 'disabled');
                links_title.attr('disabled', 'disabled');
                links_text_lang_select.attr('disabled', 'disabled');
                links_text_value.attr('disabled', 'disabled');
                
                $('#submit').attr('disabled', 'disabled');
                $('#delete').attr('disabled', 'disabled');
            }
        });
        //cancel the submit button default behaviours
        return false;
    });

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
			url: "_admin_links_add_image.php?id=" + id.val(),
			type: "POST",
			contentType: 'multipart/form-data',
			data: formdata,
			processData: false,
			contentType: false,
			success: function (html) {
				$('input[id=image_id]').val(html);

                var list = document.getElementById("image_list");

                var li_list = list.getElementsByTagName('li');
                if (li_list.length > 0) {
                    list.removeChild(li_list[0]);
                }

				$("#image_list").append('<li><img id="' + html + '" src="<?php echo IMAGE_LITTLE_LINK; ?>' + html + '" onClick="javascript:deleteImage(this.id);"><img src="../images/index/delete_little.jpg" alt="<?php echo DELETE; ?>"></li>');

				$('span[id=message]').html("<?php echo BLOG_IMAGE_LOADED; ?>");
                $('div[id=notification]').show();
			}
		});
	}, false);

<?php
    echo Util::PageGetDocumentReadyBottom();
?>

function updateLangSelect()
{
	var links_id = $('input[id=id]');
	var links_text_id = $('input[id=links_text_id]');
	var links_text_lang = $('input[id=links_text_lang]');
	var links_text_value = $('textarea[id=links_text_value]');

	var links_text_lang_new_value = $('select[id=links_text_lang_select]').val();
	links_text_lang_new_value = links_text_lang_new_value.substr(0, links_text_lang_new_value.indexOf(','));
	
	var data = 'links_id=' + links_id.val() + '&links_text_id=' + links_text_id.val() 
			 + '&links_text_lang=' + links_text_lang.val() + '&links_text_lang_new_value=' + links_text_lang_new_value
			 + '&links_text_value=' + links_text_value.val().replace(/\n/g, "<br>");
	
	$.ajax({
        //this is the php file that processes the data and send mail
        url: "_admin_links_save_and_get_text.php",
         
        //GET method is used
        type: "GET",

        //pass the data        
        data: data,    
         
        //Do not cache the page
        cache: false,
         
        //success
        success: function (html) {
            var result = html.split('#');
            if (result.length == 3) {
            	links_text_id.val(result[0]);
            	links_text_value.val(result[2].replace(/<br>/g, "\n"));
            } else {
            	links_text_id.val('');
            	links_text_value.val('');
            }

            links_text_lang.val(links_text_lang_new_value);
        }
    });
	
};

function deleteImage(image) {
	var data = 'image=' + image;
	 
	$.ajax({
		url: "_admin_links_delete_image.php",
		type: "GET",
		data: data,
		cache: false,
		success: function (html) {
			var list = document.getElementById(id);
			
			list.parentNode.parentNode.removeChild(list.parentNode);
			
			$("#image_list").append('<li><img src="../images/index/question_little.jpg"></li>');

			$('input[id=image_id]').val('');
			$('span[id=message]').html("<?php echo LINKS_IMAGE_DELETED; ?>");
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
	<ul class="crumb admin_links_crumb" itemprop="breadcrumb">
		<li typeof="v:Breadcrumb">
			<a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/index.php" title="'.MENU_HOME.'" rel="v:url" property="v:title" >'.MENU_HOME.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin.php" rel="v:url" property="v:title" >'.ADMIN_TITLE.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin_links.php" rel="v:url" property="v:title" >'.LINKS_LIST_TITLE.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><span class="title"><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin_links_update.php?id='.$id.'" rel="v:url" property="v:title" >'.LINKS_UPDATE_TITLE.'</A></span> | <a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin_links_add.php" >'.LINKS_ADD_TITLE.'</A>
		</li>
	</ul>
</div>
<div id="main">
	<form method="POST" action="_admin_links_update.php">
		<TABLE>
			<TR>
				<TD>
					<TABLE>
						<TR>
							<TD>'.LINKS_ACTIVE.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>';
			
	$active_selected = $_REQUEST['links_active'];

	echo '<select id="links_active_select" name="links_active_select" onChange="javascript:updateSelect(\'links_active_select\')">';
	echo $data->DisplayBooleanList($active_selected);
	echo '</select>';
			
						echo '</TD>
						</TR>
						<TR>
							<TD class="separator"></TD>
						</TR>
						<TR>
							<TD>'.LINKS_LINK.' * :</TD>
							<TD class="field_separator"></TD>
							<TD><INPUT TYPE="text" ID="links_link" NAME="links_link" VALUE="'.$_REQUEST['links_link'].'" STYLE="width:400px" MAXLENGTH="500"></TD>
						</TR>
						<TR>
							<TD class="separator"></TD>
						</TR>
						<TR>
							<TD>'.LINKS_TITLE.' * :</TD>
							<TD class="field_separator"></TD>
							<TD><INPUT TYPE="text" ID="links_title" NAME="links_title" VALUE="'.$_REQUEST['links_title'].'" STYLE="width:300px" MAXLENGTH="300"></TD>
						</TR>
						<TR>
							<TD class="separator"></TD>
						</TR>
						<TR>
							<TD>'.LINKS_TEXT_LANG.' :</TD>
							<TD class="field_separator"></TD>
							<TD>';
			
	$lang_selected = $_REQUEST['links_text_lang'];

	echo '<select id="links_text_lang_select" name="links_text_lang_select" onChange="javascript:updateLangSelect()">';
	echo $data->ValueTextLangDisplayList($lang_selected);
	echo '</select>';

						echo '</TD>
						</TR>
						<TR>
							<TD class="separator"></TD>
						</TR>
						<TR>
							<TD>'.LINKS_TEXT_VALUE.' :</TD>
							<TD class="field_separator"></TD>
							<TD><textarea cols="60" rows="10" ID="links_text_value" NAME="links_text_value">'.str_replace("<br>", "\n", $_REQUEST['links_text_value']).'</textarea></TD>
						</TR>
					</TABLE>
				<TD>
			</TR>
			
			<TR>
				
			</tr>
			
			<TR>
				<TD>
					<TABLE>
						<TR>
							<TD>
								<ul id="image_list">';
if ($current[4] != NULL) {
	echo '<li><img id="'.$current[4].'.'.$current[5].'" src="'.IMAGE_LITTLE_LINK.$current[4].'.'.$current[5].'" onClick="javascript:deleteImage(this.id);"><img src="../images/index/delete_little.jpg" alt="'.DELETE.'"></li>';
} else {
	echo '<li><img src="../images/index/question_little.jpg"></li>';
}
								echo '
								</ul>
								<input type="file" class="file" id="image_upload" name="image_upload" style="visibility:hidden" />
								<input type="button" id="image_upload_button" onclick="$(\'#image_upload\').click();" value="'.UPLOAD_IMAGE.'" alt="'.UPLOAD_IMAGE.'" />
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
			<TR>
				<TD class="max_separator">
					<input type="hidden" id="id" name="id" value="'.$id.'">
					<input type="hidden" id="links_active" name="links_active" value="'.$current[1].'">
					<input type="hidden" id="links_text_id" name="links_text_id" value="'.$currentText[0].'">
					<input type="hidden" id="links_text_lang" name="links_text_lang" value="'.$currentText[1].'">
					<input type="hidden" id="image_id" name="image_id" value="';
if ($current[4] != '') {
	echo $current[4].'.'.$current[5];
}
								echo '">
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
								<INPUT TYPE="submit" ID="submit" NAME="submit" VALUE="'.LINKS_UPDATE_UPDATE.'" ALT="'.LINKS_UPDATE_UPDATE.'">
								<INPUT TYPE="submit" ID="delete" NAME="delete" VALUE="'.LINKS_DELETE_DELETE.'" ALT="'.LINKS_DELETE_DELETE.'">
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