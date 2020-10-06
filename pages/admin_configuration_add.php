<?php  
/* V1.0 : 20130927 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	if (!isset($_SESSION[SITE_ID]['connection_id'])) {
		Util::Init();
	}
	
	// Param
	$style = '';
	$table_name = 'admin_configuration';
	$hidden_field = '';
	$hidden_field_value = '';
	$script = '';
	$document_ready_script_field_list = '';
	$document_ready_script_data_list = '';
	$document_ready_script_disabled_list = '';
	$form_script = '';
	// End param
	
	// Param init
	$data = new Data();
	
	$style = $_SESSION[SITE_ID]['admin_configuration_theme'];
	$parameters = '';
		
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
		
	if(!Util::IsAllowed($table_name)) {
		header('Location: '.BASE_LINK.'/pages/not_allowed.php');
		exit();
	}
	
	$document_ready_script_field_list .= '
	var hidden_field = $(\'input[id=hidden_field]\');';
	
	$document_ready_script_data_list .= ' \'&hidden_field=\' + hidden_field.val()';
	
	$fields = $data->AdminGetTableFields($table_name);
	
	foreach ($fields as $field) {
		
		if (($field['Key'] != 'PRI') &&
			(strtolower($field['Field']) != $table_name.'_creation_date') &&
			(strtolower($field['Field']) != $table_name.'_last_update_date') &&
			(strtolower($field['Field']) != $table_name.'_last_update_admin_user_id')) {
			
			$mandatory = '';
			$mandatory_field_list = '';
			$type = Array();
			
			if ($field['Null'] == 'NO') {
				$mandatory = ' *';
			}
			
			if (strpos(strtolower($field['Field']), '_id') !== FALSE) {
				
				$link_table_name = substr($field['Field'], strlen($table_name.'_'));
				$link_table_name = substr($link_table_name, strpos($link_table_name, $table_name));
				$link_table_name = substr($link_table_name, 0, strpos($link_table_name, '_id'));
				
				$field_name = substr($field['Field'], strlen($table_name.'_'));
				$field_name = substr($field_name, 0, strpos($field_name, '_id'));
				
				$selected = $field['Default'];
				
				$form_script .= '<TR>
									<TD>
										<TABLE>
											<TR>
												<TD>'.constant(strtoupper($field_name)).$mandatory.' :</TD>
												<TD class="field_separator"></TD>
												<TD>';
					
				$form_script .= '<select id="'.$field_name.'_select" name="'.$field_name.'_select" onChange="javascript:updateSelect(\''.$field_name.'_select\')">';
				$form_script .= $data->SpecificTableDisplayList($link_table_name, $selected);
				$form_script .= '</select>';
			
				$form_script .= '				</TD>
											</TR>
										</TABLE>
									<TD>
								</TR>
								<TR>
									<TD class="separator"><input type="hidden" id="'.$field_name.'" name="'.$field_name.'" value="'.$selected.'"></TD>
								</TR>';
				
				$document_ready_script_field_list .= '
	var '.$field_name.' = $(\'input[id='.$field_name.']\');
	var '.$field_name.'_select = $(\'select[id='.$field_name.'_select]\');';
				
				if ($field['Null'] == 'NO') {
					$document_ready_script_field_list .= '
	if ('.$field_name.'.val()==\'\') {
		'.$field_name.'_select.addClass(\'missingvalue\');
		checkProblem = true;
		missingFields = true;
	} else '.$field_name.'_select.removeClass(\'missingvalue\');';
				}
				
				if (strlen($document_ready_script_data_list) > 0) {
					$document_ready_script_data_list .= ' + \'&'.$field_name.'=\' + '.$field_name.'.val()';
				} else {
					$document_ready_script_data_list .= ' \''.$field_name.'=\' + '.$field_name.'.val()';
				}
				
				$document_ready_script_disabled_list .= '
			'.$field_name.'_select.attr(\'disabled\', \'disabled\');';
				
			} else {
			
				if (strpos($field['Type'], '(')) {
					preg_match('/(\w+)\((\d+)\)/', $field['Type'], $type);
				} else {
					$type[0] = $field['Type'];
					$type[1] = $field['Type'];
					$type[2] = 8;
				}
				
				switch ($type[1]) {
					case 'datetime':
						$form_script .= '<TR>
											<TD>
												<TABLE>
													<TR>
														<TD>'.constant(strtoupper($field['Field'])).$mandatory.' :</TD>
														<TD class="field_separator"></TD>
														<TD>
															<INPUT TYPE="text" ID="'.$field['Field'].'" NAME="'.$field['Field'].'" VALUE="'.$field['Default'].'" STYLE="width:'.($type[2]*4).'px" MAXLENGTH="'.$type[2].'">
														</TD>
													</TR>
												</TABLE>
											<TD>
										</TR>';
						break;
					case 'int':
						$form_script .= '<TR>
											<TD>
												<TABLE>
													<TR>
														<TD>'.constant(strtoupper($field['Field'])).$mandatory.' :</TD>
														<TD class="field_separator"></TD>
														<TD>
															<INPUT TYPE="text" ID="'.$field['Field'].'" NAME="'.$field['Field'].'" VALUE="'.$field['Default'].'" STYLE="width:'.($type[2]*8).'px" MAXLENGTH="'.$type[2].'">
														</TD>
													</TR>
												</TABLE>
											<TD>
										</TR>';
						break;
					case 'bigint':
						$form_script .= '<TR>
											<TD>
												<TABLE>
													<TR>
														<TD>'.constant(strtoupper($field['Field'])).$mandatory.' :</TD>
														<TD class="field_separator"></TD>
														<TD>
															<INPUT TYPE="text" ID="'.$field['Field'].'" NAME="'.$field['Field'].'" VALUE="'.$field['Default'].'" STYLE="width:'.($type[2]*8).'px" MAXLENGTH="'.$type[2].'">
														</TD>
													</TR>
												</TABLE>
											<TD>
										</TR>';
						break;
					case 'tinyint':
						$form_script .= '<TR>
											<TD>
												<TABLE>
													<TR>
														<TD>'.constant(strtoupper($field['Field'])).$mandatory.' :</TD>
														<TD class="field_separator"></TD>
														<TD>';
												
									$selected = $field['Default'];
									
									$form_script .= '<select id="'.$field['Field'].'_select" name="'.$field['Field'].'_select" onChange="javascript:updateSelect(\''.$field['Field'].'_select\')">';
									$form_script .= $data->DisplayBooleanList($selected);
									$form_script .= '</select>';
												
													$form_script .= '</TD>
													</TR>
													<TR>
														<TD class="separator"><input type="hidden" id="'.$field['Field'].'" name="'.$field['Field'].'" value="'.$field['Default'].'"></TD>
													</TR>
												</TABLE>
											<TD>
										</TR>';
						break;
					default:
						$form_script .= '<TR>
											<TD>
												<TABLE>
													<TR>
														<TD>'.constant(strtoupper($field['Field'])).$mandatory.' :</TD>
														<TD class="field_separator"></TD>
														<TD>
															<INPUT TYPE="text" ID="'.$field['Field'].'" NAME="'.$field['Field'].'" VALUE="'.$field['Default'].'" STYLE="width:'.($type[2]*6).'px" MAXLENGTH="'.$type[2].'">
														</TD>
													</TR>
												</TABLE>
											<TD>
										</TR>';
						break;
				}
				
				if ($type[1] == 'tinyint') {
					$document_ready_script_field_list .= '
		var '.$field['Field'].' = $(\'input[id='.$field['Field'].']\');
		var '.$field['Field'].'_select = $(\'select[id='.$field['Field'].'_select]\');';
					
					if ($field['Null'] == 'NO') {
						$document_ready_script_field_list .= '
		if ('.$field['Field'].'.val()==\'\') {
			'.$field['Field'].'.addClass(\'missingvalue\');
			checkProblem = true;
			missingFields = true;
		} else '.$field['Field'].'.removeClass(\'missingvalue\');';
					}
					
					$document_ready_script_disabled_list .= '
				'.$field['Field'].'_select.attr(\'disabled\', \'disabled\');';
				} else {
					$document_ready_script_field_list .= '
		var '.$field['Field'].' = $(\'input[id='.$field['Field'].']\');';
					
					if ($field['Null'] == 'NO') {
						$document_ready_script_field_list .= '
		if ('.$field['Field'].'.val()==\'\') {
			'.$field['Field'].'.addClass(\'missingvalue\');
			checkProblem = true;
			missingFields = true;
		} else '.$field['Field'].'.removeClass(\'missingvalue\');';
					}
					
					$document_ready_script_disabled_list .= '
				'.$field['Field'].'.attr(\'disabled\', \'disabled\');';
				}
				
				if (strlen($document_ready_script_data_list) > 0) {
					$document_ready_script_data_list .= ' + \'&'.$field['Field'].'=\' + '.$field['Field'].'.val()';
				} else {
					$document_ready_script_data_list .= ' \''.$field['Field'].'=\' + '.$field['Field'].'.val()';
				}
			}
		}
	}
	
	// SCRIPT CREATION
	
	$script .= '<?php echo Util::PageGetHtmlTop(); ?>
	<HEAD>
		<TITLE>'.SITE_TITLE.'</TITLE>
		';
	
	$script .= Util::PageGetLightMeta();
	$script .= '		<LINK REL="SHORTCUT ICON" HREF="<?php echo BASE_LINK; ?>/images/ico/favicon.ico">
		<LINK REL="STYLESHEET" href="../css/'.$style.'.css" type="text/css"> 
		<LINK REL="STYLESHEET" media="handheld , (max-width: 1000px)" href="../css/mobile.css" type="text/css">
		<SCRIPT src="<?php echo BASE_LINK; ?>/scripts/jquery-latest.js" type="text/javascript"></SCRIPT>
		<SCRIPT src="<?php echo BASE_LINK; ?>/scripts/script.js.php" type="text/javascript"></SCRIPT>
		<SCRIPT type="text/javascript">';    	
	
	$script .= Util::PageGetDocumentReadyTop();
	
	$script .= '	$(\'#submit\').click(function () {

	var checkProblem = false;
	var missingFields = false;
    ';
	
	$script .= $document_ready_script_field_list;
	
	$script .= '

	if (missingFields) {
     	$(\'span[id=message]\').html(\''.MISSING_FIELDS_ERROR.'\');
        $(\'div[id=notification]\').show();
    }
    
	if (checkProblem) {
		return false;
	}
	';
	
    $script .= '
	var data =';
    
    $script .= $document_ready_script_data_list;
    
    $script .= ';
    
	$.ajax({
		url: "_admin_configuration_add.php",
		type: "GET",
		data: data,
		cache: false,
		success: function (html) {
			$(\'span[id=message]\').html(html);
    		$(\'div[id=notification]\').show();';
    
    $script .= $document_ready_script_disabled_list;
    
    $script .= '
			$(\'#submit\').attr(\'disabled\', \'disabled\');
		}
	});
        
	return false;
});';

	$script .= Util::PageGetDocumentReadyBottom();
	$script .= '		</SCRIPT>
	</HEAD>
	<BODY>
	';
	$script .= Util::PageGetTop();
	$script .= '		<div id="content">
<div id="notification"';
if(isset($_REQUEST['message']) && ($_REQUEST['message'] != '')) {
	$script .= ' style="display:block;"><span id="message">'.$_REQUEST['message'];
} else {
	 $script .= '><span id="message">';
}

$script .= '</span><a class="close" href="javascript:void(0)" onclick="$(\'div[id=notification]\').hide();return false;"></a></div>
<div id="title" xmlns:v="http://rdf.data-vocabulary.org/#">
	<ul class="crumb admin_specific_crumb" itemprop="breadcrumb">
		<li typeof="v:Breadcrumb">
			<a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/index.php" title="'.MENU_HOME.'" rel="v:url" property="v:title" >'.MENU_HOME.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin.php" rel="v:url" property="v:title" >'.ADMIN_TITLE.'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin_configuration.php" rel="v:url" property="v:title" >'.constant('ADMIN_ADMIN_CONFIGURATION_LIST_TITLE').'</A>
		</li>
		<li typeof="v:Breadcrumb" >
			<span class="arrow">></span><span class="title"><a href="'.$_SESSION[SITE_ID]['admin_configuration_http'].$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/admin_configuration_add.php" rel="v:url" property="v:title" >'.constant('ADMIN_ADMIN_CONFIGURATION_ADD_TITLE').'</A></span>
		</li>
	</ul>
</div>
 			<div id="main">
		<form method="POST" action="_admin_configuration_add.php">
			<TABLE>
				<TR>
					<TD>
						<TABLE>
						';
	
	$script .= $form_script;
	
	$script .= '	<TR>
						<TD>'.MANDATORY_FIELDS.'</TD>
					</TR>
					<TR>
						<TD>
	                        <INPUT TYPE="submit" ID="submit" NAME="submit" VALUE="'.constant('ADMIN_'.strtoupper($table_name).'_ADD_ADD').'" ALT="'.constant('ADMIN_'.strtoupper($table_name).'_ADD_TITLE').'">
							<INPUT TYPE="button" ID="back" NAME="back" VALUE="'.BACK.'" ALT="'.BACK.'" OnClick="javascript:history.back();">
						</TD>
					</TR>
				</TABLE>
			</TD>
		</TR>
	</TABLE>
</form>
</div>'.Util::PageGetBottom().'
</BODY>
</HTML>';

	// SCRIPT CREATION END
	
	// SHOW

	echo $script;
?>