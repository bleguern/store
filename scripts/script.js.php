<?php  
/* V1.0 : 20121115 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
?>
function load_url(url, id) {
	
	var xhr_object = null;
	var content = null;
	
	if (window.XMLHttpRequest) {
		xhr_object = new XMLHttpRequest();
	} else if (window.ActiveXObject) {
		xhr_object = new ActiveXObject("Microsoft.XML$_SESSION[SITE_ID]['admin_configuration_http']");
	} else {
		alert("<?php echo ERROR_LOAD_URL; ?>");
	}
	
	// Init
	if (document.getElementById(id) != null) {
		content = document.getElementById(id);
	} else {
		content = document.body;
	}
	
	content.innerHTML = '';
	
	// Loading URL content...
	xhr_object.open("GET", url, true);
	xhr_object.onreadystatechange = function() {
		if (xhr_object.readyState == 4) {
			if(xhr_object.status != 200) {
				content.innerHTML = "<?php echo ERROR; ?>" + xhr_object.status;
			} else {
				content.innerHTML = xhr_object.responseText;
			}
		} else {
			content.innerHTML = '<p style="text-align:center"><?php echo LOADING; ?></p>';
		}
	}
	
	// Get case
	xhr_object.send(null);
};

function updateSelect(selectName)
{
	var selectedValue = '';
	var htmlSelect = document.getElementById(selectName);
	selectedValue = htmlSelect.options[htmlSelect.selectedIndex].value;
	selectedValue = selectedValue.substr(0, selectedValue.indexOf(','));
	
	var inputField = document.getElementById(selectName.substr(0, selectName.lastIndexOf('_')));

	inputField.value = selectedValue;
};

function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
};

function showDateCalendar(elem)
{
	var calendar = new CalendarPopup();

	calendar.showNavigationDropdowns();
	calendar.showYearNavigationInput();
	calendar.setYearSelectStartOffset(50);

	var input = document.getElementById(elem);
	
	calendar.select(input,elem + '_button','dd/MM/yyyy');
	
	return false;
};
