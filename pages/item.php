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
	
	if($id == '') {
		header('Location: '.BASE_LINK.'/pages/index.php');
		exit();
	}

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
		$_REQUEST['item_specific_price'] = $current[7];
		$_REQUEST['item_specific_admin_currency'] = $current[8];
		$_REQUEST['item_specific_admin_currency_code'] = $current[9];
		$_REQUEST['store_inventory_count'] = $current[10];
		$_REQUEST['item_specific_brand'] = $current[12];
		$_REQUEST['item_specific_brand_name'] = $current[13];
		
		$currentText =  $data->ItemGetText($id, strtoupper($_SESSION[SITE_ID]['lang']));
		
		$_REQUEST['item_text_lang'] = '';
		$_REQUEST['item_text_value'] = '';
		
		if (count($currentText) > 1) {
			$_REQUEST['item_text_lang'] = $currentText[1];
			$_REQUEST['item_text_value'] = $currentText[2];
		}
		
		$firstImage = $data->ImageGetFirst($id, 'item');
		$imageList = $data->ImageGetList($id, 'item');
		
		$tagList = $data->ItemTagGetList($id);
		
		$data->ItemAddHit($id);
	} catch (DataException $ex) {
		$_REQUEST['message'] = $ex->getMessage();
	}
	
	$title = '';
	$image = BASE_LINK.'/images/index/question_little.jpg';
	
	if (isset($_REQUEST['item_name']) && ($_REQUEST['item_name'] != '')) {
		$title .= ucfirst($_REQUEST['item_name']);
	}
	
	if (isset($_REQUEST['item_type_name']) && ($_REQUEST['item_type_name'] != '')) {
		$title .= ' | '.constant($_REQUEST['item_type_name']);
	}
	
	if (isset($_REQUEST['item_type_2_name']) && ($_REQUEST['item_type_2_name'] != '')) {
		$title .= ' - '.constant($_REQUEST['item_type_2_name']);
	}
	
	if (isset($_REQUEST['item_specific_brand_name']) && ($_REQUEST['item_specific_brand_name'] != '')) {
		$title .= ' - '.$_REQUEST['item_specific_brand_name'];
	}
	
	$title .= ' | '.SITE_TITLE;
	
	if (($firstImage != NULL) && (count($firstImage) > 2)) {
		$image = BASE_LINK.IMAGE_MEDIUM.$firstImage[1].'.'.$firstImage[2];
	}
?>
<?php echo Util::PageGetHtmlTop(); ?>
<HEAD>
<TITLE><?php 
echo $title;
?></TITLE>
<?php
echo Util::PageGetMetaV2(str_replace('"', '', str_replace('<br>', ' ', $_REQUEST['item_text_value'])),
						 $_REQUEST['item_name'],
						 $title,
						 BASE_LINK.'/item/'.$id.'-'.Util::GetPageName($_REQUEST['item_name']).PAGE_EXTENSION,
						 $image,
					     'product',
					     BASE_LINK);

?>
<link rel="CANONICAL" href="<?php echo BASE_LINK.'/item/'.$id.'-'.Util::GetPageName($_REQUEST['item_name']).PAGE_EXTENSION; ?>" />
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
	echo Util::PageGetDocumentReadyTop();
	
	if ($_SESSION[SITE_ID]['admin_configuration_store_enabled']) {
?>
	//if submit button is clicked
	$('.addtobasket').click(function () {
	
		var checkProblem = false;
	    //Get the data from all the fields
	    var id = $(this).attr("name");
	
		var data = 'id=' + id;
	
	    //start the ajax
	    $.ajax({
	        //this is the php file that processes the data and send mail
	        url: "<?php echo BASE_LINK; ?>/pages/_basket_add.php",
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
	            window.setTimeout('location.reload()', 1500);
	        }
	    });
	    
	    //cancel the submit button default behaviours
	    return false;
	});

<?php
	}
	
	echo Util::PageGetDocumentReadyBottom();
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
			<span class="arrow">></span><a href="'.BASE_LINK.'/pages/item_list.php?type='.$_REQUEST['item_type'].'" title="'.constant($_REQUEST['item_type_name']).'" rel="v:url" property="v:title" >'.constant($_REQUEST['item_type_name']).'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><a href="'.BASE_LINK.'/pages/item_list.php?type='.$_REQUEST['item_type'].'&type2='.$_REQUEST['item_type_2'].'" title="'.constant($_REQUEST['item_type_2_name']).'" rel="v:url" property="v:title" >'.constant($_REQUEST['item_type_2_name']).'</A>
		</li>
		<li>
			<span class="arrow">></span><span class="title"><a href="'.BASE_LINK.'/item/'.$id.'-'.Util::GetPageName($_REQUEST['item_name']).PAGE_EXTENSION.'">'.ucfirst($_REQUEST['item_name']).'</a></span>
		</li>
	</ul>
</div>
<div itemscope itemtype="http://schema.org/Product" id="main">
	<span itemprop="name" class="hidden">'.ucfirst($_REQUEST['item_name']).'</span>
	<span itemprop="productID" class="hidden">'.$id.'</span>';

if ($_REQUEST['item_specific_brand_name'] != '') {
	echo '<span itemprop="brand" class="hidden">'.$_REQUEST['item_specific_brand_name'].'</span>';
}

	echo '<DIV id="item_header">
		<DIV id="item_header_image">';
if (($firstImage != NULL) && (count($firstImage) > 2)) {
	echo '<A HREF="../pages/gallery.php?type=item&id='.$id.'&slide=0" TARGET="_blank">
		  <img itemprop="image" src="'.IMAGE_MEDIUM_LINK.$firstImage[1].'.'.$firstImage[2].'" class="medium_image"></A>';
} else {
	echo '<img itemprop="image" src="'.BASE_LINK.'/images/index/question_little.jpg" class="medium_image">';
}
		  echo '</DIV>
				<DIV ';
