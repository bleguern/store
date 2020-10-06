<?php  
/* V1.4
 * 
 * V1.1 : 20130624 : Major update
 * V1.2 : 20131007 : Item type 2 added
 * V1.3 : 20131015 : Item specific price added
 * V1.4 : 20131015 : META update
 * 
 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	if (!isset($_SESSION[SITE_ID]['connection_id'])) {
		Util::Init();
	}
	
	$id = Util::GetPostValue('id');
	$type = Util::GetPostValue('type');
	$slide = Util::GetPostValue('slide');
	
	if (($id == '') || 
		($type == '')) {
		header('Location: index.php');
		exit();
	}
	
	if ($slide == '') {
		$slide = '0';
	}
	
	$title = '';
	$image = $_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/images/index/question_little.jpg';
	
	if ($type == 'item') {
		try {
			$data = new Data();
			$dataSpecific = new DataSpecific();
		
			$current = $dataSpecific->ItemGet($id);
			$_REQUEST['item_type'] = $current[1];
			$_REQUEST['item_type_2'] = $current[2];
			$_REQUEST['item_type_name'] = $current[3];
			$_REQUEST['item_type_2_name'] = $current[4];
			$_REQUEST['item_active'] = $current[5];
			$_REQUEST['item_name'] = $current[6];
		
			$currentText =  $data->ItemGetText($id, strtoupper($_SESSION[SITE_ID]['lang']));
		
			if (count($currentText) > 1) {
				$_REQUEST['item_text_lang'] = $currentText[1];
				$_REQUEST['item_text_value'] = $currentText[2];
			} else {
				$_REQUEST['item_text_lang'] = '';
				$_REQUEST['item_text_value'] = '';
			}
		
			$firstImage =  $data->ImageGetFirst($id, $type);
			$imageList =  $data->ImageGetList($id, $type);
		} catch (DataException $ex) {
			$_REQUEST['message'] = $ex->getMessage();
		}
		
		if (isset($_REQUEST['item_name']) && ($_REQUEST['item_name'] != '')) {
			$title .= ucfirst($_REQUEST['item_name']);
		}
		
		if ($_REQUEST['item_type_name'] == 'SALES') {
			$title .= ' ['.TO_SELL.']';
		}
		
		if (isset($_REQUEST['item_type_name']) && ($_REQUEST['item_type_name'] != '')) {
			$title .= ' | '.constant($_REQUEST['item_type_name']);
		}
		
		if (isset($_REQUEST['item_type_2_name']) && ($_REQUEST['item_type_2_name'] != '')) {
			$title .= ' - '.constant($_REQUEST['item_type_2_name']);
		}
	} else if ($type == 'blog') {
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
		
			$firstImage =  $data->ImageGetFirst($id, $type);
			$imageList =  $data->ImageGetList($id, $type);
			
			if (isset($_REQUEST['blog_text_title']) && ($_REQUEST['blog_text_title'] != '')) {
				$title .= $_REQUEST['blog_text_title'];
			}
		} catch (DataException $ex) {
			$_REQUEST['message'] = $ex->getMessage();
		}
	}
	
	$title .= ' | '.SITE_TITLE;
?>
<?php echo Util::PageGetHtmlTop(); ?>
<HEAD>
<TITLE><?php 
echo $title;
?></TITLE>
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
<LINK REL="STYLESHEET" href="<?php echo BASE_LINK; ?>/css/jquery.bxslider.css" type="text/css">
<SCRIPT src="<?php echo BASE_LINK; ?>/scripts/jquery-latest.js" type="text/javascript"></SCRIPT>
<SCRIPT src="<?php echo BASE_LINK; ?>/scripts/jquery.easing.1.3.js" type="text/javascript"></SCRIPT>
<SCRIPT src="<?php echo BASE_LINK; ?>/scripts/jquery.bxslider.js" type="text/javascript"></SCRIPT>
<SCRIPT src="<?php echo BASE_LINK; ?>/scripts/script.js.php" type="text/javascript"></SCRIPT>
<SCRIPT type="text/javascript">

	$(document).ready(function(){
		$('.slider1').bxSlider({
			slideWidth: 1600,
			adaptiveHeight:true,
			minSlides: 1,
			maxSlides: 1,
			startSlide: <?php echo $slide; ?>
		});
	});
	
</SCRIPT>
</HEAD>
<?php 
echo '<BODY>
		<div class="slider1">';

	if (($firstImage != NULL) && (count($firstImage) > 2)) {
		echo '<div class="slide">
					<img src="'.IMAGE_FULL_LINK.$firstImage[1].'.'.$firstImage[2].'">';
		
		if (($firstImage[4] != '') ||
			($firstImage[3] != '')) {
			echo '<div id="gallery_copyright">';
				
			if ($firstImage[4] != '') {
				echo '<A HREF="'.$firstImage[4].'" TARGET="_blank">';
			}
			
			echo '<div id="gallery_copyright_image"><img src="../images/index/copyright.png"></div>
				  <div id="gallery_copyright_text">';
				
			if ($firstImage[5] != '') {
				echo '('.$firstImage[5].') ';
			}
				
			echo $firstImage[3].'</div>';
				
			if ($firstImage[4] != '') {
				echo '</A>';
			}
				
			echo '</div>';
		}
	
		echo '</div>';
		
		if (isset($imageList)) {
			if (count($imageList) == 1) {
				echo '<div class="slide">
						<img src="'.IMAGE_FULL_LINK.$imageList[0][1].'.'.$imageList[0][2].'">';
					
				if (($imageList[0][4] != '') ||
					($imageList[0][3] != '')) {
					echo '<div id="gallery_copyright">';
					
					if ($imageList[0][4] != '') {
						echo '<A HREF="'.$imageList[0][4].'" TARGET="_blank">';
					}
					
					echo '<div id="gallery_copyright_image"><img src="../images/index/copyright.png"></div>
						  <div id="gallery_copyright_text">';
					
					if ($imageList[0][5] != '') {
						echo '('.$imageList[0][5].') ';
					}
					
					echo $imageList[0][3].'</div>';
					
					if ($imageList[0][4] != '') {
						echo '</A>';
					}
					
					echo '</div>';
				}
				
				echo '</div>';
			} else {
				foreach($imageList as $image) {
					echo '<div class="slide">
							<img src="'.IMAGE_FULL_LINK.$image[1].'.'.$image[2].'">';
					
					if (($image[4] != '') ||
						($image[3] != '')) {
						echo '<div id="gallery_copyright">';
			
						if ($image[4] != '') {
							echo '<A HREF="'.$image[4].'" TARGET="_blank">';
						}
						
						echo '<div id="gallery_copyright_image"><img src="../images/index/copyright.png"></div>
						  	  <div id="gallery_copyright_text">';
			
						if ($image[5] != '') {
							echo '('.$image[5].') ';
						}
			
						echo $image[3].'</div>';
			
						if ($image[4] != '') {
							echo '</A>';
						}
			
						echo '</div>';
					}
					
					echo '</div>';
				}
			}
		}
	} else {
		echo '<div class="slide">
				<A HREF="../pages/gallery.php?id='.$id.'" TARGET="_blank">
					<img src="'.BASE_LINK.'/images/index/question_little.jpg">
				</A>
			  </div>';
	}
		
  	echo '</div>
	</BODY>
</HTML>';
?>