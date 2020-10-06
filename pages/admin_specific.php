<?php  
/* V1.0 : 20130927 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	if (!isset($_SESSION[SITE_ID]['connection_id'])) {
		Util::Init();
	}
	
	// Param
	$table_name = '';
	$script = '';
	// End param
	
	// Param init
	$data = new Data();
	
	$parameters = '';
		
	if (isset($_REQUEST['table']) && ($_REQUEST['table'] != '')) {
		$table_name = $_REQUEST['table'];
		$parameters .= 'table='.$_REQUEST['table'];
	}
	
	if (isset($_REQUEST['field']) && ($_REQUEST['field'] != '')) {
		$hidden_field = $_REQUEST['field'];
		
		if ($parameters != '') {
			$parameters .= '&';
		}
		
		$parameters .= 'field='.$hidden_field;
	}
	
	if (isset($_REQUEST['field_value']) && ($_REQUEST['field_value'] != '')) {
		$hidden_field_value = $_REQUEST['field_value'];
		
		if ($parameters != '') {
			$parameters .= '&';
		}
		
		$parameters .= 'field_value='.$hidden_field_value;
	}
	
	// End param init

	if ($table_name == '') {
		header('Location: error.php?message='.ADMIN_MISSING_SPECIFIC_TABLE);
		exit();
	} else {
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
	<ul class="crumb admin_specific_crumb" itemprop="breadcrumb">
		<li typeof="v:Breadcrumb">
			<a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/index.php" title="'.MENU_HOME.'" rel="v:url" property="v:title" >'.MENU_HOME.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin.php" rel="v:url" property="v:title" >'.ADMIN_TITLE.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><span class="title"><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin_specific.php?'.$parameters.'" rel="v:url" property="v:title" >'.constant('ADMIN_'.strtoupper($table_name).'_LIST_TITLE').'</A></span> | <a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin_specific_add.php?'.$parameters.'" >'.constant('ADMIN_'.strtoupper($table_name).'_ADD_TITLE').'</A>
		</li>
	</ul>
</div>
<div id="main">
<TABLE>
	<TR>
		<TD>'.Util::AdminGetSpecificList($table_name).'</TD>
	</TR>
</TABLE>
</div></div>
'.Util::PageGetBottom().'
</BODY>
</HTML>';
	}