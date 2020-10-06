<?php  
/* V1.2
 * 
 * V1.1 : 20130624 : Major update
 * V1.2 : 20130930 : Javascript update
 * 
 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	if (!isset($_SESSION[SITE_ID]['connection_id'])) {
		Util::Init();
	}
	
	if(!Util::IsAllowed('admin_user')) {
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
		
		$current = $data->AdminUserGet($id);
		$_REQUEST['admin_user_admin_role'] = $current[1];
		$_REQUEST['admin_user_active'] = $current[2];
		$_REQUEST['admin_user_login'] = $current[3];
		$_REQUEST['admin_user_email'] = $current[4];
		$_REQUEST['admin_user_first_name'] = $current[5];
		$_REQUEST['admin_user_last_name'] = $current[6];
		$_REQUEST['admin_user_phone'] = $current[7];
		$_REQUEST['admin_user_lang'] = $current[8];
		$_REQUEST['admin_user_admin_site_theme'] = $current[9];
		$_REQUEST['admin_user_address_line_1'] = $current[10];
		$_REQUEST['admin_user_address_line_2'] = $current[11];
		$_REQUEST['admin_user_address_line_3'] = $current[12];
		$_REQUEST['admin_user_address_postal_code'] = $current[13];
		$_REQUEST['admin_user_address_city'] = $current[14];
		$_REQUEST['admin_user_address_region'] = $current[15];
		$_REQUEST['admin_user_address_country'] = $current[16];
		
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

	//if submit button is clicked
    $('#submit').click(function () {

    	var checkProblem = false;
    	var missingFields = false;
    	
        //Get the data from all the fields
        var id = $('input[id=id]');
        var admin_user_admin_role = $('input[id=admin_user_admin_role]');
        var admin_user_admin_role_select = $('select[id=admin_user_admin_role_select]');
        var admin_user_active = $('input[id=admin_user_active]');
        var admin_user_active_select = $('select[id=admin_user_active_select]');
        var admin_user_login = $('input[id=admin_user_login]');
        var admin_user_email = $('input[id=admin_user_email]');
        var admin_user_first_name = $('input[id=admin_user_first_name]');
        var admin_user_last_name = $('input[id=admin_user_last_name]');
        var admin_user_phone = $('input[id=admin_user_phone]');
        var admin_user_lang = $('input[id=admin_user_lang]');
        var admin_user_lang_select = $('select[id=admin_user_lang_select]');
        var admin_user_admin_site_theme = $('input[id=admin_user_admin_site_theme]');
        var admin_user_admin_site_theme_select = $('select[id=admin_user_admin_site_theme_select]');
        var admin_user_address_line_1 = $('input[id=admin_user_address_line_1]');
        var admin_user_address_line_2 = $('input[id=admin_user_address_line_2]');
        var admin_user_address_line_3 = $('input[id=admin_user_address_line_3]');
        var admin_user_address_postal_code = $('input[id=admin_user_address_postal_code]');
        var admin_user_address_city = $('input[id=admin_user_address_city]');
        var admin_user_address_region = $('input[id=admin_user_address_region]');
        var admin_user_address_country = $('input[id=admin_user_address_country]');
            
        //Simple validation to make sure user entered something
        //If error found, add hightlight class to the text field
        if (admin_user_admin_role.val()=='') {
        	admin_user_admin_role_select.addClass('missingvalue');
        	checkProblem = true;
        	missingFields = true;
        } else admin_user_admin_role_select.removeClass('missingvalue');

        if (admin_user_active.val()=='') {
        	admin_user_active_select.addClass('missingvalue');
        	checkProblem = true;
        	missingFields = true;
        } else admin_user_active_select.removeClass('missingvalue');

        if (admin_user_login.val()=='') {
        	admin_user_login.addClass('missingvalue');
        	checkProblem = true;
        	missingFields = true;
        } else admin_user_login.removeClass('missingvalue');

        if (admin_user_email.val()=='') {
        	admin_user_email.addClass('missingvalue');
        	checkProblem = true;
        	missingFields = true;
        } else {
        	if (validateEmail(admin_user_email.val())) {
        		admin_user_email.removeClass('missingvalue');
        	} else {
        		admin_user_email.addClass('missingvalue');
            	$('span[id=message]').html('<?php echo ADMIN_USER_EMAIL_NOT_CORRECT; ?>');
            	$('div[id=notification]').show();
            	checkProblem = true;
        	}
        }

        if (admin_user_lang.val()=='') {
        	admin_user_lang_select.addClass('missingvalue');
        	checkProblem = true;
        	missingFields = true;
        } else admin_user_lang_select.removeClass('missingvalue');

        if (admin_user_admin_site_theme.val()=='') {
        	admin_user_admin_site_theme_select.addClass('missingvalue');
        	checkProblem = true;
        	missingFields = true;
        } else admin_user_admin_site_theme_select.removeClass('missingvalue');

        if (admin_user_first_name.val()=='') {
        	admin_user_first_name.addClass('missingvalue');
        	checkProblem = true;
        	missingFields = true;
        } else admin_user_first_name.removeClass('missingvalue');

        if (admin_user_last_name.val()=='') {
        	admin_user_last_name.addClass('missingvalue');
        	checkProblem = true;
        	missingFields = true;
        } else admin_user_last_name.removeClass('missingvalue');

        if (admin_user_phone.val()=='') {
        	admin_user_phone.addClass('missingvalue');
        	checkProblem = true;
        	missingFields = true;
        } else admin_user_phone.removeClass('missingvalue');

        if (admin_user_address_line_1.val()=='') {
        	admin_user_address_line_1.addClass('missingvalue');
        	checkProblem = true;
        	missingFields = true;
        } else admin_user_address_line_1.removeClass('missingvalue');

        if (admin_user_address_postal_code.val()=='') {
        	admin_user_address_postal_code.addClass('missingvalue');
        	checkProblem = true;
        	missingFields = true;
        } else admin_user_address_postal_code.removeClass('missingvalue');

        if (admin_user_address_city.val()=='') {
        	admin_user_address_city.addClass('missingvalue');
        	checkProblem = true;
        	missingFields = true;
        } else admin_user_address_city.removeClass('missingvalue');

        if (admin_user_address_country.val()=='') {
        	admin_user_address_country.addClass('missingvalue');
        	checkProblem = true;
        	missingFields = true;
        } else admin_user_address_country.removeClass('missingvalue');
        
        if (missingFields) {
        	$('span[id=message]').html('<?php echo MISSING_FIELDS_ERROR; ?>');
            $('div[id=notification]').show();
        }
        
        if (checkProblem) {
            return false;
        }
        
        //organize the data properly
        var data = 'id=' + id.val() + '&admin_user_admin_role=' + admin_user_admin_role.val() + 
        		   '&admin_user_active=' + admin_user_active.val() + '&admin_user_login='  + admin_user_login.val() + 
        		   '&admin_user_email='  + admin_user_email.val() + '&admin_user_first_name=' + admin_user_first_name.val() +
        		   '&admin_user_last_name='  + admin_user_last_name.val() + '&admin_user_phone='  + admin_user_phone.val() + 
        		   '&admin_user_lang=' + admin_user_lang.val() + '&admin_user_admin_site_theme=' + admin_user_admin_site_theme.val() + 
        		   '&admin_user_address_line_1=' + admin_user_address_line_1.val() + '&admin_user_address_line_2=' + admin_user_address_line_2.val() + 
        		   '&admin_user_address_line_3=' + admin_user_address_line_3.val() + '&admin_user_address_postal_code=' + admin_user_address_postal_code.val() + 
        		   '&admin_user_address_city=' + admin_user_address_city.val() + '&admin_user_address_region=' + admin_user_address_region.val() + 
        		   '&admin_user_address_country=' + admin_user_address_country.val();
       
        //show the loading sign
        //TO_DO
        //start the ajax
        $.ajax({
            //this is the php file that processes the data and send mail
            url: "_admin_user_update.php",
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
        var admin_user_admin_role_select = $('select[id=admin_user_admin_role_select]');
        var admin_user_active_select = $('select[id=admin_user_active_select]');
        var admin_user_login = $('input[id=admin_user_login]');
        var admin_user_email = $('input[id=admin_user_email]');
        var admin_user_first_name = $('input[id=admin_user_first_name]');
        var admin_user_last_name = $('input[id=admin_user_last_name]');
        var admin_user_phone = $('input[id=admin_user_phone]');
        var admin_user_lang_select = $('select[id=admin_user_lang_select]');
        var admin_user_admin_site_theme_select = $('select[id=admin_user_admin_site_theme_select]');
        var admin_user_address_line_1 = $('input[id=admin_user_address_line_1]');
        var admin_user_address_line_2 = $('input[id=admin_user_address_line_2]');
        var admin_user_address_line_3 = $('input[id=admin_user_address_line_3]');
        var admin_user_address_postal_code = $('input[id=admin_user_address_postal_code]');
        var admin_user_address_city = $('input[id=admin_user_address_city]');
        var admin_user_address_region = $('input[id=admin_user_address_region]');
        var admin_user_address_country = $('input[id=admin_user_address_country]');

		var answer = confirm("<?php echo ADMIN_USER_DELETE_QUESTION; ?>");
        
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
            url: "_admin_user_delete.php",
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

                admin_user_admin_role_select.attr('disabled', 'disabled');
                admin_user_active_select.attr('disabled', 'disabled');
                admin_user_login.attr('disabled', 'disabled');
                admin_user_email.attr('disabled', 'disabled');
                admin_user_first_name.attr('disabled', 'disabled');
                admin_user_last_name.attr('disabled', 'disabled');
                admin_user_phone.attr('disabled', 'disabled');
                admin_user_lang_select.attr('disabled', 'disabled');
                admin_user_admin_site_theme_select.attr('disabled', 'disabled');
                admin_user_address_line_1.attr('disabled', 'disabled');
                admin_user_address_line_2.attr('disabled', 'disabled');
                admin_user_address_line_3.attr('disabled', 'disabled');
                admin_user_address_postal_code.attr('disabled', 'disabled');
                admin_user_address_city.attr('disabled', 'disabled');
                admin_user_address_region.attr('disabled', 'disabled');
                admin_user_address_country.attr('disabled', 'disabled');
                
                $('#submit').attr('disabled', 'disabled');
                $('#reset_password').attr('disabled', 'disabled');
                $('#delete').attr('disabled', 'disabled');
            }
        });
        //cancel the submit button default behaviours
        return false;
    });

  	//if delete button is clicked
    $('#reset_password').click(function () {
        
        //Get the data from all the fields
        var id = $('input[id=id]');
        

		var answer = confirm("<?php echo ADMIN_USER_RESET_PASSWORD_QUESTION; ?>");
        
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
            url: "_admin_user_reset_password.php",
            //GET method is used
            type: "GET",
            //pass the data        
            data: data,
            //Do not cache the page
            cache: false,
            //success
            success: function (html) {
                $('span[id=message]').html(html);
            }
        });
        //cancel the submit button default behaviours
        return false;
    });

<?php
    echo Util::PageGetDocumentReadyBottom();
?>
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
	<ul class="crumb admin_user_crumb" itemprop="breadcrumb">
		<li typeof="v:Breadcrumb">
			<a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/index.php" title="'.MENU_HOME.'" rel="v:url" property="v:title" >'.MENU_HOME.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin.php" rel="v:url" property="v:title" >'.ADMIN_TITLE.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin_user.php" rel="v:url" property="v:title" >'.ADMIN_USER_LIST_TITLE.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><span class="title"><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin_user_update.php?id='.$id.'" rel="v:url" property="v:title" >'.ADMIN_USER_UPDATE_TITLE.'</A></span> | <a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin_user_add.php" >'.ADMIN_USER_ADD_TITLE.'</A>
		</li>
	</ul>
</div>
<div id="main">
	<form method="POST" action="_admin_user_update.php">
		<TABLE>
			<TR>
				<TD>
					<TABLE>
						<TR>
							<TD>'.ADMIN_USER_ROLE.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>';
			
	$role_selected = $_REQUEST['admin_user_admin_role'];

	echo '<select id="admin_user_admin_role_select" name="admin_user_admin_role_select" onChange="javascript:updateSelect(\'admin_user_admin_role_select\')">';
	echo $data->AdminRoleDisplayList($role_selected);
	echo '</select>';
			
						echo '</TD>
						</TR>
						<TR>
							<TD class="max_separator"></TD>
						</TR>
						<TR>
							<TD>'.ADMIN_USER_ACTIVE.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>';
			
	$active_selected = $_REQUEST['admin_user_active'];

	echo '<select id="admin_user_active_select" name="admin_user_active_select" onChange="javascript:updateSelect(\'admin_user_active_select\')">';
	echo $data->DisplayBooleanList($active_selected);
	echo '</select>';
			
						echo '</TD>
						</TR>
						<TR>
							<TD class="separator"></TD>
						</TR>
						<TR>
							<TD>'.ADMIN_USER_LOGIN.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="admin_user_login" NAME="admin_user_login" VALUE="'.$_REQUEST['admin_user_login'].'" STYLE="width:200px" MAXLENGTH="30">
							</TD>
						</TR>
						<TR>
							<TD class="max_separator"></TD>
						</TR>
						<TR>
							<TD>'.ADMIN_USER_PASSWORD.' :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="submit" ID="reset_password" NAME="reset_password" VALUE="'.ADMIN_USER_RESET_PASSWORD.'" ALT="'.ADMIN_USER_RESET_PASSWORD.'">
							</TD>
						</TR>
						<TR>
							<TD class="max_separator"></TD>
						</TR>
						<TR>
							<TD>'.ADMIN_USER_EMAIL.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="admin_user_email" NAME="admin_user_email" VALUE="'.$_REQUEST['admin_user_email'].'" STYLE="width:300px" MAXLENGTH="100">
							</TD>
						</TR>
						<TR>
							<TD class="max_separator"></TD>
						</TR>
						<TR>
							<TD>'.ADMIN_USER_LANG.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>';
			
	$lang_selected = $_REQUEST['admin_user_lang'];

	echo '<select id="admin_user_lang_select" name="admin_user_lang_select" onChange="javascript:updateSelect(\'admin_user_lang_select\')">';
	echo $data->ValueTextLangDisplayList($lang_selected);
	echo '</select>';

						echo '</TD>
						</TR>
						<TR>
							<TD class="max_separator"></TD>
						</TR>
						<TR>
							<TD>'.ADMIN_USER_THEME.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>';
			
	$theme_selected = $_REQUEST['admin_user_admin_site_theme'];

	echo '<select id="admin_user_admin_site_theme_select" name="admin_user_admin_site_theme_select" onChange="javascript:updateSelect(\'admin_user_admin_site_theme_select\')">';
	echo $data->AdminSiteThemeDisplayList($theme_selected);
	echo '</select>';
			
						echo '</TD>
						</TR>
						<TR>
							<TD class="max_separator"></TD>
						</TR>
						<TR>
							<TD>'.ADMIN_USER_FIRST_NAME.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="admin_user_first_name" NAME="admin_user_first_name" VALUE="'.$_REQUEST['admin_user_first_name'].'" STYLE="width:200px" MAXLENGTH="50">
							</TD>
						</TR>
						<TR>
							<TD class="max_separator"></TD>
						</TR>
						<TR>
							<TD>'.ADMIN_USER_LAST_NAME.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="admin_user_last_name" NAME="admin_user_last_name" VALUE="'.$_REQUEST['admin_user_last_name'].'" STYLE="width:200px" MAXLENGTH="50">
							</TD>
						</TR>
						<TR>
							<TD class="max_separator"></TD>
						</TR>
						<TR>
							<TD>'.ADMIN_USER_PHONE.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="admin_user_phone" NAME="admin_user_phone" VALUE="'.$_REQUEST['admin_user_phone'].'" STYLE="width:200px" MAXLENGTH="20">
							</TD>
						</TR>
						<TR>
							<TD class="max_separator"></TD>
						</TR>
					</TABLE>
				</TD>
        		<TD class="max_separator"></TD>
        		<TD VALIGN="top">
					<TABLE>
						<TR>
							<TD>'.ADMIN_USER_ADDRESS_LINE_1.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="admin_user_address_line_1" NAME="admin_user_address_line_1" VALUE="'.$_REQUEST['admin_user_address_line_1'].'" STYLE="width:300px" MAXLENGTH=50">
							</TD>
						</TR>
						<TR>
							<TD class="max_separator"></TD>
						</TR>
						<TR>
							<TD>'.ADMIN_USER_ADDRESS_LINE_2.' :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="admin_user_address_line_2" NAME="admin_user_address_line_2" VALUE="'.$_REQUEST['admin_user_address_line_2'].'" STYLE="width:300px" MAXLENGTH=50">
							</TD>
						</TR>
						<TR>
							<TD class="max_separator"></TD>
						</TR>
        		   		<TR>
							<TD>'.ADMIN_USER_ADDRESS_LINE_3.' :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="admin_user_address_line_3" NAME="admin_user_address_line_3" VALUE="'.$_REQUEST['admin_user_address_line_3'].'" STYLE="width:300px" MAXLENGTH=50">
							</TD>
						</TR>
						<TR>
							<TD class="max_separator"></TD>
						</TR>
            			<TR>
							<TD>'.ADMIN_USER_ADDRESS_POSTAL_CODE.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="admin_user_address_postal_code" NAME="admin_user_address_postal_code" VALUE="'.$_REQUEST['admin_user_address_postal_code'].'" STYLE="width:100px" MAXLENGTH=20">
							</TD>
						</TR>
						<TR>
							<TD class="max_separator"></TD>
						</TR>
                		<TR>
							<TD>'.ADMIN_USER_ADDRESS_CITY.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="admin_user_address_city" NAME="admin_user_address_city" VALUE="'.$_REQUEST['admin_user_address_city'].'" STYLE="width:300px" MAXLENGTH=100">
							</TD>
						</TR>
						<TR>
							<TD class="max_separator"></TD>
						</TR>
                		<TR>
							<TD>'.ADMIN_USER_ADDRESS_REGION.' :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="admin_user_address_region" NAME="admin_user_address_region" VALUE="'.$_REQUEST['admin_user_address_region'].'" STYLE="width:200px" MAXLENGTH=100">
							</TD>
						</TR>
						<TR>
							<TD class="max_separator"></TD>
						</TR>
						<TR>
							<TD>'.ADMIN_USER_ADDRESS_COUNTRY.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="admin_user_address_country" NAME="admin_user_address_country" VALUE="'.$_REQUEST['admin_user_address_country'].'" STYLE="width:200px" MAXLENGTH=100">
							</TD>
						</TR>
						<TR>
							<TD class="max_separator"></TD>
						</TR>
        		   	</TABLE>
				</TD>
			</TR>
			<TR>
				<TD class="max_separator">
					<input type="hidden" id="id" name="id" value="'.$id.'">
					<input type="hidden" id="admin_user_admin_role" name="admin_user_admin_role" value="'.$_REQUEST['admin_user_admin_role'].'">
					<input type="hidden" id="admin_user_active" name="admin_user_active" value="'.$_REQUEST['admin_user_active'].'">
					<input type="hidden" id="admin_user_lang" name="admin_user_lang" value="'.$_REQUEST['admin_user_lang'].'">
					<input type="hidden" id="admin_user_admin_site_theme" name="admin_user_admin_site_theme" value="'.$_REQUEST['admin_user_admin_site_theme'].'">
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
								<INPUT TYPE="submit" ID="submit" NAME="submit" VALUE="'.ADMIN_USER_UPDATE_UPDATE.'" ALT="'.ADMIN_USER_UPDATE_UPDATE.'">
								<INPUT TYPE="submit" ID="delete" NAME="delete" VALUE="'.ADMIN_USER_DELETE_DELETE.'" ALT="'.ADMIN_USER_DELETE_DELETE.'">
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