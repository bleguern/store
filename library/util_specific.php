<?php

$root = dirname(__FILE__)."/../";
include_once($root.'./library/data.php');

class UtilSpecificException extends Exception
{
	public function __construct($message) {
		parent :: __construct($message);
	}

	public function getError() {
		return $this->getMessage();
	}
}

class UtilSpecific
{
	public function __construct() {

	}

	public function __destruct() {

	}
	
	///////////////////////////////////////////////////////////////////////
	//////////////       STANDARD WITH SPECIFIC PART      /////////////////
	///////////////////////////////////////////////////////////////////////
	
	public static function PageGetMenu() {
		
		$result = '';
		
		try {
			$menu = null;
			$data = new Data();
			$dataSpecific = new DataSpecific();
			$tmp_menu = $data->AdminMenuGetList();
			
			for($i=0, $j = 0; $i < count($tmp_menu); $i++) {
				if ((($tmp_menu[$i][9] == '') || Util::IsAllowed($tmp_menu[$i][9])) &&
				    ($_SESSION[SITE_ID]['admin_configuration_blog_enabled'] || (($tmp_menu[$i][1] != 'MENU_BLOG') &&  ($tmp_menu[$i][1] != 'MENU_ADMIN_BLOG'))) &&
				    ($_SESSION[SITE_ID]['admin_configuration_store_enabled'] || (($tmp_menu[$i][1] != 'MENU_CONNECTION_BASKET') && ($tmp_menu[$i][1] != 'MENU_CONNECTION_ORDER'))))
				{
					$menu[$j] = $tmp_menu[$i];
					$j++;
					
					if (($tmp_menu[$i][10] != '') || ($tmp_menu[$i][11] != '')) {
						
						if ($tmp_menu[$i][10] != '') {
							if ($tmp_menu[$i][11] != '') {
								$item_list = $dataSpecific->ItemGetActiveListByTypeAndType2($tmp_menu[$i][10], $tmp_menu[$i][11]);
							} else {
								$item_list = $dataSpecific->ItemGetActiveListByType($tmp_menu[$i][10]);
							}
						} else {
							$item_list = $dataSpecific->ItemGetActiveListByType2($tmp_menu[$i][11]);
						}
						
						for ($k = 0; $k < count($item_list); $k++) {
							$new_menu = Array();
							$new_menu[0] = '';
							$new_menu[1] = $item_list[$k][6];
							$new_menu[2] = '';
							$new_menu[3] = ITEM_MENU_LINK.$item_list[$k][0].'-'.Util::GetPageName($item_list[$k][6]).PAGE_EXTENSION;
							$new_menu[4] = '_self';
							$new_menu[5] = $tmp_menu[$i][5];
							$new_menu[6] = $k + 1;
							$new_menu[7] = '';
							$new_menu[8] = '';
							$new_menu[9] = '';
							$new_menu[10] = 'NO';
							$new_menu[11] = 'NO';
							$new_menu[12] = $tmp_menu[$i][12];
							$new_menu[13] = '';
							
							$menu[$j] = $new_menu;
							$j++;
						}
					}
				}
			}
		
			$tmp_menu = NULL;
		
			$current_level_0 = -1;
			$current_level_1 = -1;
		
			$result .= '
				<DIV id="menu_container" class="clearfix">
					<nav id="menu">
						<div id="menu_toggle" class="menu_toggle">
							<span class="menu_toggle_text">'.MENU.'</span>
							<span class="menu_toggle_icon"></span>
							<span class="menu_toggle_links">';
			
			$result .= '<DIV id="search_toggle">
							<input type="text" id="search_toggle_value" name="search_toggle_value" value="'.SEARCH.'" maxlength="50">
							<input type="button" id="search_toggle_button" name="search_toggle_button" value="" alt="'.SEARCH.'">
						</div>&nbsp;|&nbsp;';
			
			if ($_SESSION[SITE_ID]['admin_configuration_store_enabled'] == '1') {
				$result .= '<a href="'.BASE_LINK.'/pages/basket.php" TARGET="_self">'.MENU_CONNECTION_BASKET.' ('.$data->BasketGetCount().')</A>&nbsp;|&nbsp;';
			}
			
			if (isset($_SESSION[SITE_ID]['authenticated'])) {
				$result .= '<a href="'.BASE_LINK.'/pages/logout.php" TARGET="_self"> '.MENU_DISCONNECTION.'</A>';
			} else {
				$result .= '<a href="'.BASE_LINK.'/pages/login.php" TARGET="_self"> '.MENU_CONNECTION.'</A>';
			}
			
			
			$result .= '</span></div>
						';
		
			if (isset($menu)) {
				for ($i=0, $j=0; $i < count($menu); $i++) {
			
					$style = $menu[$i][12];
					
					if ($i == 0) {
						$current_level_0 = $menu[$i][5];        // admin_menu_level_0
						$current_level_1 = $menu[$i][6];        // admin_menu_level_1
						$result .= '<ul class="menu">
							<li id="sub_menu_'.$j.'" class="'.$style.'"';
							$j++;
					} else {
						if ($current_level_0 == $menu[$i][5]) { // admin_menu_level_0
							if (($menu[$i][6] != '0') && ($menu[$i-1][6] == '0')) {          // admin_menu_level_1
								$result .= '
								<div class="sub_menu"><ul class="sub_menu">
									<li class="sub_menu"';
								
							} else {
								$result .= '</li>
									<li class="sub_menu"';
							}
						} else {
							if (($current_level_1 != '0') && ($menu[$i][6] == '0')) { // admin_menu_level_1
								$result .= '</li>
								</ul></div>
							</li>
							<li id="sub_menu_'.$j.'" class="'.$style.'"';
							$j++;
							} else {
								$result .= '</li>
							<li id="sub_menu_'.$j.'" class="'.$style.'"';
							$j++;
							}
						}
					}
					
					$str = '';
					$label = '';
						
					if ($menu[$i][10] != 'NO') {
						if (($menu[$i][1] == 'MENU_CONNECTION') && isset($_SESSION[SITE_ID]['authenticated'])) {
							$label .= MENU_DISCONNECTION;
						} else {
							$label .= constant($menu[$i][1]);
						}
					} else {
						$label .= $menu[$i][1];
					}
						
					if ($menu[$i][13] != '') {
						$str .= '<img src="'.BASE_LINK.'/images/index/'.$menu[$i][13].'" class="menu_home" alt="'.$label.'"> ';
					}
						
					$str .= $label;
					
					if (($menu[$i][1] == 'MENU_CONNECTION_BASKET') && ($_SESSION[SITE_ID]['admin_configuration_store_enabled'] == '1')) {
						$str .= ' ('.$data->BasketGetCount().')';
					}
					
					if ($menu[$i][1] == 'MENU_SEARCH') {
						$str .=  '<DIV id="search">
							<input type="text" id="search_value" name="search_value" value="'.SEARCH.'" maxlength="50">
							<input type="button" id="search_button" name="search_button" value="" alt="'.SEARCH.'">
						</div>';
					}
					
					if ($menu[$i][1] != 'MENU_SEARCH') {
						if ($menu[$i][6] == '0') {
							$result .= '><a href="../pages/'.$menu[$i][3].'" TARGET="'.$menu[$i][4].'" class="menu">'.$str.'</a>';
						} else {
							$result .= '><a href="../pages/'.$menu[$i][3].'" TARGET="'.$menu[$i][4].'" class="sub_menu">'.$str.'</a>';
						}
					} else {
						$result .= '>'.$str;
					}
			
					$current_level_0 = $menu[$i][5];        // admin_menu_level_0
					$current_level_1 = $menu[$i][6];        // admin_menu_level_1
				}
				
				if ($i > 0) {
					if ($current_level_1 != '0') {
						$result .= '</li>
								</ul>
							';
					}
				
					$result .= '</li>
						</ul>
					';
				}
			}
		
			$result .= '</nav></DIV>
			';
		
			$menu = null;
		
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = GET_MENU_ERROR;
		}
		
		return $result;
	}
	
