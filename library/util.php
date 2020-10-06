<?php  
/* V1.10
 * 
 * V1.2  : 20130524 : PageGetTop, PageGetBottom, AdminGetList fixes and links added
 * V1.3  : 20130531 : Blog & item lists
 * V1.4  : 20130624 : Major update
 * V1.5  : 20130930 : Performance issue
 * V1.6  : 20131004 : Menu style added
 * V1.7  : 20131007 : Item type 2 added
 * V1.8  : 20131015 : Like box update
 * V1.9  : 20131015 : META update
 * V1.10 : 20140128 : Major design update
 * V1.11 : 20140228 : Site map
 * 
 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/data.php');
	
class UtilException extends Exception 
{
	public function __construct($message) {
		parent :: __construct($message);
	}

	public function getError() {
		return $this->getMessage();
	}
}

class Util
{
	public function __construct() {	
		
	}

	public function __destruct() {

	}
	
	public static function Init() {
		try {
			if (!isset($_SESSION[SITE_ID]['connection_id'])) {
			
				//$browser = get_browser(null, true); DO NOT WORK!!!
				//$ipaddress = new IpAddress();
				$data = new Data();
				
				$_SESSION[SITE_ID]['ip_address'] = $_SERVER['REMOTE_ADDR'];
				$_SESSION[SITE_ID]['country_code'] = ''; //$ipaddress->GetCountry($_SERVER['REMOTE_ADDR']);
				$_SESSION[SITE_ID]['city'] = ''; // $ipaddress->GetCity($_SERVER['REMOTE_ADDR']);
				$_SESSION[SITE_ID]['latitude'] = ''; // $ipaddress->GetLatitude($_SERVER['REMOTE_ADDR']);
				$_SESSION[SITE_ID]['longitude'] = ''; // $ipaddress->GetLongitude($_SERVER['REMOTE_ADDR']);
				$_SESSION[SITE_ID]['platform'] = ''; // $browser['platform'];
				$_SESSION[SITE_ID]['browser'] = $_SERVER['HTTP_USER_AGENT'];
				$_SESSION[SITE_ID]['cookies'] = ''; // $browser['cookies'];
				
				$data->AdminActiveConfigurationGet();
				
				$_SESSION[SITE_ID]['admin_configuration_theme'] = $_SESSION[SITE_ID]['admin_configuration_default_theme'];
				
				$_SESSION[SITE_ID]['connection_id'] = $data->AdminUserSaveConnection($_SESSION[SITE_ID]['ip_address'],
														      	 	           		   $_SESSION[SITE_ID]['country_code'],
														      	 	           		   $_SESSION[SITE_ID]['city'],
																	           	       $_SESSION[SITE_ID]['latitude'],
																	           		   $_SESSION[SITE_ID]['longitude'],
																	           		   $_SESSION[SITE_ID]['platform'],
														      		           		   $_SESSION[SITE_ID]['browser'],
														      		           		   '', // $browser['version'],
														      		           		   '', // $browser['javascript'],
														      		           		   '', // $browser['javaapplets'],
														      		           		   '', // $browser['activexcontrols'],
														      		           		   $_SESSION[SITE_ID]['cookies'],
														     		           		   '', // $browser['cssversion'],
														     		           		   '', // $browser['frames'],
														     		           		   ''); // $browser['iframes']);
						
				$data->AdminSaveLog('CONNECTION', 'ID : '.$_SESSION[SITE_ID]['connection_id']);
			}
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = INITIALISE_ERROR;
		}
	}
	
	public static function Login($user_name, $user_password, $type = 'local') {
		$data = new Data();
		$user_name = strtolower($user_name);
		
		if (!isset($_SESSION[SITE_ID]['authenticated'])) {
			
			$status = -1;

			switch($type) {
				case 'local':
					{
						$password = $data->AdminUserGetPasswordWithUserLogin($user_name);
						$salt = substr($password, 0, 2);
						
        				if (crypt($user_password, $salt) == $password) {
        					$status = 0;
        				} else {
        					$status = 1;
        				}
        				
        				break;
					}
				case 'ldap':
					break;
				default:
					break;
			}
			
			switch($status) {
				case 0:
				{
					$user = $data->AdminUserGetInformationWithUserLogin($user_name);
					
					if ($user[2] == 0) {
						$data->AdminSaveLog('LOGIN_INACTIVE', 'USER : '.$user_name);
						throw new DataException(LOGIN_INACTIVE);
					} else {
						$_SESSION[SITE_ID]['authenticated'] = 1;
						$_SESSION[SITE_ID]['user_id'] = $user[0];
						$_SESSION[SITE_ID]['user_login'] = $user_name;
						$_SESSION[SITE_ID]['role_name'] = $user[1];
						$_SESSION[SITE_ID]['user_email'] = $user[3];
						$_SESSION[SITE_ID]['user_first_name'] = $user[4];
						$_SESSION[SITE_ID]['user_last_name'] = $user[5];
						$_SESSION[SITE_ID]['lang'] = strtolower($user[6]);
						$_SESSION[SITE_ID]['admin_configuration_theme'] = strtolower($user[7]);
						
						$right = $data->AdminUserGetRightWithUserLogin($user_name);
						
						for ($i = 0; $i < count($right); $i++) {
							$_SESSION[SITE_ID]['user_right'][$i] = $right[$i][0];
						}
						
						$data->AdminSaveLog('LOGIN_CONNECTED', 'USER : '.$user_name);
						return true;
					}
					break;
				}
				case 1:
				{
					$data->AdminSaveLog('LOGIN_INCORRECT', 'USER : '.$user_name);
					throw new DataException(LOGIN_INCORRECT);
					break;
				}
				default:
					break;
			}
		} else {
			$data->AdminSaveLog('LOGIN_ALREADY_CONNECTED', 'USER : '.$user_name);
			throw new DataException(LOGIN_ALREADY_CONNECTED);
		}
		
		return false;
	}
	
	public static function Logout() {
		
		try {
			$data = new Data();
			
			if (isset($_SESSION[SITE_ID]['authenticated'])) {
				$user_login = $_SESSION[SITE_ID]['user_login'];
				$data->AdminSaveLog('LOGIN_DISCONNECTED', 'USER : '.$user_login);
				unset($_SESSION[SITE_ID]['authenticated']);
				session_destroy();
				session_start();
				Util::Init();
				return true;
			}
		} catch (Exception $ex) {
			$data->AdminSaveLog('LOGIN_DISCONNECT_ERROR', $ex->getMessage());
			throw new DataException(LOGIN_DISCONNECT_ERROR);
		}
		
		return false;
	}
	
	public static function IsAllowed($right) {
		try {
			if (isset($_SESSION[SITE_ID]['user_right'])) {
				for ($i = 0; $i < count($_SESSION[SITE_ID]['user_right']); $i++) {
					if(strtolower($right) == strtolower($_SESSION[SITE_ID]['user_right'][$i])) {
						return true;
					}
				}
			}
			
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = ERROR_RIGHT;
		}
		
		return false;
	}
	
	public static function GetPostValue($id) {
		$result = '';
		
		if(isset($_GET[$id]) || isset($_POST[$id]) || isset($_REQUEST[$id])) {
			if(isset($_GET[$id])) {
				$result = $_GET[$id];
			} else if(isset($_POST[$id])) {
				$result = $_POST[$id];
			} else if(isset($_REQUEST[$id])) {
				$result = $_REQUEST[$id];
			}
			
			$result = htmlentities($result);
		}
		
		return $result;
	}
	
	public static function CryptPassword($password) {

		$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	
		$first = $characters[rand(0, strlen($characters)-1)];
		$second = $characters[rand(0, strlen($characters)-1)];
	
		return crypt($password, $first.$second);
	}
	
	public static function GeneratePassword($length = 8) {
	
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	    $count = mb_strlen($chars);
	
	    for ($i = 0, $result = ''; $i < $length; $i++) {
	        $index = rand(0, $count - 1);
	        $result .= mb_substr($chars, $index, 1);
	    }
	
	    return $result;
	}
	
	public static function SendMail($to, $subject, $message, $from = '', $cc = '', $bcc = '') {
		$from = $_SESSION[SITE_ID]['admin_configuration_manager_email'].', '.$from;
		$cc = $_SESSION[SITE_ID]['admin_configuration_manager_email'].', '.$cc;
		
		// Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// En-têtes additionnels
		$headers .= 'From: '.$from.'' . "\r\n";
		$headers .= 'Cc: '.$cc.'' . "\r\n";
		$headers .= 'Bcc: '.$bcc.'' . "\r\n";
		
		// Envoi
		mail($to, $subject, $message, $headers);
	}
	
	public static function PageGetHtmlTop() {
	
		$result = '<!DOCTYPE html>
<HTML>';
		
		return $result;
	}
	
	public static function PageGetBodyTop() {
	
		$result = Util::PageGetAnalytics();
		$result .= Util::PageGetBanner();
		$result .= Util::PageGetLang();
		$result .= UtilSpecific::PageGetMenu();
	
		return $result;
	}
	
	public static function PageGetMeta() {
		$result = '<META http-equiv="content-type" content="text/html; charset=UTF-8">
<META http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
<META NAME="DESCRIPTION" LANG="'.LANG.'" content="'.constant('META_DESCRIPTION_'.LANG).'">
<META NAME="KEYWORDS" LANG="'.LANG.'" content="'.constant('META_KEYWORDS_'.LANG).'">
<META NAME="ROBOTS" CONTENT="INDEX, FOLLOW">
';
		
		$lang_list = array("fr", "en", "de", "es"); // TODO : TO BE CHANGED (dynamic)...
		
		for ($i = 0; $i < count($lang_list); $i++) { // TODO : TO BE CHANGED (dynamic)...
			$result .= '<link rel="alternate" hreflang="'.$lang_list[$i].'" href="'.BASE_LINK.$_SERVER['PHP_SELF'].'?lang='.$lang_list[$i].'">
					';
		}
		
		return $result;
	}
	
	public static function PageGetLightMeta() {
		$result = '<META http-equiv="content-type" content="text/html; charset=UTF-8">
<META http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
<META NAME="ROBOTS" CONTENT="INDEX, FOLLOW">
';
	
		return $result;
	}
	
	public static function PageGetMetaV2($description = '',
			                             $keywords = '',
			                             $property_title = '',
										 $property_url = '',
										 $property_image = '',
										 $property_type = '',
										 $property_site_name = '') {
		
		
		$result = '<META http-equiv="content-type" content="text/html; charset=UTF-8">
<META http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
';
		
		if ($description != '') {
			$result .= '<META NAME="DESCRIPTION" LANG="'.LANG.'" content="'.constant('META_DESCRIPTION_'.LANG).', '.$description.'">
';
		} else {
			$result .= '<META NAME="DESCRIPTION" LANG="'.LANG.'" content="'.constant('META_DESCRIPTION_'.LANG).'">
';
		}
		
		if ($keywords != '') {
			$result .= '<META NAME="KEYWORDS" LANG="'.LANG.'" content="'.constant('META_KEYWORDS_'.LANG).', '.$keywords.'">
';
		} else {
			$result .= '<META NAME="KEYWORDS" LANG="'.LANG.'" content="'.constant('META_KEYWORDS_'.LANG).'">
';
		}
		
		if ($property_title != '') {
			$result .= '<META property="og:title" content="'.$property_title.'"/>
';
		}
		
		if ($property_url != '') {
			$result .= '<META property="og:url" content="'.$property_url.'"/>
';
		}
		
		if ($property_image != '') {
			$result .= '<META property="og:image" content="'.$property_image.'"/>
';
		}
		
		if ($property_type != '') {
			$result .= '<META property="og:type" content="'.$property_type.'"/>
';
		}
		
		if ($property_site_name != '') {
			$result .= '<META property="og:site_name" content="'.$property_site_name.'"/>
';
		}
		
		
		$result .= '<META NAME="ROBOTS" CONTENT="INDEX, FOLLOW">
';
		
		$lang_list = array("fr", "en", "de", "es"); // TODO : TO BE CHANGED (dynamic)...
		
		for ($i = 0; $i < count($lang_list); $i++) { // TODO : TO BE CHANGED (dynamic)...
			$result .= '<link rel="alternate" hreflang="'.$lang_list[$i].'" href="'.BASE_LINK.$_SERVER['PHP_SELF'].'?lang='.$lang_list[$i].'" />
					';
		}
		
		return $result;	
	}
	
	public static function PageGetBottom() {
		$result = Util::PageGetCopyright();
		
		return $result;
	}
	
	public static function PageGetDocumentReadyTop() {
		$result = '
$(document).ready(function() {
	
	$(window).scroll(function () { 
		var id = "#menu_container";
		var id2 = "#menu_toggle";
		var id3 = "#notification";
		var originalSize = '.$_SESSION[SITE_ID]['admin_configuration_banner_size'].';
	
		if ($(id2).is(":visible")) {
			originalSize = 0;
		}
				
		if (originalSize <= $(document).scrollTop()) {
			offset = $(document).scrollTop() - originalSize + "px";
			offset2 = $(document).scrollTop() - originalSize - 8 + "px";
		} else {
			offset = "0px";
			offset2 = "-8px";
		}
		
		$(id).animate({top:offset},{duration:300,queue:false});
		$(id3).animate({top:offset2},{duration:300,queue:false});
	});
				
	$("#search_value").focus(function() {
		var search_value = $("input[id=search_value]");
				
		if (search_value.val() == "'.SEARCH.'") {
			search_value.val("");
		}
	});
				
	$("#search_toggle_value").focus(function() {
		var search_toggle_value = $("input[id=search_toggle_value]");
				
		if (search_toggle_value.val() == "'.SEARCH.'") {
			search_toggle_value.val("");
		}
	});
	
	$("#search_value").bind("keydown", function(l) {
    	if (l.keyCode == 13) {
			$("#search_button").trigger( "click" );
		}
	});
				
	$("#search_toggle_value").bind("keydown", function(l) {
    	if (l.keyCode == 13) {
			$("#search_toggle_button").trigger( "click" );
		}
	});
			
	$("#search_button").click(function () {
		var search_value = $("input[id=search_value]");
				
		if ((search_value.val() != \'\') && 
			(search_value.val() != "'.SEARCH.'")) {
			window.location = "'.BASE_LINK.'/search/index.php?query=" + search_value.val();
		}
	});
					
	$("#search_toggle_button").click(function () {
		var search_toggle_value = $("input[id=search_toggle_value]");
				
		if ((search_toggle_value.val() != \'\') && 
			(search_toggle_value.val() != "'.SEARCH.'")) {
			window.location = "'.BASE_LINK.'/search/index.php?query=" + search_toggle_value.val();
		}
	});

';
		return $result;
	}
	
	public static function PageGetDocumentReadyBottom() {
		$result = '
	
//Menu

$(window).resize(function() {
  	 if ($(window).width() > 1000) {
	 	$("ul.menu").show();
     }
});
				
$("li.menu").hover(function() {
	$(this).children("div.sub_menu").slideToggle();
});

$("li.menu_login").hover(function() {
	$(this).children("div.sub_menu").slideToggle();
});
		
$("#facebook_box_arrow_down").click(function () {
	$("#facebook_box_arrow_down").hide();
	$("#facebook_box_arrow_up").show();
	$("#facebook_box_container").slideDown();
});

$("#facebook_box_arrow_up").click(function () {
	$("#facebook_box_arrow_up").hide();
	$("#facebook_box_arrow_down").show();
    $("#facebook_box_container").slideUp();
});

$(".menu_toggle_links").click(function() {
	$("#menu_toggle").off("click"); 
});
				
$("#menu_toggle").click(function() {
	$("ul.menu").slideToggle();
});

});
';
	
		return $result;
	}
	
	public static function PageGetCopyright() {
		$result = '<div id="copyright"><span class="copyright"><A HREF="'.$_SESSION[SITE_ID]['admin_configuration_copyright_link'].'" target="_blank">'.$_SESSION[SITE_ID]['admin_configuration_copyright'].'</A></span></div>';
	
		return $result;
	}
	
	public static function PageGetFacebookTop() {
		$result = '<div id="fb-root"></div>
<script type="text/javascript">
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/'.FACEBOOK_LANG.'/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, \'script\', \'facebook-jssdk\'));
</script>';
		
		return $result;
	}
	
	public static function PageGetFacebookBottom() {
		$result = '<div id="facebook_box">
						<div id="facebook_box_arrow_down">Facebook</div><div id="facebook_box_arrow_up">Facebook</div>
						<div id="facebook_box_container">
					   		<div class="fb-like-box" data-href="'.FACEBOOK_LINK.'" data-width="300" data-show-faces="true" data-stream="false" data-show-border="false" data-header="false"></div>
				   		</div>
				   	</div>';
		
		return $result;
	}
	
	public static function PageGetAnalytics() {
		$result = "<script type='text/javascript'>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	ga('create', '".$_SESSION[SITE_ID]['admin_configuration_google_analytics']."', 'auto');
	ga('send', 'pageview');
	ga('set', '&uid', '".$_SESSION[SITE_ID]['connection_id']."');
	</script>";
	
		return $result;
	}
	
	public static function PageGetBanner() {
		$result = '<DIV id="banner_container">
				   		<DIV id="banner">
							<DIV id="site_title"></div>
				   		</DIV>
				   </DIV>';
		
		return $result;
	}
	
	public static function PageGetLang() {
		$result = '';
		
		if ($_SESSION[SITE_ID]['admin_configuration_show_lang']) {
			$result = '
						<DIV id="lang">
							<A HREF="'.BASE_LINK.'/pages/_lang.php?lang=en" TITLE="English" TARGET="_self"><img src="'.BASE_LINK.'/images/index/english.jpg" class="lang_image" Alt="English"></A>
							<A HREF="'.BASE_LINK.'/pages/_lang.php?lang=de" TITLE="Deutsch" TARGET="_self"><img src="'.BASE_LINK.'/images/index/german.jpg" class="lang_image" Alt="Deutsch"></A>
							<A HREF="'.BASE_LINK.'/pages/_lang.php?lang=es" TITLE="Español" TARGET="_self"><img src="'.BASE_LINK.'/images/index/spanish.jpg" class="lang_image" Alt="Español"></A>
							<A HREF="'.BASE_LINK.'/pages/_lang.php?lang=fr" TITLE="Français" TARGET="_self"><img src="'.BASE_LINK.'/images/index/french.jpg" class="lang_image" Alt="Français"></A>
						</DIV>';
		}
		
		return $result;
	}
	
	public static function GetAdminMenuList() {
		$result = '';
		
		try {
			$data = new Data();
			$menu = $data->AdminMenuGetList();
			
			for($i=0, $j = 0; $i < count($menu); $i++) {
				if ((($menu[$i][9] == '') || Util::IsAllowed($menu[$i][9])) &&
					((strpos($menu[$i][3], 'admin') !== false) && ($menu[$i][3] != 'admin.php')))
				{
					
					$result .= '<TR>
									<TD><DIV class="crumb '.$menu[$i][9].'_crumb"><A HREF="'.BASE_LINK.'/pages/'.$menu[$i][3].'" TARGET="'.$menu[$i][4].'" class="title">'.constant($menu[$i][1]).'</A></DIV></TD>
								</TR>';
					
				}
			}
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = GET_ADMIN_MENU_LIST__ERROR;
		}
		
		return $result;
	}
	
	public static function GetActiveBlogList() {
	
		$result = '<DIV id="blog_list">
			';
	
		try {
			$data = new Data();
			$blog_list = $data->BlogGetActiveList();
	
			for ($i=0; $i < count($blog_list); $i++) {
				if (($blog_list[$i][2] != '') && ($blog_list[$i][3] != '')) {
					$blog_link = BLOG_LINK.$blog_list[$i][0].'-'.Util::GetPageName($blog_list[$i][2]).PAGE_EXTENSION;
					$image = $data->ImageGetFirst($blog_list[$i][0], 'blog');
					$image_link = '';
					
					if (count($image) > 1) {
						$image_link = IMAGE_LITTLE_LINK.$image[1].'.'.$image[2];
					} else {
						$image_link = BASE_LINK.'/images/index/question_little.jpg';
					}
					
					$image_full_link = $image_link;
					
					// Dates
					$date_modified = DateTime::createFromFormat(PHP_DATETIME_FORMAT, $blog_list[$i][1]);
					$date_on = date('d/m/Y', $date_modified->getTimestamp());
					$time_on = date('H:i:s', $date_modified->getTimestamp());
					$date_modified_schema_format = date('Y-m-d\TH:i', $date_modified->getTimestamp());
					
					$date_created = DateTime::createFromFormat(PHP_DATETIME_FORMAT, $blog_list[$i][6]);
					$date_created_schema_format = date('Y-m-d\TH:i', $date_created->getTimestamp());
					
					// Blog text
					$blog_text = '';
					$text = explode('<br>', $blog_list[$i][3]);
					
					for ($j = 0; $j < 3; $j++) {
						if ($j > 0) {
							$blog_text .= '<br>';
						}
						
						if (isset($text[$j])) {
							$blog_text .= $text[$j];
						}
					}
					
					$blog_text .= ' <A HREF=\''.$blog_link.'\' target=\'_self\'><I>'.READ_NEXT.'</I></A>';
					
					// Blog keywords
					$blog_keywords = '';
					
					$tagList = $data->BlogTagGetList($blog_list[$i][0]);
					
					if ($tagList != NULL && (count($tagList) > 0)) {
						for ($k = 0; $k < count($tagList); $k++) {
							if ($k > 0) {
								$blog_keywords .= ', ';
							}
							
							$blog_keywords .= $tagList[$k][0];
						}
					}
				
					$result .= '<DIV id="blog_list_item" itemscope="" itemtype="http://schema.org/BlogPosting">
									<DIV id="blog_list_item_image"><A HREF=\''.$blog_link.'\' target=\'_self\'><img src="'.$image_link.'" alt="'.$blog_list[$i][2].'" class="little_image" /></A>
										<span class="hidden" itemprop="thumbnailUrl">'.$image_full_link.'</span>
										<span class="hidden"><A HREF=\''.$blog_link.'\' target=\'_self\' itemprop="url">'.$blog_list[$i][2].'</A></span>
									</DIV>
									<DIV id="blog_list_item_text"><span class="blog_list_title"><A HREF=\''.$blog_link.'\' target=\'_self\'>'.$blog_list[$i][2].'</A></span>
										<span itemprop="name" class="hidden">'.$blog_list[$i][2].'</span>
										<BR><span class="blog_list_date">'.ON.$date_on.AT.$time_on.BY.' <A HREF="mailto:'.$blog_list[$i][7].'?subject='.SITE_TITLE.' - '.$blog_list[$i][2].'" TARGET="_blank">'.$blog_list[$i][4].'</A> | '.$blog_list[$i][7].' '.BLOG_HITS.'</span>
										<span datetime="'.$date_created_schema_format.'" itemprop="datecreated" class="hidden">'.$date_created_schema_format.'</span>
										<span datetime="'.$date_modified_schema_format.'" itemprop="datemodified" class="hidden">'.$date_modified_schema_format.'</span>
										<BR><span class="blog_list_text" itemprop="articleBody">'.$blog_text.'</span>
										<span class="hidden" itemprop="keywords">'.$blog_keywords.'</span>
										<meta itemprop="interactionCount" content="UserPageVisits:'.$blog_list[$i][7].'" />
									</DIV>
								</DIV>';
				}
			}
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = ERROR_GET_ACTIVE_BLOG_LIST;
		}
		
		$result .= '</DIV>
			';
	
		return $result;
	}
	
	public static function GetHomeActiveBlogList() {
	
		$result = '';
	
		try {
			$data = new Data();
			$blog_list = $data->BlogGetActiveList();
	
			for ($i=0, $j=0; $i < count($blog_list); $i++) {
				if (($blog_list[$i][2] != '') && ($blog_list[$i][3] != '')) {
					$blog_link = BLOG_LINK.$blog_list[$i][0].'-'.Util::GetPageName($blog_list[$i][2]).PAGE_EXTENSION;
					$image = $data->ImageGetFirst($blog_list[$i][0], 'blog');
					$image_link = '';
					
					if (count($image) > 1) {
						$image_link = IMAGE_LITTLE_LINK.$image[1].'.'.$image[2];
					} else {
						$image_link = BASE_LINK.'/images/index/question_little.jpg';
					}
					
					$image_full_link = $image_link;
		
					// Dates
					$date_modified = DateTime::createFromFormat(PHP_DATETIME_FORMAT, $blog_list[$i][1]);
					$date_on = date('d/m/Y', $date_modified->getTimestamp());
					$time_on = date('H:i:s', $date_modified->getTimestamp());
					$date_modified_schema_format = date('Y-m-d\TH:i', $date_modified->getTimestamp());
					
					$date_created = DateTime::createFromFormat(PHP_DATETIME_FORMAT, $blog_list[$i][6]);
					$date_created_schema_format = date('Y-m-d\TH:i', $date_created->getTimestamp());
				
					// Blog text
					$blog_text = '';
					$text = explode('<br>', $blog_list[$i][3]);
					
					for ($j = 0; $j < 2; $j++) {
						if ($j > 0) {
							$blog_text .= '<br>';
						}
							
						if (isset($text[$j])) {
							$blog_text .= $text[$j];
						}
					}
					
					$blog_text .= ' <A HREF=\''.$blog_link.'\' target=\'_self\'><I>'.READ_NEXT.'</I></A>';
	
					// Blog keywords
					$blog_keywords = '';
					
					$tagList = $data->BlogTagGetList($blog_list[$i][0]);
					
					if ($tagList != NULL && (count($tagList) > 0)) {
						for ($k = 0; $k < count($tagList); $k++) {
							if ($k > 0) {
								$blog_keywords .= ', ';
							}
							
							$blog_keywords .= $tagList[$k][0];
						}
					}
					
					$result .= '<DIV id="home_list_item" itemscope="" itemtype="http://schema.org/BlogPosting">
									<DIV id="home_list_item_image"><A HREF=\''.$blog_link.'\' target=\'_self\'><img src="'.$image_link.'" alt="'.$blog_list[$i][2].'" class="min_image" /></A><span class="hidden" itemprop="thumbnailUrl">'.$image_full_link.'</span><span class="hidden"><A HREF=\''.$blog_link.'\' target=\'_self\' itemprop="url">'.$blog_list[$i][2].'</A></span>
									</DIV>
									<DIV id="home_list_item_text"><span class="home_blog_list_title"><A HREF=\''.$blog_link.'\' target=\'_self\'>'.$blog_list[$i][2].'</A></span><span itemprop="name" class="hidden">'.$blog_list[$i][2].'</span>
										<BR><span class="home_blog_list_text" itemprop="articleBody">'.$blog_text.'</span>&nbsp;&nbsp;<span class="home_blog_list_date">'.$date_on.' '.$time_on.' | '.$blog_list[$i][7].' '.BLOG_HITS.'</span>
										<span datetime="'.$date_created_schema_format.'" itemprop="datecreated" class="hidden">'.$date_created_schema_format.'</span>
										<span datetime="'.$date_modified_schema_format.'" itemprop="datemodified" class="hidden">'.$date_modified_schema_format.'</span>
										<span class="hidden" itemprop="keywords">'.$blog_keywords.'</span></DIV>
										<meta itemprop="interactionCount" content="UserPageVisits:'.$blog_list[$i][7].'" />
								</DIV>';
					
					if ($j >= $_SESSION[SITE_ID]['admin_configuration_home_blog_number'] - 1) {
						break;
					} else {
						$j++;
					}
				}
			}
	
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = ERROR_GET_HOME_ACTIVE_BLOG_LIST;
		}
	
		return $result;
	}
	
	
	
	public static function GetActiveLinksList() {
	
		$result = '';
	
		try {
			$data = new Data();
			$links_list = $data->LinksGetActiveList();
	
			$result = '<div id="links_list">
			';
	
	
			for ($i=0; $i < count($links_list); $i++) {
				$image = $data->ImageGetFirst($links_list[$i][0], 'links');
				$image_link = '';
				
				if (count($image) > 1) {
					$image_link = IMAGE_LITTLE_LINK.$image[1].'.'.$image[2];
				} else {
					$image_link = '../images/index/question_little.jpg';
				}
				
				$links_text = ' ';
				
				$result .= '
							<div id="link">
								<div id="link_image"><A HREF=\''.$links_list[$i][2].'\' target=\'_blank\' ALT="'.$links_list[$i][5].'"><img src="'.$image_link.'" ALT="'.$links_list[$i][3].'" class="little_image" /></A></TD></div>
								<div id="link_title"><A HREF=\''.$links_list[$i][2].'\' target=\'_blank\' ALT="'.$links_list[$i][5].'">'.$links_list[$i][3].'</A></div>
								<div id="link_text"><A HREF=\''.$links_list[$i][2].'\' target=\'_blank\' ALT="'.$links_list[$i][5].'">'.$links_list[$i][4].'</A></div>
							</div>';
			}
	
			$result .= '</div>
			';
	
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = GET_ACTIVE_LINKS_LIST_ERROR;
		}
	
		return $result;
	}
	
	public static function AdminGetAccessList() {
	
		try {
			$data = new Data();
			
			$show_header = true;
			$max_row_per_page = 10;
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
		
			$header_list = Array(Array(ADMIN_ACCESS_URL, 1, 'left', 'text', true, 0, 'admin_access_update.php', '_self'),
							  	 Array(ADMIN_ACCESS_DESCRIPTION, 2, 'right', 'text', true, null, null, null),
								 Array(LAST_UPDATE_DATE, 3, 'center', 'date', true, null, null, null),
								 Array(LAST_UPDATE_USER, 4, 'right', 'text', true, null, null, null));
		
			$item_list = $data->AdminAccessGetList($order, $sort);
		
			return Util::AdminGetList($header_list, $item_list, $show_header, $max_row_per_page, $style, $order, $sort);
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = ADMIN_ACCESS_GET_LIST_ERROR;
		}
	}
	
	public static function AdminGetErrorList() {
	
		try {
			$data = new Data();
			
			$show_header = true;
			$max_row_per_page = 25;
			$style = 'admin';
			$order = -1;
			$sort = 'DESC';
			
			if(isset($_REQUEST['order'])) {
				$order = $_REQUEST['order'];
			}
			
			if(isset($_REQUEST['sort'])) {
				if ($_REQUEST['sort'] == 0) {
					$sort = 'ASC';
				}
			}
			
			$header_list = Array(Array(ADMIN_ERROR_DATE, 1, 'center', 'date', true, null, null, null),
						 		 Array(ADMIN_ERROR_USER, 2, 'left', 'text', true, null, null, null),
								 Array(ADMIN_ERROR_URL, 3, 'left', 'text', true, null, null, null),
								 Array(ADMIN_ERROR_NAME, 4, 'left', 'text', true, null, null, null),
								 Array(ADMIN_ERROR_DESCRIPTION, 5, 'left', 'text', true, null, null, null));
			
			$item_list = $data->AdminErrorGetList($order, $sort);
			
			return Util::AdminGetList($header_list, $item_list, $show_header, $max_row_per_page, $style, $order, $sort);
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = ADMIN_ERROR_GET_LIST_ERROR;
		}
	}
	
	public static function AdminGetLogList() {
	
		try {
			$data = new Data();
			
			$show_header = true;
			$max_row_per_page = 25;
			$style = 'admin';
			$order = -1;
			$sort = 'DESC';
			
			if(isset($_REQUEST['order'])) {
				$order = $_REQUEST['order'];
			}
			
			if(isset($_REQUEST['sort'])) {
				if ($_REQUEST['sort'] == 0) {
					$sort = 'ASC';
				}
			}
			
			$header_list = Array(Array(ADMIN_LOG_DATE, 1, 'center', 'date', true, null, null, null),
								 Array(ADMIN_LOG_USER, 2, 'left', 'text', true, null, null, null),
								 Array(ADMIN_LOG_NAME, 3, 'left', 'text', true, null, null, null),
								 Array(ADMIN_LOG_DESCRIPTION, 4, 'left', 'text', true, null, null, null));
			
			$item_list = $data->AdminLogGetList($order, $sort);
			
			return Util::AdminGetList($header_list, $item_list, $show_header, $max_row_per_page, $style, $order, $sort);
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = ADMIN_LOG_GET_LIST_ERROR;
		}
	}
	
	public static function AdminGetMenuList() {
	
		try {
			$data = new Data();
			
			$show_header = true;
			$max_row_per_page = 10;
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
		
			$header_list = Array(Array(ADMIN_MENU_NAME, 1, 'left', 'text', true, 0, 'admin_menu_update.php', '_self'),
								 Array(ADMIN_MENU_LEVEL_0, 5, 'right', 'integer', true, null, null, null),
								 Array(ADMIN_MENU_LEVEL_1, 6, 'right', 'integer', true, null, null, null),
								 Array(ADMIN_MENU_STYLE, 12, 'center', 'text', true, null, null, null),
								 Array(LAST_UPDATE_DATE, 7, 'center', 'date', true, null, null, null),
								 Array(LAST_UPDATE_USER, 8, 'right', 'text', true, null, null, null));
		
			$item_list = $data->AdminMenuGetList($order, $sort);
		
			return Util::AdminGetList($header_list, $item_list, $show_header, $max_row_per_page, $style, $order, $sort);
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = ADMIN_MENU_GET_LIST_ERROR;
		}
	}
	
	public static function AdminGetVersionList() {
	
		try {
			$data = new Data();
			
			$show_header = true;
			$max_row_per_page = 10;
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
	
			$header_list = Array(Array(ADMIN_VERSION_NUMBER, 2, 'left', 'text', true, 0, 'admin_version_update.php', '_self'),
								 Array(ADMIN_VERSION_DATE, 1, 'center', 'date', true, null, null, null),
								 Array(ADMIN_VERSION_NAME, 3, 'right', 'text', true, null, null, null),
								 Array(LAST_UPDATE_DATE, 5, 'center', 'date', true, null, null, null),
								 Array(LAST_UPDATE_USER, 6, 'right', 'text', true, null, null, null));
	
			$item_list = $data->AdminVersionGetList($order, $sort);
	
			return Util::AdminGetList($header_list, $item_list, $show_header, $max_row_per_page, $style, $order, $sort);
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = ADMIN_VERSION_GET_LIST_ERROR;
		}
	}
	
	public static function AdminGetSiteThemeList() {
	
		try {
			$data = new Data();
	
			$show_header = true;
			$max_row_per_page = 10;
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
	
			$header_list = Array(Array(ADMIN_SITE_THEME_CODE, 1, 'right', 'text', true, 0, 'admin_site_theme_update.php', '_self'),
								 Array(ADMIN_SITE_THEME_NAME, 2, 'right', 'text', true, null, null, null),
								 Array(LAST_UPDATE_DATE, 3, 'center', 'date', true, null, null, null),
								 Array(LAST_UPDATE_USER, 4, 'right', 'text', true, null, null, null));
	
			$item_list = $data->AdminSiteThemeGetList($order, $sort);
	
			return Util::AdminGetList($header_list, $item_list, $show_header, $max_row_per_page, $style, $order, $sort);
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = ADMIN_SITE_THEME_GET_LIST_ERROR;
		}
	}
	
	public static function AdminGetBlogList() {
	
		try {
			$data = new Data();
	
			$show_header = true;
			$max_row_per_page = 6;
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
	
			$header_list = Array(Array(BLOG_IMAGE, 0, 'center', 'blog_image', true, 0, 'admin_blog_update.php', '_self'),
								 Array(BLOG_TEXT_TITLE, 4, 'left', 'text', true, null, null, null),
								 Array(BLOG_ACTIVE, 1, 'center', 'boolean', true, 0, '_admin_blog_activate.php', '_self'),
								 Array(LAST_UPDATE_DATE, 3, 'center', 'date', true, null, null, null),
								 Array(LAST_UPDATE_USER, 2, 'left', 'text', true, null, null, null));
	
			$item_list = $data->BlogGetList($order, $sort);
	
			return Util::AdminGetList($header_list, $item_list, $show_header, $max_row_per_page, $style, $order, $sort);
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = BLOG_GET_LIST_ERROR;
		}
	}
	
	public static function AdminGetLinksList() {
	
		try {
			$data = new Data();
	
			$show_header = true;
			$max_row_per_page = 6;
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
	
			$header_list = Array(Array(LINKS_IMAGE, 0, 'center', 'link_image', true, 0, 'admin_links_update.php', '_self'),
								 Array(LINKS_LINK, 4, 'left', 'text', true, null, null, null),
								 Array(LINKS_TITLE, 5, 'left', 'text', true, null, null, null),
								 Array(LINKS_ACTIVE, 1, 'center', 'boolean', true, 0, '_admin_links_activate.php', '_self'),
								 Array(LAST_UPDATE_DATE, 3, 'center', 'date', true, null, null, null),
								 Array(LAST_UPDATE_USER, 2, 'left', 'text', true, null, null, null));
	
			$item_list = $data->LinksGetList($order, $sort);
	
			return Util::AdminGetList($header_list, $item_list, $show_header, $max_row_per_page, $style, $order, $sort);
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = LINKS_GET_LIST_ERROR;
		}
	}
	
	public static function AdminGetUserList() {
	
		try {
			$data = new Data();
	
			$show_header = true;
			$max_row_per_page = 10;
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
	
			$header_list = Array(Array(ADMIN_USER_LOGIN, 4, 'left', 'text', true, 0, 'admin_user_update.php', '_self'),
								 Array(ADMIN_USER_ROLE, 2, 'right', 'text', true, null, null, null),
								 Array(ADMIN_USER_ACTIVE, 3, 'center', 'boolean', true, 0, '_admin_user_activate.php', '_self'),
								 Array(ADMIN_USER_FIRST_NAME, 6, 'right', 'text', true, null, null, null),
								 Array(ADMIN_USER_LAST_NAME, 7, 'right', 'text', true, null, null, null),
								 Array(LAST_UPDATE_DATE, 12, 'center', 'date', true, null, null, null),
								 Array(LAST_UPDATE_USER, 13, 'left', 'text', true, null, null, null));
	
			$item_list = $data->AdminUserGetList($order, $sort);
	
			return Util::AdminGetList($header_list, $item_list, $show_header, $max_row_per_page, $style, $order, $sort);
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = ADMIN_USER_GET_LIST_ERROR;
		}
	}
	
	public static function AdminGetRoleList() {
	
		try {
			$data = new Data();
	
			$show_header = true;
			$max_row_per_page = 10;
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
	
			$header_list = Array(Array(ADMIN_ROLE_NAME, 1, 'left', 'text', true, 0, 'admin_role_update.php', '_self'),
								 Array(LAST_UPDATE_DATE, 3, 'center', 'date', true, null, null, null),
								 Array(LAST_UPDATE_USER, 2, 'left', 'text', true, null, null, null));
	
			$item_list = $data->AdminRoleGetList($order, $sort);
	
			return Util::AdminGetList($header_list, $item_list, $show_header, $max_row_per_page, $style, $order, $sort);
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = ADMIN_ROLE_GET_LIST_ERROR;
		}
	}
	
	public static function AdminGetSpecificList($table_name) {
	
		try {
			$data = new Data();
	
			$show_header = true;
			$max_row_per_page = 10;
			$style = 'admin';
			$order = -1;
			$sort = '';
	
			if(isset($_REQUEST['order'])) {
				$order = $_REQUEST['order'];
			}
	
			if(isset($_REQUEST['sort'])) {
				if ($_REQUEST['sort'] == 1) {
					$sort = 'DESC';
				} else {
					$sort = 'ASC';
				}
			}
	
			$header_list = $data->AdminSpecificTableListGet($table_name);
			
			$item_list = $data->AdminSpecificTableGetList($table_name, $order, $sort);
	
			return Util::AdminGetList($header_list, $item_list, $show_header, $max_row_per_page, $style, $order, $sort);
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = ADMIN_SPECIFIC_TABLE_GET_LIST_ERROR;
		}
	}
	
	public static function AdminGetConfigurationList() {
	
		try {
			$data = new Data();
	
			$show_header = true;
			$max_row_per_page = 10;
			$style = 'admin';
			$order = -1;
			$sort = '';
	
			if(isset($_REQUEST['order'])) {
				$order = $_REQUEST['order'];
			}
	
			if(isset($_REQUEST['sort'])) {
				if ($_REQUEST['sort'] == 1) {
					$sort = 'DESC';
				} else {
					$sort = 'ASC';
				}
			}
			
			$header_list = Array(Array(ADMIN_CONFIGURATION_NAME, 1, 'left', 'text', true, 0, 'admin_configuration_update.php', '_self'),
								 Array(ADMIN_CONFIGURATION_ACTIVE, 2, 'center', 'boolean', true, null, null, null),
								 Array(LAST_UPDATE_DATE, 3, 'center', 'date', true, null, null, null),
								 Array(LAST_UPDATE_USER, 4, 'right', 'text', true, null, null, null));
			
			$item_list = $data->AdminConfigurationGetList($order, $sort);
			
			return Util::AdminGetList($header_list, $item_list, $show_header, $max_row_per_page, $style, $order, $sort);
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = ADMIN_SPECIFIC_TABLE_GET_LIST_ERROR;
		}
	}
	
	public static function AdminGetAccessListWithRole($admin_role_id) {
	
		if (isset($admin_role_id)) {
			try {
				$data = new Data();
		
				$show_header = true;
				$max_row_per_page = 10;
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
		
				$header_list = Array(Array(ADMIN_ACCESS_URL, 1, 'left', 'text', true, null, null, null),
									 Array(ADMIN_ACCESS_DESCRIPTION, 2, 'right', 'text', true, null, null, null),
									 Array('', 0, 'center', 'delete', true, 0, '_admin_role_access_delete.php?admin_role_id='.$admin_role_id, '_self'));
		
				$item_list = $data->AdminRoleAccessGetList($admin_role_id, $order, $sort);
		
				return Util::AdminGetList($header_list, $item_list, $show_header, $max_row_per_page, $style, $order, $sort, $admin_role_id);
			} catch (Exception $ex) {
				$_SESSION[SITE_ID]['error'] = ADMIN_ROLE_GET_ACCESS_LIST_ERROR;
			}
		} else {
			throw new DataException(MISSING_ARGUMENT_ERROR);
		}
	}
	
	public static function AdminGetList($header_list, $item_list, $show_header, $max_row_per_page, $style, $order, $sort, $id = NULL, $store_mode = false, $email = false) {
	
		$result = '';
		$link = '';
		$email_link = '';
		$parameters = '';
		$total_amount = 0;
		
		if(isset($_REQUEST['table'])) {
			$parameters .= 'table='.$_REQUEST['table'];
		}
		
		if(isset($_REQUEST['field'])) {
			
			if ($parameters != '') {
				$parameters .= '&';
			}
			
			$parameters .= 'field='.$_REQUEST['field'];
		}
		
		if(isset($_REQUEST['field_value'])) {
			if ($parameters != '') {
				$parameters .= '&';
			}
			
			$parameters .= 'field_value='.$_REQUEST['field_value'];
		}
		
		if ($email) {
			$email_link = $_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/';
		}
		
		try {
			// Header name
			// Database column ID
			// Align
			// Format (text, number, date, datetime, bool, image)
			// Order yes/no
			// Database link ID
			// Link
			// Link target
			$data = new Data();
	
			// Column and row count
			$column_count = 0;
			$row_count = 0;
	
			if (isset($header_list)) {
				$column_count = count($header_list);
			}
	
			if (isset($item_list)) {
				$row_count = count($item_list);
			}
			
			if ($row_count == 0) {
				if ($store_mode == true) {
					return NO_RESULT;
				} else {
					return '<TABLE class="'.$style.'"><TR><TD>'.NO_RESULT.'</TD></TR></TABLE>';
				}
				
			}
	
			// Page count
			$page_total = 1;
	
			if ($row_count > $max_row_per_page) {
				$page_total = ceil($row_count/$max_row_per_page);
			}
	
			$page_number = 1;
	
			if(isset($_REQUEST['page'])) {
				$page_number = $_REQUEST['page'];
				if ($page_number > $page_total) {
					$page_number = 1;
				}
			}
	
			$page_next = -1;
			$page_previous = -1;
	
			if ($page_number < $page_total) {
				$page_next = $page_number+1;
			} else {
				$page_next = $page_total;
			}
	
			if ($page_number > 1) {
				$page_previous = $page_number-1;
			} else {
				$page_previous = 1;
			}
			
			if ($id != NULL) {
				$link = 'id='.$id.'&';
			}
	
			$result .= '<TABLE class="'.$style.'">';
	
			if ($show_header && ($column_count > 0)) {
	
				$result .= '<TR>';
	
				for ($i = 0; $i < $column_count; $i++) {
					
					$url = explode('?', $_SERVER['REQUEST_URI']);
					
					$result .= '<TH ALIGN="'.$header_list[$i][2].'">';  // Align
	
					if ($header_list[$i][1] && !$email) { // Order possible?
						if(($order == ($header_list[$i][1]+1)) && ($sort == 'ASC')) {
							$result .= '<A HREF="'.$url[0].'?'.$parameters.'&'.$link.'order='.($header_list[$i][1]+1).'&sort=1&page='.$page_number.'" TARGET="_self">';
						} else {
							$result .= '<A HREF="'.$url[0].'?'.$parameters.'&'.$link.'order='.($header_list[$i][1]+1).'&sort=0&page='.$page_number.'" TARGET="_self">';
						}
					}
	
					$result .= $header_list[$i][0];
	
					if ($header_list[$i][1] && !$email) { // Order possible?
						$result .= '</A>';
					}
	
					$result .= '</TH>';
				}
	
				$result .= '</TR>';
			}
	
			for ($j = ($page_number-1)*$max_row_per_page; $j < $row_count; $j++) {
	
				$result .= '<TR>';
	
				for ($k = 0; $k < $column_count; $k++) {
	
					$result .= '<TD>';
	
					if (isset($header_list[$k][6]) && ($header_list[$k][6] != '')) {
						
						if (strpos($header_list[$k][6], '?')) {
							$result .= '<A HREF="'.$email_link.$header_list[$k][6].'&'.$parameters.'&id='.$item_list[$j][$header_list[$k][5]].'" TARGET="'.$header_list[$k][7].'">';
						} else {
							$result .= '<A HREF="'.$email_link.$header_list[$k][6].'?'.$parameters.'&id='.$item_list[$j][$header_list[$k][5]].'" TARGET="'.$header_list[$k][7].'">';
						}
					}
	
					switch($header_list[$k][3]) {
						case 'number':{
							$result .= $item_list[$j][$header_list[$k][1]]; // TBD
							break;
						}
						case 'date':{
							$result .= $item_list[$j][$header_list[$k][1]]; // TBD
							break;
						}
						case 'datetime':{
							$result .= $item_list[$j][$header_list[$k][1]]; // TBD
							break;
						}
						case 'boolean':{
							if ($item_list[$j][$header_list[$k][1]] == 1) {
								$result .= YES;
							} else {
								$result .= NO;
							}
							break;
						}
						case 'delete':{
							$result .= DELETE;
							break;
						}
						case 'item_image':{
							$image = $data->ImageGetFirst($item_list[$j][0], 'item');
							$image_link = '';
	
							if (count($image) > 1) {
								$image_link = IMAGE_LITTLE_LINK.$image[1].'.'.$image[2];
							} else {
								$image_link = '../images/index/question_little.jpg';
							}
							
							if ($email) {
								$image_link = str_replace('..', $_SESSION[SITE_ID]['admin_configuration_site_name'], $image_link);
							}
	
							$result .= '<img src="'.$image_link.'" height="'.$_SESSION[SITE_ID]['admin_configuration_image_little_height'].'" class="little" />';
							break;
						}
						case 'blog_image':{
							$image = $data->ImageGetFirst($item_list[$j][0], 'blog');
							$image_link = '';
	
							if (count($image) > 1) {
								$image_link = IMAGE_LITTLE_LINK.$image[1].'.'.$image[2];
							} else {
								$image_link = '../images/index/question_little.jpg';
							}
							
							if ($email) {
								$image_link = str_replace('..', $_SESSION[SITE_ID]['admin_configuration_site_name'], $image_link);
							}
	
							$result .= '<img src="'.$image_link.'" height="'.$_SESSION[SITE_ID]['admin_configuration_image_little_height'].'" class="little" />';
							break;
						}
						case 'link_image':{
							$image = $data->ImageGetFirst($item_list[$j][0], 'links');
							$image_link = '';
						
							if (count($image) > 1) {
								$image_link = IMAGE_LITTLE_LINK.$image[1].'.'.$image[2];
							} else {
								$image_link = '../images/index/question_little.jpg';
							}
						
							if ($email) {
								$image_link = str_replace('..', $_SESSION[SITE_ID]['admin_configuration_site_name'], $image_link);
							}
						
							$result .= '<img src="'.$image_link.'" height="'.$_SESSION[SITE_ID]['admin_configuration_image_little_height'].'" class="little" />';
							break;
						}
						case 'constant':{
							if ($item_list[$j][$header_list[$k][1]] != '') {
								$result .= constant($item_list[$j][$header_list[$k][1]]);
							} else {
							 	$result .= '';
							 }
							break;
						}
						case 'price':{
							if ($item_list[$j][$header_list[$k][1]] != '') {
								$price = str_replace(',', '.', $item_list[$j][$header_list[$k][1]]);
								$price = str_replace('EUR', '&euro;', $price);
								$price = str_replace('USD', '&#36;', $price);
								
								$result .= $price;
								
								$price_amount = explode(" ", $price);
								$total_amount += floatval($price_amount[0]);
							} else {
								$result .= '';
							}
							break;
						}
						case 'text':
						default:
							$result .= $item_list[$j][$header_list[$k][1]];
							break;
					}
	
					if (isset($header_list[$k][6])) {
						$result .= '</A>';
					}
	
	
					$result .= '</TD>';
				}
	
				$result .= '</TR>
				';
	
				if ($j >= ($page_number*$max_row_per_page-1)) {
					break;
				}
			}
			
			if ($store_mode) {
				$result .= '<TR>
				            	<TD COLSPAN="'.$column_count.'" ALIGN="RIGHT">
									<TABLE>
										<TR>
											<TD ALIGN="RIGHT">'.TABLE_TOTAL_AMOUNT.' :</TD>
											<TD class="field_separator"></TD>
											<TD>';
				if ($email) { 
					$result .= number_format($total_amount, 2, '.', '').' &euro;';
				} else {
					$result .= '<INPUT TYPE="text" ID="table_total_amount" NAME="table_total_amount" CLASS="sub_total" READONLY VALUE="'.number_format($total_amount, 2, '.', '').'"> &euro;';
				}
				
				$result .= '</TD>
										</TR>
									</TABLE>
								</TD>
			        		</TR>';
			}
	
			if (!$email) {
				
				$url = explode('?', $_SERVER['REQUEST_URI']);
				
				if ($sort == 'DESC') {
					$result .= '<TR><TD COLSPAN="'.$column_count.'" ALIGN="RIGHT">'.TABLE_TOTAL_NUMBER.' : '.count($item_list).' / '.TABLE_PAGE_NUMBER.' :';
					
					for ($i = 1; $i <= $page_total; $i++) {
						$result .= ' <A HREF="'.$url[0].'?'.$parameters.'&'.$link.'order='.$order.'&sort=1&page='.$i.'" TARGET="_self">';
						
						if ($page_number == $i) {
							$result .= '<span class="current_page_number">'.$i.'</span></A>';
						} else {
							$result .= '<span class="page_number">'.$i.'</span></A>';
						}
					}
					
					$result .= '</TD></TR>';
				} else {
					$result .= '<TR><TD COLSPAN="'.$column_count.'" ALIGN="RIGHT">'.TABLE_TOTAL_NUMBER.' : '.count($item_list).' / '.TABLE_PAGE_NUMBER.' :';
					
					for ($i = 1; $i <= $page_total; $i++) {
						$result .= ' <A HREF="'.$url[0].'?'.$parameters.'&'.$link.'order='.$order.'&sort=0&page='.$i.'" TARGET="_self">';
						
						if ($page_number == $i) {
							$result .= '<span class="current_page_number">'.$i.'</span></A>';
						} else {
							$result .= '<span class="page_number">'.$i.'</span></A>';
						}
					}
					
					$result .= '</TD></TR>';
				}
			}
			
			$result .= '</TABLE>';
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = GET_LIST_ERROR;
		}
	
		if ($store_mode) {
			return Array($result, $total_amount);
		} else {
			return $result;
		}
		
	}
	
	// OBSOLETE
	public static function GetPostalCharges($total_amount, $order_delivery_type) {
		$postal_charges = 0;
		
		if ($order_delivery_type != '0') {
			if ($total_amount <= $_SESSION[SITE_ID]['admin_configuration_store_postal_charges_0_amount']) {
				$postal_charges = $_SESSION[SITE_ID]['admin_configuration_store_postal_charges_0'];
			} else if (($total_amount > $_SESSION[SITE_ID]['admin_configuration_store_postal_charges_0_amount']) && ($total_amount < $_SESSION[SITE_ID]['admin_configuration_store_postal_charges_1_amount'])) {
				$postal_charges = $_SESSION[SITE_ID]['admin_configuration_store_postal_charges_1'];
			} else if ($total_amount >= $_SESSION[SITE_ID]['admin_configuration_store_postal_charges_2_amount']) {
				$postal_charges = $_SESSION[SITE_ID]['admin_configuration_store_postal_charges_2'];
			} else {
				$postal_charges = $_SESSION[SITE_ID]['admin_configuration_store_postal_charges_0'];
			}
		}
		
		return $postal_charges;
	}
	// END OF OBSOLETE
	
	public static function GetPostalChargesV2($order_delivery_type) {
		$postal_charges = 0;
		$total_weight = 0;
		
		if ($order_delivery_type != '0') {
			try {
				$data = new Data();
				$basket = $data->BasketGetV2();
				
				for ($i = 0; $i < count($basket); $i++) {
					$total_weight += $basket[$i][3];
				}
					
				if ($total_weight <= $_SESSION[SITE_ID]['admin_configuration_store_postal_charges_0_weight']) {
					$postal_charges = $_SESSION[SITE_ID]['admin_configuration_store_postal_charges_0'];
				} else if (($total_weight > $_SESSION[SITE_ID]['admin_configuration_store_postal_charges_0_weight']) && ($total_weight <= $_SESSION[SITE_ID]['admin_configuration_store_postal_charges_1_weight'])) {
					$postal_charges = $_SESSION[SITE_ID]['admin_configuration_store_postal_charges_1'];
				} else if (($total_weight > $_SESSION[SITE_ID]['admin_configuration_store_postal_charges_1_weight']) && ($total_weight <= $_SESSION[SITE_ID]['admin_configuration_store_postal_charges_2_weight'])) {
					$postal_charges = $_SESSION[SITE_ID]['admin_configuration_store_postal_charges_2'];
				} else if ($total_weight >= $_SESSION[SITE_ID]['admin_configuration_store_postal_charges_2_weight']) {
					$postal_charges = $_SESSION[SITE_ID]['admin_configuration_store_postal_charges_3'];
				} else {
					$postal_charges = $_SESSION[SITE_ID]['admin_configuration_store_postal_charges_0'];
				}
			} catch (Exception $ex) {
				$_SESSION[SITE_ID]['error'] = GET_POSTAL_CHARGES_V2_ERROR;
			}
		}
		
		return $postal_charges;
	}
	
	
	public static function GetPostalChargesWithOrderId($order_id) {
		$postal_charges = 0;
	
		if (isset($order_id)) {
			try {
				$data = new Data();
				$postal_charges = $data->PostalChargesGetWithOrderId($order_id);
			} catch (Exception $ex) {
				$_SESSION[SITE_ID]['error'] = GET_POSTAL_CHARGES_WITH_ORDER_ID_ERROR;
			}
		} else {
			throw new DataException(MISSING_ARGUMENT_ERROR);
		}

		return $postal_charges;
	}
	
	public static function GetDiscountWithOrderId($order_id) {
		$discount = 0;
	
		if (isset($order_id)) {
			try {
				$data = new Data();
				$discount = $data->DiscountGetWithOrderId($order_id);
			} catch (Exception $ex) {
				$_SESSION[SITE_ID]['error'] = GET_DISCOUNT_WITH_ORDER_ID_ERROR;
			}
		} else {
			throw new DataException(MISSING_ARGUMENT_ERROR);
		}
	
		return $discount;
	}
	
	public static function ItemAddOrUpdatePage($item_id) {

		if (isset($item_id)) {
			try {
				$data = new Data();
				$dataSpecific = new DataSpecific();
				$current = $dataSpecific->ItemGet($item_id);
				
				$filename = $item_id.'-'.Util::GetPageName($current[6]);
				
				if (file_exists(ITEM_DIRECTORY.$filename.PAGE_EXTENSION)) {
					unlink(ITEM_DIRECTORY.$filename.PAGE_EXTENSION);
				}
				
				$file = new File(ITEM_DIRECTORY.$filename.PAGE_EXTENSION);
				$file->WriteLine('<?php');
				$file->WriteLine('$_REQUEST[\'id\'] = '.$item_id.';');
				$file->WriteLine('$root = dirname(__FILE__)."/../";');
				$file->WriteLine('include_once($root.\'./pages/item.php\');');
				$file->WriteLine("?>");
				
			} catch (Exception $ex) {
				$_SESSION[SITE_ID]['error'] = ITEM_ADD_OR_UPDATE_PAGE_ERROR;
			}
		} else {
			throw new DataException(MISSING_ARGUMENT_ERROR);
		}
	}
	
	public static function ItemDeletePage($item_id) {
		if (isset($item_id)) {
			try {
				$dataSpecific = new DataSpecific();
				$current = $dataSpecific->ItemGet($item_id);
		
				$filename = $item_id.'-'.Util::GetPageName($current[6]);
		
				if (file_exists(ITEM_DIRECTORY.$filename.PAGE_EXTENSION)) {
					unlink(ITEM_DIRECTORY.$filename.PAGE_EXTENSION);
				}
		
			} catch (Exception $ex) {
				$_SESSION[SITE_ID]['error'] = ITEM_DELETE_PAGE_ERROR;
			}
		} else {
			throw new DataException(MISSING_ARGUMENT_ERROR);
		}
	}
	
	public static function BlogAddOrUpdatePage($blog_id) {
		if (isset($blog_id)) {
			try {
				$data = new Data();
				$blog_list = $data->BlogGetMultilanguageText($blog_id);
				
				for($i = 0; $i < count($blog_list); $i++) {
					$filename = $blog_list[$i][0].'-'.Util::GetPageName($blog_list[$i][2]);
				
					if (file_exists(BLOG_DIRECTORY.$filename.PAGE_EXTENSION)) {
						unlink(BLOG_DIRECTORY.$filename.PAGE_EXTENSION);
					}
					
					$file = new File(BLOG_DIRECTORY.$filename.PAGE_EXTENSION);
					$file->WriteLine('<?php');
					$file->WriteLine('$_REQUEST[\'id\'] = '.$blog_id.';');
					$file->WriteLine('$root = dirname(__FILE__)."/../";');
					$file->WriteLine('include_once($root.\'./pages/blog.php\');');
					$file->WriteLine("?>");
				}
			} catch (Exception $ex) {
				$_SESSION[SITE_ID]['error'] = BLOG_ADD_OR_UPDATE_PAGE_ERROR;
			}
		} else {
			throw new DataException(MISSING_ARGUMENT_ERROR);
		}
	}
	
	public static function BlogDeletePage($blog_id) {
		if (isset($blog_id)) {
			try {
				$data = new Data();
				$blog_list = $data->BlogGetMultilanguageText($blog_id);
	
				for($i = 0; $i < count($blog_list); $i++) {
					$filename = $blog_list[$i][0].'-'.Util::GetPageName($blog_list[$i][2]);
					
					if (file_exists(BLOG_DIRECTORY.$filename.PAGE_EXTENSION)) {
						unlink(BLOG_DIRECTORY.$filename.PAGE_EXTENSION);
					}
				}
			} catch (Exception $ex) {
				$_SESSION[SITE_ID]['error'] = BLOG_DELETE_PAGE_ERROR;
			}
		} else {
			throw new DataException(MISSING_ARGUMENT_ERROR);
		}
	}
	
	public static function GetPageName($str) {
		$result = '';

		if ($str != '') {
			$replace = array(
					'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'Ae', 'Å'=>'A', 'Æ'=>'A', 'Ă'=>'A',
					'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'ae', 'å'=>'a', 'ă'=>'a', 'æ'=>'ae',
					'þ'=>'b', 'Þ'=>'B',
					'Ç'=>'C', 'ç'=>'c',
					'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E',
					'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e',
					'Ğ'=>'G', 'ğ'=>'g',
					'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'İ'=>'I', 'ı'=>'i', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i',
					'Ñ'=>'N',
					'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'Oe', 'Ø'=>'O', 'ö'=>'oe', 'ø'=>'o',
					'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
					'Š'=>'S', 'š'=>'s', 'Ş'=>'S', 'ș'=>'s', 'Ș'=>'S', 'ş'=>'s', 'ß'=>'ss',
					'ț'=>'t', 'Ț'=>'T',
					'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'Ue',
					'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ü'=>'ue',
					'Ý'=>'Y',
					'ý'=>'y', 'ý'=>'y', 'ÿ'=>'y',
					'Ž'=>'Z', 'ž'=>'z'
			);
			
			$str = strtr($str, $replace);
			
			$result = preg_replace("/[^A-Za-z0-9]/", "-", $str);
			$result = strtolower($result);
		}
		
		return $result;
	}
	
	public static function AdminFixPages() {
		try {
			$data = new Data();
			$dataSpecific = new DataSpecific();
			$item_list = $dataSpecific->ItemGetList();
			
			for($i = 0; $i < count($item_list); $i++) {
				if ($item_list[$i][5] == '1') {
					Util::ItemAddOrUpdatePage($item_list[$i][0]);
				} else {
					Util::ItemDeletePage($item_list[$i][0]);
				}
			}
			
			$blog_list = $data->BlogGetMultilanguageList();
			
			for($i = 0; $i < count($blog_list); $i++) {
				if ($blog_list[$i][1] == '1') {
					Util::BlogAddOrUpdatePage($blog_list[$i][0], $blog_list[$i][6]);
				} else {
					Util::BlogDeletePage($blog_list[$i][0], $blog_list[$i][6]);
				}
			}
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = ADMIN_FIX_PAGES_ERROR;
		}
	}
	
	public static function AdminGenerateSiteMap() {
		
		$lang_list = array("fr", "en", "de", "es"); // TODO : TO BE CHANGED (dynamic)...
		
		$file = new File(ROOT_DIRECTORY.$_SESSION[SITE_ID]['admin_configuration_sitemap_file']);
		$file->WriteLine('<?xml version="1.0" encoding="UTF-8"?>');
		$file->WriteLine('<urlset ');
		$file->WriteLine('		xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" ');
		$file->WriteLine('		xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ');
		$file->WriteLine('		xmlns:xhtml="http://www.w3.org/1999/xhtml" ');
		$file->WriteLine('		xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 ');
		$file->WriteLine('		http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"');
		$file->WriteLine('>');
		
		$file->WriteLine('<url>');
		$file->WriteLine('    <loc>'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/index.php</loc>');
		$file->WriteLine('    <lastmod>'.date("Y-m-d\TH:i:s+01:00", filemtime(ROOT_DIRECTORY.'/pages/index.php')).'</lastmod>');
		
		for ($i = 0; $i < count($lang_list); $i++) { // TODO : TO BE CHANGED (dynamic)...
			$file->WriteLine('    <xhtml:link rel="alternate" hreflang="'.$lang_list[$i].'" href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/index.php?lang='.$lang_list[$i].'" />');
		}
		
		$file->WriteLine('</url>');
		
		$file->WriteLine('<url>');
		$file->WriteLine('    <loc>'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/css/main.css</loc>');
		$file->WriteLine('    <lastmod>'.date("Y-m-d\TH:i:s+01:00", filemtime(ROOT_DIRECTORY.'/css/main.css')).'</lastmod>');
		$file->WriteLine('</url>');

		$filename_list = scandir(ROOT_DIRECTORY.'/pages/');
		
		foreach ($filename_list as $filename) {
			if (($filename != '.') &&
				($filename != '..') &&
				($filename != '.htaccess') &&
				(strpos($filename, 'admin') === FALSE) &&
				((strpos($filename, '_') != 0) || (strpos($filename, '_') === FALSE))) {
					$file->WriteLine('<url>');
					$file->WriteLine('    <loc>'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/'.$filename.'</loc>');
					$file->WriteLine('    <lastmod>'.date("Y-m-d\TH:i:s+01:00", filemtime(ROOT_DIRECTORY.'/pages/'.$filename)).'</lastmod>');
					for ($i = 0; $i < count($lang_list); $i++) { // TODO : TO BE CHANGED (dynamic)...
						$file->WriteLine('    <xhtml:link rel="alternate" hreflang="'.$lang_list[$i].'" href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/'.$filename.'?lang='.$lang_list[$i].'" />');
					}
					$file->WriteLine('</url>');
				}
		}
		
		$blog_list = scandir(ROOT_DIRECTORY.'/blog/');
		
		foreach ($blog_list as $blog) {
			if ($blog != '.' &&
				$blog != '..' &&
				$blog != '.htaccess') {
					$file->WriteLine('<url>');
					$file->WriteLine('    <loc>'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/blog/'.$blog.'</loc>');
					$file->WriteLine('    <lastmod>'.date("Y-m-d\TH:i:s+01:00", filemtime(ROOT_DIRECTORY.'/blog/'.$blog)).'</lastmod>');
					for ($i = 0; $i < count($lang_list); $i++) { // TODO : TO BE CHANGED (dynamic)...
						$file->WriteLine('    <xhtml:link rel="alternate" hreflang="'.$lang_list[$i].'" href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/blog/'.$blog.'?lang='.$lang_list[$i].'" />');
					}
					$file->WriteLine('</url>');
				}
		}
		
		$item_list = scandir(ROOT_DIRECTORY.'/item/');
		
		foreach ($item_list as $item) {
			if ($item != '.' &&
				$item != '..' &&
				$item != '.htaccess') {
					$file->WriteLine('<url>');
					$file->WriteLine('    <loc>'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/item/'.$item.'</loc>');
					$file->WriteLine('    <lastmod>'.date("Y-m-d\TH:i:s+01:00", filemtime(ROOT_DIRECTORY.'/item/'.$item)).'</lastmod>');
					for ($i = 0; $i < count($lang_list); $i++) { // TODO : TO BE CHANGED (dynamic)...
						$file->WriteLine('    <xhtml:link rel="alternate" hreflang="'.$lang_list[$i].'" href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/item/'.$item.'?lang='.$lang_list[$i].'" />');
					}
					$file->WriteLine('</url>');
				}
		}
		
		$file->WriteLine('</urlset>');
	}
	
	public static function AdminGetItemTypeList() {
	
		try {
			$data = new Data();
	
			$show_header = true;
			$max_row_per_page = 10;
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
	
			$header_list = Array(Array(ITEM_TYPE_NAME, 1, 'left', 'text', true, 0, 'admin_item_type_update.php', '_self'),
								 Array(LAST_UPDATE_DATE, 2, 'center', 'date', true, null, null, null),
								 Array(LAST_UPDATE_USER, 3, 'right', 'text', true, null, null, null));
	
			$item_list = $data->ItemTypeGetList($order, $sort);
	
			return Util::AdminGetList($header_list, $item_list, $show_header, $max_row_per_page, $style, $order, $sort);
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = ITEM_TYPE_GET_LIST_ERROR;
		}
	}
	
	public static function AdminGetItemType2List() {
	
		try {
			$data = new Data();
	
			$show_header = true;
			$max_row_per_page = 10;
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
	
			$header_list = Array(Array(ITEM_TYPE_2_NAME, 1, 'left', 'text', true, 0, 'admin_item_type_2_update.php', '_self'),
								 Array(LAST_UPDATE_DATE, 2, 'center', 'date', true, null, null, null),
								 Array(LAST_UPDATE_USER, 3, 'right', 'text', true, null, null, null));
	
			$item_list = $data->ItemType2GetList($order, $sort);
	
			return Util::AdminGetList($header_list, $item_list, $show_header, $max_row_per_page, $style, $order, $sort);
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = ITEM_TYPE_GET_LIST_ERROR;
		}
	}
	
////// STORE PART

	public static function AdminGetOrderStatusList() {
	
		try {
			$data = new Data();
	
			$show_header = true;
			$max_row_per_page = 10;
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
	
			$header_list = Array(Array(ADMIN_ORDER_STATUS_ID, 0, 'center', 'text', true, 0, 'admin_order_status_update.php', '_self'),
					Array(ADMIN_ORDER_STATUS_NAME, 1, 'left', 'text', true, 0, 'admin_order_status_update.php', '_self'),
					Array(ADMIN_ORDER_STATUS_ACTIVE, 2, 'center', 'boolean', true, null, null, null),
					Array(ADMIN_ORDER_STATUS_INVENTORY_RESERVE, 3, 'center', 'boolean', true, null, null, null),
					Array(ADMIN_ORDER_STATUS_INVENTORY_CLEANUP, 4, 'center', 'boolean', true, null, null, null),
					Array(ADMIN_ORDER_STATUS_LOCK, 5, 'center', 'boolean', true, null, null, null),
					Array(ADMIN_ORDER_STATUS_OTHER_POSSIBLE_STATUS, 6, 'right', 'text', true, null, null, null),
					Array(LAST_UPDATE_DATE, 7, 'center', 'date', true, null, null, null),
					Array(LAST_UPDATE_USER, 8, 'right', 'text', true, null, null, null));
	
			$item_list = $data->AdminOrderStatusGetList($order, $sort);
	
			return Util::AdminGetList($header_list, $item_list, $show_header, $max_row_per_page, $style, $order, $sort);
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = ADMIN_ORDER_STATUS_GET_LIST_ERROR;
		}
	}
	
	public static function GetBasket() {
	
		try {
			$data = new Data();
	
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
	
			$header_list = Array(Array(ITEM_IMAGE, 0, 'center', 'item_image', true, 0, 'item.php', '_self'),
								 Array(ITEM_NAME, 3, 'left', 'text', true, 0, 'item.php', '_self'),
								 Array(ITEM_TYPE, 1, 'left', 'constant', true, null, null, null),
								 Array(ITEM_TYPE_2, 2, 'left', 'constant', true, null, null, null),
								 Array(QUANTITY, 4, 'center', 'integer', true, null, null, null),
								 Array(PRICE, 5, 'left', 'price', true, null, null, null),
								 Array('', 0, 'center', 'delete', true, 0, '_basket_delete.php', '_self')); // SPECIFIC
	
			$item_list = $data->BasketGet($order, $sort);
	
			return Util::AdminGetList($header_list, $item_list, $show_header, $max_row_per_page, $style, $order, $sort, null, true);
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = GET_BASKET_ERROR;
		}
	}
	
	public static function GetOrderHeader($order_id, $email = false) {
	
		try {
			$data = new Data();
			$result = '';
	
			$header = $data->OrderGetHeader($order_id);
			
			if (isset($header)) {
				
				if ($email) {
					$result .= MAIL_ORDER_ORDER_NUMBER.' : '.$order_id.'<BR>';
					$result .= ORDER_CREATION_DATE.' : '.$header[3].'<BR>';
					$result .= ORDER_LAST_UPDATE.' : '.$header[4].' '.ORDER_LAST_UPDATE_BY.' '.$header[5].'<BR>';
					$result .= ORDER_DELIVERY_TYPE.' : '.constant($header[6]).'<BR>';
					$result .= '<H4>'.ORDER_STATUS.' : '.constant($header[2]).'</H4>';
					$result .= '<A HREF="'.$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/order.php?id='.$order_id.'" TARGET="_blank">'.MAIL_ORDER_SEE_ONLINE.'</A>';
				} else {
					$result .= ORDER_CREATION_DATE.' : '.$header[3].'<BR>';
					$result .= ORDER_LAST_UPDATE.' : '.$header[4].' '.ORDER_LAST_UPDATE_BY.' '.$header[5].'<BR>';
					$result .= ORDER_DELIVERY_TYPE.' : '.constant($header[6]).'<BR>';
					$result .= '<H4>'.ORDER_STATUS.' : '.constant($header[2]).'</H4>';
				}
			}
			
			return $result;
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = GET_ORDER_HEADER_ERROR;
		}
	}
	
	public static function GetItemTypeName($item_type_id) {
	
		try {
			$data = new Data();
			return $data->ItemTypeGetName($item_type_id);
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = GET_ITEM_TYPE_NAME_ERROR;
		}
	}
	
	public static function GetItemTypeInformation($item_type_id) {
	
		try {
			$data = new Data();
			return $data->ItemTypeGetInformation($item_type_id);
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = GET_ITEM_TYPE_INFORMATION_ERROR;
		}
	}
	
	public static function GetItemType2Name($item_type_2_id) {
	
		try {
			$data = new Data();
			return $data->ItemType2GetName($item_type_2_id);
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = GET_ITEM_TYPE_2_NAME_ERROR;
		}
	}
	
	public static function GetItemType2Information($item_type_2_id) {
	
		try {
			$data = new Data();
			return $data->ItemType2GetInformation($item_type_2_id);
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = GET_ITEM_TYPE_2_INFORMATION_ERROR;
		}
	}
	
	public static function GetOrderOwner($order_id) {
	
		try {
			$data = new Data();
			return $data->OrderGetOwner($order_id);
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = GET_ORDER_OWNER_ERROR;
		}
	}
	
	public static function AdminGetOrderLockStatus($order_id) {
	
		try {
			$data = new Data();
			return $data->AdminOrderGetLockStatus($order_id);
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = ADMIN_GET_ORDER_LOCK_STATUS_ERROR;
		}
	}
	
	public static function AdminGetOrderHeader($order_id, $email = false) {
	
		try {
			$data = new Data();
			$result = '';
	
			$header = $data->AdminOrderGetHeader($order_id);
				
			if (isset($header)) {
				
				if ($email) {
					$result .= MAIL_ORDER_ORDER_NUMBER.' : '.$order_id.'<BR>';
					$result .= ORDER_CREATION_DATE.' : '.$header[3].'<BR>';
					$result .= ORDER_LAST_UPDATE.' : '.$header[4].' '.ORDER_LAST_UPDATE_BY.' '.$header[6].'<BR>';
					$result .= ORDER_DELIVERY_TYPE.' : '.constant($header[9]).'<BR>';
					$result .= '<H4>'.ORDER_STATUS.' : '.constant($header[2]).'</H4>';
					$result .= '<A HREF="'.$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/order.php?id='.$order_id.'" TARGET="_blank">'.MAIL_ORDER_SEE_ONLINE.'</A>';
				} else {
					$result .= ORDER_CUSTOMER.' : '.$header[5].'<BR>';
					$result .= ORDER_CREATION_DATE.' : '.$header[3].'<BR>';
					$result .= ORDER_LAST_UPDATE.' : '.$header[4].' '.ORDER_LAST_UPDATE_BY.' '.$header[6].'<BR>';
					$result .= ORDER_DELIVERY_TYPE.' : '.constant($header[9]).'<BR><BR>';
						
					$order_status_selected = $header[1];
					
					if ($header[10] == '1') {
						$result .= '<B>'.ORDER_STATUS.' : '.constant($header[2]).'</B><BR><BR>';
					} else {
						$result .= '<B>'.ORDER_STATUS.'</B> * : <select id="order_status_select" name="order_status_select" onChange="javascript:updateSelect(\'order_status_select\')">';
						$result .= $data->OrderStatusDisplayPossibleList($order_status_selected);
						$result .= '</select>
								<input type="hidden" id="order_status" name="order_status" value="'.$order_status_selected.'">
								<BR><BR>';
					}
				}
			}
			
			return $result;
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = GET_ORDER_HEADER_ERROR;
		}
	}
	
	public static function AdminGetOrderCommentList($order_id) {
	
		try {
			$data = new Data();
			$result = '';
	
			$comment = $data->AdminGetOrderCommentList($order_id);
	
			if (isset($comment)) {
				for ($i=0; $i < count($comment); $i++) {
					
					$date = DateTime::createFromFormat(PHP_DATETIME_FORMAT, $comment[$i][2]);
					$date_on = date('d/m/Y', $date->getTimestamp());
					$time_on = date('H:i:s', $date->getTimestamp());
					
					$result .= '<TR>
									<TD><SPAN class="order_comment_list_date">'.ON.$date_on.AT.$time_on.BY.' '.$comment[$i][3].'</SPAN><BR>
									'.$comment[$i][1].'
									</TD>
								</TR>';
				}
			}
	
			return $result;
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = GET_ORDER_COMMENT_ERROR;
		}
	}
	
	public static function GetOrderCommentList($order_id) {
	
		try {
			$data = new Data();
			$result = '';
	
			$comment = $data->GetOrderCommentList($order_id);
	
			if (isset($comment)) {
				for ($i=0; $i < count($comment); $i++) {
						
					$date = DateTime::createFromFormat(PHP_DATETIME_FORMAT, $comment[$i][2]);
					$date_on = date('d/m/Y', $date->getTimestamp());
					$time_on = date('H:i:s', $date->getTimestamp());
						
					$result .= '<TR>
									<TD><SPAN class="order_comment_list_date">'.ON.$date_on.AT.$time_on.BY.' '.$comment[$i][3].'</SPAN><BR>
									'.$comment[$i][1].'
									</TD>
								</TR>';
				}
			}
	
			return $result;
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = GET_ORDER_COMMENT_ERROR;
		}
	}
	
	public static function GetOrderLineList($order_id, $email = false) {
	
		try {
			$data = new Data();
	
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
	
			$header_list = Array(Array(ITEM_IMAGE, 0, 'center', 'item_image', true, 0, 'item.php', '_self'),
								 Array(ITEM_NAME, 3, 'left', 'text', true, 0, 'item.php', '_self'),
								 Array(ITEM_TYPE, 1, 'left', 'constant', true, null, null, null),
								 Array(ITEM_TYPE_2, 2, 'left', 'constant', true, null, null, null),
								 Array(QUANTITY, 4, 'center', 'integer', true, null, null, null),
								 Array(PRICE, 5, 'left', 'price', true, null, null, null)); // SPECIFIC
	
			$item_list = $data->OrderGetLineList($order_id, $order, $sort);
	
			return Util::AdminGetList($header_list, $item_list, $show_header, $max_row_per_page, $style, $order, $sort, null, true, $email);
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = GET_ORDER_LINE_LIST_ERROR;
		}
	}
	
	public static function AdminGetOrderLineList($order_id, $email = false) {
	
		try {
			$data = new Data();
	
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
	
			$header_list = Array(Array(ITEM_IMAGE, 0, 'center', 'item_image', true, 0, 'item.php', '_self'),
					Array(ITEM_NAME, 3, 'left', 'text', true, 0, 'item.php', '_self'),
					Array(ITEM_TYPE, 1, 'left', 'constant', true, null, null, null),
					Array(ITEM_TYPE_2, 2, 'left', 'constant', true, null, null, null),
					Array(QUANTITY, 4, 'center', 'integer', true, null, null, null),
					Array(PRICE, 5, 'left', 'price', true, null, null, null),
					Array('', 0, 'center', 'delete', true, 6, '_admin_order_delete.php?order_id='.$order_id, '_self')); // SPECIFIC
	
			$item_list = $data->AdminOrderGetLineList($order_id, $order, $sort);
	
			return Util::AdminGetList($header_list, $item_list, $show_header, $max_row_per_page, $style, $order, $sort, null, true, $email);
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = GET_ORDER_LINE_LIST_ERROR;
		}
	}
	
	public static function GetOrderList() {
	
		try {
			$data = new Data();
	
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
	
			$header_list = Array(Array(ORDER_NUMBER, 0, 'center', 'integer', true, 0, 'order.php', '_self'),
								 Array(ORDER_CREATION_DATE, 1, 'left', 'date', true, null, null, null),
								 Array(ORDER_LAST_UPDATE, 2, 'left', 'date', true, null, null, null),
								 Array(ORDER_STATUS, 3, 'left', 'constant', true, null, null, null),
								 Array(ORDER_ITEM_COUNT, 4, 'center', 'integer', true, null, null, null),
								 Array(TABLE_FULL_AMOUNT, 5, 'right', 'price', true, null, null, null)); // SPECIFIC
	
			$item_list = $data->OrderGetList($order, $sort);
	
			return Util::AdminGetList($header_list, $item_list, $show_header, $max_row_per_page, $style, $order, $sort, null);
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = GET_ORDER_LIST_ERROR;
		}
	}
	
	public static function AdminGetOrderList($status = '', $user = '') {
	
		try {
			$data = new Data();
	
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
	
			$header_list = Array(Array(ORDER_NUMBER, 0, 'center', 'integer', true, 0, 'admin_order_update.php', '_self'),
								 Array(ORDER_USER, 1, 'left', 'text', true, null, null, null),
								 Array(ORDER_CREATION_DATE, 2, 'left', 'date', true, null, null, null),
								 Array(ORDER_LAST_UPDATE, 3, 'left', 'date', true, null, null, null),
								 Array(ORDER_STATUS, 4, 'left', 'constant', true, null, null, null),
								 Array(ORDER_ITEM_COUNT, 5, 'center', 'integer', true, null, null, null),
								 Array(TABLE_FULL_AMOUNT, 6, 'right', 'price', true, null, null, null)); // SPECIFIC
	
			$item_list = $data->AdminOrderGetList($order, $sort, $status, $user);
	
			return Util::AdminGetList($header_list, $item_list, $show_header, $max_row_per_page, $style, $order, $sort, null);
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = GET_ORDER_LIST_ERROR;
		}
	}

////// END OF STORE PART

	public static function GetCommentList($id, $type) {
	
		try {
			$data = new Data();
			$result = '';
	
			$comment = $data->GetCommentList($id, $type);
	
			if (isset($comment)) {
				for ($i=0; $i < count($comment); $i++) {
	
					$date = DateTime::createFromFormat(PHP_DATETIME_FORMAT, $comment[$i][2]);
					$date_on = date('d/m/Y', $date->getTimestamp());
					$time_on = date('H:i:s', $date->getTimestamp());
	
					$result .= '<TR>
									<TD><SPAN class="comment_list_date">'.ON.$date_on.AT.$time_on.BY.' '.$comment[$i][3].'</SPAN><BR>
									'.$comment[$i][1].'
									</TD>
								</TR>';
				}
			}
	
			return $result;
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = GET_ORDER_COMMENT_ERROR;
		}
	}
	
	public static function GetCustomListName($list) {
	
		$result= '';
	
		try {
			$result = constant(strtoupper($list).'_LIST');
		} catch (Exception $ex) {
			$_SESSION[SITE_ID]['error'] = GET_CUSTOM_LIST_NAME_ERROR;
		}
	
		return $result;
	}

	public function __call($method = '', $args = '') {
		
		switch ($method) {
			default:
				break;
		}
	}
}

include_once($root.'./library/util_specific.php');
?>