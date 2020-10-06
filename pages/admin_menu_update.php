<?php  
/* V1.3
 * 
 * V1.1 : 20130624 : Major update
 * V1.2 : 20131004 : Style added
 * V1.3 : 20131015 : Item type 2 added
 * 
 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	if (!isset($_SESSION[SITE_ID]['connection_id'])) {
		Util::Init();
	}
	
	if(!Util::IsAllowed('admin_menu')) {
		header('Location: '.BASE_LINK.'/pages/not_allowed.php');
		exit();
	}
	
	$id = Util::GetPostValue('id');
	
	if($id == '') {
		header('Location: index.php');
		exit();
	}
	
	try {
		$data = new Data();
		
		$current = $data->AdminMenuGet($id);
		$_REQUEST['menu_name'] = $current[1];
		$_REQUEST['menu_access'] = $current[2];
		$_REQUEST['menu_link'] = $current[3];
		$_REQUEST['menu_target'] = $current[4];
		$_REQUEST['menu_level_0'] = $current[5];
		$_REQUEST['menu_level_1'] = $current[6];
		$_REQUEST['menu_style'] = $current[7];
		$_REQUEST['menu_item_type'] = $current[8];
		$_REQUEST['menu_item_type_2'] = $current[9];
		$_REQUEST['menu_image'] = $current[10];
	} catch (DataException $ex) {
		$_REQUEST['message'] = $ex->getMessage();
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
?>

    //if submit button is clicked
    $('#submit').click(function () {

    	var checkProblem = false;
    	var missingFields = false;
    	
        //Get the data from all the fields
        var id = $('input[id=id]');
        var menu_name = $('input[id=menu_name]');
        var menu_access = $('input[id=menu_access]');
        var menu_link = $('input[id=menu_link]');
        var menu_target = $('input[id=menu_target]');
        var menu_level_0 = $('input[id=menu_level_0]');
        var menu_level_1 = $('input[id=menu_level_1]');
        var menu_style = $('input[id=menu_style]');
        var menu_item_type = $('input[id=menu_item_type]');
        var menu_item_type_2 = $('input[id=menu_item_type_2]');
        var menu_image = $('input[id=menu_image]');
        
        //Simple validation to make sure user entered something
        //If error found, add hightlight class to the text field
        if (menu_name.val()=='') {
        	menu_name.addClass('missingvalue');
        	checkProblem = true;
        	missingFields = true;
        } else menu_name.removeClass('missingvalue');

        if (menu_link.val()=='') {
        	menu_link.addClass('missingvalue');
        	checkProblem = true;
        	missingFields = true;
        } else menu_link.removeClass('missingvalue');

        if (menu_target.val()=='') {
        	menu_target.addClass('missingvalue');
        	checkProblem = true;
        	missingFields = true;
        } else menu_target.removeClass('missingvalue');

        if (menu_level_0.val()=='') {
        	menu_level_0.addClass('missingvalue');
        	checkProblem = true;
        	missingFields = true;
        } else menu_level_0.removeClass('missingvalue');

        if (menu_level_1.val()=='') {
        	menu_level_1.addClass('missingvalue');
        	checkProblem = true;
        	missingFields = true;
        } else menu_level_1.removeClass('missingvalue');

        if (menu_style.val()=='') {
        	menu_style.addClass('missingvalue');
        	checkProblem = true;
        	missingFields = true;
        } else menu_style.removeClass('missingvalue');

        if (missingFields) {
        	$('span[id=message]').html('<?php echo MISSING_FIELDS_ERROR; ?>');
            $('div[id=notification]').show();
        }
        
        if (checkProblem) {
            return false;
        }
        
        //organize the data properly
        var data = 'id=' + id.val() + '&menu_name=' + menu_name.val() + '&menu_access=' + menu_access.val() +
        		   '&menu_link=' + menu_link.val() + '&menu_target=' + menu_target.val() +
        		   '&menu_level_0=' + menu_level_0.val() + '&menu_level_1=' + menu_level_1.val() + 
        		   '&menu_style=' + menu_style.val() + '&menu_item_type=' + menu_item_type.val() + 
        		   '&menu_item_type_2=' + menu_item_type_2.val() + '&menu_image=' + menu_image.val();
       
        //show the loading sign
        //TO_DO
        //start the ajax
        $.ajax({
            //this is the php file that processes the data and send mail
            url: "_admin_menu_update.php",
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
            }
        });
        //cancel the submit button default behaviours
        return false;
    });

  	//if delete button is clicked
    $('#delete').click(function () {
        
        //Get the data from all the fields
        var id = $('input[id=id]');
        var menu_name = $('input[id=menu_name]');
        var menu_link = $('input[id=menu_link]');
        var menu_target = $('input[id=menu_target]');
        var menu_level_0 = $('input[id=menu_level_0]');
        var menu_level_1 = $('input[id=menu_level_1]');
        var menu_style = $('input[id=menu_style]');
        var menu_image = $('input[id=menu_image]');
        
        var menu_access_select = $('select[id=menu_access_select]');
        var menu_item_type_select = $('select[id=menu_item_type_select]');
        var menu_item_type_2_select = $('select[id=menu_item_type_2_select]');
        
		var answer = confirm("<?php echo ADMIN_MENU_DELETE_QUESTION; ?>");
        
        if (!answer) {
            return false;
        }
        
        //organize the data properly
        var data = 'id=' + id.val();
       
        //show the loading sign
        //TO_DO
        //start the ajax
        $.ajax({
            //this is the php file that processes the data and send mail
            url: "_admin_menu_delete.php",
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

                menu_name.attr('disabled', 'disabled');
                menu_access_select.attr('disabled', 'disabled');
                menu_link.attr('disabled', 'disabled');
                menu_target.attr('disabled', 'disabled');
                menu_level_0.attr('disabled', 'disabled');
                menu_level_1.attr('disabled', 'disabled');
                menu_style.attr('disabled', 'disabled');
                menu_item_type_select.attr('disabled', 'disabled');
                menu_item_type_2_select.attr('disabled', 'disabled');
                menu_image.attr('disabled', 'disabled');
                
                $('#submit').attr('disabled', 'disabled');
                $('#delete').attr('disabled', 'disabled');
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
	<ul class="crumb admin_menu_crumb" itemprop="breadcrumb">
		<li typeof="v:Breadcrumb">
			<a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/index.php" title="'.MENU_HOME.'" rel="v:url" property="v:title" >'.MENU_HOME.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin.php" rel="v:url" property="v:title" >'.ADMIN_TITLE.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin_menu.php" rel="v:url" property="v:title" >'.ADMIN_MENU_LIST_TITLE.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><span class="title"><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin_menu_update.php?id='.$id.'" rel="v:url" property="v:title" >'.ADMIN_MENU_UPDATE_TITLE.'</A></span> | <a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin_menu_add.php" >'.ADMIN_MENU_ADD_TITLE.'</A>
		</li>
	</ul>
</div>
<div id="main">
<form method="POST" action="_admin_menu_update.php">
	  	<TABLE>
			<TR>
				<TD>
					<TABLE>
						<TR>
							<TD>'.ADMIN_MENU_NAME.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="menu_name" NAME="menu_name" VALUE="'.$_REQUEST['menu_name'].'" STYLE="width:200px" MAXLENGTH="100">
							</TD>
						</TR>
					</TABLE>
				<TD>
			</TR>
			
			<TR>
				<TD>
					<TABLE>
						<TR>
							<TD>'.ADMIN_MENU_ACCESS.' :</TD>
							<TD class="field_separator"></TD>
							<TD>';
					
			$access_selected = $_REQUEST['menu_access'];
			
			echo '<select id="menu_access_select" name="menu_access_select" onChange="javascript:updateSelect(\'menu_access_select\')">';
			echo $data->AdminAccessDisplayList($access_selected);
			echo '</select>';
			
							echo '</TD>
						</TR>
					</TABLE>
				</TD>
			<TR>
				<TD class="max_separator"></TD>
			</TR>				
			<TR>
				<TD>
					<TABLE>
						<TR>
							<TD>'.ADMIN_MENU_LINK.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="menu_link" NAME="menu_link" VALUE="'.$_REQUEST['menu_link'].'" STYLE="width:300px" MAXLENGTH="200">
							</TD>
						</TR>
					</TABLE>
				<TD>
			</TR>
			
			<TR>
				<TD>
					<TABLE>
						<TR>
							<TD>'.ADMIN_MENU_TARGET.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="menu_target" NAME="menu_target" VALUE="'.$_REQUEST['menu_target'].'" STYLE="width:100px" MAXLENGTH="20">
							</TD>
						</TR>
					</TABLE>
				<TD>
			</TR>
			<TR>
				<TD>
					<TABLE>
						<TR>
							<TD>'.ADMIN_MENU_LEVEL_0.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="menu_level_0" NAME="menu_level_0" VALUE="'.$_REQUEST['menu_level_0'].'" STYLE="width:50px" MAXLENGTH="3">
							</TD>
						</TR>
					</TABLE>
				<TD>
			</TR>
			<TR>
				<TD>
					<TABLE>
						<TR>
							<TD>'.ADMIN_MENU_LEVEL_1.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="menu_level_1" NAME="menu_level_1" VALUE="'.$_REQUEST['menu_level_1'].'" STYLE="width:50px" MAXLENGTH="3">
							</TD>
						</TR>
					</TABLE>
				<TD>
			</TR>
			<TR>
				<TD>
					<TABLE>
						<TR>
							<TD>'.ADMIN_MENU_STYLE.' * :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="menu_style" NAME="menu_style" VALUE="'.$_REQUEST['menu_style'].'" STYLE="width:150px" MAXLENGTH="50">
							</TD>
						</TR>
					</TABLE>
				<TD>
			</TR>
			<TR>
				<TD>
					<TABLE>
						<TR>
							<TD>'.ADMIN_MENU_ITEM_TYPE.' :</TD>
							<TD class="field_separator"></TD>
							<TD>';
			$menu_item_type_selected = $_REQUEST['menu_item_type'];
		
			echo '<select id="menu_item_type_select" name="item_type_select" onChange="javascript:updateSelect(\'menu_item_type_select\')">';
			echo $data->ItemTypeDisplayList($menu_item_type_selected);
			echo '</select>';
					
						echo '</TD>
						</TR>
					</TABLE>
				<TD>
			</TR>
			<TR>
				<TD>
					<TABLE>
						<TR>
							<TD>'.ADMIN_MENU_ITEM_TYPE_2.' :</TD>
							<TD class="field_separator"></TD>
							<TD>';
			$menu_item_type_2_selected = $_REQUEST['menu_item_type_2'];
		
			echo '<select id="menu_item_type_2_select" name="menu_item_type_2_select" onChange="javascript:updateSelect(\'menu_item_type_2_select\')">';
			echo $data->ItemType2DisplayList($menu_item_type_2_selected);
			echo '</select>';
					
						echo '</TD>
						</TR>
					</TABLE>
				<TD>
			</TR>
            <TR>
				<TD>
					<TABLE>
						<TR>
							<TD>'.ADMIN_MENU_IMAGE.' :</TD>
							<TD class="field_separator"></TD>
							<TD>
								<INPUT TYPE="text" ID="menu_image" NAME="menu_image" VALUE="'.$_REQUEST['menu_image'].'" STYLE="width:150px" MAXLENGTH="50">
							</TD>
						</TR>
					</TABLE>
				<TD>
			</TR>
			<TR>
				<TD class="max_separator">
					<input type="hidden" id="id" name="id" value="'.$id.'">
					<input type="hidden" id="menu_access" name="menu_access" value="'.$_REQUEST['menu_access'].'">
					<input type="hidden" id="menu_item_type" name="menu_item_type" value="'.$_REQUEST['menu_item_type'].'">
					<input type="hidden" id="menu_item_type_2" name="menu_item_type_2" value="'.$_REQUEST['menu_item_type_2'].'">
				</TD>
			</TR>
			<TR>
				<TD>
					<TABLE class="normal">
						<TR>
							<TD>'.MANDATORY_FIELDS.'</TD>
						</TR>
						<TR>
							<TD>
								<INPUT TYPE="submit" ID="submit" NAME="submit" VALUE="'.ADMIN_MENU_UPDATE_UPDATE.'" ALT="'.ADMIN_MENU_UPDATE_UPDATE.'">
								<INPUT TYPE="submit" ID="delete" NAME="delete" VALUE="'.ADMIN_MENU_DELETE_DELETE.'" ALT="'.ADMIN_MENU_DELETE_DELETE.'">
								<INPUT TYPE="button" ID="back" NAME="back" VALUE="'.BACK.'" ALT="'.BACK.'" OnClick="javascript:history.back();">
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
		</TABLE>
	</form>
</div></div>'.Util::PageGetBottom().'
</BODY>
</HTML>';
?>