	public static function Search($string) {
		
		$result = '';
		$string = strtoupper(trim($string));
		$item_result = null;
		$blog_result = null;

		try {
			$data = new Data();
			$dataSpecific = new DataSpecific();
			
			$i = 0;
			$item_list = $dataSpecific->ItemSearch();
			$item_result = null;
			
			for($j = 0; $j < count($item_list); $j++) {
				
				$string_in_tag = false;
				$tagList = $data->ItemTagGetList($item_list[$j][0]);
				
				if ($tagList != NULL && (count($tagList) > 0)) {
					foreach($tagList as $tag) {
						if (strpos(strtoupper($tag[0]), $string) > -1) {
							$string_in_tag = true;
							break;
						}
					}
				}
				
				if ((strpos(strtoupper(constant($item_list[$j][3])), $string) > -1) ||
					(strpos(strtoupper(constant($item_list[$j][4])), $string) > -1) ||
					(strpos(strtoupper($item_list[$j][6]), $string) > -1) ||
					(strpos(strtoupper($item_list[$j][14]), $string) > -1) ||
					$string_in_tag) {
		
					$item_result[$i] = $item_list[$j];
					$i++;
				}
			}
			
			$i = 0;
			$blog_list = $data->BlogSearch();
			
			for($j = 0; $j < count($blog_list); $j++) {
				
				$string_in_tag = false;
				$tagList = $data->BlogTagGetList($blog_list[$j][0]);
				
				if ($tagList != NULL && (count($tagList) > 0)) {
					foreach($tagList as $tag) {
						if (strpos(strtoupper($tag[0]), $string) > -1) {
							$string_in_tag = true;
							break;
						}
					}
				}
				
				if ((strpos(strtoupper($blog_list[$j][4]), $string) > -1) ||
					(strpos(strtoupper($blog_list[$j][5]), $string) > -1) ||
					$string_in_tag) {

					$blog_result[$i] = $blog_list[$j];
					$i++;
				}
			}
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = SEARCH_ERROR;
		}
		
		
		$result .= '<div id="subtitle">
				 		<span class="subtitle">'.SEARCH_ITEMS.' ('.count($item_result).')</span></TD>
					</div>
					<DIV id="home_list">';
		
		for ($i=0, $j=0; $i < count($item_result); $i++) {
			if ($item_result[$i][6] != '') {
				$image = $data->ImageGetFirst($item_result[$i][0], 'item');
				$image_link = '';
		
				if (count($image) > 1) {
					$image_link = IMAGE_LITTLE_LINK.$image[1].'.'.$image[2];
				} else {
					$image_link = '../images/index/question_little.jpg';
				}
		
				$result .= '<DIV itemscope itemtype="http://schema.org/Product" id="home_list_item">
								<DIV id="home_list_item_image"><span itemprop="productID" class="hidden">'.$item_result[$i][0].'</span><span itemprop="name" class="hidden">'.ucfirst($item_result[$i][6]).'</span><span itemprop="brand" class="hidden">'.$item_result[$i][14].'</span><A HREF=\''.ITEM_LINK.$item_result[$i][0].'-'.Util::GetPageName($item_result[$i][6]).PAGE_EXTENSION.'\' target=\'_self\'><img itemprop="image" src="'.$image_link.'" alt="'.ucfirst($item_result[$i][6]);
		
				if ($item_list[$i][3] != '') {
					$result .= ' : '.constant($item_result[$i][3]);
				}
					
				if ($item_list[$i][4] != '') {
					$result .= ' - '.constant($item_result[$i][4]);
				}
					
				if ($item_list[$i][13] != '') {
					$result .= ' | '.$item_result[$i][14];
				}
		
				$result .= '" class="min_image" /></A></DIV>
								<DIV itemprop="offers" itemscope itemtype="http://schema.org/Offer" id="home_list_item_text"><span class="home_item_list_title"><A HREF=\''.ITEM_LINK.$item_result[$i][0].'-'.Util::GetPageName($item_result[$i][6]).PAGE_EXTENSION.'\' target=\'_self\'>'.ucfirst($item_result[$i][6]).'</A></span>';
					
				if ($item_result[$i][3] != '') {
					$result .= '<BR><A HREF="'.BASE_LINK.'/pages/item_list.php?type='.$item_result[$i][1].'" TARGET="_self">'.constant($item_result[$i][3]).'</A>';
				}
					
				if ($item_result[$i][4] != '') {
					$result .= ' - <A HREF="'.BASE_LINK.'/pages/item_list.php?type2='.$item_result[$i][2].'" TARGET="_self">'.constant($item_result[$i][4]).'</A>';
				}
					
				if ($item_result[$i][13] != '') {
					$result .= ' | <A HREF="'.BASE_LINK.'/pages/item_list.php?brand='.$item_result[$i][13].'" TARGET="_self"><i>'.$item_result[$i][14].'</i></A>';
				}
		
				if (($item_result[$i][8] != '') && $_SESSION[SITE_ID]['admin_configuration_store_enabled']) {
		
					$result .= '<BR>'.$item_result[$i][8];
		
					if (($item_result[$i][9] != '') && ($item_result[$i][9] == 'EUR')) {
						$result .= ' &euro;<span itemprop="price" class="hidden">'.$item_result[$i][8].'</span><span itemprop="priceCurrency" class="hidden">'.$item_result[$i][9].'</span><span itemprop="seller" class="hidden">'.SITE_TITLE.'</span><link itemprop="availability" href="http://schema.org/InStock" content="In Stock" />';
					}
				} else {
					$result .= '<BR><BR>';
				}
		
				$result .= '</DIV>
						</DIV>';
		
				$j++;
			}
		}
		
		$result .= '</DIV>';
		
		if($_SESSION[SITE_ID]['admin_configuration_blog_enabled'] == 1) {
			$result .= '<div id="subtitle">
			 				<span class="subtitle">'.SEARCH_BLOG.' ('.count($blog_result).')</span></TD>
						</div>
						<DIV id="home_list">';
			
			for ($i=0, $j=0; $i < count($blog_result); $i++) {
				if (($blog_result[$i][4] != '') && ($blog_result[$i][5] != '')) {
					$image_link = '';
			
					if (($blog_result[$i][1] != '') && ($blog_result[$i][2] != '')) {
						$image_link = IMAGE_LITTLE_LINK.$blog_result[$i][1].'.'.$blog_result[$i][2];
					} else {
						$image_link = '../images/index/question_little.jpg';
					}
			
					$date = DateTime::createFromFormat(PHP_DATETIME_FORMAT, $blog_result[$i][3]);
					$date_on = date('d/m/Y', $date->getTimestamp());
					$time_on = date('H:i:s', $date->getTimestamp());
			
					$blog_text = '';
					$text = explode('<br>', $blog_result[$i][5]);
						
					for ($j = 0; $j < 2; $j++) {
						if ($j > 0) {
							$blog_text .= '<br>';
						}
							
						if (isset($text[$j])) {
							$blog_text .= $text[$j];
						}
					}
						
					$blog_text .= ' <A HREF=\''.BLOG_LINK.$blog_result[$i][0].'-'.Util::GetPageName($blog_result[$i][4]).PAGE_EXTENSION.'\' target=\'_self\'><I>'.READ_NEXT.'</I></A>';
			
					$result .= '<DIV id="home_list_item">
									<DIV id="home_list_item_image"><A HREF=\''.BLOG_LINK.$blog_result[$i][0].'-'.Util::GetPageName($blog_result[$i][4]).PAGE_EXTENSION.'\' target=\'_self\'><img src="'.$image_link.'" alt="'.$blog_result[$i][4].'" class="min_image" /></A></DIV>
									<DIV id="home_list_item_text"><span class="home_blog_list_title"><A HREF=\''.BLOG_LINK.$blog_result[$i][0].'-'.Util::GetPageName($blog_result[$i][4]).PAGE_EXTENSION.'\' target=\'_self\'>'.$blog_result[$i][4].'</A></span>
										<BR><span class="home_blog_list_text" itemprop="articleBody">'.$blog_text.'</span>&nbsp;&nbsp;<span class="home_blog_list_date">'.$date_on.' '.$time_on. '</span></DIV>
								</DIV>';
						
					$j++;
				}
			}
			
			$result .= '</DIV>';
		}
		
		return $result;
	}
	
