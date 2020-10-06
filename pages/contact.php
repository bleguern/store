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
	
	$_REQUEST['contact_email'] = '';
	
	if (isset($_SESSION[SITE_ID]['user_email'])) {
		$_REQUEST['contact_email'] = $_SESSION[SITE_ID]['user_email'];
	}
?>
<?php echo Util::PageGetHtmlTop(); ?>
<HEAD>
<TITLE><?php echo CONTACT_TITLE.' | '.SITE_TITLE; ?></TITLE>
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
<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
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
        var contact_email = $('input[id=contact_email]');
        var contact_name = $('input[id=contact_name]');
        var contact_message = $('textarea[id=contact_message]');
        var contact_copy = $('input[id=contact_copy]');
        var contact_copy_checked = '0';

        if (contact_copy.attr('checked')) {
        	contact_copy_checked = '1';
        }
            
        //Simple validation to make sure user entered something
        //If error found, add hightlight class to the text field
        if (contact_email.val()=='') {
        	contact_email.addClass('missingvalue');
        	checkProblem = true;
            missingFields = true;
        } else {
        	if (validateEmail(contact_email.val())) {
        		contact_email.removeClass('missingvalue');
        	} else {
        		contact_email.addClass('missingvalue');
            	$('span[id=message]').html('<?php echo ADMIN_USER_EMAIL_NOT_CORRECT; ?>');
            	$('div[id=notification]').show();
            	checkProblem = true;
        	}
        }
		
        if (contact_message.val()=='') {
        	contact_message.addClass('missingvalue');
            checkProblem = true;
            missingFields = true;
        } else contact_message.removeClass('missingvalue');

        if (missingFields) {
        	$('span[id=message]').html('<?php echo MISSING_FIELDS_ERROR; ?>');
            $('div[id=notification]').show();
        }
        
        if (checkProblem) {
            return false;
        }
        
        //organize the data properly
        var data = 'contact_email='  + contact_email.val() + '&contact_name=' + contact_name.val() +
        		   '&contact_message='  + encodeURIComponent(contact_message.val().replace(/\n/g, "<br>")) + '&contact_copy=' + contact_copy_checked;

        //show the loading sign
        //TO_DO
        //start the ajax
        $.ajax({
            //this is the php file that processes the data and send mail
            url: "_contact.php",
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
                
                contact_email.attr('disabled', 'disabled');
                contact_name.attr('disabled', 'disabled');
                contact_message.attr('disabled', 'disabled');
                contact_copy.attr('disabled', 'disabled');

                $('#submit').attr('disabled', 'disabled');
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
	<ul class="crumb contact_crumb" itemprop="breadcrumb">
		<li typeof="v:Breadcrumb">
			<a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/index.php" title="'.MENU_HOME.'" rel="v:url" property="v:title" >'.MENU_HOME.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/contact.php" rel="v:url" property="v:title" >'.CONTACT_TITLE.'</A>
		</li>
	</ul>
</div>
<div id="main">
	<form method="POST" action="_admin_version_add.php">
		<TABLE>
			<TR>
				<TD>
					<TABLE>
						<TR>
							<TD>'.CONTACT_EMAIL.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="contact_email" NAME="contact_email" VALUE="'.$_REQUEST['contact_email'].'" STYLE="width:300px" MAXLENGTH="50">
							</TD>
						</TR>
						<TR>
							<TD class="max_separator"></TD>
						</TR>
						<TR>
							<TD>'.CONTACT_NAME.' :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="contact_name" NAME="contact_name" VALUE="" STYLE="width:300px" MAXLENGTH="50">
							</TD>
						</TR>
						<TR>
							<TD class="max_separator"></TD>
						</TR>
						<TR>
							<TD>'.CONTACT_MESSAGE.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<TEXTAREA cols="60" rows="10" ID="contact_message" NAME="contact_message"></TEXTAREA>
							</TD>
						</TR>
					</TABLE>
				<TD>
			</TR>
			<TR>
				<TD>
					<TABLE class="normal">
						<TR>
							<TD><INPUT TYPE="checkbox" ID="contact_copy" NAME="contact_copy">'.CONTACT_COPY.'</TD>
						</TR>
						<TR>
							<TD class="max_separator"></TD>
						</TR>
					</TABLE>
				<TD>
			</TR>
			<TR>
				<TD>
					<TABLE class="normal">
						<TR>
							<TD>'.MANDATORY_FIELDS.'</TD>
						</TR>
						<TR>
							<TD>
								<INPUT TYPE="submit" ID="submit" NAME="submit" VALUE="'.CONTACT_SEND.'" ALT="'.CONTACT_SEND.'">
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
		</TABLE>
	</form>
<BR>'.LEGALS.' : <A HREF="mailto:'.$_SESSION[SITE_ID]['admin_configuration_administrator_email'].'?subject='.$_SESSION[SITE_ID]['admin_configuration_site_name'].'"><B>'.$_SESSION[SITE_ID]['admin_configuration_copyright'].'</B></A><BR>
<BR>
</div></div>
'.Util::PageGetBottom().'
</BODY>
</HTML>';