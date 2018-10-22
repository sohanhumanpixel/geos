/**
 * File : addUser.js
 * 
 * This file contain the validation of add user form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Human Pixel
 */

$(document).ready(function(){
	$( "#addUser" ).validate({
				rules: {
					
					fname: "required",
					lname: "required",
					email: {
						email: true,
						remote : { url : baseURL + "Admin/ajax_checkEmailExists", type :"post"}
					},
    			username:{
    				required:true,
    				minlength: 3,
    				remote : { url : baseURL + "Admin/ajax_checkUsernameExists", type :"post"}
   				},
  				password: {
  					required: true,
  				},
  				cpassword: {
  					required: true,
  					minlength: 5,
  					equalTo: "#password"
  				},
				role: {
  					required: true
  				},
				},
				messages: {
					role: "Please choose a role",
					fname: "Please enter first name",
					lname: "Please enter last name",
					email: {
						email: "Please enter a valid email address",
						remote:'This already exists!'
					},
			    username:{
    			  required: "Please enter a username",
    			  remote:'This username already registered',
    			  minlength: "Your username must consist of at least 5 characters"
			    },
  				password: {
  					required: "Please provide a password",
  					minlength: "Your password must be at least 5 characters long"
  				},
    			cpassword: {
    					required: "Please provide a password",
    					minlength: "Your password must be at least 5 characters long",
    					equalTo: "Please enter the same password as above"
    					}
			  }
			});
	$("#user_skills").chosen();
});