	public static function SearchTag($tag) {
	
		$result = '';
		$tag = strtoupper(trim($tag));
		$item_result = null;
		$blog_result = null;
	
		try {
			$data = new Data();
			$dataSpecific = new DataSpecific();
				
			$item_result = $dataSpecific->ItemSearchTag($tag);
			$blog_result = $data->BlogSearchTag($tag);
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = SEARCH_TAG_ERROR;
		}
	
		$result .= '<div id="subtitle">
				 		<span class="subtitle">'.TAG_ITEMS.' ('.count($item_result).')</span></TD>
					</div>
					<DIV id="home_list">';
	
		for ($i=0, $j=0; $i < count($item_result); $i++) {
			if ($item_result[$i][6] != '') {
				$image = $data->ImageGetFirst($item_result[$i][0], 'item');
				$image_link = '';
	
				if (count($image) > 1) {
					$image_link = IMAGE_LITTLE_LINK.$image[1].'.'.$image[2];
				} else {
					$image_link = BASE_LINK.'/images/index/question_little.jpg';
				}
	
				$result .= '<DIV itemscope itemtype="http://schema.org/Product" id="home_list_item">
								<DIV id="home_list_item_image"><span itemprop="productID" class="hidden">'.$item_result[$i][0].'</span><span itemprop="name" class="hidden">'.ucfirst($item_result[$i][6]).'</span><span itemprop="brand" class="hidden">'.$item_result[$i][14].'</span><A HREF=\''.ITEM_LINK.$item_result[$i][0].'-'.Util::GetPageName($item_result[$i][6]).PAGE_EXTENSION.'\' target=\'_self\'><img itemprop="image" src="'.$image_link.'" alt="'.ucfirst($item_result[$i][6]);
	
				if ($item_list[$i][3] != '') {
					$result .= ' : '.constant($item_result[$i][3]);
				}
					
				if ($item_list[$i][4] != '') {
					$result .= ' - '.constant($item_result[$i][4]);
				}
					
				if ($item_list[$i][13] != '') {
					$result .= ' | '.$item_result[$i][14];
				}
	
				$result .= '" class="min_image" /></A></DIV>
								<DIV itemprop="offers" itemscope itemtype="http://schema.org/Offer" id="home_list_item_text"><span class="home_item_list_title"><A HREF=\''.ITEM_LINK.$item_result[$i][0].'-'.Util::GetPageName($item_result[$i][6]).PAGE_EXTENSION.'\' target=\'_self\'>'.ucfirst($item_result[$i][6]).'</A></span>';
					
				if ($item_result[$i][3] != '') {
					$result .= '<BR><A HREF="../pages/item_list.php?type='.$item_result[$i][1].'" TARGET="_self">'.constant($item_result[$i][3]).'</A>';
				}
					
				if ($item_result[$i][4] != '') {
					$result .= ' - <A HREF="../pages/item_list.php?type2='.$item_result[$i][2].'" TARGET="_self">'.constant($item_result[$i][4]).'</A>';
				}
					
				if ($item_result[$i][13] != '') {
					$result .= ' | <A HREF=\'../pages/item_list.php?brand='.$item_result[$i][13].'\' TARGET=\'_self\'><i>'.$item_result[$i][14].'</i></A>';
				}
	
				if (($item_result[$i][8] != '') && $_SESSION[SITE_ID]['admin_configuration_store_enabled']) {
	
					$result .= '<BR>'.$item_result[$i][8];
	
					if (($item_result[$i][9] != '') && ($item_result[$i][9] == 'EUR')) {
						$result .= ' &euro;<span itemprop="price" class="hidden">'.$item_result[$i][8].'</span><span itemprop="priceCurrency" class="hidden">'.$item_result[$i][9].'</span><span itemprop="seller" class="hidden">'.SITE_TITLE.'</span><link itemprop="availability" href="http://schema.org/InStock" content="In Stock" />';
					}
				} else {
					$result .= '<BR><BR>';
				}
	
				$result .= '</DIV>
						</DIV>';
	
				$j++;
			}
		}
	
		$result .= '</DIV>';
	
		if($_SESSION[SITE_ID]['admin_configuration_blog_enabled'] == 1) {
			$result .= '<div id="subtitle">
			 				<span class="subtitle">'.TAG_BLOG.' ('.count($blog_result).')</span></TD>
						</div>
						<DIV id="home_list">';
				
			for ($i=0, $j=0; $i < count($blog_result); $i++) {
				if (($blog_result[$i][4] != '') && ($blog_result[$i][5] != '')) {
					$image = $data->ImageGetFirst($blog_result[$i][0], 'blog');
					$image_link = '';
		
					if (count($image) > 1) {
						$image_link = IMAGE_LITTLE_LINK.$image[1].'.'.$image[2];
					} else {
						$image_link = BASE_LINK.'/images/index/question_little.jpg';
					}
						
					$date = DateTime::createFromFormat(PHP_DATETIME_FORMAT, $blog_result[$i][3]);
					$date_on = date('d/m/Y', $date->getTimestamp());
					$time_on = date('H:i:s', $date->getTimestamp());
						
					$blog_text = '';
					$text = explode('<br>', $blog_result[$i][5]);
	
					for ($j = 0; $j < 2; $j++) {
						if ($j > 0) {
							$blog_text .= '<br>';
						}
							
						if (isset($text[$j])) {
							$blog_text .= $text[$j];
						}
					}
	
					$blog_text .= ' <A HREF=\''.BLOG_LINK.$blog_result[$i][0].'-'.Util::GetPageName($blog_result[$i][4]).PAGE_EXTENSION.'\' target=\'_self\'><I>'.READ_NEXT.'</I></A>';
						
					$result .= '<DIV id="home_list_item">
									<DIV id="home_list_item_image"><A HREF=\''.BLOG_LINK.$blog_result[$i][0].'-'.Util::GetPageName($blog_result[$i][4]).PAGE_EXTENSION.'\' target=\'_self\'><img src="'.$image_link.'" alt="'.$blog_result[$i][4].'" class="min_image" /></A></DIV>
									<DIV id="home_list_item_text"><span class="home_blog_list_title"><A HREF=\''.BLOG_LINK.$blog_result[$i][0].'-'.Util::GetPageName($blog_result[$i][4]).PAGE_EXTENSION.'\' target=\'_self\'>'.$blog_result[$i][4].'</A></span>
										<BR><span class="home_blog_list_text" itemprop="articleBody">'.$blog_text.'</span>&nbsp;&nbsp;<span class="home_blog_list_date">'.$date_on.' '.$time_on. '</span></DIV>
								</DIV>';
	
					$j++;
				}
			}
				
			$result .= '</DIV>';
		}
	
		return $result;
	}
	
	public static function AdminGetItemList($item_active = '', $item_type = '', $item_type2 = '') {
	
		try {
			$dataSpecific = new DataSpecific();
				
			$show_header = true;
			$max_row_per_page = 20;
			$style = 'admin';
			$order = -1;
			$sort = 'ASC';
	
			if(isset($_REQUEST['order'])) {
				$order = $_REQUEST['order'];
			}
	
			if(isset($_REQUEST['sort'])) {
				if ($_REQUEST['sort'] == 1) {
					$sort = 'DESC';
				}
			}
	
			$header_list = Array(Array(ITEM_IMAGE, 0, 'center', 'item_image', true, 0, 'admin_item_update.php', '_self'),
								 Array(ITEM_NAME, 6, 'left', 'text', true, null, null, null),
								 Array(ITEM_ACTIVE, 5, 'center', 'boolean', true, 0, '_admin_item_activate.php', '_self'),
								 Array(ITEM_TYPE, 3, 'left', 'constant', true, null, null, null),
								 Array(ITEM_TYPE_2, 4, 'left', 'constant', true, null, null, null),
								 Array(ITEM_SPECIFIC_PRICE, 10, 'left', 'integer', true, null, null, null), // SPECIFIC
								 Array(ITEM_HIT, 7, 'center', 'integer', true, null, null, null),
								 Array(LAST_UPDATE_DATE, 8, 'center', 'date', true, null, null, null),
								 Array(LAST_UPDATE_USER, 9, 'left', 'text', true, null, null, null));
	
			$item_list = $dataSpecific->AdminItemGetList($order, $sort, $item_active, $item_type, $item_type2);
	
			return Util::AdminGetList($header_list, $item_list, $show_header, $max_row_per_page, $style, $order, $sort);
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = ITEM_GET_LIST_ERROR;
		}
	}
	
