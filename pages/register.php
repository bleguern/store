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
<TITLE><?php echo LOGIN_REGISTER.' | '.SITE_TITLE; ?></TITLE>
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
        var admin_user_password = $('input[id=admin_user_password]');
        var admin_user_password2 = $('input[id=admin_user_password2]');
        var admin_user_email = $('input[id=admin_user_email]');
        var admin_user_lang = $('input[id=admin_user_lang]');
        var admin_user_lang_select = $('select[id=admin_user_lang_select]');
        var admin_user_admin_site_theme = $('input[id=admin_user_admin_site_theme]');
        var admin_user_admin_site_theme_select = $('select[id=admin_user_admin_site_theme_select]');
        var gotourl = $('input[id=gotourl]');
            
        //Simple validation to make sure user entered something
        //If error found, add hightlight class to the text field

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
        var data = 'admin_user_password=' + admin_user_password.val() +
        		   '&admin_user_email='  + admin_user_email.val() +
        		   '&admin_user_lang=' + admin_user_lang.val() + 
        		   '&admin_user_admin_site_theme=' + admin_user_admin_site_theme.val() + 
        		   '&gotourl=' + gotourl.val();
       
        //show the loading sign
        //TO_DO
        //start the ajax
        $.ajax({
            //this is the php file that processes the data and send mail
            url: "_register.php",
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
                
                admin_user_password.attr('disabled', 'disabled');
                admin_user_password2.attr('disabled', 'disabled');
                admin_user_email.attr('disabled', 'disabled');
                admin_user_lang_select.attr('disabled', 'disabled');
                admin_user_admin_site_theme_select.attr('disabled', 'disabled');

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
			<span class="arrow">></span><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/register.php" rel="v:url" property="v:title" >'.LOGIN_REGISTER.'</A>
		</li>
	</ul>
</div>
<div id="main">
	<form method="POST" action="_register.php">
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
								<INPUT TYPE="submit" ID="submit" NAME="submit" VALUE="'.LOGIN_REGISTER.'" ALT="'.LOGIN_REGISTER.'">
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