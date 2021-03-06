<?php  
/* V1.4
 * 
 * V1.1 : 20130531 : Mandatory sex field
 * V1.2 : 20130624 : Major update
 * V1.3 : 20131008 : Item type 2 added
 * V1.4 : 20131015 : Item specific price added
 * 
 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	if (!isset($_SESSION[SITE_ID]['connection_id'])) {
		Util::Init();
	}
	
	if(!Util::IsAllowed('admin_item')) {
		header('Location: '.BASE_LINK.'/pages/not_allowed.php');
		exit();
	}
	
	$data = new Data();
	$dataSpecific = new DataSpecific();
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
<SCRIPT src="<?php echo BASE_LINK; ?>/scripts/calendar.js.php" type="text/javascript"></script>
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
        var item_type = $('input[id=item_type]');
        var item_type_2 = $('input[id=item_type_2]');
        var item_active = $('input[id=item_active]');
        var item_name = $('input[id=item_name]');
        var item_specific_price = $('input[id=item_specific_price]');
        var item_specific_weight = $('input[id=item_specific_weight]');
        var item_specific_admin_currency = $('input[id=item_specific_admin_currency]');
        var item_text_lang = $('input[id=item_text_lang]');
		var item_text_value = $('textarea[id=item_text_value]');
		var first_image_id = $('input[id=first_image_id]');
		var image_id = $('input[id=image_id]');
        var item_type_select = $('select[id=item_type_select]');
        var item_type_2_select = $('select[id=item_type_2_select]');
        var item_specific_sex_select = $('select[id=item_specific_sex_select]');
        var item_active_select = $('select[id=item_active_select]');
        var item_specific_mother_link_select = $('select[id=item_specific_mother_link_select]');
        var item_specific_father_link_select = $('select[id=item_specific_father_link_select]');
        var item_text_lang_select = $('select[id=item_text_lang_select]');
        var item_specific_admin_currency_select = $('input[id=item_specific_admin_currency_select]');
        var store_inventory_count = $('input[id=store_inventory_count]');
        var item_specific_brand_select = $('input[id=item_specific_brand_select]');
        var item_specific_brand = $('input[id=item_specific_brand]');
        var item_specific_brand_text = $('input[id=item_specific_brand_text]');
        var tag_list_value = $('input[id=tag_list_value]');
        var tag_value = $('input[id=tag_value]');
            
        //Simple validation to make sure user entered something
        //If error found, add hightlight class to the text field
        if (item_type.val()=='') {
        	item_type_select.addClass('missingvalue');
        	checkProblem = true;
            missingFields = true;
        } else item_type_select.removeClass('missingvalue');

        if (item_type_2.val()=='') {
        	item_type_2_select.addClass('missingvalue');
        	checkProblem = true;
            missingFields = true;
        } else item_type_2_select.removeClass('missingvalue');

        if (item_active.val()=='') {
        	item_active_select.addClass('missingvalue');
        	checkProblem = true;
            missingFields = true;
        } else item_active_select.removeClass('missingvalue');

        if (item_name.val()=='') {
            item_name.addClass('missingvalue');
            checkProblem = true;
            missingFields = true;
        } else item_name.removeClass('missingvalue');

        if (item_specific_price.val()=='') {
        	item_specific_price.addClass('missingvalue');
        	checkProblem = true;
            missingFields = true;
        } else item_specific_price.removeClass('missingvalue');

        if (item_specific_weight.val()=='') {
        	item_specific_weight.addClass('missingvalue');
        	checkProblem = true;
            missingFields = true;
        } else item_specific_weight.removeClass('missingvalue');
        
        if (store_inventory_count.val()=='') {
        	store_inventory_count.addClass('missingvalue');
            checkProblem = true;
            missingFields = true;
        } else store_inventory_count.removeClass('missingvalue');

        if (missingFields) {
        	$('span[id=message]').html('<?php echo MISSING_FIELDS_ERROR; ?>');
            $('div[id=notification]').show();
        }
        
        if (checkProblem) {
            return false;
        }
        
        //organize the data properly
        var data = 'item_type=' + item_type.val() + 
                   '&item_type_2=' + item_type_2.val() + 
                   '&item_active=' + item_active.val() + 
                   '&store_inventory_count='  + store_inventory_count.val() + 
        		   '&item_name='  + item_name.val() + 
        		   '&item_specific_price=' + item_specific_price.val() + 
        		   '&item_specific_admin_currency='  + item_specific_admin_currency.val() + 
        		   '&item_specific_weight='  + item_specific_weight.val() +
        		   '&item_specific_brand='  + item_specific_brand.val() + 
        		   '&item_specific_brand_text='  + item_specific_brand_text.val() + 
        		   '&item_text_lang=' + item_text_lang.val() + 
        		   '&item_text_value=' + encodeURIComponent(item_text_value.val().replace(/\n/g, "<br>")) + 
        		   '&first_image_id=' + first_image_id.val() + 
        		   '&image_id=' + image_id.val() + 
        		   '&tag_list_value=' + tag_list_value.val();
       
        //show the loading sign
        //TO_DO
        //start the ajax
        $.ajax({
            //this is the php file that processes the data and send mail
            url: "_admin_item_add.php",
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
                
                item_type_select.attr('disabled', 'disabled');
                item_type_2_select.attr('disabled', 'disabled');
                item_active_select.attr('disabled', 'disabled');
                item_name.attr('disabled', 'disabled');
                item_specific_price.attr('disabled', 'disabled');
                item_specific_admin_currency_select.attr('disabled', 'disabled');
                item_specific_weight.attr('disabled', 'disabled');
                item_text_lang_select.attr('disabled', 'disabled');
                item_text_value.attr('disabled', 'disabled');
                item_specific_brand_select.attr('disabled', 'disabled');
                item_specific_brand_text.attr('disabled', 'disabled');
                tag_value.attr('disabled', 'disabled');
                $('#first_image_upload_button').attr('disabled', 'disabled');
                $('#image_upload_button').attr('disabled', 'disabled');
                $('#submit').attr('disabled', 'disabled');
                $('.inventory').attr('disabled', 'disabled');
                $('#tag_button').attr('disabled', 'disabled');
            }
        });
        //cancel the submit button default behaviours
        return false;
    });

    $('.inventory').click(function () {

        var count = parseInt($('input[id=store_inventory_count]').val());

        if ($(this).attr("value") == '+') {
        	$('input[id=store_inventory_count]').val(count + 1);
        } else {
            if (count != 0) {
            	$('input[id=store_inventory_count]').val(count - 1);
            }
        }
        
        //cancel the submit button default behaviours
        return false;
    });

    firstImageUpload.addEventListener("change", function (evt) {
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
			url: "_admin_item_add_tmp_image.php",
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

				$("#first_image_list").append('<li class="image"><img id="' + html + '" src="<?php echo IMAGE_LITTLE_LINK; ?>' + html + '" onClick="javascript:deleteTmpFirstImage(this.id);"></li>');

				$('span[id=message]').html("<?php echo ITEM_TMP_IMAGE_LOADED; ?>");
				$('div[id=notification]').show();
			}
		});
	}, false);

    imageUpload.addEventListener("change", function (evt) {
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
			url: "_admin_item_add_tmp_image.php",
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

				$("#image_list").append('<li class="image"><img id="' + html + '" src="<?php echo IMAGE_LITTLE_LINK; ?>' + html + '" onClick="javascript:deleteTmpImage(this.id);"></li>');

				$('span[id=message]').html("<?php echo ITEM_TMP_IMAGE_LOADED; ?>");
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

function deleteTmpImage(image) {
	var data = 'image=' + image;
	 
	$.ajax({
		url: "_admin_item_delete_tmp_image.php",
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
			$('span[id=message]').html("<?php echo ITEM_TMP_IMAGE_DELETED; ?>");
		}
	});
	
	return false;
}

function deleteTmpFirstImage(image) {
	var data = 'image=' + image;
	 
	$.ajax({
		url: "_admin_item_delete_tmp_image.php",
		type: "GET",
		data: data,
		cache: false,
		success: function (html) {
			var list = document.getElementById(id);
			
			list.parentNode.parentNode.removeChild(list.parentNode);
			
			$("#first_image_list").append('<li class="no_image"><img src="../images/index/question_little.jpg"></li>');

			$('input[id=first_image_id]').val('');
			$('span[id=message]').html("<?php echo ITEM_TMP_IMAGE_DELETED; ?>");
		}
	});
	
	return false;
}

function showDateOfBirthCalendar()
{
	var calendar = new CalendarPopup();

	calendar.showNavigationDropdowns();
	calendar.showYearNavigationInput();
	calendar.setYearSelectStartOffset(50);

	var input = document.getElementById('item_specific_date_of_birth');
	
	calendar.select(input,'item_specific_date_of_birth_button','dd/MM/yyyy');
	
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
	<ul class="crumb admin_item_crumb" itemprop="breadcrumb">
		<li typeof="v:Breadcrumb">
			<a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/index.php" title="'.MENU_HOME.'" rel="v:url" property="v:title" >'.MENU_HOME.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin.php" rel="v:url" property="v:title" >'.ADMIN_TITLE.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin_item.php" rel="v:url" property="v:title" >'.ITEM_LIST_TITLE.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><span class="title"><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin_item_add.php" rel="v:url" property="v:title" >'.ITEM_ADD_TITLE.'</A></span>
		</li>
	</ul>
</div>
<div id="main">
	<form method="POST" action="_admin_item_add.php">
		<TABLE>
			<TR>
				<TD>
					<TABLE>
						<TR>
							<TD>'.ITEM_TYPE.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>';
						
				$type_selected = '';
			
				echo '<select id="item_type_select" name="item_type_select" onChange="javascript:updateSelect(\'item_type_select\')" class="medium">';
				echo $data->ItemTypeDisplayList($type_selected);
				echo '</select>';
						
						echo '</TD>
							<TD class="field_separator"></TD>
        					<TD>'.ITEM_TYPE_2.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>';
						
				$type_2_selected = '';
			
				echo '<select id="item_type_2_select" name="item_type_2_select" onChange="javascript:updateSelect(\'item_type_2_select\')" class="medium">';
				echo $data->ItemType2DisplayList($type_2_selected);
				echo '</select>';
						
						echo '</TD>
							</TR>
					</TABLE>
				</TD>
			</TR>
			<TR>
				<TD>
					<TABLE>
						<TR>
							<TD>'.ITEM_NAME.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="item_name" NAME="item_name" VALUE="" class="large" MAXLENGTH="50">
							</TD>
        					<TD class="field_separator"></TD>
							<TD>'.ITEM_SPECIFIC_BRAND.' :</TD>
							<TD class="field_separator"></TD>
							<TD>';
						
			$item_specific_brand_selected = '';
			
			        			echo '<select id="item_specific_brand_select" name="item_specific_brand_select" class="editable medium">';
								echo $dataSpecific->SpecificItemBrandDiplayList($item_specific_brand_selected);
								echo '</select>
								<INPUT TYPE="text" ID="item_specific_brand_text" NAME="item_specific_brand_text" VALUE="'.$_REQUEST['item_specific_brand'].'" class="editable_medium" MAXLENGTH="50">
			        			<INPUT TYPE="hidden" ID="item_specific_brand" NAME="item_specific_brand" VALUE="'.$item_specific_brand_selected.'">
			        			<SCRIPT src="<?php echo BASE_LINK; ?>/scripts/auto_input.js" type="text/javascript"></SCRIPT>
			        		</TD>
        				</TR>
					</TABLE>
				</TD>
			</TR>
        	<TR>
				<TD>
					<TABLE>
						<TR>
							<TD>'.ITEM_ACTIVE.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>';
						
			$active_selected = '1';
			
			echo '<select id="item_active_select" name="item_active_select" onChange="javascript:updateSelect(\'item_active_select\')" class="mini">';
			echo $data->DisplayBooleanList($active_selected);
			echo '</select>';
						
							echo '</TD>
        				</TR>
					</TABLE>
				</TD>
			</TR>
			<TR>
				<TD>
					<TABLE>
						<TR>
							<TD>'.ITEM_TEXT_VALUE.' :</TD>
							<TD class="field_separator"></TD>
							<TD><textarea cols="60" rows="10" ID="item_text_value" NAME="item_text_value"></textarea></TD>
							<TD class="field_separator"></TD>
		            		<TD>'.ITEM_TEXT_LANG.' :</TD>
							<TD class="field_separator"></TD>
							<TD>';
				
		$lang_selected = LANG;
		
		echo '<select id="item_text_lang_select" name="item_text_lang_select" onChange="javascript:updateSelect(\'item_text_lang_select\')" class="mini">';
		echo $data->ValueTextLangDisplayList($lang_selected);
		echo '</select>';
		
					echo '</TD>
        				</TR>
					</TABLE>
				</TD>
			</TR>
            <TR>
				<TD>
					<TABLE>
						<TR>
							<TD>'.ITEM_SPECIFIC_PRICE.' * :</TD>
							<TD class="field_separator"></TD>
							<TD><INPUT TYPE="text" ID="item_specific_price" NAME="item_specific_price" class="little" MAXLENGTH="10" VALUE="">
        					<TD class="field_separator"></TD>
        					<TD>';
					
		$currency_selected = '1';
		
		echo '<select id="item_specific_admin_currency_select" name="item_specific_admin_currency_select" onChange="javascript:updateSelect(\'item_specific_admin_currency_select\')" class="mini">';
		echo $data->AdminCurrencyDisplayList($currency_selected);
		echo '</select>';
		
					echo '</TD>
        				</TR>
					</TABLE>
				</TD>
			</TR>
        	 <TR>
				<TD>
					<TABLE>
		        		<TR>
							<TD>'.ITEM_SPECIFIC_WEIGHT.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="item_specific_weight" NAME="item_specific_weight" VALUE="100" class="little" MAXLENGTH="10">
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
        	 <TR>
				<TD>
					<TABLE>
		        		<TR>
							<TD>'.ITEM_SPECIFIC_INVENTORY.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="store_inventory_count" NAME="store_inventory_count" VALUE="1" class="mini" MAXLENGTH="2" READONLY>
			        			<input type="button" class="inventory" value="+" alt="+" /> / 
			        			<input type="button" class="inventory" value="-" alt="-" />
							</TD>
						</TR>
					</TABLE>
				</TD>
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
								<ul id="first_image_list">
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
											<input type="file" class="file" id="first_image_upload" name="first_image_upload" style="visibility:hidden;width:0px;" />
											<input type="button" id="first_image_upload_button" onclick="$(\'#first_image_upload\').click();" value="'.UPLOAD_MAIN_IMAGE.'" alt="'.UPLOAD_MAIN_IMAGE.'" />
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
											<ul id="image_list">
					
											</ul>
					        			</TD>
									</TR>
						         </TABLE>
			        		</TD>
						</TR>
			        	<TR>
							<TD>
						<input type="file" class="file" id="image_upload" name="image_upload" style="visibility:hidden;width:0px;" />
						<input type="button" id="image_upload_button" onclick="$(\'#image_upload\').click();" value="'.UPLOAD_IMAGE.'" alt="'.UPLOAD_IMAGE.'" />
					</TD>
			</TR>
			<TR>
					<TD class="max_separator">
						<input type="hidden" id="item_type" name="item_type" value="'.$type_selected.'">
						<input type="hidden" id="item_type_2" name="item_type_2" value="'.$type_2_selected.'">
						<input type="hidden" id="item_active" name="item_active" value="'.$active_selected.'">
						<input type="hidden" id="item_specific_admin_currency" name="item_specific_admin_currency" value="'.$currency_selected.'">
					    <input type="hidden" id="item_text_lang" name="item_text_lang" value="'.$lang_selected.'">
						<input type="hidden" id="first_image_id" name="first_image_id" value="">
						<input type="hidden" id="image_id" name="image_id" value="">
					</TD>
			</TR>
			<TR>
				<TD>'.MANDATORY_FIELDS.'</TD>
			</TR>
			<TR>
				<TD>
					<INPUT TYPE="submit" ID="submit" NAME="submit" VALUE="'.ITEM_ADD_ADD.'" ALT="'.ITEM_ADD_ADD.'">
					<INPUT TYPE="button" ID="back" NAME="back" VALUE="'.BACK.'" ALT="'.BACK.'" OnClick="javascript:history.back();">
				</TD>
			</TR>
		</TABLE>
	</form>
</div></div>'.Util::PageGetBottom().'
</BODY>
</HTML>';

?>