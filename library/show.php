<?php  
/* V1.0 : 20121115 */

class ShowException extends Exception 
{
	public function __construct($message) {
		parent :: __construct($message);
	}

	public function getError() {
		return $this->getMessage();
	}
}

class Show
{
	public function __construct() {	
		
	}

	public function __destruct() {

	}
	
	public function __call($method = '', $args = '') {
		
		switch ($method) {
			case 'Say' :
				{
					if (isset($args[0])) {
						echo $args[0];
					}
					break;
				}
			case 'SayLine' :
				{
					if (isset($args[0])) {
						echo $args[0].'<BR>';
					}
					break;
				}
			default:
				break;
		}
	}
}

?>