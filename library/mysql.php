<?php   
/* V1.0 : 20121115 */

class SqlException extends Exception 
{
	private $number = 0;
	
	public function __construct() {
		$argv = func_get_args();
		
		switch(func_num_args())
		{
			default:
			case 1:
				self::__construct1($argv[0]);
				break;
			case 2:
				self::__construct2($argv[0], $argv[1]);
				break;
		}
	}

	public function __construct1($exceptionMessage) {
		parent :: __construct($exceptionMessage);
		$this->number = 0;
	}
	
	public function __construct2($exceptionNumber, $exceptionMessage) {
		parent :: __construct($exceptionMessage);
		$this->number = $exceptionNumber;
	}

	public function getError() {
		if ($this->number != 0)
		{
			return $this->number.'|'.$this->getMessage();
		}
		else 
		{
			return $this->getMessage();
		}
		
	}
	
	public function getErrorMessage() {
		return $this->getMessage();
	}
	
	public function getErrorNumber() {
		return $this->number;
	}
}

class MySql
{
	private $mySqlHost = DATABASE_HOST, 
	        $mySqlDBName = DATABASE_NAME,
	        $mySqlDBUser = DATABASE_USERNAME,
			$mySqlDBPassword = DATABASE_PASSWORD,
			$link = NULL;
			
	public function __construct() {	
		$this->link = mysqli_connect($this->mySqlHost, $this->mySqlDBUser, $this->mySqlDBPassword, $this->mySqlDBName);
		
		if (!$this->link) {
			throw new SqlException(mysqli_errno(), mysqli_error ()); 
		}
	}
	
	public function __destruct() {	
		
	}
	
	public function __call($method = '', $args = '') {
		
		$returnValue = NULL;
		
		switch ($method) {
			case 'SelectSingleValueQuery' :
				{
					if (isset($args[0])) {
						
						$result = mysqli_query($this->link, $args[0]);
						
						if (!$result) {
							throw new SqlException(mysqli_errno($this->link), mysqli_error ($this->link)); 
						} else {
							$returnValue = mysqli_fetch_array($result, MYSQLI_NUM);
							$returnValue = stripslashes($returnValue[0]);
							mysqli_free_result($result);
						}
					}
					break;
				}
			case 'SelectRowQuery' :
				{
					if (isset($args[0])) {
						
						$result = mysqli_query($this->link, $args[0]);
						
						if (!$result) {
							throw new SqlException(mysqli_errno($this->link), mysqli_error ($this->link)); 
						} else {
							$returnValue = array();
							$row = mysqli_fetch_array($result, MYSQLI_NUM);
							
							for ($i = 0; $i < count($row); $i++) {
								$returnValue[$i] = stripslashes($row[$i]);
							}
							
							mysqli_free_result($result);
						}
					}
					break;
				}
			case 'SelectTableQuery' :
				{
					if (isset($args[0])) {
						
						$result = mysqli_query($this->link, $args[0]);
						
						if (!$result) {
							throw new SqlException(mysqli_errno($this->link), mysqli_error ($this->link)); 
						} else {
							$i = 0;
							$returnValue = array();
							
							while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
							{
								foreach ($row as $key => $value) {
									 $returnValue[$i][$key] = stripslashes($value);
								}
								
								$i++;
							}
							
							mysqli_free_result($result);
						}
					}
					break;
				}
			case 'SelectAssocTableQuery' :
				{
					if (isset($args[0])) {
						
						$result = mysqli_query($this->link, $args[0]);
						
						if (!$result) {
							throw new SqlException(mysqli_errno($this->link), mysqli_error ($this->link)); 
						} else {
							$i = 0;
							$returnValue = array();
							
							while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
							{
								foreach ($row as $key => $value) {
									 $returnValue[$i][$key] = stripslashes($value);
								}
								
								$i++;
							}
							
							mysqli_free_result($result);
						}
					}
					break;
				}
			case 'InsertQuery' :
				{
					if (isset($args[0])) {
						
						$result = mysqli_query($this->link, $args[0]);
						
						if (!$result) {
							throw new SqlException(mysqli_errno($this->link), mysqli_error ($this->link)); 
						} else {
							$returnValue = array(mysqli_affected_rows($this->link), mysqli_insert_id($this->link));
						}
					}
					break;
				}
			case 'UpdateQuery' :
				{
					if (isset($args[0])) {
						
						$result = mysqli_query($this->link, $args[0]);
						
						if (!$result) {
							throw new SqlException(mysqli_errno($this->link), mysqli_error ($this->link)); 
						} else {
							$returnValue = mysqli_affected_rows($this->link);
						}
					}
					break;
				}
			case 'DeleteQuery' :
				{
					if (isset($args[0])) {
						
						$result = mysqli_query($this->link, $args[0]);
						
						if (!$result) {
							throw new SqlException(mysqli_errno($this->link), mysqli_error ($this->link)); 
						} else {
							$returnValue = mysqli_affected_rows($this->link);
						}
					}
					break;
				}
			default:
				break;
		}
		
		return $returnValue;
	}
	
	
	public function FormatDataToBoolean($strValue) {
		$strValue = trim($strValue);
		$strValue = strtolower($strValue);
		
		if ($strValue != '') {
			if (($strValue == 'yes') || ($strValue == '1')) {
				return 1;
			} else if (($strValue == 'no') || ($strValue == '0')) {
				return 0;
			}
		}
	}
	
