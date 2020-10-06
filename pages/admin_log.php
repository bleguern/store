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
	
	if(!Util::IsAllowed('admin_log')) {
		header('Location: '.BASE_LINK.'/pages/not_allowed.php');
		exit();
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
<SCRIPT src="<?php echo BASE_LINK; ?>/scripts/calendar.js.php" type="text/javascript"></script>
<SCRIPT src="<?php echo BASE_LINK; ?>/scripts/script.js.php" type="text/javascript"></SCRIPT>
<SCRIPT type="text/javascript">
<?php
echo Util::PageGetDocumentReadyTop();
?>

    //if submit button is clicked
    $('#delete').click(function () {

    	var checkProblem = false;
        var missingFields = false;
        
        //Get the data from all the fields
        var log_delete_start_date = $('input[id=log_delete_start_date]');
        var log_delete_end_date = $('input[id=log_delete_end_date]');
        
        //Simple validation to make sure user entered something
        //If error found, add hightlight class to the text field
        if (log_delete_start_date.val()=='') {
        	log_delete_start_date.addClass('missingvalue');
        	missingFields = true;
        	checkProblem = true;
        } else log_delete_start_date.removeClass('missingvalue');

        if (log_delete_end_date.val()=='') {
        	log_delete_end_date.addClass('missingvalue');
        	missingFields = true;
        	checkProblem = true;
        } else log_delete_end_date.removeClass('missingvalue');

        if (missingFields) {
        	$('span[id=message]').html('<?php echo MISSING_FIELDS_ERROR; ?>');
            $('div[id=notification]').show();
        }
        
        if (checkProblem) {
            return false;
        }

        
		var answer = confirm("<?php echo ADMIN_LOG_DELETE_QUESTION; ?>");
        
        if (!answer) {
            return false;
        }
        
        //organize the data properly
        var data = 'log_delete_start_date=' + log_delete_start_date.val() + '&log_delete_end_date=' + log_delete_end_date.val();
       
        //show the loading sign
        //TO_DO
        //start the ajax
        $.ajax({
            //this is the php file that processes the data and send mail
            url: "_admin_log_delete.php",
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

<?php
    echo Util::PageGetDocumentReadyBottom();
?>

function showLogDeleteStartDateCalendar()
{
	var calendar = new CalendarPopup();

	calendar.showNavigationDropdowns();
	calendar.showYearNavigationInput();
	calendar.setYearSelectStartOffset(50);

	var input = document.getElementById('log_delete_start_date');
	
	calendar.select(input,'log_delete_start_date_button','dd/MM/yyyy');
	
	return false;
}

function showLogDeleteEndDateCalendar()
{
	var calendar = new CalendarPopup();

	calendar.showNavigationDropdowns();
	calendar.showYearNavigationInput();
	calendar.setYearSelectStartOffset(50);

	var input = document.getElementById('log_delete_end_date');
	
	calendar.select(input,'log_delete_end_date_button','dd/MM/yyyy');
	
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
	<ul class="crumb admin_log_crumb" itemprop="breadcrumb">
		<li typeof="v:Breadcrumb">
			<a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/index.php" title="'.MENU_HOME.'" rel="v:url" property="v:title" >'.MENU_HOME.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin.php" rel="v:url" property="v:title" >'.ADMIN_TITLE.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><span class="title"><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin_log.php" rel="v:url" property="v:title" >'.ADMIN_LOG_LIST_TITLE.'</A></span>
		</li>
	</ul>
</div>
<div id="main">
<form method="POST" action="admin_log.php">
	<TABLE>
		<TR>
			<TD>
				<TABLE>
					<TR>
						<TD>'.ADMIN_LOG_DELETE_START_DATE.' :</TD>
						<TD class="field_separator"></TD>
						<TD>
							<INPUT TYPE="text" ID="log_delete_start_date" NAME="log_delete_start_date" VALUE=""><img src="../images/index/calendar_little.gif" id="log_delete_start_date_button" onclick="javascript:showLogDeleteStartDateCalendar();">
							'.ADMIN_LOG_DELETE_END_DATE.' :
							<INPUT TYPE="text" ID="log_delete_end_date" NAME="log_delete_end_date" VALUE=""><img src="../images/index/calendar_little.gif" id="log_delete_end_date_button" onclick="javascript:showLogDeleteEndDateCalendar();">
							<INPUT TYPE="submit" ID="delete" NAME="delete" VALUE="'.ADMIN_LOG_DELETE_DELETE.'" ALT="'.ADMIN_LOG_DELETE_DELETE.'">
						</TD>
					</TR>
				</TABLE>
			</TD>
		</TR>
		<TR>
			<TD class="max_separator"></TD>
		</TR>
		<TR>
			<TD>'.Util::AdminGetLogList().'</TD>
		</TR>
	</TABLE>
</form>
</div></div>
'.Util::PageGetBottom().'
</BODY>
</HTML>';

