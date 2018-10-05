/**
 * File : addClient.js
 * 
 * This file contain the validation of add client form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Human Pixel
 */

$(document).ready(function(){
	$( "#addClient" ).validate({
				rules: {
					
					fname: "required",
					lname: "required",
					email: {
						email: true,
						remote : { url : baseURL + "Client/ajax_checkEmailExists", type :"post"}
					},
  				password: {
  					required: true,
  				},
          phone: {
            required: true
          }
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
