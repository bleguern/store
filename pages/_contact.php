<?php  
/* V1.0 : 20121115 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	$contact_email = isset($_GET['contact_email']) ? $_GET['contact_email'] : $_POST['contact_email'];
	$contact_name = isset($_GET['contact_name']) ? $_GET['contact_name'] : $_POST['contact_name'];
	$contact_message = isset($_GET['contact_message']) ? $_GET['contact_message'] : $_POST['contact_message'];
	$contact_copy = isset($_GET['contact_copy']) ? $_GET['contact_copy'] : $_POST['contact_copy'];
	
	try {
		
		if ($contact_name == '') {
			$contact_name = $contact_email;
		}
		
		$to = $_SESSION[SITE_ID]['admin_configuration_manager_email'];
		$subject = SITE_TITLE.' - '.CONTACT_MAIL_MESSAGE.FROM.$contact_name;
		$message = '<?php echo Util::PageGetHtmlTop(); ?>
									      <BODY>
											<TABLE>
												<TR>
													<TD>'.$contact_message.'</TD>
												</TR>
									       	</TABLE>
									      </BODY>
									     </HTML>';
		$from = $contact_email;
		
		$cc = '';
		if ($contact_copy == '1') {
			$cc = $contact_email;
		}
		
		Util::SendMail($to, $subject, $message, $from, $cc);
		
		echo CONTACT_MESSAGE_SENT;
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}
?>







