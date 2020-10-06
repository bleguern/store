<?php  
/* V1.0
 * 
 * V1.0 : 20140130 : Major update
 * 
 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	if(!$_SESSION[SITE_ID]['admin_configuration_store_enabled']) {
		header('Location: index.php');
		exit();
	}
	
	if (!isset($_SESSION[SITE_ID]['connection_id'])) {
		Util::Init();
	}
	
	$result = Util::GetBasket();
	$order_delivery_type_selected = $_SESSION[SITE_ID]['admin_configuration_store_order_delivery_type_default'];
	$postal_charges = Util::GetPostalChargesV2($order_delivery_type_selected);
	
	$data = new Data();
?>
<?php echo Util::PageGetHtmlTop(); ?>
<HEAD>
<TITLE><?php echo BASKET_TITLE.' | '.SITE_TITLE; ?></TITLE>
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
	//if submit button is clicked
	$('.emptybasket').click(function () {
	
		var answer = confirm("<?php echo BASKET_DELETE_QUESTION; ?>");
        
        if (!answer) {
            return false;
        }
	
        //start the ajax
	    $.ajax({
	        //this is the php file that processes the data and send mail
	        url: "_basket_empty.php",
	        //GET method is used
	        type: "GET",
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

	$('.gotoorder').click(function () {
		var checkProblem = false;
		var missingFields = false;
        //Get the data from all the fields
        var order_delivery_type_select = $('select[id=order_delivery_type_select]');
        var order_delivery_type = $('input[id=order_delivery_type]');

        if (order_delivery_type.val()=='') {
        	order_delivery_type_select.addClass('missingvalue');
        	missingFields = true;
        	checkProblem = true;
        } else order_delivery_type_select.removeClass('missingvalue');

        if (missingFields) {
        	$('span[id=message]').html('<?php echo MISSING_FIELDS_ERROR; ?>');
            $('div[id=notification]').show();
        }

        if (checkProblem) {
            return false;
        }

		var answer = confirm("<?php echo BASKET_GO_TO_ORDER_QUESTION; ?>");
        
        if (!answer) {
            return false;
        }

        location.href = '_basket_go_to_order.php?order_delivery_type=' + order_delivery_type.val();
	    
	    //cancel the submit button default behaviours
	    return false;
	});


	$('#order_delivery_type_select').change(function () {
		var order_delivery_type_select = $('select[id=order_delivery_type_select]');
        var order_delivery_type = $('input[id=order_delivery_type]');
        
        var table_total_amount = $('input[id=table_total_amount]');
        var order_delivery_price = $('input[id=order_delivery_price]');
        var order_total_price = $('input[id=order_total_price]');
        
		var selectedValue = '';
		var selectedText = '';
			
        selectedValue = order_delivery_type_select.val();
        selectedText = selectedValue.split(',')[1];
        selectedValue = selectedValue.split(',')[0];

        order_delivery_type.val(selectedValue);

		if (selectedText == 'ORDER_DELIVERY_TYPE_HAND_OVER') {
			order_delivery_price.val('0.00');
			order_total_price.val(table_total_amount.val());
		} else if (selectedText == 'ORDER_DELIVERY_TYPE_POST') {
			order_delivery_price.val('<?php echo number_format($postal_charges, 2, '.', ''); ?>');
			order_total_price.val((parseFloat(table_total_amount.val()) + parseFloat(order_delivery_price.val())).toFixed(2));
		} else {
			order_delivery_price.val('?');
			order_total_price.val('?');
		}
		
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
	<ul class="crumb basket_crumb" itemprop="breadcrumb">
		<li typeof="v:Breadcrumb">
			<a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/index.php" title="'.MENU_HOME.'" rel="v:url" property="v:title" >'.MENU_HOME.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/basket.php" rel="v:url" property="v:title" >'.BASKET_TITLE.'</A>
		</li>
	</ul>
</div>
<div id="main">
<TABLE>';

	if($result == NO_RESULT) {
		echo '<TR>
					<TD>'.BASKET_IS_EMPTY.'</TD>
				</TR>';
	} else {
		echo '<TR>
					<TD class="main_sub_section_text"><INPUT TYPE="button" class="emptybasket" ID="emptybasket" NAME="emptybasket" VALUE="'.EMPTY_BASKET.'" ALT="'.EMPTY_BASKET.'"> <INPUT TYPE="button" class="gotoorder" ID="gotoorder" NAME="gotoorder" VALUE="'.GO_TO_ORDER.'" ALT="'.GO_TO_ORDER.'"></TD>
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
								<TD ALIGN="RIGHT">'.ORDER_DELIVERY_TYPE.' * :</TD>
								<TD class="field_separator"></TD>
								<TD>';

	echo '<select id="order_delivery_type_select" name="order_delivery_type_select">';
	echo $data->OrderDeliveryTypeDisplayList($order_delivery_type_selected);
	echo '</select>';

						echo '</TD>
								<TD class="field_separator"></TD>
								<TD ALIGN="RIGHT">'.POSTAL_CHARGES_AMOUNT.' :</TD>
								<TD class="field_separator"></TD>
								<TD><INPUT TYPE="text" ID="order_delivery_price" NAME="order_delivery_price" CLASS="sub_total" READONLY VALUE="'.number_format($postal_charges, 2, '.', '').'"> &euro;</TD>
							</TR>
						</TABLE>
					</TD>
				</TR>
				<TR>
	            	<TD ALIGN="RIGHT">
						<TABLE>
							<TR>
								<TD ALIGN="RIGHT"><B>'.TABLE_FULL_AMOUNT.' :</B></TD>
								<TD class="field_separator"></TD>
								<TD><INPUT TYPE="text" ID="order_total_price" NAME="order_total_price" CLASS="total" READONLY VALUE="'.number_format($result[1] + $postal_charges, 2, '.', '').'"> <B>&euro;</B></TD>
							</TR>
						</TABLE>
					</TD>
        		</TR>
				<TR>
					<TD class="max_separator">
				</TR>
				<TR>
					<TD>'.MANDATORY_FIELDS.'</TD>
				</TR>
				<TR>
					<TD class="max_separator">
				</TR>
				<TR>
					<TD class="main_sub_section_text"><INPUT TYPE="button" class="emptybasket" ID="emptybasket" NAME="emptybasket" VALUE="'.EMPTY_BASKET.'" ALT="'.EMPTY_BASKET.'"> <INPUT TYPE="button" class="gotoorder" ID="gotoorder" NAME="gotoorder" VALUE="'.GO_TO_ORDER.'" ALT="'.GO_TO_ORDER.'"></TD>
					<DIV id="item_bottom_back"><INPUT TYPE="button" ID="back" NAME="back" VALUE="'.BACK.'" ALT="'.BACK.'" OnClick="javascript:history.back();"></DIV>
				</TR>
				<TR>
					<TD class="max_separator">
						<input type="hidden" id="id" name="id" value="'.$_SESSION[SITE_ID]['connection_id'].'">
						<input type="hidden" id="order_delivery_type" name="order_delivery_type" value="'.$order_delivery_type_selected.'">
					</TD>
				</TR>';
	}
	
	echo '
</TABLE>
</div>
<div id="subtitle">
 	<span class="subtitle">'.BASKET_INFORMATIONS_TITLE.'</span>
</div>
<DIV id="basket_information">
	<div id="basket_information">';
	
if($result == NO_RESULT) {
	echo BASKET_INFORMATIONS_EMPTY_MESSAGE;
} else {
	echo BASKET_INFORMATIONS_NOT_EMPTY_MESSAGE;
}

 	echo '</DIV>
</DIV>
</div>
'.Util::PageGetBottom().'
</BODY>
</HTML>';