	public static function GetHomeActiveItemList() {
	
		$result = '';
	
		try {
			$data = new Data();
			$dataSpecific = new DataSpecific();
			$item_list = $dataSpecific->ItemGetActiveList();
	
			for ($i=0, $j=0; $i < count($item_list); $i++) {
				if ($item_list[$i][6] != '') {
				$image = $data->ImageGetFirst($item_list[$i][0], 'item');
					$image_link = '';
	
					if (count($image) > 1) {
						$image_link = IMAGE_LITTLE_LINK.$image[1].'.'.$image[2];
					} else {
						$image_link = '../images/index/question_little.jpg';
					}
	
					$result .= '<DIV itemscope itemtype="http://schema.org/Product" id="home_list_item">
									<DIV id="home_list_item_image"><span itemprop="productID" class="hidden">'.$item_list[$i][0].'</span><span itemprop="name" class="hidden">'.ucfirst($item_list[$i][6]).'</span><span itemprop="brand" class="hidden">'.$item_list[$i][14].'</span><A HREF=\''.ITEM_LINK.$item_list[$i][0].'-'.Util::GetPageName($item_list[$i][6]).PAGE_EXTENSION.'\' target=\'_self\'><img itemprop="image" src="'.$image_link.'" alt="'.ucfirst($item_list[$i][6]);
						
					if ($item_list[$i][3] != '') {
						$result .= ' : '.constant($item_list[$i][3]);
					}
					
					if ($item_list[$i][4] != '') {
						$result .= ' - '.constant($item_list[$i][4]);
					}
					
					if ($item_list[$i][13] != '') {
						$result .= ' | '.$item_list[$i][14];
					}
						
					$result .= '" class="min_image" /></A></DIV>
									<DIV itemprop="offers" itemscope itemtype="http://schema.org/Offer" id="home_list_item_text"><span class="home_item_list_title"><A HREF=\''.ITEM_LINK.$item_list[$i][0].'-'.Util::GetPageName($item_list[$i][6]).PAGE_EXTENSION.'\' target=\'_self\'>'.ucfirst($item_list[$i][6]).'</A></span>';
					
					if ($item_list[$i][3] != '') {
						$result .= '<BR><A HREF="../pages/item_list.php?type='.$item_list[$i][1].'" TARGET="_self">'.constant($item_list[$i][3]).'</A>';
					}
					
					if ($item_list[$i][4] != '') {
						$result .= ' - <A HREF="../pages/item_list.php?type2='.$item_list[$i][2].'" TARGET="_self">'.constant($item_list[$i][4]).'</A>';
					}
					
					if ($item_list[$i][13] != '') {
						$result .= ' | <A HREF=\'../pages/item_list.php?brand='.$item_list[$i][13].'\' TARGET=\'_self\'><i>'.$item_list[$i][14].'</i></A>';
					}
	
					if (($item_list[$i][8] != '') && $_SESSION[SITE_ID]['admin_configuration_store_enabled']) {
	
						$result .= '<BR>'.$item_list[$i][8];
						
						if (($item_list[$i][9] != '') && ($item_list[$i][9] == 'EUR')) {
							$result .= ' &euro;<span itemprop="price" class="hidden">'.$item_list[$i][8].'</span><span itemprop="priceCurrency" class="hidden">'.$item_list[$i][9].'</span><span itemprop="seller" class="hidden">'.SITE_TITLE.'</span><link itemprop="availability" href="http://schema.org/InStock" content="In Stock" />';
						}
					} else {
						$result .= '<BR><BR>';
					}
						
					$result .= '</DIV>
							</DIV>';
						
					if ($j >= $_SESSION[SITE_ID]['admin_configuration_home_items_number'] - 1) {
						break;
					} else {
						$j++;
					}
				}
			}
	
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = ERROR_GET_HOME_ACTIVE_ITEM_LIST;
		}
	
		return $result;
	}
	
	public static function GetHomeActiveItemListSlides() {
	
		$result = '';
	
		try {
			$data = new Data();
			$dataSpecific = new DataSpecific();
			$item_list = $dataSpecific->ItemGetActiveList();
	
			for ($i=0, $j=0; $i < count($item_list); $i++) {
				if ($item_list[$i][6] != '') {
				$image = $data->ImageGetFirst($item_list[$i][0], 'item');
					$image_link = '';
	
					if (count($image) > 1) {
						$image_link = IMAGE_LITTLE_LINK.$image[1].'.'.$image[2];
					} else {
						$image_link = '../images/index/question_little.jpg';
					}
	
					$result .= '<DIV id="home_list_item_slides">
									<DIV id="home_list_item_slides_image"><A HREF=\''.ITEM_LINK.$item_list[$i][0].'-'.Util::GetPageName($item_list[$i][6]).PAGE_EXTENSION.'\' target=\'_self\'><img src="'.$image_link.'" alt="'.$item_list[$i][6];
	
					if ($item_list[$i][3] != '') {
						$result .= ' : '.constant($item_list[$i][3]);
					}
						
					if ($item_list[$i][4] != '') {
						$result .= ' - '.constant($item_list[$i][4]);
					}
	
					$result .= '" class="min_image" /></A></DIV>
									<DIV id="home_list_item_slides_text"><span class="home_item_list_slides_title"><A HREF=\''.ITEM_LINK.$item_list[$i][0].'-'.Util::GetPageName($item_list[$i][6]).PAGE_EXTENSION.'\' target=\'_self\'>'.$item_list[$i][6].'</A></span>';
						
					if ($item_list[$i][3] != '') {
						$result .= '<BR><A HREF="'.BASE_LINK.'/pages/item_list.php?type='.$item_list[$i][1].'" TARGET="_self">'.constant($item_list[$i][3]).'</A>';
					}
						
					if ($item_list[$i][4] != '') {
						$result .= ' - <A HREF="'.BASE_LINK.'/pages/item_list.php?type2='.$item_list[$i][2].'" TARGET="_self">'.constant($item_list[$i][4]).'</A>';
					}
					
					if ($item_list[$i][13] != '') {
						$result .= ' - <A HREF="'.BASE_LINK.'/pages/item_list.php?brand='.$item_list[$i][13].'" TARGET="_self"><i>'.$item_list[$i][14].'</i></A>';
					}
	
					if ($item_list[$i][8] != '') {
	
						$result .= '<BR>'.$item_list[$i][8];
	
						if (($item_list[$i][9] != '') && ($item_list[$i][9] == 'EUR')) {
							$result .= ' &euro;';
						}
					}
	
					$result .= '</DIV>
							</DIV>';
	
					if ($j >= $_SESSION[SITE_ID]['admin_configuration_home_items_number'] - 1) {
						break;
					} else {
						$j++;
					}
				}
			}
	
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = ERROR_GET_HOME_ACTIVE_ITEM_LIST;
		}
	
		return $result;
	}
	
