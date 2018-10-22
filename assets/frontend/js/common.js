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
	
	/** 
	*induction check box
	*added date: 12-10-2018
	*/
	$("#is_induction").click(function() {
    if($(this).is(":checked")) {
        $(".inductionurl").show();
		$("#induction_url").val($('#induction_url').data("urlval"));
    } else {
		$("#induction_url").val('');
        $(".inductionurl").hide();
		
    }
	});
	
	/**
	 *@user Profile Pic Change model
	 */
	 $("#changephoto").click(function(){
		 
		 $("#editimgmodal").modal("show");
		 var imgurl = $('#realPic').attr('src');
		 $('#oldimg').attr('src',imgurl);
	 });
	 
	 /**
	  *@save User profile Images
	  */
	$("#changeimgform").on('submit',(function(e) {
		e.preventDefault();
		$(".modal-content").css('opacity','0.7');
		$("#saveImg").text('updating...');
		$("#saveImg").prop( "disabled", true );
		  $.ajax({
				url: baseURL + "Profile/ajax_editImageHtml",
				type: "POST",
				data:  new FormData(this),
				contentType: false,
				cache: false,
				processData:false,
				success: function(response) {
					$(".modal-content").css('opacity','1');
					$("#saveImg").text('Save');
					$("#saveImg").prop( "disabled", false );
					var responseA = JSON.parse(response);
					if(responseA.status=='success')
					{
					 $("#changeimgform")[0].reset();
					 //$("#successmmm").show();
					 $('#realPic').attr('src',responseA.message);
					 //$("#successmmm").text("Profile picture changed success");
					 $('#editimgmodal').modal('hide');
					}
					else
					{
					 // invalid file format.
					 $("#err").html(responseA.message).fadeIn();
					}          
				}
			});
			return false;
	}));
	
	/**
	 *@Emp Profile Pic Change model
	 */
	 $("#changephotoEmp").click(function(){
		 $("#editimgmodalemp").modal("show");
		 var imgurl = $('#realPic').attr('src');
		 $('#oldimg').attr('src',imgurl);
	 });
	 
	 $("#empchangeimgform").on('submit',(function(e) {
		e.preventDefault();
		$(".modal-content").css('opacity','0.7');
		$("#empsaveImg").text('updating...');
		$("#empsaveImg").prop( "disabled", true );
		  $.ajax({
				url: baseURL + "Admin/ajax_editImageHtml",
				type: "POST",
				data:  new FormData(this),
				contentType: false,
				cache: false,
				processData:false,
				success: function(response) {
					$(".modal-content").css('opacity','1');
					$("#saveImg").text('Save');
					$("#saveImg").prop( "disabled", false );
					var responseA = JSON.parse(response);
					if(responseA.status=='success')
					{
					 $("#empchangeimgform")[0].reset();
					 //$("#successmmm").show();
					 $('#realPic').attr('src',responseA.message);
					 //$("#successmmm").text("Profile picture changed success");
					 $('#editimgmodalemp').modal('hide');
					}
					else
					{
					 // invalid file format.
					 $("#err").html(responseA.message).fadeIn();
					}          
				}
			});
			return false;
	}));
	
});
