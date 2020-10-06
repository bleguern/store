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
	
	if(!Util::IsAllowed('admin_order_status')) {
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
		
		$current = $data->AdminOrderStatusGet($id);
		$_REQUEST['order_status_name'] = $current[1];
		$_REQUEST['order_status_active'] = $current[2];
		$_REQUEST['order_status_inventory_reserve'] = $current[4];
		$_REQUEST['order_status_inventory_cleanup'] = $current[4];
		$_REQUEST['order_status_lock'] = $current[5];
		$_REQUEST['order_status_other_possible_status'] = $current[6];
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
        var order_status_name = $('input[id=order_status_name]');
        var order_status_active_select = $('select[id=order_status_active_select]');
        var order_status_active = $('input[id=order_status_active]');
        var order_status_inventory_reserve_select = $('select[id=order_status_inventory_reserve_select]');
        var order_status_inventory_reserve = $('input[id=order_status_inventory_reserve]');
        var order_status_inventory_cleanup_select = $('select[id=order_status_inventory_cleanup_select]');
        var order_status_inventory_cleanup = $('input[id=order_status_inventory_cleanup]');
        var order_status_lock_select = $('select[id=order_status_lock_select]');
        var order_status_lock = $('input[id=order_status_lock]');
        var order_status_other_possible_status = $('input[id=order_status_other_possible_status]');
            
        //Simple validation to make sure user entered something
        //If error found, add hightlight class to the text field
        if (order_status_name.val()=='') {
        	order_status_name.addClass('missingvalue');
        	checkProblem = true;
        	missingFields = true;
        } else order_status_name.removeClass('missingvalue');

        if (order_status_active.val()=='') {
        	order_status_active_select.addClass('missingvalue');
        	checkProblem = true;
        	missingFields = true;
        } else order_status_active_select.removeClass('missingvalue');

        if (order_status_inventory_reserve.val()=='') {
        	order_status_inventory_reserve_select.addClass('missingvalue');
        	checkProblem = true;
        	missingFields = true;
        } else order_status_inventory_reserve_select.removeClass('missingvalue');

        if (order_status_inventory_cleanup.val()=='') {
        	order_status_inventory_cleanup_select.addClass('missingvalue');
        	checkProblem = true;
        	missingFields = true;
        } else order_status_inventory_cleanup_select.removeClass('missingvalue');

        if (order_status_lock.val()=='') {
        	order_status_lock_select.addClass('missingvalue');
        	checkProblem = true;
        	missingFields = true;
        } else order_status_lock_select.removeClass('missingvalue');

        if (missingFields) {
        	$('span[id=message]').html('<?php echo MISSING_FIELDS_ERROR; ?>');
            $('div[id=notification]').show();
        }
        
        if (checkProblem) {
            return false;
        }
        
        //organize the data properly
        var data = 'id=' + id.val() + '&order_status_name=' + order_status_name.val() + '&order_status_active=' + order_status_active.val() + '&order_status_inventory_reserve=' + order_status_inventory_reserve.val()
		   		 + '&order_status_inventory_cleanup=' + order_status_inventory_cleanup.val() + '&order_status_lock=' + order_status_lock.val()
				 + '&order_status_other_possible_status=' + order_status_other_possible_status.val();
       
        //show the loading sign
        //TO_DO
        //start the ajax
        $.ajax({
            //this is the php file that processes the data and send mail
            url: "_admin_order_status_update.php",
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
	<ul class="crumb admin_order_crumb" itemprop="breadcrumb">
		<li typeof="v:Breadcrumb">
			<a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/index.php" title="'.MENU_HOME.'" rel="v:url" property="v:title" >'.MENU_HOME.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin.php" rel="v:url" property="v:title" >'.ADMIN_TITLE.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin_order_status.php" rel="v:url" property="v:title" >'.ADMIN_ORDER_STATUS_LIST_TITLE.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><span class="title"><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin_order_status_update.php?id='.$id.'" rel="v:url" property="v:title" >'.ADMIN_ORDER_STATUS_UPDATE_TITLE.'</A></span> | <a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin_order_status_add.php" >'.ADMIN_ORDER_STATUS_ADD_TITLE.'</A>
		</li>
	</ul>
</div>
<div id="main">
	<form method="POST" action="_admin_order_status_update.php">
		<TABLE>
			<TR>
				<TD>
					<TABLE>
						<TR>
							<TD>'.ADMIN_ORDER_STATUS_NAME.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="order_status_name" NAME="order_status_name" VALUE="'.$_REQUEST['order_status_name'].'" STYLE="width:300px" MAXLENGTH="50">
							</TD>
						</TR>
					</TABLE>
				<TD>
			</TR>
        	<TR>
				<TD>
					<TABLE>
						<TR>
							<TD>'.ADMIN_ORDER_STATUS_ACTIVE.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>';
			
	$active_selected = $_REQUEST['order_status_active'];

	echo '<select id="order_status_active_select" name="order_status_active_select" onChange="javascript:updateSelect(\'order_status_active_select\')">';
		echo $data->DisplayBooleanList($active_selected);
	echo '</select>';
			
						echo '</TD>
						</TR>
        			</TABLE>
				<TD>
			</TR>
			<TR>
				<TD>
					<TABLE>
						<TR>
							<TD>'.ADMIN_ORDER_STATUS_INVENTORY_RESERVE.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>';
			
	$reserve_selected = $_REQUEST['order_status_inventory_reserve'];

	echo '<select id="order_status_inventory_reserve_select" name="order_status_inventory_reserve_select" onChange="javascript:updateSelect(\'order_status_inventory_reserve_select\')">';
		echo $data->DisplayBooleanList($reserve_selected);
	echo '</select>';
			
						echo '</TD>
						</TR>
        			</TABLE>
				<TD>
			</TR>
        	<TR>
				<TD>
					<TABLE>
						<TR>
							<TD>'.ADMIN_ORDER_STATUS_INVENTORY_CLEANUP.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>';
			
	$cleanup_selected = $_REQUEST['order_status_inventory_cleanup'];

	echo '<select id="order_status_inventory_cleanup_select" name="order_status_inventory_cleanup_select" onChange="javascript:updateSelect(\'order_status_inventory_cleanup_select\')">';
		echo $data->DisplayBooleanList($cleanup_selected);
	echo '</select>';
			
						echo '</TD>
						</TR>
        			</TABLE>
				<TD>
			</TR>
        	<TR>
				<TD>
					<TABLE>
						<TR>
							<TD>'.ADMIN_ORDER_STATUS_LOCK.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>';
			
	$lock_selected = $_REQUEST['order_status_lock'];

	echo '<select id="order_status_lock_select" name="order_status_lock_select" onChange="javascript:updateSelect(\'order_status_lock_select\')">';
		echo $data->DisplayBooleanList($lock_selected);
	echo '</select>';
			
						echo '</TD>
						</TR>
        			</TABLE>
				<TD>
			</TR>
			<TR>
				<TD>
					<TABLE>
						<TR>
							<TD>'.ADMIN_ORDER_STATUS_OTHER_POSSIBLE_STATUS.' :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="order_status_other_possible_status" NAME="order_status_other_possible_status" VALUE="'.$_REQUEST['order_status_other_possible_status'].'" STYLE="width:100px" MAXLENGTH="20">
							</TD>
						</TR>
					</TABLE>
				<TD>
			</TR>
			<TR>
				<TD class="max_separator">
					<input type="hidden" id="id" name="id" value="'.$id.'">
					<input type="hidden" id="order_status_active" name="order_status_active" value="'.$active_selected.'">
        			<input type="hidden" id="order_status_inventory_reserve" name="order_status_inventory_reserve" value="'.$reserve_selected.'">
        			<input type="hidden" id="order_status_inventory_cleanup" name="order_status_inventory_cleanup" value="'.$cleanup_selected.'">
					<input type="hidden" id="order_status_lock" name="order_status_lock" value="'.$lock_selected.'">
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
								<INPUT TYPE="submit" ID="submit" NAME="submit" VALUE="'.ADMIN_ORDER_STATUS_UPDATE_UPDATE.'" ALT="'.ADMIN_ORDER_STATUS_UPDATE_UPDATE.'">
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