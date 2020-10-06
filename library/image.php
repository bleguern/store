<?php   
/* V1.0 : 20121115 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./config/config.php');
	
class ImageException extends Exception	
{
	public function __construct($message) {
		parent :: __construct($message);
	}

	public function getError() {
		return $this->getMessage();
	}
}

class Image
{
	var $image;
	var $image_type;
		
	public function __construct() {	
	
	}

	public function __destruct() {
		
	}
	
	function load($filename) {
    	$image_info = getimagesize($filename);
      	$this->image_type = $image_info[2];
      	
      	if( $this->image_type == IMAGETYPE_JPEG ) {
        	$this->image = imagecreatefromjpeg($filename);
      	} elseif( $this->image_type == IMAGETYPE_GIF ) {
      		$this->image = imagecreatefromgif($filename);
      	} elseif( $this->image_type == IMAGETYPE_PNG ) {
         	$this->image = imagecreatefrompng($filename);
    	}
   	}
   
	function save($filename, $image_type=IMAGETYPE_JPEG, $compression=90, $permissions=null) {		
		if( $image_type == IMAGETYPE_JPEG ) {
			imagejpeg($this->image,$filename,$compression);
		} elseif( $image_type == IMAGETYPE_GIF ) {
	        imagegif($this->image,$filename);
		} elseif( $image_type == IMAGETYPE_PNG ) {
			imagepng($this->image,$filename);
		}

		if($permissions != null) {
			chmod($filename,$permissions);
		}
   	}
   	
	function delete($filename) {		
		unlink($filename);
   	}

   	function output($image_type=IMAGETYPE_JPEG) {
	
   		if( $image_type == IMAGETYPE_JPEG ) {
        	imagejpeg($this->image);
      	} elseif( $image_type == IMAGETYPE_GIF ) {
        	imagegif($this->image);
      	} elseif( $image_type == IMAGETYPE_PNG ) {
        	imagepng($this->image);
      	}
   	}
   
   	function getWidth() {
		return imagesx($this->image);
   	}
   
   	function getHeight() {
    	return imagesy($this->image);
   	}
   	
	function getType() {
    	return image_type_to_extension($this->image_type, FALSE);
   	}
   
   	function resizeToHeight($height) {
      	$ratio = $height / $this->getHeight();
      	$width = $this->getWidth() * $ratio;
      	$this->resize($width,$height);
   	}
 
   	function resizeToWidth($width) {
      	$ratio = $width / $this->getWidth();
      	$height = $this->getheight() * $ratio;
      	$this->resize($width,$height);
   	}
   	
	function resizeAndKeepRatio($width,$height) {
      	$new_width = $width;
      	
      	$ratio = $width / $this->getWidth();
      	$new_height = $this->getheight() * $ratio;
      	
      	if ($new_height > $height)
      	{
      		$ratio = $height / $this->getHeight();
      		$new_width = $this->getWidth() * $ratio;
      		$new_height = $height;
      	}
      	
      	$this->resize($new_width,$new_height);
   	}
 
   	function scale($scale) {
      	$width = $this->getWidth() * $scale/100;
      	$height = $this->getheight() * $scale/100;
      	$this->resize($width,$height);
   	}
 
   	function resize($width,$height) {
      	$new_image = imagecreatetruecolor($width, $height);
      	imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
		$this->image = $new_image;
   	}
}

?>