	public static function GetActiveItemListByType($type, $type2, $brand) {
	
		$result = '';
	
		try {
			$data = new Data();
			$dataSpecific = new DataSpecific();
			
			if (($type != '') || ($type2 != '')) {
				if ($type != '') {
					if ($type2 != '') {
						$item_list = $dataSpecific->ItemGetActiveListByTypeAndType2($type, $type2);
					} else {
						$item_list = $dataSpecific->ItemGetActiveListByType($type);
					}
				} else {
					$item_list = $dataSpecific->ItemGetActiveListByType2($type2);
				}
			} else {
				if ($brand != '') {
					$item_list = $dataSpecific->ItemGetActiveListByBrand($brand);
				}
			}
				
				
			$result = '
			';
			
			if (count($item_list) == 0) {
				$result .= NO_RESULT;
			} else {
				
				for ($i=0; $i < count($item_list); $i++) {
					$image = $data->ImageGetFirst($item_list[$i][0], 'item');
					$image_link = '';
		
					if (count($image) > 1) {
						$image_link = IMAGE_LITTLE_LINK.$image[1].'.'.$image[2];
					} else {
						$image_link = BASE_LINK.'/images/index/question_little.jpg';
					}
		
					$result .= '<DIV itemscope itemtype="http://schema.org/Product"  id="list_item">
									<DIV id="list_item_image"><span itemprop="productID" class="hidden">'.$item_list[$i][0].'</span><span itemprop="name" class="hidden">'.ucfirst($item_list[$i][6]).'</span><span itemprop="brand" class="hidden">'.$item_list[$i][14].'</span><A HREF=\''.ITEM_LINK.$item_list[$i][0].'-'.Util::GetPageName($item_list[$i][6]).PAGE_EXTENSION.'\' target=\'_self\'><img itemprop="image" src=\''.$image_link.'\' class=\'little_image\' /></A></DIV>
									<DIV itemprop="offers" itemscope itemtype="http://schema.org/Offer" id="list_item_text"><span class=\'item_list_name\'><A HREF=\''.ITEM_LINK.$item_list[$i][0].'-'.Util::GetPageName($item_list[$i][6]).PAGE_EXTENSION.'\' target=\'_self\'>'.ucfirst($item_list[$i][6]).'</A></span>';
		
					
					
					if ($item_list[$i][3] != '') {
						$result .= '<BR><A HREF=\'../pages/item_list.php?type='.$item_list[$i][1].'\' TARGET=\'_self\'>'.constant($item_list[$i][3]).'</A>';
					}
					
					if ($item_list[$i][4] != '') {
						$result .= ' - <A HREF=\'../pages/item_list.php?type2='.$item_list[$i][2].'\' TARGET=\'_self\'>'.constant($item_list[$i][4]).'</A>';
					}
					
					if ($item_list[$i][13] != '') {
						$result .= '<BR><A HREF=\'../pages/item_list.php?brand='.$item_list[$i][13].'\' TARGET=\'_self\'><i>'.$item_list[$i][14].'</i></A>';
					}
					
					
					if (($item_list[$i][8] != '') && $_SESSION[SITE_ID]['admin_configuration_store_enabled']) {
					
						$result .= '<BR>'.$item_list[$i][8];
					
						if (($item_list[$i][9] != '') && ($item_list[$i][9] == 'EUR')) {
							$result .= ' &euro;<span itemprop="price" class="hidden">'.$item_list[$i][8].'</span><span itemprop="priceCurrency" class="hidden">'.$item_list[$i][9].'</span><span itemprop="seller" class="hidden">'.SITE_TITLE.'</span><link itemprop="availability" href="http://schema.org/InStock" content="In Stock" />';
						}
					}
						
					$result .= '</DIV></DIV>
					';
				}
			}
				
			$result .= '
			';
				
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = ERROR_GET_ACTIVE_ITEM_LIST_BY_TYPE;
		}
	
		return $result;
	}
	
///////////////////////////////////////////////////////////////////////
///////////////    100% SPECIFIC PART             /////////////////////
///////////////////////////////////////////////////////////////////////

public static function GetSpecificItemChildren($item_id) {
	
		$script = '';
	
		if (isset($item_id)) {
			try {
				$data = new Data();
				$dataSpecific = new DataSpecific();
	
				$children_list = $dataSpecific->SpecificItemChildrenGet($item_id);
	
				if (count($children_list) > 0) {
						
					$script .= '<ul class="item_children">';
						
					for ($i=0; $i < count($children_list); $i++) {
						$image = $data->ImageGetFirst($children_list[$i][0], 'item');
						$image_link = '';
						$link_start = '';
						$link_end = '';
	
						if ($children_list[$i][4] == '1') {
							$link_start = '<A HREF=\''.ITEM_LINK.$children_list[$i][0].'-'.Util::GetPageName($children_list[$i][1]).PAGE_EXTENSION.'\' target=\'_self\'>';
							$link_end = '</A>';
						}
							
						if (count($image) > 1) {
							$image_link = IMAGE_MEDIUM_LINK.$image[1].'.'.$image[2];
								
							if ($children_list[$i][4] == '0') {
								$link_start = '<A HREF=\''.IMAGE_FULL_LINK.$image[1].'.'.$image[2].'\' target=\'_blank\'>';
								$link_end = '</A>';
							}
								
						} else {
							$image_link = '../images/index/question_little.jpg';
						}
							
						$script .= '<li class="item_children"><DIV id="item_children_item">
						<DIV id="item_children_item_text">'.$link_start;
	
						if ($children_list[$i][2] != '') {
								
							$date = DateTime::createFromFormat(PHP_DATE_FORMAT, $children_list[$i][2]);
							$date = date('Y', $date->getTimestamp());
							$script .= $date.' - ';
						}
							
						$script .= $children_list[$i][1].' <SPAN class="item_children_item_specific_sex">'.constant($children_list[$i][3]).'</SPAN>'.$link_end.'
						</DIV>
						<DIV id="item_children_item_image">'.$link_start.'<img src="'.$image_link.'" alt="'.$children_list[$i][3].'" class="little_image" />'.$link_end.'</DIV>
						</DIV></li>';
					}
						
					$script .= '</ul>';
				}
			} catch (Exception $ex) {
				$_SESSION[SITE_ID]['error'] = ITEM_SPECIFIC_CHILDREN_GET_ERROR.' : '.$ex->getError();
			}
		}
	
		return $script;
	}
	
