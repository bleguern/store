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
	
	if(!Util::IsAllowed('admin_version')) {
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
		
		$current = $data->AdminVersionGet($id);
		$_REQUEST['admin_version_date'] = $current[1];
		$_REQUEST['admin_version_number'] = $current[2];
		$_REQUEST['admin_version_name'] = $current[3];
		$_REQUEST['admin_version_description'] = $current[4];
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
<SCRIPT src="<?php echo BASE_LINK; ?>/scripts/calendar.js.php" type="text/javascript"></script>
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
        var admin_version_number = $('input[id=admin_version_number]');
        var admin_version_name = $('input[id=admin_version_name]');
        var admin_version_date = $('input[id=admin_version_date]');
        var admin_version_description = $('textarea[id=admin_version_description]');
        
        //Simple validation to make sure user entered something
        //If error found, add hightlight class to the text field
        if (admin_version_number.val()=='') {
        	admin_version_number.addClass('missingvalue');
        	checkProblem = true;
        	missingFields = true;
        } else admin_version_number.removeClass('missingvalue');

        if (admin_version_name.val()=='') {
        	admin_version_name.addClass('missingvalue');
        	checkProblem = true;
        	missingFields = true;
        } else admin_version_name.removeClass('missingvalue');

        if (admin_version_date.val()=='') {
        	admin_version_date.addClass('missingvalue');
        	checkProblem = true;
        	missingFields = true;
        } else admin_version_date.removeClass('missingvalue');

        if (missingFields) {
        	$('span[id=message]').html('<?php echo MISSING_FIELDS_ERROR; ?>');
            $('div[id=notification]').show();
        }
        
        if (checkProblem) {
            return false;
        }
        
        //organize the data properly
        var data = 'id=' + id.val() + '&admin_version_number=' + admin_version_number.val() + '&admin_version_name=' + admin_version_name.val() +
        		   '&admin_version_date=' + admin_version_date.val() + '&admin_version_description=' + admin_version_description.val().replace(/\n/g, "<br>");
       
        //show the loading sign
        //TO_DO
        //start the ajax
        $.ajax({
            //this is the php file that processes the data and send mail
            url: "_admin_version_update.php",
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
        var admin_version_number = $('input[id=admin_version_number]');
        var admin_version_name = $('input[id=admin_version_name]');
        var admin_version_date = $('input[id=admin_version_date]');
        var admin_version_description = $('textarea[id=admin_version_description]');

		var answer = confirm("<?php echo ADMIN_VERSION_DELETE_QUESTION; ?>");
        
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
            url: "_admin_version_delete.php",
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

                admin_version_number.attr('disabled', 'disabled');
                admin_version_name.attr('disabled', 'disabled');
                admin_version_date.attr('disabled', 'disabled');
                admin_version_description.attr('disabled', 'disabled');
                
                $('#submit').attr('disabled', 'disabled');
                $('#delete').attr('disabled', 'disabled');
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
			<span class="arrow">></span><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin_version.php" rel="v:url" property="v:title" >'.ADMIN_VERSION_LIST_TITLE.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><span class="title"><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin_version_update.php?id='.$id.'" rel="v:url" property="v:title" >'.ADMIN_VERSION_UPDATE_TITLE.'</A></span> | <a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin_version_add.php" >'.ADMIN_VERSION_ADD_TITLE.'</A>
		</li>
	</ul>
</div>
<div id="main">
<form method="POST" action="_admin_version_update.php">
	  	<TABLE>
			<TR>
				<TD>
					<TABLE>
						<TR>
							<TD>'.ADMIN_VERSION_NUMBER.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="admin_version_number" NAME="admin_version_number" VALUE="'.$_REQUEST['admin_version_number'].'" STYLE="width:100px" MAXLENGTH="10">
							</TD>
						</TR>
						<TR>
							<TD class="max_separator"></TD>
						</TR>
						<TR>
							<TD>'.ADMIN_VERSION_NAME.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="admin_version_name" NAME="admin_version_name" VALUE="'.$_REQUEST['admin_version_name'].'" STYLE="width:200px" MAXLENGTH="50">
							</TD>
						</TR>
						<TR>
							<TD class="max_separator"></TD>
						</TR>
						<TR>
							<TD>'.ADMIN_VERSION_DATE.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="admin_version_date" NAME="admin_version_date" VALUE="'.$_REQUEST['admin_version_date'].'"><img src="../images/index/calendar_little.gif" id="admin_version_date_button" onclick="javascript:showDateCalendar();">
							</TD>
						</TR>
						<TR>
							<TD class="max_separator"></TD>
						</TR>
						<TR>
							<TD>'.ADMIN_VERSION_DESCRIPTION.' :</TD>
							<TD class="field_separator"></TD>
							<TD><textarea cols="60" rows="10" ID="admin_version_description" NAME="admin_version_description">'.str_replace("<br>", "\n", $_REQUEST['admin_version_description']).'</textarea></TD>
						</TR>
					</TABLE>
				<TD>
			</TR>
			<TR>
				<TD class="max_separator">
					<input type="hidden" id="id" name="id" value="'.$id.'">
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
								<INPUT TYPE="submit" ID="submit" NAME="submit" VALUE="'.ADMIN_VERSION_UPDATE_UPDATE.'" ALT="'.ADMIN_VERSION_UPDATE_UPDATE.'">
								<INPUT TYPE="submit" ID="delete" NAME="delete" VALUE="'.ADMIN_VERSION_DELETE_DELETE.'" ALT="'.ADMIN_VERSION_DELETE_DELETE.'">
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