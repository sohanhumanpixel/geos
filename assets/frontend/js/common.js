/**
 * @author Human Pixel
 * @created date: 28-09-2018
 */


jQuery(document).ready(function(){
	//dleete user
	jQuery(document).on("click", ".deleteUser", function(){
		var userId = $(this).data("userid"),
			hitURL = baseURL + "Admin/ajax_deleteUser",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this user ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { userId : userId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("User successfully deleted"); }
				else if(data.status = false) { alert("User deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
    //delete client
	jQuery(document).on("click", ".deleteClient", function(){
		var clientId = $(this).data("userid"),
			hitURL = baseURL + "Client/ajax_deleteClient",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this client ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { clientId : clientId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Client successfully deleted"); }
				else if(data.status = false) { alert("Client deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
    //delete project
	jQuery(document).on("click", ".deleteProject", function(){
		var projectId = $(this).data("userid"),
			hitURL = baseURL + "Projects/ajax_deleteProject",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this project ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { projectId : projectId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Project successfully deleted"); }
				else if(data.status = false) { alert("Project deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
});
