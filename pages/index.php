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
echo Util::PageGetDocumentReadyBottom();
?>
</SCRIPT>
</HEAD>
<?php 
echo '<BODY>
'.Util::PageGetBodyTop().'
<DIV id="content">
<div id="notification"';
if(isset($_REQUEST['message']) && ($_REQUEST['message'] != '')) {
	echo ' style="display:block;"><span id="message">'.$_REQUEST['message'];
} else {
	 echo '><span id="message">';
}

echo '</span><a class="close" href="javascript:void(0)" onclick="$(\'div[id=notification]\').hide();return false;"></a></div>
<div id="title" xmlns:v="http://rdf.data-vocabulary.org/#">
	<ul class="crumb home_crumb" itemprop="breadcrumb">
		<li typeof="v:Breadcrumb" >
			<a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/index.php" title="'.MENU_HOME.'" rel="v:url" property="v:title" >'.MENU_HOME.'</A>
		</li>
	</ul>
</div>
<DIV id="main">
	<DIV id="welcome_note">'.WELCOME_NOTE.'</div>';

if ($_SESSION[SITE_ID]['admin_configuration_home_show_items']) {
echo '<div id="subtitle">
 		<span class="subtitle">'.ITEM_LAST_LIST_TITLE.'</span></TD>
	</div>
	<DIV id="home_list">
'.UtilSpecific::GetHomeActiveItemList().'
	</DIV>';
}

if ($_SESSION[SITE_ID]['admin_configuration_home_show_blog']) {
	echo '<div id="subtitle">
 		<span class="subtitle">'.BLOG_LAST_LIST_TITLE.'</span></TD>
	</div>
	<DIV id="home_list">
'.Util::GetHomeActiveBlogList().'
	</DIV>';
}

/*
echo '<div id="home_container">
		<div id="home_slides">
			<div class="home_slides_container">
			'.UtilSpecific::GetHomeActiveItemListSlides().'
			</div>
			<a href="#" class="prev"><img src="../images/index/slideshow/arrow-prev.png" width="24" height="43" alt="Arrow Prev"></a>
			<a href="#" class="next"><img src="../images/index/slideshow/arrow-next.png" width="24" height="43" alt="Arrow Next"></a>
		</div>
	</div>';*/

echo '
</div>
</div>
'.Util::PageGetBottom().'
</BODY>
</HTML>';