if($_SESSION[SITE_ID]['admin_configuration_store_enabled']) {
		echo 'itemprop="offers" itemscope itemtype="http://schema.org/Offer" ';
}
		echo 'id="item_header_text" >';

$item_type_name = '';
$item_type_2_name = '';
$item_specific_brand_name = '';
$item_specific_price = '';
$item_specific_admin_currency_code = '';

if ($_REQUEST['item_type_name'] != '') {
	$item_type_name = '<A HREF="'.BASE_LINK.'/pages/item_list.php?type='.$_REQUEST['item_type'].'" TARGET="_self">'.constant($_REQUEST['item_type_name']).'</A><BR>';
}

if ($_REQUEST['item_type_2_name'] != '') {
	$item_type_2_name = '<A HREF="'.BASE_LINK.'/pages/item_list.php?type2='.$_REQUEST['item_type_2'].'" TARGET="_self">'.constant($_REQUEST['item_type_2_name']).'</A><BR><BR>';
}

if ($_REQUEST['item_specific_brand_name'] != '') {
	$item_specific_brand_name = '<A HREF="'.BASE_LINK.'/pages/item_list.php?brand='.$_REQUEST['item_specific_brand'].'" TARGET="_self">'.$_REQUEST['item_specific_brand_name'].'</A><BR><BR>';
}

if (($_REQUEST['item_specific_price'] != '') && $_SESSION[SITE_ID]['admin_configuration_store_enabled']) {	
	$item_specific_price = '<B>'.ITEM_SPECIFIC_PRICE.' : '.$_REQUEST['item_specific_price'].' ';
}

if (($_REQUEST['item_specific_admin_currency_code'] != '') && $_SESSION[SITE_ID]['admin_configuration_store_enabled']) {
	if ($_REQUEST['item_specific_admin_currency_code'] == 'EUR') {
		$item_specific_admin_currency_code = '&euro;<span itemprop="price" class="hidden">'.$_REQUEST['item_specific_price'].'</span><span itemprop="priceCurrency" class="hidden">'.$_REQUEST['item_specific_admin_currency_code'].'</span><span itemprop="seller" class="hidden">'.SITE_TITLE.'</span></B><BR><BR>';
	}
}

echo $item_type_name.$item_type_2_name.$item_specific_brand_name.$item_specific_price.$item_specific_admin_currency_code;

if($_SESSION[SITE_ID]['admin_configuration_store_enabled']) {
	if (($_REQUEST['store_inventory_count'] != '') && ($_REQUEST['store_inventory_count'] > 0)) {
		echo '<link itemprop="availability" href="http://schema.org/InStock" content="In Stock" /><INPUT TYPE="button" class="addtobasket" ID="addtobasket_'.$id.'" NAME="'.$_REQUEST['id'].'" VALUE="'.ADD_TO_BASKET.'" ALT="'.ADD_TO_BASKET.'">';
	} else {
		echo '<link itemprop="availability" href="http://schema.org/OutOfStock" content="Out of Stock" /><INPUT TYPE="button" class="noaddtobasket" ID="addtobasket_'.$id.'" NAME="'.$_REQUEST['id'].'" VALUE="'.NOT_AVAILABLE.'" ALT="'.NOT_AVAILABLE.'">';
	}
}
	
		
		
		
		echo '<BR><BR>
				<div><a class="addthis_button_facebook_like" fb:like:layout="button_count"></a><a class="addthis_button_tweet"></a><a class="addthis_button_google_plusone" g:plusone:size="medium"></a></DIV>
		<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-525e7da107f3c1ef"></script>
			</DIV></DIV>
				';
		    
	if (isset($_REQUEST['item_text_value']) && ($_REQUEST['item_text_value'] != '')) {
		
		echo '<DIV id="item_part">
				<div id="subtitle">
				 	<span class="subtitle">'.ITEM_TEXT_VALUE.'</span>
				</div>
				<DIV id="item_part_content">
					<div itemprop="description" id="item_text">'.$_REQUEST['item_text_value'].'</DIV>
				</DIV>
			  </DIV>';
	}
				
				
	if ($imageList != NULL && count($imageList) > 0) {
	
		echo '<DIV id="item_part">
				<div id="subtitle">
				 	<span class="subtitle">'.ITEM_PHOTO_GALLERY.'</span></TD>
				</div>
			 	<DIV id="item_part_content">';
					
		if (count($imageList) == 1) {
			echo '<div class="slider1">
					<div class="slide">
						<A HREF="../pages/gallery.php?type=item&id='.$id.'&slide=1" TARGET="_blank">
						<img src="'.IMAGE_FULL_LINK.$imageList[0][1].'.'.$imageList[0][2].'">
							
						</A>
					</div>
				  </div>';
		} else {
			echo '<div class="slider1">';
			
			$i = 1;
			
			foreach($imageList as $image) {
				echo '<div class="slide">
						<A HREF="../pages/gallery.php?type=item&id='.$id.'&slide='.$i.'" TARGET="_blank">
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
			echo '<li class="tag_link"><A href="'.BASE_LINK.'/tag/index.php?tag='.urlencode($tag[0]).'" TARGET="_self" rel="tag">'.$tag[0].'</A></li>';
		}
	}
	
	echo '</div><DIV id="item_bottom">
			<DIV id="item_bottom_back"><INPUT TYPE="button" ID="back" NAME="back" VALUE="'.BACK.'" ALT="'.BACK.'" OnClick="javascript:history.back();"></DIV>
		  </DIV>
</div></div></div>'.Util::PageGetBottom().'
</BODY>
</HTML>';
?>