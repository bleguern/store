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
	
	if(!Util::IsAllowed('admin_access')) {
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
		
		$current = $data->AdminAccessGet($id);
		$_REQUEST['access_url'] = $current[1];
		$_REQUEST['access_description'] = $current[2];
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
        var access_url = $('input[id=access_url]');
        var access_description = $('input[id=access_description]');
        
        //Simple validation to make sure user entered something
        //If error found, add hightlight class to the text field
        if (access_url.val()=='') {
        	access_url.addClass('missingvalue');
        	missingFields = true;
        	checkProblem = true;
        } else access_url.removeClass('missingvalue');

        if (missingFields) {
        	$('span[id=message]').html('<?php echo MISSING_FIELDS_ERROR; ?>');
            $('div[id=notification]').show();
        }
        
        if (checkProblem) {
            return false;
        }
        
        //organize the data properly
        var data = 'id=' + id.val() + '&access_url=' + access_url.val() + '&access_description=' + access_description.val();
       
        //show the loading sign
        //TO_DO
        //start the ajax
        $.ajax({
            //this is the php file that processes the data and send mail
            url: "_admin_access_update.php",
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

    // Access delete
	$('#delete').click(function () {
        
        //Get the data from all the fields
        var id = $('input[id=id]');
        var access_url = $('input[id=access_url]');
        var access_description = $('input[id=access_description]');
        
        //organize the data properly
        var data = 'id=' + id.val();

        var answer = confirm("<?php echo ADMIN_ACCESS_DELETE_QUESTION; ?>")
        
        if (!answer) {
            return false;
        }
       
        //show the loading sign
        //TO_DO
        //start the ajax
        $.ajax({
            //this is the php file that processes the data and send mail
            url: "_admin_access_delete.php",
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

                access_url.attr('disabled', 'disabled');
                access_description.attr('disabled', 'disabled');
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
	<ul class="crumb admin_access_crumb" itemprop="breadcrumb">
		<li typeof="v:Breadcrumb">
			<a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/index.php" title="'.MENU_HOME.'" rel="v:url" property="v:title" >'.MENU_HOME.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin.php" rel="v:url" property="v:title" >'.ADMIN_TITLE.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin_access.php" rel="v:url" property="v:title" >'.ADMIN_ACCESS_LIST_TITLE.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><span class="title"><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin_access_update.php?id='.$id.'" rel="v:url" property="v:title" >'.ADMIN_ACCESS_UPDATE_TITLE.'</A></span> | <a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin_access_add.php" >'.ADMIN_ACCESS_ADD_TITLE.'</A>
		</li>
	</ul>
</div>
<div id="main">
<form method="POST" action="_admin_access_update.php">
	  	<TABLE>
    		<TR>
				<TD>
					<TABLE>
						<TR>
							<TD>'.ADMIN_ACCESS_URL.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="access_url" NAME="access_url" VALUE="'.$_REQUEST['access_url'].'" STYLE="width:200px" MAXLENGTH="50">
							</TD>
						</TR>
					</TABLE>
				<TD>
			</TR>
			
			<TR>
				<TD>
					<TABLE>
						<TR>
							<TD>'.ADMIN_ACCESS_DESCRIPTION.' :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="access_description" NAME="access_description" VALUE="'.$_REQUEST['access_description'].'" STYLE="width:300px" MAXLENGTH="200">
							</TD>
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
								<INPUT TYPE="submit" ID="submit" NAME="submit" VALUE="'.ADMIN_ACCESS_UPDATE_UPDATE.'" ALT="'.ADMIN_ACCESS_UPDATE_UPDATE.'">
								<INPUT TYPE="submit" ID="delete" NAME="delete" VALUE="'.ADMIN_ACCESS_DELETE_DELETE.'" ALT="'.ADMIN_ACCESS_DELETE_DELETE.'">
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