	public static function GetItemSpecificBrandName($item_specific_brand_id) {
	
		try {
			$data = new Data();
			$dataSpecific = new DataSpecific();
			return $dataSpecific->SpecificItemBrandGetName($item_specific_brand_id);
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = GET_ITEM_SPECIFIC_BRAND_NAME_ERROR;
		}
	}
	
public static function GetSpecificItemGenealogyTree($item_id) {
	
		$level_1 = null;
		$level_2_father = null;
		$level_2_mother = null;
		$level_3_father_father = null;
		$level_3_father_mother = null;
		$level_3_mother_father = null;
		$level_3_mother_mother = null;
	
		$script = '';
	
		if (isset($item_id)) {
			try {
				$data = new Data();
				$dataSpecific = new DataSpecific();
	
				$current = $dataSpecific->ItemGet($item_id);
				$firstImage = $data->ImageGetFirst($item_id, 'item');
				$level_1 = $dataSpecific->SpecificItemFatherAndMotherLinkGet($item_id);
	
				if (count($level_1) == 10) {
					if ($level_1[0] != '') { // Father link
						$level_2_father = $dataSpecific->SpecificItemFatherAndMotherLinkGet($level_1[0]);
	
						if (count($level_2_father) == 10) {
							if ($level_2_father[0] != '') { // Grand father link
								$level_3_father_father = $dataSpecific->SpecificItemFatherAndMotherLinkGet($level_2_father[0]);
							}
								
							if ($level_2_father[4] != '') { // Grand mother link
								$level_3_father_mother = $dataSpecific->SpecificItemFatherAndMotherLinkGet($level_2_father[4]);
							}
						}
					}
						
					if ($level_1[4] != '') { // Mother link
						$level_2_mother = $dataSpecific->SpecificItemFatherAndMotherLinkGet($level_1[4]);
	
						if (count($level_2_mother) == 10) {
							if ($level_2_mother[0] != '') { // Grand father link
								$level_3_mother_father = $dataSpecific->SpecificItemFatherAndMotherLinkGet($level_2_mother[0]);
	
							}
	
							if ($level_2_mother[4] != '') { // Grand mother link
								$level_3_mother_mother = $dataSpecific->SpecificItemFatherAndMotherLinkGet($level_2_mother[4]);
							}
						}
					}
				}
			} catch (Exception $ex) {
				$_SESSION[SITE_ID]['error'] = ITEM_SPECIFIC_GENEALOGY_TREE_GET_ERROR;
			}
		} else {
			throw new DataException(MISSING_ARGUMENT_ERROR);
		}
	
		$script .= '<TABLE class="item_genealogy">
						<TR>';
	
		// Level 0
		$script .= '<TD>
						<TABLE>';
	
		if (($firstImage != NULL) && (count($firstImage) > 2)) {
			$script .= '<TR>
							<TD><img src="'.IMAGE_LITTLE_LINK.$firstImage[1].'.'.$firstImage[2].'" class="little_image"></TD>
							<TD>'.$current[6].'</TD>
						</TR>';
		} else {
			$script .= '<TR>
							<TD><img src="'.BASE_LINK.'/images/index/question_little.jpg" class="little_image"></TD>
							<TD>'.$current[6].'</TD>
						</TR>';
		}
	
		$script .= '</TABLE>
		</TD>';
	
		// Level 1
		$script .= '<TD>
						<TABLE>';
	
		if (isset($level_1)) {
			$father_link_start = '';
			$father_link_end = '';
			$mother_link_start = '';
			$mother_link_end = '';
			

			$firstImage = $data->ImageGetFirst($level_1[0], 'item');
			
			if (($firstImage != NULL) && (count($firstImage) > 2)) {
				if ($level_1[8] == '0') {
					$father_link_start = '<A HREF="'.IMAGE_FULL_LINK.$firstImage[1].'.'.$firstImage[2].'" TARGET="_blank">';
					$father_link_end = '</A>';
				}
				$level_1[2] = IMAGE_LITTLE_LINK.$firstImage[1].'.'.$firstImage[2];
			} else {
				$level_1[2] = BASE_LINK.'/images/index/question_little.jpg';
			}
	
			$firstImage = $data->ImageGetFirst($level_1[4], 'item');
			
			if (($firstImage != NULL) && (count($firstImage) > 2)) {
				if ($level_1[9] == '0') {
					$mother_link_start = '<A HREF="'.IMAGE_FULL_LINK.$firstImage[1].'.'.$firstImage[2].'" TARGET="_blank">';
					$mother_link_end = '</A>';
				}
				$level_1[6] = IMAGE_LITTLE_LINK.$firstImage[1].'.'.$firstImage[2];
			} else {
				$level_1[6] = BASE_LINK.'/images/index/question_little.jpg';
			}
				
			if ($level_1[3] != '') {
				$father_name = $level_1[3];
			} else {
				$father_name = $level_1[1];
			}
				
			if ($level_1[7] != '') {
				$mother_name = $level_1[7];
			} else {
				$mother_name = $level_1[5];
			}
				
			if (($level_1[0] != '') && ($level_1[8] == '1')) {
				$father_link_start = '<A HREF="'.ITEM_LINK.$level_1[0].'-'.Util::GetPageName($father_name).PAGE_EXTENSION.'" TARGET="_self">';
				$father_link_end = '</A>';
			}
				
			if (($level_1[4] != '') && ($level_1[9] == '1')) {
				$mother_link_start = '<A HREF="'.ITEM_LINK.$level_1[4].'-'.Util::GetPageName($mother_name).PAGE_EXTENSION.'" TARGET="_self">';
				$mother_link_end = '</A>';
			}
				
			$script .= '<TR>
			<TD>
				<TABLE class="item_genealogy">
					<TR height="'.$_SESSION[SITE_ID]['admin_configuration_image_little_height'].'">
						<TD>'.$father_link_start.'<img src="'.$level_1[2].'" class="little_image">'.$father_link_end.'</TD>
						<TD>'.$father_link_start.$father_name.$father_link_end.'</TD>
					<TR height="'.$_SESSION[SITE_ID]['admin_configuration_image_little_height'].'">
						<TD><BR><TD>
						<TD></TD>
					</TR>
					<TR height="'.$_SESSION[SITE_ID]['admin_configuration_image_little_height'].'">
						<TD>'.$mother_link_start.'<img src="'.$level_1[6].'" class="little_image">'.$mother_link_end.'</TD>
						<TD>'.$mother_link_start.$mother_name.$mother_link_end.'</TD>
					</TR>
				</TABLE>
			</TD>
			</TR>';
		} else {
			$script .= '<TR>
			<TD>
				<TABLE class="item_genealogy">
					<TR height="'.$_SESSION[SITE_ID]['admin_configuration_image_little_height'].'">
						<TD><img src="'.BASE_LINK.'/images/index/question_little.jpg" class="little_image"></TD>
						<TD></TD>
					</TR>
					<TR height="'.$_SESSION[SITE_ID]['admin_configuration_image_little_height'].'">
						<TD><BR></TD>
						<TD></TD>
					</TR>
					<TR height="'.$_SESSION[SITE_ID]['admin_configuration_image_little_height'].'">
						<TD><img src="'.BASE_LINK.'/images/index/question_little.jpg" class="little_image"></TD>
						<TD></TD>
					</TR>
				</TABLE>
			</TD>
			</TR>';
		}
	
		$script .= '		</TABLE>
		</TD>';
	
		// Level 2
		$script .= '<TD>
		<TABLE class="item_genealogy">';
	
		if (isset($level_2_father)) {
			$father_link_start = '';
			$father_link_end = '';
			$mother_link_start = '';
			$mother_link_end = '';
				
			$firstImage = $data->ImageGetFirst($level_2_father[0], 'item');
			
			if (($firstImage != NULL) && (count($firstImage) > 2)) {
				if ($level_2_father[8] == '0') {
					$father_link_start = '<A HREF="'.IMAGE_FULL_LINK.$firstImage[1].'.'.$firstImage[2].'" TARGET="_blank">';
					$father_link_end = '</A>';
				}
				$level_2_father[2] = IMAGE_LITTLE_LINK.$firstImage[1].'.'.$firstImage[2];
			} else {
				$level_2_father[2] = BASE_LINK.'/images/index/question_little.jpg';
			}
	
			$firstImage = $data->ImageGetFirst($level_2_father[4], 'item');
			
			if (($firstImage != NULL) && (count($firstImage) > 2)) {
				if ($level_2_father[9] == '0') {
					$mother_link_start = '<A HREF="'.IMAGE_FULL_LINK.$firstImage[1].'.'.$firstImage[2].'" TARGET="_blank">';
					$mother_link_end = '</A>';
				}
	
				$level_2_father[6] = IMAGE_LITTLE_LINK.$firstImage[1].'.'.$firstImage[2];
			} else {
				$level_2_father[6] = BASE_LINK.'/images/index/question_little.jpg';
			}
				
			if ($level_2_father[3] != '') {
				$father_name = $level_2_father[3];
			} else {
				$father_name = $level_2_father[1];
			}
				
			if ($level_2_father[7] != '') {
				$mother_name = $level_2_father[7];
			} else {
				$mother_name = $level_2_father[5];
			}
				
			if (($level_2_father[0] != '') && ($level_2_father[8] == '1')) {
				$father_link_start = '<A HREF="'.ITEM_LINK.$level_2_father[0].'-'.Util::GetPageName($father_name).PAGE_EXTENSION.'" TARGET="_self">';
				$father_link_end = '</A>';
			}
				
			if (($level_2_father[4] != '') && ($level_2_father[9] == '1')) {
				$mother_link_start = '<A HREF="'.ITEM_LINK.$level_2_father[4].'-'.Util::GetPageName($mother_name).PAGE_EXTENSION.'" TARGET="_self">';
				$mother_link_end = '</A>';
			}
	
			$script .= '<TR>
							<TD>
								<TABLE class="item_genealogy">
									<TR>
										<TD>'.$father_link_start.'<img src="'.$level_2_father[2].'" class="little_image">'.$father_link_end.'</TD>
										<TD>'.$father_link_start.$father_name.$father_link_end.'</TD>
									</TR>
									<TR>
										<TD>'.$mother_link_start.'<img src="'.$level_2_father[6].'" class="little_image">'.$mother_link_end.'</TD>
										<TD>'.$mother_link_start.$mother_name.$mother_link_end.'</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>';
		} else {
			$script .= '<TR>
							<TD>
								<TABLE class="item_genealogy">
									<TR>
										<TD><img src="'.BASE_LINK.'/images/index/question_little.jpg" class="little_image"></TD>
										<TD></TD>
									</TR>
									<TR>
										<TD><img src="'.BASE_LINK.'/images/index/question_little.jpg" class="little_image"></TD>
										<TD></TD>
									</TR>
								</TABLE>
							</TD>
						</TR>';
		}
	
		if (isset($level_2_mother)) {
			$father_link_start = '';
			$father_link_end = '';
			$mother_link_start = '';
			$mother_link_end = '';
				
			$firstImage = $data->ImageGetFirst($level_2_mother[0], 'item');
			
			if (($firstImage != NULL) && (count($firstImage) > 2)) {
				if ($level_2_mother[8] == '0') {
					$father_link_start = '<A HREF="'.IMAGE_FULL_LINK.$firstImage[1].'.'.$firstImage[2].'" TARGET="_blank">';
					$father_link_end = '</A>';
				}
				$level_2_mother[2] = IMAGE_LITTLE_LINK.$firstImage[1].'.'.$firstImage[2];
			} else {
				$level_2_mother[2] = BASE_LINK.'/images/index/question_little.jpg';
			}
	
			$firstImage = $data->ImageGetFirst($level_2_mother[4], 'item');
			
			if (($firstImage != NULL) && (count($firstImage) > 2)) {
				if ($level_2_mother[9] == '0') {
					$mother_link_start = '<A HREF="'.IMAGE_FULL_LINK.$firstImage[1].'.'.$firstImage[2].'" TARGET="_blank">';
					$mother_link_end = '</A>';
				}
				$level_2_mother[6] = IMAGE_LITTLE_LINK.$firstImage[1].'.'.$firstImage[2];
			} else {
				$level_2_mother[6] = BASE_LINK.'/images/index/question_little.jpg';
			}
				
			if (isset($level_2_mother[3]) && ($level_2_mother[3] != '')) {
				$father_name = $level_2_mother[3];
			} else {
				if (isset($level_2_mother[1]) && ($level_2_mother[1] != '')) {
					$father_name = $level_2_mother[1];
				}
			}
				
			if (isset($level_2_mother[7]) && ($level_2_mother[7] != '')) {
				$mother_name = $level_2_mother[7];
			} else {
				if (isset($level_2_mother[5]) && ($level_2_mother[5] != '')) {
					$mother_name = $level_2_mother[5];
				}
			}
				
			if (($level_2_mother[0] != '') && ($level_2_mother[8] == '1')) {
				$father_link_start = '<A HREF="'.ITEM_LINK.$level_2_mother[0].'-'.Util::GetPageName($father_name).PAGE_EXTENSION.'" TARGET="_self">';
				$father_link_end = '</A>';
			}
				
			if (isset($level_2_mother[4]) && ($level_2_mother[4] != '') && ($level_2_mother[9] == '1')) {
				$mother_link_start = '<A HREF="'.ITEM_LINK.$level_2_mother[4].'-'.Util::GetPageName($mother_name).PAGE_EXTENSION.'" TARGET="_self">';
				$mother_link_end = '</A>';
			}
	
			$script .= '<TR>
							<TD>
								<TABLE class="item_genealogy">
									<TR>
										<TD>'.$father_link_start.'<img src="'.$level_2_mother[2].'" class="little_image">'.$father_link_end.'</TD>
										<TD>'.$father_link_start.$father_name.$father_link_end.'</TD>
									</TR>
									<TR>
										<TD>'.$mother_link_start.'<img src="'.$level_2_mother[6].'" class="little_image">'.$mother_link_end.'</TD>
										<TD>'.$mother_link_start.$mother_name.$mother_link_end.'</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>';
		} else {
			$script .= '<TR>
							<TD>
								<TABLE class="item_genealogy">
									<TR>
										<TD><img src="'.BASE_LINK.'/images/index/question_little.jpg" class="little_image"></TD>
										<TD></TD>
									</TR>
									<TR>
										<TD><img src="'.BASE_LINK.'/images/index/question_little.jpg" class="little_image"></TD>
										<TD></TD>
									</TR>
								</TABLE>
							</TD>
						</TR>';
		}
	
		$script .= '		</TABLE>
		</TD>';
	
		// Level 3
		$script .= '		<TD>
								<TABLE class="item_genealogy">';
			
		if (isset($level_3_father_father)) {
			$father_link_start = '';
			$father_link_end = '';
			$mother_link_start = '';
			$mother_link_end = '';
			
			$firstImage = $data->ImageGetFirst($level_3_father_father[0], 'item');
				
			if (($firstImage != NULL) && (count($firstImage) > 2)) {
				if ($level_3_father_father[8] == '0') {
					$father_link_start = '<A HREF="'.IMAGE_FULL_LINK.$firstImage[1].'.'.$firstImage[2].'" TARGET="_blank">';
					$father_link_end = '</A>';
				}
				$level_3_father_father[2] = IMAGE_LITTLE_LINK.$firstImage[1].'.'.$firstImage[2];
			} else {
				$level_3_father_father[2] = BASE_LINK.'/images/index/question_little.jpg';
			}
			
			$firstImage = $data->ImageGetFirst($level_3_father_father[4], 'item');
			
			if (($firstImage != NULL) && (count($firstImage) > 2)) {
				if ($level_3_father_father[9] == '0') {
					$mother_link_start = '<A HREF="'.IMAGE_FULL_LINK.$firstImage[1].'.'.$firstImage[2].'" TARGET="_blank">';
					$mother_link_end = '</A>';
				}
				$level_3_father_father[6] = IMAGE_LITTLE_LINK.$firstImage[1].'.'.$firstImage[2];
			} else {
				$level_3_father_father[6] = BASE_LINK.'/images/index/question_little.jpg';
			}
				
			if ($level_3_father_father[3] != '') {
				$father_name = $level_3_father_father[3];
			} else {
				$father_name = $level_3_father_father[1];
			}
				
			if ($level_3_father_father[7] != '') {
				$mother_name = $level_3_father_father[7];
			} else {
				$mother_name = $level_3_father_father[5];
			}
				
			if (($level_3_father_father[0] != '') && ($level_3_father_father[8] == '1')) {
				$father_link_start = '<A HREF="'.ITEM_LINK.$level_3_father_father[0].'-'.Util::GetPageName($father_name).PAGE_EXTENSION.'" TARGET="_self">';
				$father_link_end = '</A>';
			}
				
			if (($level_3_father_father[4] != '') && ($level_3_father_father[9] == '1')) {
				$mother_link_start = '<A HREF="'.ITEM_LINK.$level_3_father_father[4].'-'.Util::GetPageName($mother_name).PAGE_EXTENSION.'" TARGET="_self">';
				$mother_link_end = '</A>';
			}
				
			$script .= '<TR>
							<TD>
								<TABLE class="item_genealogy">
									<TR>
										<TD>'.$father_link_start.'<img src="'.$level_3_father_father[2].'" class="min_image">'.$father_link_end.'</TD>
										<TD>'.$father_link_start.$father_name.$father_link_end.'</TD>
									</TR>
									<TR>
										<TD>'.$mother_link_start.'<img src="'.$level_3_father_father[6].'" class="min_image">'.$mother_link_end.'</TD>
										<TD>'.$mother_link_start.$mother_name.$mother_link_end.'</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>';
		} else {
			$script .= '<TR>
							<TD>
								<TABLE class="item_genealogy">
									<TR>
										<TD><img src="'.BASE_LINK.'/images/index/question_little.jpg" class="min_image"></TD>
										<TD></TD>
									</TR>
									<TR>
										<TD><img src="'.BASE_LINK.'/images/index/question_little.jpg" class="min_image"></TD>
										<TD></TD>
									</TR>
								</TABLE>
							</TD>
						</TR>';
		}
			
		if (isset($level_3_father_mother)) {
			$father_link_start = '';
			$father_link_end = '';
			$mother_link_start = '';
			$mother_link_end = '';
				
			$firstImage = $data->ImageGetFirst($level_3_father_mother[0], 'item');
			
			if (($firstImage != NULL) && (count($firstImage) > 2)) {
				if ($level_3_father_mother[8] == '0') {
					$father_link_start = '<A HREF="'.IMAGE_FULL_LINK.$firstImage[1].'.'.$firstImage[2].'" TARGET="_blank">';
					$father_link_end = '</A>';
				}
				$level_3_father_mother[2] = IMAGE_LITTLE_LINK.$firstImage[1].'.'.$firstImage[2];
			} else {
				$level_3_father_mother[2] = BASE_LINK.'/images/index/question_little.jpg';
			}
				
			$firstImage = $data->ImageGetFirst($level_3_father_mother[4], 'item');
			
			if (($firstImage != NULL) && (count($firstImage) > 2)) {
				if ($level_3_father_mother[9] == '0') {
					$mother_link_start = '<A HREF="'.IMAGE_FULL_LINK.$firstImage[1].'.'.$firstImage[2].'" TARGET="_blank">';
					$mother_link_end = '</A>';
				}
				$level_3_father_mother[6] = IMAGE_LITTLE_LINK.$firstImage[1].'.'.$firstImage[2];
			} else {
				$level_3_father_mother[6] = BASE_LINK.'/images/index/question_little.jpg';
			}
				
			if ($level_3_father_mother[3] != '') {
				$father_name = $level_3_father_mother[3];
			} else {
				$father_name = $level_3_father_mother[1];
			}
				
			if ($level_3_father_mother[7] != '') {
				$mother_name = $level_3_father_mother[7];
			} else {
				$mother_name = $level_3_father_mother[5];
			}
				
			if (($level_3_father_mother[0] != '') && ($level_3_father_mother[8] == '1')) {
				$father_link_start = '<A HREF="'.ITEM_LINK.$level_3_father_mother[0].'-'.Util::GetPageName($father_name).PAGE_EXTENSION.'" TARGET="_self">';
				$father_link_end = '</A>';
			}
				
			if (($level_3_father_mother[4] != '') && ($level_3_father_mother[9] == '1')) {
				$mother_link_start = '<A HREF="'.ITEM_LINK.$level_3_father_mother[4].'-'.Util::GetPageName($mother_name).PAGE_EXTENSION.'" TARGET="_self">';
				$mother_link_end = '</A>';
			}
				
			$script .= '<TR>
							<TD>
								<TABLE class="item_genealogy">
									<TR>
										<TD>'.$father_link_start.'<img src="'.$level_3_father_mother[2].'" class="min_image">'.$father_link_end.'</TD>
										<TD>'.$father_link_start.$father_name.$father_link_end.'</TD>
									</TR>
									<TR>
										<TD>'.$mother_link_start.'<img src="'.$level_3_father_mother[6].'" class="min_image">'.$mother_link_end.'</TD>
										<TD>'.$mother_link_start.$mother_name.$mother_link_end.'</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>';
		} else {
			$script .= '<TR>
							<TD>
								<TABLE class="item_genealogy">
									<TR>
										<TD><img src="'.BASE_LINK.'/images/index/question_little.jpg" class="min_image"></TD>
										<TD></TD>
									</TR>
									<TR>
										<TD><img src="'.BASE_LINK.'/images/index/question_little.jpg" class="min_image"></TD>
										<TD></TD>
									</TR>
								</TABLE>
							</TD>
						</TR>';
		}
	
		if (isset($level_3_mother_father)) {
			$father_link_start = '';
			$father_link_end = '';
			$mother_link_start = '';
			$mother_link_end = '';
				
			$firstImage = $data->ImageGetFirst($level_3_mother_father[0], 'item');
			
			if (($firstImage != NULL) && (count($firstImage) > 2)) {
				if ($level_3_mother_father[8] == '0') {
					$father_link_start = '<A HREF="'.IMAGE_FULL_LINK.$firstImage[1].'.'.$firstImage[2].'" TARGET="_blank">';
					$father_link_end = '</A>';
				}
				$level_3_mother_father[2] = IMAGE_LITTLE_LINK.$firstImage[1].'.'.$firstImage[2];
			} else {
				$level_3_mother_father[2] = BASE_LINK.'/images/index/question_little.jpg';
			}
				
			$firstImage = $data->ImageGetFirst($level_3_mother_father[4], 'item');
			
			if (($firstImage != NULL) && (count($firstImage) > 2)) {
				if ($level_3_mother_father[9] == '0') {
					$mother_link_start = '<A HREF="'.IMAGE_FULL_LINK.$firstImage[1].'.'.$firstImage[2].'" TARGET="_blank">';
					$mother_link_end = '</A>';
				}
				$level_3_mother_father[6] = IMAGE_LITTLE_LINK.$firstImage[1].'.'.$firstImage[2];
			} else {
				$level_3_mother_father[6] = BASE_LINK.'/images/index/question_little.jpg';
			}
				
			if ($level_3_mother_father[3] != '') {
				$father_name = $level_3_mother_father[3];
			} else {
				$father_name = $level_3_mother_father[1];
			}
				
			if ($level_3_mother_father[7] != '') {
				$mother_name = $level_3_mother_father[7];
			} else {
				$mother_name = $level_3_mother_father[5];
			}
				
			if (($level_3_mother_father[0] != '') && ($level_3_mother_father[8] == '1')) {
				$father_link_start = '<A HREF="'.ITEM_LINK.$level_3_mother_father[0].'-'.Util::GetPageName($father_name).PAGE_EXTENSION.'" TARGET="_self">';
				$father_link_end = '</A>';
			}
				
			if (($level_3_mother_father[4] != '') && ($level_3_mother_father[9] == '1')) {
				$mother_link_start = '<A HREF="'.ITEM_LINK.$level_3_mother_father[4].'-'.Util::GetPageName($mother_name).PAGE_EXTENSION.'" TARGET="_self">';
				$mother_link_end = '</A>';
			}
				
			$script .= '<TR>
							<TD>
								<TABLE class="item_genealogy">
									<TR>
										<TD>'.$father_link_start.'<img src="'.$level_3_mother_father[2].'" class="min_image">'.$father_link_end.'</TD>
										<TD>'.$father_link_start.$father_name.$father_link_end.'</TD>
									</TR>
									<TR>
										<TD>'.$mother_link_start.'<img src="'.$level_3_mother_father[6].'" class="min_image">'.$mother_link_end.'</TD>
										<TD>'.$mother_link_start.$mother_name.$mother_link_end.'</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>';
		} else {
			$script .= '<TR>
							<TD>
								<TABLE class="item_genealogy">
									<TR>
										<TD><img src="'.BASE_LINK.'/images/index/question_little.jpg" class="min_image"></TD>
										<TD></TD>
									</TR>
									<TR>
										<TD><img src="'.BASE_LINK.'/images/index/question_little.jpg" class="min_image"></TD>
										<TD></TD>
									</TR>
								</TABLE>
							</TD>
						</TR>';
		}
	
		if (isset($level_3_mother_mother)) {
			$father_link_start = '';
			$father_link_end = '';
			$mother_link_start = '';
			$mother_link_end = '';
				
			$firstImage = $data->ImageGetFirst($level_3_mother_mother[0], 'item');
			
			if (($firstImage != NULL) && (count($firstImage) > 2)) {
				if ($level_3_mother_mother[8] == '0') {
					$father_link_start = '<A HREF="'.IMAGE_FULL_LINK.$firstImage[1].'.'.$firstImage[2].'" TARGET="_blank">';
					$father_link_end = '</A>';
				}
				$level_3_mother_mother[2] = IMAGE_LITTLE_LINK.$firstImage[1].'.'.$firstImage[2];
			} else {
				$level_3_mother_mother[2] = BASE_LINK.'/images/index/question_little.jpg';
			}
				
			$firstImage = $data->ImageGetFirst($level_3_mother_mother[4], 'item');
			
			if (($firstImage != NULL) && (count($firstImage) > 2)) {
				if ($level_3_mother_mother[9] == '0') {
					$mother_link_start = '<A HREF="'.IMAGE_FULL_LINK.$firstImage[1].'.'.$firstImage[2].'" TARGET="_blank">';
					$mother_link_end = '</A>';
				}
				$level_3_mother_mother[6] = IMAGE_LITTLE_LINK.$firstImage[1].'.'.$firstImage[2];
			} else {
				$level_3_mother_mother[6] = BASE_LINK.'/images/index/question_little.jpg';
			}
				
			if ($level_3_mother_mother[3] != '') {
				$father_name = $level_3_mother_mother[3];
			} else {
				$father_name = $level_3_mother_mother[1];
			}
				
			if ($level_3_mother_mother[7] != '') {
				$mother_name = $level_3_mother_mother[7];
			} else {
				$mother_name = $level_3_mother_mother[5];
			}
				
			if (($level_3_mother_mother[0] != '') && ($level_3_mother_mother[8] == '1')) {
				$father_link_start = '<A HREF="'.ITEM_LINK.$level_3_mother_mother[0].'-'.Util::GetPageName($father_name).PAGE_EXTENSION.'" TARGET="_self">';
				$father_link_end = '</A>';
			}
				
			if (($level_3_mother_mother[4] != '') && ($level_3_mother_mother[9] == '1')) {
				$mother_link_start = '<A HREF="'.ITEM_LINK.$level_3_mother_mother[4].'-'.Util::GetPageName($mother_name).PAGE_EXTENSION.'" TARGET="_self">';
				$mother_link_end = '</A>';
			}
				
			$script .= '<TR>
							<TD>
								<TABLE class="item_genealogy">
									<TR>
										<TD>'.$father_link_start.'<img src="'.$level_3_mother_mother[2].'" class="min_image">'.$father_link_end.'</TD>
										<TD>'.$father_link_start.$father_name.$father_link_end.'</TD>
									</TR>
									<TR>
										<TD>'.$mother_link_start.'<img src="'.$level_3_mother_mother[6].'" class="min_image">'.$mother_link_end.'</TD>
										<TD>'.$mother_link_start.$mother_name.$mother_link_end.'</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>';
		} else {
			$script .= '<TR>
							<TD>
								<TABLE class="item_genealogy">
									<TR>
										<TD><img src="'.BASE_LINK.'/images/index/question_little.jpg" class="min_image"></TD>
										<TD></TD>
									</TR>
									<TR>
										<TD><img src="'.BASE_LINK.'/images/index/question_little.jpg" class="min_image"></TD>
										<TD></TD>
									</TR>
								</TABLE>
							</TD>
						</TR>';
		}
			
		$script .= '			</TABLE>
					</TD>';
	
		$script .= '</TR>
				</TABLE>';
	
		return $script;
	}

///////////////////////////////////////////////////////////////////////
///////////////        END OF 100% SPECIFIC PART            ///////////
///////////////////////////////////////////////////////////////////////

	public function __call($method = '', $args = '') {
	
		switch ($method) {
			default:
				break;
		}
	}
}

?>