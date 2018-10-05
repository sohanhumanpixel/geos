/**
 * File : editClient.js 
 * 
 * This file contain the validation of edit client form
 * 
 * @author Human Pixel
 */
$(document).ready(function(){
	$( "#editClient" ).validate({
				rules: {
					
					fname: "required",
					lname: "required",
					email: {
						email: true,
						remote : { url : baseURL + "Client/ajax_checkEmailExists", type :"post", data : { clientId : function(){ return $("#clientId").val(); } }}
					},
					phone: "required"
				},
				messages: {
					fname: "Please enter first name",
					lname: "Please enter last name",
					email: {
						email: "Please enter a valid email address",
						remote:'This already exists!'
					},
			        phone: "Please enter phone number"
			  }
			});
});