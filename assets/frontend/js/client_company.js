jQuery(document).ready(function($){
	$(".add_contact").click(function(){
		$("#addContactModal").modal("show");
	});
	$( "#addClient" ).validate({
		rules: {
				fname: "required",
				lname: "required",
				email: {
					email: true
					},
			phone:{
				required: true
				}
			},
			messages: {
				fname: "Please enter first name",
				lname: "Please enter last name",
				email: {
					email: "Please enter a valid email address"
				},
				phone: "Please enter phone number"
		  }
			});
	$( "#notesForm" ).validate({
		rules: {
				note_title: "required",
				note_content: "required",
			},
			messages: {
				note_title: "Please enter note title",
				note_content: "Please enter note content",
		  },
		  submitHandler: function (form,e) {
		  	e.preventDefault();
		  	$(".notes_submit").val('Saving...');
		  	$(".notes_submit").attr('disabled','disabled');
		  	$.ajax({
		  		type: "POST",
				url: baseURL + "Company/addNotesAjax",
				data: $(form).serialize(),
				success: function (response) {
					var responseA = JSON.parse(response);
					if(responseA.status=='success'){
						$(".notes_submit").val('Save');
		  				$(".notes_submit").removeAttr('disabled');
		  				$(form).find("input[type=text],select, textarea").val("");
		  				$("#notestab .notes-row:nth-child(4)").before('<div class="row notes-row"><div class="col-md-6 col-md-offset-2 notes-container"><div class="col-md-2 note-icon"><i class="fa fa-tag" style="font-size: 34px; position: relative; top: 14px;color: #3c8dbc;"></i></div><div class="col-md-8 note-content"><h5>'+responseA.note_title+'</h5><p>'+responseA.date+'- Note added by '+responseA.created_by+'</p><p>'+responseA.note_content+'</p></div><div class="col-md-2 note-action" data-id="'+responseA.note_id+'"><i class="fa fa-edit" data-title="Edit note" style="color: #045098;"></i><i class="fa fa-trash" data-title="Delete note" style="color: #d82828;"></i></div></div><div class="col-md-6 col-md-offset-2 notes-container-hidden" style="display: none;"><div class="col-md-2 note-icon"><i class="fa fa-tag" style="font-size: 34px; position: relative; top: 14px;color: #3c8dbc;"></i></div><div class="col-md-8 note-content"><form method="post" class="editNotesForm edit_form_'+responseA.note_id+'"><input type="text" name="edit_title" class="form-control" value="'+responseA.note_title+'"><input type="hidden" name="edit_id" value="'+responseA.note_id+'"><textarea name="edit_content" class="form-control">'+responseA.note_content+'</textarea></form></div><div class="col-md-2 note-action" data-id="'+responseA.note_id+'"><i class="fa fa-check" data-title="Save note" style="color: #2aa52a;"></i><i class="fa fa-times" data-title="Cancel" style="    color: #d82828;"></i></div></div></div>');
					}else{
						$(".notes_submit").val('Save');
		  				$(".notes_submit").removeAttr('disabled');
		  				alert('Error!:'+responseA.msg);
					}
				 }
		  	})
		  }
			});
	$(document).on('click','.note-action .fa-edit', function(){
		$(this).parents('.notes-container').hide();
		$(this).parents('.notes-container').siblings('.notes-container-hidden').show();
	})
	$(document).on('click','.note-action .fa-times', function(){
		$(this).parents('.notes-container-hidden').hide();
		$(this).parents('.notes-container-hidden').siblings('.notes-container').show();
	})
	$(document).on('click','.note-action .fa-check', function(){
		var note_id = $(this).parent().data('id');
		$(this).parents(".notes-container-hidden").css('opacity','0.5');
		$.ajax({
			type: "POST",
			url: baseURL + "Company/saveNotesAjax",
			data: $('.edit_form_'+note_id).serialize(),
			success: function (response) {
				var responseA = JSON.parse(response);
				if(responseA.status=='success'){
					$('.edit_form_'+note_id).parents('.notes-container-hidden').css('opacity','1');
					$('.edit_form_'+note_id).parents('.notes-container-hidden').hide();
					$('.edit_form_'+note_id).parents('.notes-container-hidden').siblings('.notes-container').show();
					$('.edit_form_'+note_id).parents('.notes-container-hidden').siblings('.notes-container').find('.note-content h5').html(responseA.note_title);
					$('.edit_form_'+note_id).parents('.notes-container-hidden').siblings('.notes-container').find('.note-content p:nth-child(3)').html(responseA.note_content);
				}else{
					$('.edit_form_'+note_id).parents('.notes-container-hidden').css('opacity','1');
					alert('Error!:'+responseA.msg);
				}
			}
		})
	})
	$(document).on('click','.note-action .fa-trash', function(){
		var note_id = $(this).parent().data('id');
		var current_row = $(this).parents(".notes-container");
		if(confirm("Are you sure to delete this note?")){
			$(this).parents(".notes-container").css('opacity','0.5');
			$.ajax({
				type: "POST",
				url: baseURL + "Company/deleteNotesAjax",
				data: {'note_id':note_id},
				success: function (response) {
					var responseA = JSON.parse(response);
					if(responseA.status=='success'){
						current_row.css('opacity','1');
						current_row.fadeTo("slow",0.7, function(){
				            $(this).remove();
				        })
					}else{
						current_row.css('opacity','1');
						alert('Error!:'+responseA.msg);
					}
				}
			})
		}
	})
	$( "#taskForm" ).validate({
		rules: {
			employee_id: "required",
			task_title: "required",
			task_content: "required",
			},
		messages: {
			employee_id: "Please select employee",
			task_title: "Please enter task name",
			task_content: "Please enter task description",
	    },
		submitHandler: function (form,e) {
			e.preventDefault();
		  	$(".tasks_submit").val('Saving...');
		  	$(".tasks_submit").attr('disabled','disabled');
		  	$.ajax({
		  		type: "POST",
				url: baseURL + "Company/addTasksAjax",
				data: $(form).serialize(),
				success: function (response) {
					var responseA = JSON.parse(response);
					if(responseA.status=='success'){
						$(".tasks_submit").val('Save');
		  				$(".tasks_submit").removeAttr('disabled');
		  				$(form).find("input[type=text],select, textarea").val("");
		  				$("#taskstab .tasks-row:nth-child(4)").before('<div class="row tasks-row"><div class="col-md-6 col-md-offset-2 tasks-container"><div class="col-md-2 task-icon"><i class="fa fa-tasks" style="font-size: 34px; position: relative; top: 14px;color: #3c8dbc;"></i></div><div class="col-md-8 task-content"><h5>'+responseA.task_title+'</h5><p>'+responseA.date+'- Note added by '+responseA.created_by+'</p><p>'+responseA.task_content+'</p></div><div class="col-md-2 task-action" data-id="'+responseA.task_id+'"><i class="fa fa-edit" data-title="Edit task" style="color: #045098;"></i><i class="fa fa-trash" data-title="Delete task" style="color: #d82828;"></i></div></div><div class="col-md-6 col-md-offset-2 tasks-container-hidden" style="display: none;"><div class="col-md-2 task-icon"><i class="fa fa-tasks" style="font-size: 34px; position: relative; top: 14px;color: #3c8dbc;"></i></div><div class="col-md-8 task-content"><form method="post" class="editTaskForm edit_form_'+responseA.task_id+'"><select name="edit_empid" class="form-control">'+responseA.empHtml+'</select><input type="text" name="edittask_title" class="form-control" value="'+responseA.task_title+'"><input type="hidden" name="edittask_id" value="'+responseA.task_id+'"><textarea name="edittask_content" class="form-control">'+responseA.task_content+'</textarea></form></div><div class="col-md-2 task-action" data-id="'+responseA.task_id+'"><i class="fa fa-check" data-title="Save task" style="color: #2aa52a;"></i><i class="fa fa-times" data-title="Cancel" style="    color: #d82828;"></i></div></div></div>');
					}else{
						$(".tasks_submit").val('Save');
		  				$(".tasks_submit").removeAttr('disabled');
		  				alert('Error!:'+responseA.msg);
					}
				 }
		  	})
		}
	})
	$(document).on('click','.task-action .fa-edit', function(){
		$(this).parents('.tasks-container').hide();
		$(this).parents('.tasks-container').siblings('.tasks-container-hidden').show();
	})
	$(document).on('click','.task-action .fa-times', function(){
		$(this).parents('.tasks-container-hidden').hide();
		$(this).parents('.tasks-container-hidden').siblings('.tasks-container').show();
	})
	$(document).on('click','.task-action .fa-trash', function(){
		var task_id = $(this).parent().data('id');
		var current_row = $(this).parents(".tasks-container");
		if(confirm("Are you sure to delete this task?")){
			$(this).parents(".tasks-container").css('opacity','0.5');
			$.ajax({
				type: "POST",
				url: baseURL + "Company/deleteTasksAjax",
				data: {'task_id':task_id},
				success: function (response) {
					var responseA = JSON.parse(response);
					if(responseA.status=='success'){
						current_row.css('opacity','1');
						current_row.fadeTo("slow",0.7, function(){
				            $(this).remove();
				        })
					}else{
						current_row.css('opacity','1');
						alert('Error!:'+responseA.msg);
					}
				}
			})
		}
	})
	$(document).on('click','.task-action .fa-check', function(){
		var task_id = $(this).parent().data('id');
		$(this).parents(".tasks-container-hidden").css('opacity','0.5');
		$.ajax({
			type: "POST",
			url: baseURL + "Company/saveTasksAjax",
			data: $('.edit_form_'+task_id).serialize(),
			success: function (response) {
				var responseA = JSON.parse(response);
				if(responseA.status=='success'){
					$('.edit_form_'+task_id).parents('.tasks-container-hidden').css('opacity','1');
					$('.edit_form_'+task_id).parents('.tasks-container-hidden').hide();
					$('.edit_form_'+task_id).parents('.tasks-container-hidden').siblings('.tasks-container').show();
					$('.edit_form_'+task_id).parents('.tasks-container-hidden').siblings('.tasks-container').find('.task-content h5').html(responseA.task_title);
					$('.edit_form_'+task_id).parents('.tasks-container-hidden').siblings('.tasks-container').find('.task-content p:nth-child(3)').html(responseA.task_content);
				}else{
					$('.edit_form_'+task_id).parents('.tasks-container-hidden').css('opacity','1');
					alert('Error!:'+responseA.msg);
				}
			}
		})
	})
})