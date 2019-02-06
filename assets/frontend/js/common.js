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
	//delete company
	jQuery(document).on("click", ".deleteCompany", function(){
		var companyId = $(this).data("userid"),
			hitURL = baseURL + "Company/ajax_deleteCompany",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this company ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { companyId : companyId } 
			}).done(function(data){
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Company successfully deleted"); }
				else if(data.status = false) { alert("Company deletion failed"); }
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
	//delete task
	jQuery(document).on("click", ".deleteTask", function(){
		var taskID = $(this).data("id"),
			hitURL = baseURL + "TaskList/ajax_deleteTask",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this task ?");
		
		if(confirmation)
		{
			jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL,
				data : { taskID : taskID } 
			}).done(function(data){
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Task successfully deleted"); }
				else if(data.status = false) { alert("Task deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	//delete subtask
	jQuery(document).on("click", ".deleteSubTask", function(){
		var taskID = $(this).data("id"),
			hitURL = baseURL + "TaskList/ajax_deleteSubTask",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this subtask ?");
		
		if(confirmation)
		{
			jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL,
				data : { taskID : taskID } 
			}).done(function(data){
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("SubTask successfully deleted"); }
				else if(data.status = false) { alert("SubTask deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	 $(document).on("click",".constCardThumb",function(){

        var src  =    $(this).attr("src");


         $('#constP').html('<img src="'+src+'" class="img-responsive">');


         $("#constCardModal").modal("show");

       });
	 $(document).on("click",".openExcModal",function(){
         $("#exclmodal").modal("show");
       });
	 //$("#project_name").chosen();
	 $("#exclProjForm").validate({
	 	rules: {
			employee_name: "required",
			client_name: "required",
			project_name: "required"
		},
		messages: {
			employee_name: "Please select employee",
			client_name: "Please enter client name",
			project_name: "Please choose projects",
	    },
	    submitHandler: function (form) {
			 $('.opacity-add').css('opacity', '0.5');
			 $('.submiting').text('Saving....');
             $.ajax({
                 type: "POST",
                 url: baseURL + "Profile/ajax_ExcludeProjectSave",
                 data: $(form).serialize(),
                 success: function (response) {
                     var responseA = JSON.parse(response);
					 if(responseA.status=='success'){
						 $('.opacity-add').css('opacity','1');
						 $('.alert-success').show();
						 window.setTimeout(function(){
							window.location.href = '';
							}, 800);

					 }else if(responseA.status=='already_exists'){
					 	 $('.submiting').text('Save');
						 $('.opacity-add').css('opacity','1');
						 $('.already_exists').show();
						 $('.already_exists').addClass('alert');
						 $('.already_exists').addClass('alert-danger');
						 $('.already_exists').html(responseA.msg);
					 }else{
						 $('.submiting').text('Save');
						 $('.opacity-add').css('opacity','1');
						 $('.alert-danger').show();
						 
					 }
                 }
             });
             return false; // required to block normal submit since you used ajax
         }
	 });
	 $("#client_name").autocomplete({

		source: function( request, response ) {
        $.ajax({
          url: baseURL + "Schedules/get_ajaxClients",
          dataType: "json",
          data: {
            q: request.term
          },
          success: function( data ) {
            response( $.map( data, function( item ) {
                return {
                    label: item.label,
                    value: item.label,
                    id: item.id
                }
            }));
        }
        });
      },
      minLength: 2,
      select: function( event, ui ) {
            $("#client_id").val(ui.item.id);
            var client_id = ui.item.id
            if(client_id!=""){
	            $.ajax({
					url: baseURL+"Schedules/getProjectsByClient",
					type: 'POST',
					data: {'cid' : client_id },
					success: function(response) {
            			$("#project_name").removeAttr('disabled');
						$('#project_name').html(response);
					}            
				});
	        }
        },

	});

	 $("#editclient_name").autocomplete({

		source: function( request, response ) {
        $.ajax({
          url: baseURL + "Schedules/get_ajaxClients",
          dataType: "json",
          data: {
            q: request.term
          },
          success: function( data ) {
            response( $.map( data, function( item ) {
                return {
                    label: item.label,
                    value: item.label,
                    id: item.id
                }
            }));
        }
        });
      },
      minLength: 2,
      select: function( event, ui ) {
            $("#editclient_id").val(ui.item.id);
            var client_id = ui.item.id
            if(client_id!=""){
	            $.ajax({
					url: baseURL+"Schedules/getProjectsByClient",
					type: 'POST',
					data: {'cid' : client_id },
					success: function(response) {
						$('#editproject_name').html(response);
					}            
				});
	        }
        },

	});
	 $(".deleteExcProj i.glyphicon-trash").click(function(){
	 	$(this).css('opacity','0.5');
	 	var currentRow = $(this).closest('.row');
	 	var id = $(this).parents('.deleteExcProj').data('id');
	 	$.ajax({
			url: baseURL+"Profile/deleteExcludeProjects",
			type: 'POST',
			data: {'id' : id },
			success: function(response) {
    			currentRow.fadeOut('fast');
			}            
		});
	 })
	 $(".deleteExcProj i.glyphicon-pencil").click(function(){
	 	$(this).css('opacity','0.5');
	 	var id = $(this).parents('.deleteExcProj').data('id');
	 	$.ajax({
			url: baseURL+"Profile/editExcludeProjects",
			type: 'POST',
			data: {'id' : id },
			success: function(response) {
				var responseA = JSON.parse(response);
				$('.deleteExcProj i.glyphicon-pencil').css('opacity','1');
    			$("#editexclmodal").modal("show");
    			$("#editproject_name").html(responseA.html);
    			$("#editemployee_name").val(responseA.data[0].employee_id);
    			$("#editclient_name").val(responseA.data[0].company_name);
    			$("#editclient_id").val(responseA.data[0].client_id);
    			$("#edit_id").val(responseA.data[0].id);
    			var project_ids = responseA.data[0].project_id.split(',');
    			$("#editproject_name").val(project_ids);
			}            
		});
	 });
	 $("#editexclProjForm").validate({
	 	rules: {
			employee_name: "required",
			client_name: "required",
			project_name: "required"
		},
		messages: {
			employee_name: "Please select employee",
			client_name: "Please enter client name",
			project_name: "Please choose projects",
	    },
	    submitHandler: function (form) {
			 $('.opacity-add').css('opacity', '0.5');
			 $('.updating').text('Updating....');
             $.ajax({
                 type: "POST",
                 url: baseURL + "Profile/ajax_ExcludeProjectUpdate",
                 data: $(form).serialize(),
                 success: function (response) {
                     var responseA = JSON.parse(response);
					 if(responseA.status=='success'){
						 $('.opacity-add').css('opacity','1');
						 $('.alert-success').show();
						 window.setTimeout(function(){
							window.location.href = '';
							}, 800);

					 }else{
						 $('.updating').text('Update');
						 $('.opacity-add').css('opacity','1');
						 $('.alert-danger').show();
						 
					 }
                 }
             });
             return false; // required to block normal submit since you used ajax
         }
	 });
	 $("#company").change(function(){
	  	var company_id = $(this).val();
	  	$.ajax({
	  		type: "POST",
            url: baseURL + "Booking/ajax_getContactsByCompany",
            data: {company_id:company_id},
            success: function(response) {
            	var responseA = JSON.parse(response);
            	$("#contact").html(responseA.contacts);
            	$("#project").html(responseA.projects);
            }
	  	})
	  })
	 $(document).on('change','#project',function(){
	 	var project_id = $(this).val();
		if(project_id!=''){
			$.ajax({
				url: baseURL+"Schedules/ajax_getTasks",
				type: 'POST',
				data: {'pid' : project_id },
				success: function(response) {
					var responseA = JSON.parse(response);
					$('.tasks_div').html(responseA.resdata);
				}            
			});
		}
	 })
	 $("#addBooking").validate({
	 	rules:{
	 		company: "required",
	 		project: "required",
	 		pfrd_day: "required",
	 		pfrd_time: "required",
	 		instructions: "required"
	 	},
	 	messages:{
	 		company: "Select company name",
	 		project: "Select project name",
	 		pfrd_day: "Select Pfrd Day",
	 		pfrd_time: "Select pfrd time",
	 		instructions: "Write instructions"
	 	}
	 });
	 $(document).on('change',".tasks_div input[name='task_ids[]']",function(){
	 	var task_id = $(this).val();
	 	if($(this).prop('checked')==true){
	 		$(".tasks_div .st_"+task_id).prop('checked',true);
	 	}else{
	 		$(".tasks_div .st_"+task_id).prop('checked',false);
	 	}
	 })
	 $(document).on('change',".tasks_div input[name='subtask_ids[]']",function(){
	 	var task_id = $(this).data('parent');
	 	if($(this).prop('checked')==true){
	 		$(".t_"+task_id).prop('checked',true);
	 	}
	 	var subLength = $('.st_'+task_id).length;
	 	//console.log(subLength);
	 	var loopL = 0;
	 	$('.st_'+task_id).each(function(){
	 		if($(this).prop('checked')==false){
	 			loopL++;
	 		}
	 	})
	 	//console.log(loopL);
	 	if(loopL==subLength){
	 		$(".t_"+task_id).prop('checked',false);
	 	}
	 })
	 $("#client").autocomplete({

		source: function( request, response ) {
        $.ajax({
          url: baseURL + "Schedules/get_ajaxClients",
          dataType: "json",
          data: {
            q: request.term
          },
          success: function( data ) {
          	if(!data.length){
		      var result = [
		       {
		       label: 'No search results, found, click here to add a New Company', 
		       value: response.term
		       }
		     ];
		       response(result);
		     }
		     else{
            response( $.map( data, function( item ) {
                return {
                    label: item.label,
                    value: item.label,
                    id: item.id
                }
            }));
        }
    }
        });
      },
      minLength: 2,
      select: function( event, ui ) {
            $("#clientname").val(ui.item.id);
            //console.log(ui.item);
            if(ui.item.label=='No search results, found, click here to add a New Company'){
            	$("#CompanyAddModal").modal('show');
            }
        },

	});
	 $("#addCompany").validate();
});
