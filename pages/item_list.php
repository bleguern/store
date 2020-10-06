<?php  
/* V1.2
 * 
 * V1.1 : 20130624 : Major update
 * V1.2 : 20131007 : Item type2 added
 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	if (!isset($_SESSION[SITE_ID]['connection_id'])) {
		Util::Init();
	}
	
	$type = Util::GetPostValue('type');
	$type2 = Util::GetPostValue('type2');
	$brand = Util::GetPostValue('brand');
	
	if (($type == '') && ($type2 == '') && ($brand == '')) {
		header('Location: index.php');
		exit();
	}
	
	$type_name = Util::GetItemTypeName($type);
	$type2_name = Util::GetItemType2Name($type2);
	$brand_name = UtilSpecific::GetItemSpecificBrandName($brand);
	
	$title = '';
	
	if ($type_name != '') {
		$title .= $type_name;
	}
	
	if ($type2_name != '') {
		if ($type_name != '') {
			$title .= ' - ';
		}
		
		$title .= $type2_name;
	}
	
	if ($brand_name != '') {
		if (($type_name != '') || ($type2_name != '')) {
			$title .= ' | ';
		}
		
		$title .= $brand_name;
	}
	
	$title .= ' | '.SITE_TITLE;
?>
<?php echo Util::PageGetHtmlTop(); ?>
<HEAD>
<TITLE><?php echo $title; ?></TITLE>
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
echo Util::PageGetDocumentReadyTop().'
'.Util::PageGetDocumentReadyBottom();
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
	<ul class="crumb item_crumb" itemprop="breadcrumb">
		<li typeof="v:Breadcrumb" >
			<a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/index.php" title="'.MENU_HOME.'" rel="v:url" property="v:title" >'.MENU_HOME.'</A>
		</li>';

	if ($type != '') {
echo '<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/item_list.php?type='.$type.'&type2=" title="'.$type_name.'" rel="v:url" property="v:title" >'.$type_name.'</A>
		</li>';
	}

	if ($type2 != '') {
echo '<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/item_list.php?type='.$type.'&type2='.$type2.'" title="'.$type2_name.'" rel="v:url" property="v:title" >'.$type2_name.'</A>
		</li>';
	}
	
	if ($brand != '') {
		echo '<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/item_list.php?brand='.$brand.'" title="'.$brand_name.'" rel="v:url" property="v:title" >'.$brand_name.'</A>
		</li>';
	}
echo '</ul>
</div>
<div id="main">
<div id="item_list">'.UtilSpecific::GetActiveItemListByType($type, $type2, $brand).'</div>
</div></div>
'.Util::PageGetBottom().'
</BODY>
</HTML>';