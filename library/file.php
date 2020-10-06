<?php  
/* V1.0 : 20121115 */

class FileException extends Exception 
{
	public function __construct($message) {
		parent :: __construct($message);
	}

	public function getError() {
		return $this->getMessage();
	}
}

class File
{
	private $link = NULL;
			
	public function __construct($fileName) {
		$this->link = fopen($fileName, "w");
	}

	public function __destruct() {
		fclose($this->link);
	}
	
	public function __call($method = '', $args = '') {
		
		switch ($method) {
			case 'Write' :
				{
					if (isset($args[0])) {
						fputs($this->link, $args[0]);
					}
					break;
				}
			case 'WriteLine' :
				{
					if (isset($args[0])) {
						fputs($this->link, $args[0].'
');
					}
					break;
				}
			default:
				break;
		}
	}
}




?>