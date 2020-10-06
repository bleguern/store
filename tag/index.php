<?php  
/* V1.2
 * 
 * V1.1 : 20130624 : Major update
 * V1.2 : 20131015 : Like box update
 * 
 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	if (!isset($_SESSION[SITE_ID]['connection_id'])) {
		Util::Init();
	}
	
	$tag = Util::GetPostValue('tag');
	
	if($tag == '') {
		header('Location: '.BASE_LINK.'/pages/index.php');  
		exit();
	}
?>
<?php echo Util::PageGetHtmlTop(); ?>
<HEAD>
<TITLE><?php echo TAG.' : '.urldecode($tag).' | '.SITE_TITLE; ?></TITLE>
<?php
echo Util::PageGetMeta();
?>
<LINK REL="SHORTCUT ICON" HREF="<?php echo BASE_LINK; ?>/images/ico/favicon.ico">
<LINK REL="STYLESHEET" href="<?php  

echo BASE_LINK.'/css/'.$_SESSION[SITE_ID]['admin_configuration_theme'].'.css';

?>" type="text/css"> 
<LINK REL="STYLESHEET" media="handheld , (max-width: 1000px)" href="<?php  

echo BASE_LINK.'/css/mobile.css';

?>" type="text/css">
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
'.Util::PageGetFacebookTop().'
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
			<a href="'.BASE_LINK.'/pages/index.php" title="'.MENU_HOME.'" rel="v:url" property="v:title" >'.MENU_HOME.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><a href="'.BASE_LINK.'/tag/index.php?tag='.$tag.'" title="'.TAG.' : '.urldecode($tag).'" rel="v:url" property="v:title" >'.TAG.' : '.urldecode($tag).'</A>
		</li>
	</ul>
</div>
<div id="main">
'.UtilSpecific::SearchTag(urldecode($tag)).'
</div></div>
'.Util::PageGetBottom().'
</BODY>
</HTML>';