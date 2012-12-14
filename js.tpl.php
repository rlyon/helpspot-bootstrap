<?php
/*
It's recommended that if you make changes to this template or any other template that you first copy the template into

/custom_templates

and make modifications on the copied version. HelpSpot will automatically use the copied version rather than the original.
This will protect your changes from being overwritten during an upgrade.
*/

//Send the HTTP header indicating that this is a javascript file
header('Content-type: text/javascript; charset=utf-8');
header('Content-Disposition: inline; filename="js.js"');
?>
//This file includes the core javascript required for the portal. 
//It also sets up HTTP headers that force visitors browsers to cache the javascript and will gzip compress the javascript if the zlib library is available in PHP
//The files included are:
// prototype.js
// scriptaculous/effects.js
// DynamicOptionList.js (used for drill down custom fields)
// jscal2/js/jscal2.js(used for date custom fields)
document.write('<script type="text/javascript" src="<?php echo $this->cf_primaryurl ?>/static_<?php echo $this->cf_version ?>/js/hs-js-combined-portal.php"></script>');

//Function that shows appropriate custom fields for each category
function ShowCategoryCustomFields(category_id){

	//Find the ID of the currently selected category
	var selected_category = category_id ? category_id : ($("xCategory") ? $F("xCategory") : 0);
	
	//Create javascript array of custom field ID's, excludes always visible custom fields
	var custom_field_ids = new Array("<?php echo implode('","', array_keys($this->splugin('CustomFields','getCategoryPublicCustomFields'))) ?>");
	var field_count = custom_field_ids.length;
	
	//Create javascript array of custom fields each category should display
	var category_custom_fields = new Array();
	<?php foreach($this->splugin('Categories','getCategories') AS $category): ?>
	category_custom_fields[<?php echo $category['xCategory'] ?>] = new Array("<?php echo implode('","',$category['sCustomFieldList']) ?>");
	<?php endforeach; ?>

	//Hide all fields on category change
	for(i=0;i < field_count;i++){
		if($("Custom" + custom_field_ids[i] + "_wrapper")) $("Custom" + custom_field_ids[i] + "_wrapper").hide();
	}
		
	//Show fields which are for this category
	if(selected_category != 0){			
		var custom_field_len = category_custom_fields[selected_category] ? category_custom_fields[selected_category].length : 0;
		for(i=0;i < custom_field_len;i++){
			if($("Custom" + category_custom_fields[selected_category][i] + "_wrapper")){
				$("Custom" + category_custom_fields[selected_category][i] + "_wrapper").show();
			}
		}
	}	
}
 
//Function that resets a portal login password
function ChangePortalLoginPassword(){

	//Find the new password they've set
	var password_new = $F('new_password');
	
	//Find the password confirmation they've set
	var password_confirm = $F('new_password_confirm');
	
	//Check if the password and the password confirm field match and that the password is not empty.
	if(password_new != password_confirm || password_new.empty()){
		//Popup an alert to notify the user that the passwords must match
		show_feedback("<?php echo lg_portal_req_passworderror ?>","error");
	}else{
		//Everything is OK so send the new password to the server
		new Ajax.Request("index.php?pg=password.change", {
			method: "post",
			parameters: {password: password_new},
			onSuccess: function(transport) {
				show_feedback("<?php echo lg_portal_req_passwordsaved ?>","success");
				
				//Hide the password box and clear the form fields
				$("change_password_box").hide();
				$("new_password").value = "";
				$("new_password_confirm").value = "";
			},
			onFailure: function(transport){
				show_feedback("<?php echo lg_portal_req_passwordposterror ?>","error");
			}			
		});
		
	}
}

//Function that sends the retrieve password email
function RetrievePortalLoginPassword(){
	//If there's no email in the box show feedback that an email needs to be entered
	if($F("login_email").empty()){
		show_feedback("<?php echo lg_portal_req_emailempty ?>","error");
		return;
	}else{
		//Change link text to loading
		$("retrievePortalPasswordLink").update('<span class="sending_note"><?php echo lg_portal_req_sending ?></span>');
		
		//An email is available so send the password email
		new Ajax.Request("index.php?pg=password.retrieve", {
			method: "post",
			parameters: {login_email: $F("login_email")},
			onSuccess: function(transport) {
				show_feedback("<?php echo lg_portal_req_passwordsent ?>","success");
			},
			onFailure: function(transport){
				show_feedback("<?php echo lg_portal_req_emailerror ?>","error");
			},
			onComplete: function(){
				//Remove sending text
				$("retrievePortalPasswordLink").update();			
			}
		});
	}
}

//Function to create a feedback box at the top of the right column. 
function show_feedback(message,type){
	//Style the feedback box as appropriate for each type of feedback
	if(type == "error"){
		$("feedback_box").addClassName("alert alert-error");
	}else{ //By default shows positive feedback
		$("feedback_box").addClassName("alert alert-success");
	}
	
	//Show the box
	$("feedback_box").show();
	
	//Insert message into the feedback box
	$("feedback_box").update(message);
}