	public function FormatDataToInteger($strValue) {
		$strValue = trim($strValue);
		
		if (($strValue == '') || (!is_numeric($strValue))) {
			return 'NULL';
		} else {
			return ((integer)$strValue);
		}
	}
	
	public function FormatDataToFloat($strValue) {
		$strValue = trim($strValue);
		$strValue = str_replace(',', '.', $strValue);
	
		if ($strValue == '') {
			return 'NULL';
		} else {
			return ((float)$strValue);
		}
	}
	
	public function FormatDataToVarchar($strValue, $maxSize) {
		$strValue = trim($strValue);
		
		if ($strValue == '') {
			return 'NULL';
		} else {
			if ($maxSize != 0) {
				return '\''.mysqli_real_escape_string($this->link, substr($strValue, 0, $maxSize)).'\'';
			} else {
				return '\''.mysqli_real_escape_string($this->link, $strValue).'\'';
			}
		}
	}
	
	public function FormatDataToDate($strValue, $strFormat) {
		$strValue = trim($strValue);
		
		if ($strValue == '') {
			return 'NULL';
		} else {
			return 'STR_TO_DATE(\''.$strValue.'\', \''.$strFormat.'\')';
		}
	}
	
	public function PrintSelectOption($sql_query, $selected, $empty_value = false) {
		$result = $this->SelectTableQuery($sql_query);
		$script = '';
		
		if ($empty_value) {
			$script .= "<option value=''></option>";
		}
		
		if ($result)
		{
			for($i = 0; $i < count($result); $i++) {
				
				$current_selected = '';
				$current = $result[$i][1];
				
				if ((string)strpos($current, '#') === (string)0)
				{
					if (defined(substr($current, 1))) {
						$current = constant(substr($current, 1));
					} else {
						$current = substr($current, 1);
					}
				}
				
				if ($result[$i][0] == $selected) {
					$current_selected = " selected";
				}
				
				$script .= '<option value=\''.$result[$i][0].','.$result[$i][1].'\''.$current_selected.'>'.$current.'</option>';
			}
		}
		
		return $script;
	}
	
	public function PrintTranslatedSelectOption($sql_query, $selected, $empty_value = false) {
		$result = $this->SelectTableQuery($sql_query);
		$script = '';
	
		if ($empty_value) {
			$script .= "<option value=''></option>";
		}
	
		if ($result)
		{
			for($i = 0; $i < count($result); $i++) {
	
				$sel = '';
	
				if ($result[$i][0] == $selected) {
					$sel = " selected";
				}
	
				$script .= '<option value=\''.$result[$i][0].','.$result[$i][1].'\''.$sel.'>'.constant($result[$i][1]).'</option>';
			}
		}
	
		return $script;
	}
	
	public function PrintBooleanSelectOption($selected, $empty_value = false) {
		$script = '';
		
		if ($empty_value) {
			if ($selected == '') {
				$script .= "<option value='' SELECTED></option>";
			} else {
				$script .= "<option value=''></option>";
			}
		}
		
		if ($selected == '1') {
			$script .= '<option value=\'1,'.YES.'\' SELECTED>'.YES.'</option>
			            <option value=\'0,'.NO.'\'>'.NO.'</option>';
		} else if ($selected == '0') {
			$script .= '<option value=\'1,'.YES.'\'>'.YES.'</option>
			            <option value=\'0,'.NO.'\' SELECTED>'.NO.'</option>';
		} else {
			$script .= '<option value=\'1,'.YES.'\'>'.YES.'</option>
			            <option value=\'0,'.NO.'\'>'.NO.'</option>';
		}
	
		return $script;
	}
}

?>