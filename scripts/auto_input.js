var $input = $('#item_specific_brand_text');
var $select_input = $('#item_specific_brand');
var $select = $('#item_specific_brand_select');

function updateInput(){
	var selectedValue = $('#item_specific_brand_select option:selected').val();
	selectedValue = selectedValue.substr(0, selectedValue.indexOf(','));
	
	$input.val($('#item_specific_brand_select option:selected').text());
	$select_input.val(selectedValue);
}

$select.change(function(){
	updateInput();
});
 
$input.on('click', function(){
	$(this).select()
}).on('blur', function(){ });

$input.change(function () {
	$select_input.val('');
});

updateInput();