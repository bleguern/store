<?php  
/* V1.2
 * 
 * V1.1 : 20130624 : Major update
 * V1.2 : 20130624 : Type 2 added
 * 
 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	if (!isset($_SESSION[SITE_ID]['connection_id'])) {
		Util::Init();
	}
	
	if(!Util::IsAllowed('admin_item')) {
		header('Location: '.BASE_LINK.'/pages/not_allowed.php');
		exit();
	}
	
	$item_active_selected = Util::GetPostValue('item_active');
	$item_type_selected = Util::GetPostValue('item_type');
	$item_type2_selected = Util::GetPostValue('item_type2');
	
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
	$('#item_active_select').change(function () {
		var item_active_select = $('select[id=item_active_select]');
	    var item_active = $('input[id=item_active]');
	    var item_type = $('input[id=item_type]');
	    var item_type2 = $('input[id=item_type2]');
	
	    selectedValue = item_active_select.val();
	    selectedText = selectedValue.split(',')[1];
	    selectedValue = selectedValue.split(',')[0];
	
	    item_active.val(selectedValue);
	    
	    location.href = 'admin_item.php?item_active=' + item_active.val() + '&item_type=' + item_type.val() + '&item_type2=' + item_type2.val();
	    return false;
	});
	
	
	$('#item_type_select').change(function () {
		var item_type_select = $('select[id=item_type_select]');
		var item_type = $('input[id=item_type]');
	    var item_active = $('input[id=item_active]');
	    var item_type2 = $('input[id=item_type2]');
	
	    selectedValue = item_type_select.val();
	    selectedText = selectedValue.split(',')[1];
	    selectedValue = selectedValue.split(',')[0];
	
	    item_type.val(selectedValue);
	    
	    location.href = 'admin_item.php?item_active=' + item_active.val() + '&item_type=' + item_type.val() + '&item_type2=' + item_type2.val();
	    return false;
	});

	$('#item_type2_select').change(function () {
		var item_type2_select = $('select[id=item_type2_select]');
		var item_type2 = $('input[id=item_type2]');
		var item_type = $('input[id=item_type]');
	    var item_active = $('input[id=item_active]');
	    
	    selectedValue = item_type2_select.val();
	    selectedText = selectedValue.split(',')[1];
	    selectedValue = selectedValue.split(',')[0];
	
	    item_type2.val(selectedValue);
	    
	    location.href = 'admin_item.php?item_active=' + item_active.val() + '&item_type=' + item_type.val() + '&item_type2=' + item_type2.val();
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
	<ul class="crumb admin_item_crumb" itemprop="breadcrumb">
		<li typeof="v:Breadcrumb">
			<a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/index.php" title="'.MENU_HOME.'" rel="v:url" property="v:title" >'.MENU_HOME.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin.php" rel="v:url" property="v:title" >'.ADMIN_TITLE.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><span class="title"><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin_item.php" rel="v:url" property="v:title" >'.ITEM_LIST_TITLE.'</A></span> | <a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin_item_add.php" >'.ITEM_ADD_TITLE.'</A>
		</li>
	</ul>
	<a class="excel" href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/_admin_item_export_to_excel.php">'.EXPORT_TO_EXCEL.'</a>
</div>
<div id="main">
<TABLE>
	<TR>
		<TD>
			<TABLE>
				<TR>
					<TD>'.ITEM_ACTIVE.' :</TD>
					<TD class="field_separator"></TD>
					<TD>';

	echo '<select id="item_active_select" name="item_active_select">';
	echo $data->DisplayBooleanList($item_active_selected);
	echo '</select>';
			
				echo '<input type="hidden" id="item_active" name="item_active" value="'.$item_active_selected.'"></TD>
					  <TD class="field_separator"></TD>
					  <TD>'.ITEM_TYPE.' :</TD>
					  <TD>';
				
	echo '<select id="item_type_select" name="item_type_select">';
	echo $data->ItemTypeDisplayList($item_type_selected);
	echo '</select>';
			
				echo '<input type="hidden" id="item_type" name="item_type" value="'.$item_type_selected.'"></TD>
					  <TD class="field_separator"></TD>
					  <TD>'.ITEM_TYPE_2.' :</TD>
					  <TD>';
				
	echo '<select id="item_type2_select" name="item_type2_select">';
	echo $data->ItemType2DisplayList($item_type2_selected);
	echo '</select>';
			
				echo '<input type="hidden" id="item_type2" name="item_type2" value="'.$item_type2_selected.'"></TD>
				</TR>
			</TABLE>
		<TD>
	</TR>
	<TR>
		<TD>'.UtilSpecific::AdminGetItemList($item_active_selected, $item_type_selected, $item_type2_selected).'</TD>
	</TR>
</TABLE>
</div></div>
'.Util::PageGetBottom().'
</BODY>
</HTML>';