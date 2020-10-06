<?php  
/* V1.1
 * 
 * V1.1 : 20130624 : Major update
 * 
 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	$gotourl = Util::GetPostValue('gotourl');
	
	if (!isset($_SESSION[SITE_ID]['connection_id'])) {
		Util::Init();
	}
	
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
<TITLE><?php echo LOGIN_LOGIN_TITLE.' | '.SITE_TITLE; ?></TITLE>
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
    $('#login').click(function () {

    	var missingFields = false;
        var checkProblem = false;
        //Get the data from all the fields
        var login_login = $('input[id=login_login]');
        var login_password = $('input[id=login_password]');
        var gotourl = $('input[id=gotourl]');
        
        //Simple validation to make sure user entered something
        //If error found, add hightlight class to the text field
        if (login_login.val()=='') {
        	login_login.addClass('missingvalue');
        	missingFields = true;
        	checkProblem = true;
        } else login_login.removeClass('missingvalue');

        if (login_password.val()=='') {
        	login_password.addClass('missingvalue');
        	missingFields = true;
        	checkProblem = true;
        } else login_password.removeClass('missingvalue');

        if (missingFields) {
        	$('span[id=message]').html('<?php echo MISSING_FIELDS_ERROR; ?>');
            $('div[id=notification]').show();
        }
        
        if (checkProblem) {
            return false;
        }
        
        //organize the data properly
        var data = 'login_login=' + login_login.val() + '&login_password=' + login_password.val() + '&gotourl=' + gotourl.val();
       
        //show the loading sign
        //TO_DO
        //start the ajax
        $.ajax({
            //this is the php file that processes the data and send mail
            url: "_login.php",
            //GET method is used
            type: "GET",
            //pass the data        
            data: data,
            //Do not cache the page
            cache: false,
            //success
            success: function (html) {
				window.location = "login.php?message=" + html + "&gotourl=" + gotourl.val();
            }
        });
        //cancel the submit button default behaviours
        return false;
    });

    $('#create_account').click(function () {
        var gotourl = $('input[id=gotourl]');
        location.href = 'account_add.php?gotourl=' + gotourl.val();
    	return false;
    });

    $('#register').click(function () {
        var gotourl = $('input[id=gotourl]');
        location.href = 'register.php?gotourl=' + gotourl.val();
    	return false;
    });

    $('#forgot_password').click(function () {
        location.href = 'forgot_password.php';
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
	<ul class="crumb login_crumb" itemprop="breadcrumb">
		<li typeof="v:Breadcrumb">
			<a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/index.php" title="'.MENU_HOME.'" rel="v:url" property="v:title" >'.MENU_HOME.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/login.php" rel="v:url" property="v:title" >'.LOGIN_LOGIN_TITLE.'</A>
		</li>
	</ul>
</div>
<div id="main">
	<FORM method="POST" action="_login.php">
		<TABLE>
			<TR>
				<TD>
					<TABLE>
						<TR>
							<TD>'.LOGIN_LOGIN.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="login_login" NAME="login_login" VALUE="" STYLE="width:200px" MAXLENGTH="30">
							</TD>
						</TR>
						<TR>
							<TD class="max_separator"></TD>
						</TR>
						<TR>
							<TD>'.LOGIN_PASSWORD.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="password" ID="login_password" NAME="login_password" VALUE="" STYLE="width:200px" MAXLENGTH="30">
							</TD>
						</TR>
					</TABLE>
				<TD>
			</TR>
			<TR>
				<TD>
					<TABLE class="normal">
						<TR>
							<TD>'.MANDATORY_FIELDS.'</TD>
							<input type="hidden" id="gotourl" name="gotourl" value="'.$gotourl.'">
						</TR>
						<TR>
							<TD>
								<INPUT TYPE="submit" ID="login" NAME="login" VALUE="'.LOGIN_CONNECT.'" ALT="'.LOGIN_CONNECT.'">';
if ($_SESSION[SITE_ID]['admin_configuration_simple_register']) {
	echo '<INPUT TYPE="submit" ID="register" NAME="register" VALUE="'.LOGIN_REGISTER.'" ALT="'.LOGIN_REGISTER.'">';
} else {
	echo '<INPUT TYPE="submit" ID="create_account" NAME="create_account" VALUE="'.LOGIN_CREATE_ACCOUNT.'" ALT="'.LOGIN_CREATE_ACCOUNT.'">';
}
								
echo '<INPUT TYPE="submit" ID="forgot_password" NAME="forgot_password" VALUE="'.LOGIN_FORGOT_PASSWORD.'" ALT="'.LOGIN_FORGOT_PASSWORD.'">
        						<INPUT TYPE="button" ID="back" NAME="back" VALUE="'.BACK.'" ALT="'.BACK.'" OnClick="javascript:history.back();">
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
		</TABLE>
	</FORM>
</div></div>'.Util::PageGetBottom().'
</BODY>
</HTML>';
?>