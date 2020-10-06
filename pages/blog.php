<?php  
/* V1.3
 * 
 * V1.1 : 20130624 : Major update
 * V1.2 : 20131015 : Like box update
 * V1.3 : 20131015 : META update
 * 
 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	if (!isset($_SESSION[SITE_ID]['connection_id'])) {
		Util::Init();
	}
	
	$id = Util::GetPostValue('id');
	
	if($id == '') {
		header('Location: '.BASE_LINK.'/pages/index.php');
		exit();
	}

	try {
		$data = new Data();
		
		$current = $data->BlogGet($id);
		$_REQUEST['blog_active'] = $current[1];
		$_REQUEST['blog_last_update_date'] = $current[2];
		$_REQUEST['admin_user_login'] = $current[3];
		$_REQUEST['admin_user_email'] = $current[4];
		$_REQUEST['blog_creation_date'] = $current[5];
		$_REQUEST['blog_hit'] = $current[6];
		
		$currentText =  $data->BlogGetText($id);
		$_REQUEST['blog_text_id'] = $currentText[0];
		$_REQUEST['blog_text_lang'] = $currentText[1];
		$_REQUEST['blog_text_title'] = $currentText[2];
		$_REQUEST['blog_text_value'] = $currentText[3];
		
		$date_modified = DateTime::createFromFormat(PHP_DATETIME_FORMAT, $_REQUEST['blog_last_update_date']);
		$date_on = date('d/m/Y', $date_modified->getTimestamp());
		$time_on = date('H:i:s', $date_modified->getTimestamp());
		$date_modified_schema_format = date('Y-m-d\TH:i', $date_modified->getTimestamp());
			
		$date_created = DateTime::createFromFormat(PHP_DATETIME_FORMAT, $_REQUEST['blog_creation_date']);
		$date_created_schema_format = date('Y-m-d\TH:i', $date_created->getTimestamp());
		
		$firstImage =  $data->ImageGetFirst($id, 'blog');
		$imageList =  $data->ImageGetList($id, 'blog');
		
		$tagList = $data->BlogTagGetList($id);
		
		$blog_keywords = '';
			
		if ($tagList != NULL && (count($tagList) > 0)) {
			foreach($tagList as $tag) {
				$blog_keywords .= $tag[0].' ';
			}
		}
		
		$data->BlogAddHit($id);
	} catch (DataException $ex) {
		$_REQUEST['message'] = $ex->getMessage();
	}
?>
<?php echo Util::PageGetHtmlTop(); ?>
<HEAD>
<TITLE><?php 

if (isset($_REQUEST['blog_text_title']) && ($_REQUEST['blog_text_title'] != '')) {
	echo $_REQUEST['blog_text_title'].' | ';
}

echo SITE_TITLE;

?></TITLE>
<?php
echo Util::PageGetLightMeta();

if (isset($_REQUEST['blog_text_value']) && ($_REQUEST['blog_text_value'] != '')) {
	echo '<META NAME="DESCRIPTION" LANG="'.$_REQUEST['blog_text_lang'].'" content="'.str_replace('"', '', str_replace('<br>', '', $_REQUEST['blog_text_value'])).'">';
}

if (isset($_REQUEST['blog_text_title']) && ($_REQUEST['blog_text_title'] != '')) {
	echo '<META NAME="KEYWORDS" LANG="FR" content="'.META_KEYWORDS_FR.', '.$_REQUEST['blog_text_title'].'">
	      <META NAME="KEYWORDS" LANG="EN" content="'.META_KEYWORDS_EN.', '.$_REQUEST['blog_text_title'].'">
	      <META NAME="KEYWORDS" LANG="DE" content="'.META_KEYWORDS_DE.', '.$_REQUEST['blog_text_title'].'">';
}

?>
<LINK REL="SHORTCUT ICON" HREF="<?php echo BASE_LINK; ?>/images/ico/favicon.ico">
<LINK REL="STYLESHEET" href="<?php  

echo BASE_LINK.'/css/'.$_SESSION[SITE_ID]['admin_configuration_theme'].'.css';

?>" type="text/css"> 
<LINK REL="STYLESHEET" media="handheld , (max-width: 1000px)" href="<?php  

echo BASE_LINK.'/css/mobile.css';

?>" type="text/css">
<LINK REL="STYLESHEET" href="<?php echo BASE_LINK; ?>/css/jquery.bxslider.css" type="text/css">
<SCRIPT src="<?php echo BASE_LINK; ?>/scripts/jquery-latest.js" type="text/javascript"></SCRIPT>
<SCRIPT src="<?php echo BASE_LINK; ?>/scripts/jquery.easing.1.3.js" type="text/javascript"></SCRIPT>
<SCRIPT src="<?php echo BASE_LINK; ?>/scripts/jquery.bxslider.js" type="text/javascript"></SCRIPT>
<SCRIPT src="<?php echo BASE_LINK; ?>/scripts/script.js.php" type="text/javascript"></SCRIPT>
<SCRIPT type="text/javascript">
<?php
echo Util::PageGetDocumentReadyTop().'
'.Util::PageGetDocumentReadyBottom();
?>
$(document).ready(function(){
	$('.slider1').bxSlider({
		slideWidth: 600,
		adaptiveHeight:true,
		minSlides: 1,
		maxSlides: 1
	});
});
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
			<span class="arrow">></span><a href="'.BASE_LINK.'/blog/index.php" title="'.MENU_BLOG.'" rel="v:url" property="v:title" >'.MENU_BLOG.'</A>
		</li>
		<li>
			<span class="arrow">></span><span class="title"><a href="'.BASE_LINK.''.$_SERVER['PHP_SELF'].'">'.ucfirst($_REQUEST['blog_text_title']).'</a></span>
		</li>
	</ul>
</div>
<div id="main" itemscope itemtype="http://schema.org/Blog">
<span class="hidden"><a title="'.MENU_BLOG.' | '.SITE_TITLE.'" href="'.BASE_LINK.'/blog/index.php" itemprop="url">'.MENU_BLOG.' | '.SITE_TITLE.'</a></span>
<span class="hidden" itemprop="name">'.MENU_BLOG.' | '.SITE_TITLE.'</span>
		<DIV id="blog" itemscope="" itemtype="http://schema.org/BlogPosting">
			<span class="hidden"><A HREF=\''.BASE_LINK.''.$_SERVER['PHP_SELF'].'\' target=\'_self\' itemprop="url">'.ucfirst($_REQUEST['blog_text_title']).'</A></span>
			<span itemprop="name" class="hidden">'.ucfirst($_REQUEST['blog_text_title']).'</span>
			<DIV id="blog_image">';

if (($firstImage != NULL) && (count($firstImage) > 2)) {
	echo '<A HREF="../pages/gallery.php?type=blog&id='.$id.'&slide=0" TARGET="_blank"><img itemprop="image" src="'.IMAGE_MEDIUM_LINK.$firstImage[1].'.'.$firstImage[2].'" class="medium_image"></A>';
} else {
	echo '<img itemprop="image" src="../images/index/question_little.jpg" class="medium_image">';
}
		  echo '</DIV>
	 		<DIV id="blog_text">
				<span class="blog_text_date">'.ON.$date_on.AT.$time_on.BY.' <A HREF="mailto:'.$_REQUEST['admin_user_email'].'?subject='.SITE_TITLE.' - '.$_REQUEST['blog_text_title'].'" TARGET="_blank">'.$_REQUEST['admin_user_login'].'</A></span>
				<span datetime="'.$date_created_schema_format.'" itemprop="datecreated" class="hidden">'.$date_created_schema_format.'</span>
				<span datetime="'.$date_modified_schema_format.'" itemprop="datemodified" class="hidden">'.$date_modified_schema_format.'</span>
				<BR><BR>
				<span class="blog_text_text" itemprop="articleBody">'.$_REQUEST['blog_text_value'].'</span>
				<span class="hidden" itemprop="keywords">'.$blog_keywords.'</span>
				<meta itemprop="interactionCount" content="UserPageVisits:'.$_REQUEST['blog_hit'].'" />
				<BR><BR>
				<div>
					<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
					<a class="addthis_button_tweet"></a>
					<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
				</div>
				<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-525e7da107f3c1ef"></script>
			</DIV>
		</DIV>';
	
	  if ($imageList != NULL && count($imageList) > 0) {
	  
	  	echo '<DIV id="item_part">
			<div id="subtitle">
			 	<span class="subtitle">'.ITEM_PHOTO_GALLERY.'</span></TD>
			</div>
		 	<DIV id="item_part_content">';
	  		
	  	if (count($imageList) == 1) {
	  		echo '<div class="slider1">
					<div class="slide">
						<A HREF="../pages/gallery.php?type=blog&id='.$id.'&slide=1" TARGET="_blank">
							<img src="'.IMAGE_FULL_LINK.$imageList[0][1].'.'.$imageList[0][2].'">
						</A>
					</div>
				  </div>';
		} else {
	  		echo '<div class="slider1">';

			$i = 1;
			
			foreach($imageList as $image) {
				echo '<div class="slide">
									<A HREF="../pages/gallery.php?type=blog&id='.$id.'&slide='.$i.'" TARGET="_blank">
										<img src="'.IMAGE_FULL_LINK.$image[1].'.'.$image[2].'">
									</A>
								  </div>';
			
				$i++;
			}
			
			echo '</div>';
	  	}
	  
	  	echo '</div></div>';
	  }
		  
	echo '<div id="subtitle"><DIV id="tag_link_title">'.TAGS.' : </DIV><DIV id="tag_link_list">';
	
	if ($tagList != NULL && (count($tagList) > 0)) {
		foreach($tagList as $tag) {
			echo '<li class="tag_link"><A href="'.BASE_LINK.'/tag/index.php?tag='.$tag[0].'" TARGET="_self" rel="tag">'.$tag[0].'</A></li>';
		}
	}
	
	echo '</div>
	 	  <DIV id="blog_bottom">
	 		<DIV id="blog_bottom_back"><INPUT TYPE="button" ID="back" NAME="back" VALUE="'.BACK.'" ALT="'.BACK.'" OnClick="javascript:history.back();"></DIV>
			<input type="hidden" id="id" name="id" value="'.$id.'">
		</DIV>
</div>
</div>
'.Util::PageGetBottom().'
</BODY>
</HTML>';

?>