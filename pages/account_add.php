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
	
	$gotourl = Util::GetPostValue('gotourl');
	
	if (isset($_SESSION[SITE_ID]['authenticated'])) {
		if ($gotourl != '') {
			header('Location: '.$gotourl);
			exit();
		} else {
			header('Location: logout.php');
			exit();
		}
	}
	
	$data = new Data();
?>
<?php echo Util::PageGetHtmlTop(); ?>
<HEAD>
<TITLE><?php echo LOGIN_CREATE_ACCOUNT.' | '.SITE_TITLE; ?></TITLE>
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
        var admin_user_login = $('input[id=admin_user_login]');
        var admin_user_password = $('input[id=admin_user_password]');
        var admin_user_password2 = $('input[id=admin_user_password2]');
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
        var gotourl = $('input[id=gotourl]');
            
        //Simple validation to make sure user entered something
        //If error found, add hightlight class to the text field
        if (admin_user_login.val()=='') {
        	admin_user_login.addClass('missingvalue');
            checkProblem = true;
            missingFields = true;
        } else admin_user_login.removeClass('missingvalue');

        if (admin_user_password.val()=='') {
        	admin_user_password.addClass('missingvalue');
            checkProblem = true;
            missingFields = true;
        } else admin_user_password.removeClass('missingvalue');

        if (admin_user_password2.val()=='') {
        	admin_user_password2.addClass('missingvalue');
            checkProblem = true;
            missingFields = true;
        } else admin_user_password2.removeClass('missingvalue');

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

        if (admin_user_password.val() != admin_user_password2.val()) {
            admin_user_password.addClass('missingvalue');
            admin_user_password2.addClass('missingvalue');
            $('span[id=message]').html('<?php echo ADMIN_USER_PASSWORD_NOT_THE_SAME; ?>');
        	$('div[id=notification]').show();
            checkProblem = true;
        }

        if (missingFields) {
        	$('span[id=message]').html('<?php echo MISSING_FIELDS_ERROR; ?>');
            $('div[id=notification]').show();
        }
        
        if (checkProblem) {
            return false;
        }
        
        //organize the data properly
        var data = 'admin_user_login='  + admin_user_login.val() + '&admin_user_password=' + admin_user_password.val() +
        		   '&admin_user_email='  + admin_user_email.val() + '&admin_user_first_name=' + admin_user_first_name.val() +
        		   '&admin_user_last_name='  + admin_user_last_name.val() + '&admin_user_phone='  + admin_user_phone.val() + 
        		   '&admin_user_lang=' + admin_user_lang.val() + '&admin_user_admin_site_theme=' + admin_user_admin_site_theme.val() + 
        		   '&admin_user_address_line_1=' + admin_user_address_line_1.val() + '&admin_user_address_line_2=' + admin_user_address_line_2.val() + 
        		   '&admin_user_address_line_3=' + admin_user_address_line_3.val() + '&admin_user_address_postal_code=' + admin_user_address_postal_code.val() + 
        		   '&admin_user_address_city=' + admin_user_address_city.val() + '&admin_user_address_region=' + admin_user_address_region.val() + 
        		   '&admin_user_address_country=' + admin_user_address_country.val() + '&gotourl=' + gotourl.val();
       
        //show the loading sign
        //TO_DO
        //start the ajax
        $.ajax({
            //this is the php file that processes the data and send mail
            url: "_account_add.php",
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
                
                admin_user_login.attr('disabled', 'disabled');
                admin_user_password.attr('disabled', 'disabled');
                admin_user_password2.attr('disabled', 'disabled');
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

	            window.setTimeout('location.reload()', 1500);
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
	<ul class="crumb user_crumb" itemprop="breadcrumb">
		<li typeof="v:Breadcrumb">
			<a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/index.php" title="'.MENU_HOME.'" rel="v:url" property="v:title" >'.MENU_HOME.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/account_add.php" rel="v:url" property="v:title" >'.LOGIN_CREATE_ACCOUNT.'</A>
		</li>
	</ul>
</div>
<div id="main">
	<form method="POST" action="_account_add.php">
		<TABLE>
			<TR>
				<TD>
					<TABLE>
						<TR>
							<TD>'.ADMIN_USER_EMAIL.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="admin_user_email" NAME="admin_user_email" VALUE="" STYLE="width:300px" MAXLENGTH="100">
							</TD>
						</TR>
						<TR>
							<TD class="max_separator"></TD>
						</TR>
						<TR>
							<TD>'.ADMIN_USER_LOGIN.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="admin_user_login" NAME="admin_user_login" VALUE="" STYLE="width:200px" MAXLENGTH="30">
							</TD>
						</TR>
						<TR>
							<TD class="max_separator"></TD>
						</TR>
						<TR>
							<TD>'.ADMIN_USER_PASSWORD.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="password" ID="admin_user_password" NAME="admin_user_password" VALUE="" STYLE="width:200px" MAXLENGTH="30">
							</TD>
						</TR>
						<TR>
							<TD class="max_separator"></TD>
						</TR>
						<TR>
							<TD>'.ADMIN_USER_PASSWORD2.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="password" ID="admin_user_password2" NAME="admin_user_password2" VALUE="" STYLE="width:200px" MAXLENGTH="30">
							</TD>
						</TR>
						<TR>
							<TD class="max_separator"></TD>
						</TR>
						<TR>
							<TD>'.ADMIN_USER_LANG.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>';
			
	$lang_selected = 'FR';

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
			
	$theme_selected = '0';

	echo '<select id="admin_user_admin_site_theme_select" name="admin_user_admin_site_theme_select" onChange="javascript:updateSelect(\'admin_user_admin_site_theme_select\')">';
	echo $data->AdminSiteThemeDisplayList($theme_selected);
	echo '</select>';
			
						echo '</TD>
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
							<TD COLSPAN="5"><B>'.ADMIN_USER_USEFULL_FOR_DELIVERIES.'</B></TD>
						</TR>
        				<TR>
							<TD>'.ADMIN_USER_FIRST_NAME.' :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="admin_user_first_name" NAME="admin_user_first_name" VALUE="" STYLE="width:200px" MAXLENGTH="50">
							</TD>
        					<TD class="field_separator"></TD>
        					<TD>'.ADMIN_USER_LAST_NAME.' :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="admin_user_last_name" NAME="admin_user_last_name" VALUE="" STYLE="width:200px" MAXLENGTH="50">
							</TD>
						</TR>
						<TR>
							<TD class="max_separator"></TD>
						</TR>
						<TR>
							<TD>'.ADMIN_USER_PHONE.' :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="admin_user_phone" NAME="admin_user_phone" VALUE="" STYLE="width:200px" MAXLENGTH="20">
							</TD>
						</TR>
						<TR>
							<TD class="max_separator"></TD>
						</TR>
						<TR>
							<TD>'.ADMIN_USER_ADDRESS_LINE_1.' :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="admin_user_address_line_1" NAME="admin_user_address_line_1" VALUE="" STYLE="width:300px" MAXLENGTH=50">
							</TD>
						</TR>
						<TR>
							<TD class="max_separator"></TD>
						</TR>
						<TR>
							<TD>'.ADMIN_USER_ADDRESS_LINE_2.' :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="admin_user_address_line_2" NAME="admin_user_address_line_2" VALUE="" STYLE="width:300px" MAXLENGTH=50">
							</TD>
						</TR>
						<TR>
							<TD class="max_separator"></TD>
						</TR>
        		   		<TR>
							<TD>'.ADMIN_USER_ADDRESS_LINE_3.' :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="admin_user_address_line_3" NAME="admin_user_address_line_3" VALUE="" STYLE="width:300px" MAXLENGTH=50">
							</TD>
						</TR>
						<TR>
							<TD class="max_separator"></TD>
						</TR>
            			<TR>
							<TD>'.ADMIN_USER_ADDRESS_POSTAL_CODE.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="admin_user_address_postal_code" NAME="admin_user_address_postal_code" VALUE="" STYLE="width:100px" MAXLENGTH=20">
							</TD>
        					<TD class="field_separator"></TD>
        					<TD>'.ADMIN_USER_ADDRESS_CITY.' :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="admin_user_address_city" NAME="admin_user_address_city" VALUE="" STYLE="width:300px" MAXLENGTH=100">
							</TD>
						</TR>
						<TR>
							<TD class="max_separator"></TD>
						</TR>
                		<TR>
							<TD>'.ADMIN_USER_ADDRESS_REGION.' :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="admin_user_address_region" NAME="admin_user_address_region" VALUE="" STYLE="width:200px" MAXLENGTH=100">
							</TD>
        					<TD class="field_separator"></TD>
        					<TD>'.ADMIN_USER_ADDRESS_COUNTRY.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="admin_user_address_country" NAME="admin_user_address_country" VALUE="" STYLE="width:200px" MAXLENGTH=100">
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
        			<input type="hidden" id="gotourl" name="gotourl" value="'.$gotourl.'">
					<input type="hidden" id="admin_user_lang" name="admin_user_lang" value="'.$lang_selected.'">
					<input type="hidden" id="admin_user_admin_site_theme" name="admin_user_admin_site_theme" value="'.$theme_selected.'">
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
								<INPUT TYPE="submit" ID="submit" NAME="submit" VALUE="'.LOGIN_CREATE_ACCOUNT.'" ALT="'.LOGIN_CREATE_ACCOUNT.'">
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