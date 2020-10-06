<?php  
/* V1.0
 * 
 * V1.0 : 20140130 : Major update
 * 
 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	if(!$_SESSION[SITE_ID]['admin_configuration_store_enabled']) {
		header('Location: index.php');
		exit();
	}
	
	if (!isset($_SESSION[SITE_ID]['connection_id'])) {
		Util::Init();
	}
	
	if(!Util::IsAllowed('admin_order')) {
		header('Location: '.BASE_LINK.'/pages/not_allowed.php');
		exit();
	}
	
	$order_status_selected = Util::GetPostValue('order_status');
	$order_user_selected = Util::GetPostValue('order_user');
	
	try {
		$data = new Data();
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
	$('#order_status_select').change(function () {
		var order_status_select = $('select[id=order_status_select]');
	    var order_status = $('input[id=order_status]');
	    var order_user = $('input[id=order_user]');

	    selectedValue = order_status_select.val();
        selectedText = selectedValue.split(',')[1];
        selectedValue = selectedValue.split(',')[0];

        order_status.val(selectedValue);
        
        location.href = 'admin_order.php?order_status=' + order_status.val() + '&order_user=' + order_user.val();
	    return false;
	});


	$('#order_user_select').change(function () {
		var order_user_select = $('select[id=order_user_select]');
	    var order_user = $('input[id=order_user]');
	    var order_status = $('input[id=order_status]');

	    selectedValue = order_user_select.val();
        selectedText = selectedValue.split(',')[1];
        selectedValue = selectedValue.split(',')[0];

        order_user.val(selectedValue);
        
        location.href = 'admin_order.php?order_status=' + order_status.val() + '&order_user=' + order_user.val();
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
			<span class="arrow">></span><span class="title"><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin_order.php" rel="v:url" property="v:title" >'.ADMIN_ORDER_LIST_TITLE.'</A></span>
		</li>
	</ul>
</div>
<div id="main">
<TABLE>
	<TR>
		<TD class="main_sub_section_text"></TD>
		<DIV id="item_top_back"><INPUT TYPE="button" ID="back" NAME="back" VALUE="'.BACK.'" ALT="'.BACK.'" OnClick="javascript:history.back();"></DIV>
	</TR>
	<TR>
		<TD>
			<TABLE>
				<TR>
					<TD>'.ORDER_STATUS.' :</TD>
					<TD class="field_separator"></TD>
					<TD>';

	echo '<select id="order_status_select" name="order_status_select">';
	echo $data->OrderStatusDisplayList($order_status_selected);
	echo '</select>';
			
				echo '<input type="hidden" id="order_status" name="order_status" value="'.$order_status_selected.'"></TD>
					  <TD class="field_separator"></TD>
					  <TD>'.ORDER_USER.' :</TD>
					  <TD>';
				
	echo '<select id="order_user_select" name="order_user_select">';
	echo $data->OrderUserDisplayList($order_user_selected);
	echo '</select>';
			
				echo '<input type="hidden" id="order_user" name="order_user" value="'.$order_user_selected.'"></TD>
				</TR>
			</TABLE>
		<TD>
	</TR>
	<TR>
		<TD>'.Util::AdminGetOrderList($order_status_selected, $order_user_selected).'</TD>
	</TR>
	<TR>
		<TD class="main_sub_section_text"></TD>
		<DIV id="item_bottom_back"><INPUT TYPE="button" ID="back" NAME="back" VALUE="'.BACK.'" ALT="'.BACK.'" OnClick="javascript:history.back();"></DIV>
	</TR>
</TABLE>
</div></div>
'.Util::PageGetBottom().'
</BODY>
</HTML>';