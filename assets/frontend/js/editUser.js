/**
 * File : editUser.js 
 * 
 * This file contain the validation of edit user form
 * 
 * @author Human Pixel
 */
$(document).ready(function(){
	$( "#editUser" ).validate({
				rules: {
					
					fname: "required",
					lname: "required",
					email: {
						email: true,
						remote : { url : baseURL + "Admin/ajax_checkEmailExists", type :"post", data : { userId : function(){ return $("#userId").val(); } }}
					},
    			username:{
    				required:true,
    				minlength: 3,
    				remote : { url : baseURL + "Admin/ajax_checkUsernameExists", type :"post", data : { userId : function(){ return $("#userId").val(); } }}
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
			    }
			  }
			});
});