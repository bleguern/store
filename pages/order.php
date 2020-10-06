<?php  
/* V1.0
 * 
 * V1.0 : 20140130 : Major update
 * 
 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	$id = Util::GetPostValue('id');
	
	if((!$_SESSION[SITE_ID]['admin_configuration_store_enabled']) || ($id == '')) {
		header('Location: index.php');
		exit();
	}
	
	if(Util::IsAllowed('admin_order')) {
		header('Location: admin_order_update.php?id='.$id);
		exit();
	}
	
	if (!isset($_SESSION[SITE_ID]['authenticated'])) {
		header('Location: login.php?message='.PLEASE_CONNECT_BEFORE_CREATE_ORDER.'&gotourl=order.php?id='.$id);
		exit();
	}
	
	$owner = Util::GetOrderOwner($id);
	
	if($owner != $_SESSION[SITE_ID]['user_id']) {
		header('Location: index.php');
		exit();
	}
	
	$header = Util::GetOrderHeader($id);
	$result = Util::GetOrderLineList($id);
	$comment = Util::GetOrderCommentList($id);
	$postal_charges = Util::GetPostalChargesWithOrderId($id);
	$discount = Util::GetDiscountWithOrderId($id);
?>
<?php echo Util::PageGetHtmlTop(); ?>
<HEAD>
<TITLE><?php echo ORDER_TITLE.' n°'.$id.' | '.SITE_TITLE; ?></TITLE>
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

	$('#add_comment').click(function () {
	    
	    //Get the data from all the fields
	    var checkProblem = false;
	    var id = $('input[id=id]');
	    var order_comment = $('textarea[id=order_comment]');
	
	    if (order_comment.val()=='') {
	    	order_comment.addClass('missingvalue');
	    	checkProblem = true;
	    } else order_comment.removeClass('missingvalue');
		        
	    if (checkProblem) {
	        return false;
	    }
	    
	    //organize the data properly
	    var data = 'id=' + id.val() + '&order_comment=' + encodeURIComponent(order_comment.val().replace(/\n/g, "<br>"));
	   
	    //show the loading sign
	    //TO_DO
	    //start the ajax
	    $.ajax({
	        //this is the php file that processes the data and send mail
	        url: "_order_add_comment.php",
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
	<ul class="crumb order_crumb" itemprop="breadcrumb">
		<li typeof="v:Breadcrumb">
			<a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/index.php" title="'.MENU_HOME.'" rel="v:url" property="v:title" >'.MENU_HOME.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/order_list.php" rel="v:url" property="v:title" >'.ORDER_LIST_TITLE.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/order.php?id='.$id.'" rel="v:url" property="v:title" >'.ORDER_TITLE.' n°'.$id.'</A>
		</li>
	</ul>
</div>
<div id="main">
<TABLE>
	<TR>
		<DIV id="item_top_back"><INPUT TYPE="button" ID="back" NAME="back" VALUE="'.BACK.'" ALT="'.BACK.'" OnClick="javascript:history.back();"></DIV>
	</TR>
	<TR>
		<TD>'.$header.'</TD>
	</TR>
	<TR>
		<TD>
		<div id="subtitle">
			<span class="subtitle">'.ORDER_ITEM_LIST.'</span></TD>
		</div>
		</TD>
	</TR>
	<TR>
		<TD>'.$result[0].'</TD>
	</TR>
	<TR>
		<TD class="max_separator">
	</TR>
	<TR>
		<TD ALIGN="RIGHT">
			<TABLE>
				<TR>
					<TD ALIGN="RIGHT">'.POSTAL_CHARGES_AMOUNT.' :</TD>
					<TD class="field_separator"></TD>
					<TD><INPUT TYPE="text" ID="order_delivery_price" NAME="order_delivery_price" CLASS="sub_total" READONLY VALUE="'.number_format($postal_charges, 2, '.', '').'"> &euro;</TD>
				</TR>
			</TABLE>
		</TD>
	</TR>';

if ($discount > 0) {

	echo '<TR>
		<TD ALIGN="RIGHT">
			<TABLE>
				<TR>
					<TD ALIGN="RIGHT">'.ORDER_DISCOUNT.' :</TD>
					<TD class="field_separator"></TD>
					<TD><INPUT TYPE="text" ID="order_discount" NAME="order_discount" CLASS="sub_total" READONLY VALUE="'.number_format($discount, 2, '.', '').'"> &euro;</TD>
				</TR>
			</TABLE>
		</TD>
	</TR>';
}
	
	echo '<TR>
		<TD ALIGN="RIGHT">
			<TABLE>
				<TR>
					<TD ALIGN="RIGHT"><B>'.TABLE_FULL_AMOUNT.' :</B></TD>
					<TD class="field_separator"></TD>
					<TD><INPUT TYPE="text" ID="order_total_price" NAME="order_total_price" CLASS="total" READONLY VALUE="'.number_format($result[1] + $postal_charges - $discount, 2, '.', '').'"> <B>&euro;</B></TD>
				</TR>
			</TABLE>
		</TD>
	</TR>
	<TR>
		<TD><div id="subtitle">
			<span class="subtitle">'.ORDER_COMMENT.'</span></TD>
		</div></TD>
	</TR>
	<TR>
		<TD>
			<TABLE>
	    		'.$comment.'
	    	</TABLE>
		</TD>
	</TR>
	<TR>
		<TD><textarea cols="60" rows="6" ID="order_comment" NAME="order_comment"></textarea></TD>
	</TR>
	<TR>
	    <TD>
		    <INPUT TYPE="submit" ID="add_comment" NAME="add_comment" VALUE="'.ORDER_ADD_COMMENT.'" ALT="'.ORDER_ADD_COMMENT.'">
		</TD>
	</TR>
	<TR>
		<DIV id="item_bottom_back"><INPUT TYPE="button" ID="back" NAME="back" VALUE="'.BACK.'" ALT="'.BACK.'" OnClick="javascript:history.back();"></DIV>
	</TR>
	<TR>
		<TD class="max_separator">
		<input type="hidden" id="id" name="id" value="'.$id.'">
	</TR>
</TABLE>
</div></div>
'.Util::PageGetBottom().'
</BODY>
</HTML>';