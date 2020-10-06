<?php   
/* V1.0 : 20121115 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./config/config.php');

class IpAddressException extends Exception 
{
	public function __construct($message) {
		parent :: __construct($message);
	}

	public function getError() {
		return $this->getMessage();
	}
}

class IpAddress
{
	protected $service = 'api.ipinfodb.com';
	protected $version = 'v3';
	protected $apiKey = '';
	protected $errors = array();
	
	
	public function __construct() {	
		$this->apiKey = $_SESSION[SITE_ID]['admin_configuration_ip_key'];
	}

	public function __destruct() {
	}
	
	public function setKey($key){
		if(!empty($key)) $this->apiKey = $key;
	}
	
	public function getError(){
		return implode("\n", $this->errors);
	}
	
	private function getResult($host, $name){
		$ip = @gethostbyname($host);

		if(preg_match('/^(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}$/', $ip)){
			$xml = @file_get_contents('http://' . $this->service . '/' . $this->version . '/' . $name . '/?key=' . $this->apiKey . '&ip=' . $ip . '&format=xml');

			try{
				$response = @new SimpleXMLElement($xml);

				foreach($response as $field=>$value){
					$result[(string)$field] = (string)$value;
				}

				return $result;
			}
			catch(Exception $e){
				$this->errors[] = $e->getMessage();
				return;
			}
		}

		$this->errors[] = '"' . $host . '" is not a valid IP address or hostname.';
		return;
	}
	
	public function __call($method = '', $args = '') {
		
		switch ($method) {
			case 'GetCity' :
				{
					if (isset($args[0])) {
						$returnValue = $this->getResult($args[0], 'ip-city');
						return $returnValue['cityName'];
					}
					break;
				}
			case 'GetCountry' :
				{
					if (isset($args[0])) {
						$returnValue = $this->getResult($args[0], 'ip-country');
						return $returnValue['countryCode'];
					}
					break;
				}
			case 'GetLatitude' :
				{
					if (isset($args[0])) {
						$returnValue = $this->getResult($args[0], 'ip-city');
						return $returnValue['latitude'];
					}
					break;
				}
			case 'GetLongitude' :
				{
					if (isset($args[0])) {
						$returnValue = $this->getResult($args[0], 'ip-city');
						return $returnValue['longitude'];
					}
					break;
				}
			case 'PrintFull' :
				{
					if (isset($args[0])) {
						$returnValue = $this->getResult($args[0], 'ip-city');
						print_r($returnValue);
					}
					break;
				}
			default:
				break;
		}
	}
}

?>