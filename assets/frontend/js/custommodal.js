/**
 * @author Human Pixel
 * @created date: 03-10-2018
 */
 
jQuery(document).ready(function(){
	
	//Add New time sheet
	
	$(".openmodaltime").click(function(){
		$(".alert-danger").hide();
		 var timesheetIdId = $(this).attr('data-ptypeid');
		 var dateselected = $(this).attr('data-date');
		 $("#bookingtime").val(dateselected);
		 $("#project_type_id").val(timesheetIdId);
		 var empid = $(this).attr('data-empid');
		 $("#emp_id").val(empid);
		 $('.empname').text($(this).attr('data-empname'));
		 $("#site").attr('disabled','disabled');
		 $('.tasks_div').html('<label class="loading_tasks" style="display:none;">Loading...</label>');
		 //alert(dateselected);
		// alert(timesheetIdId);
		 
		 //alert(fullname);
		 $("#timesheetmodal").modal("show");
	 });
	 
	 //Save Form Data
	 $('#timesheetmodal').on('hidden.bs.modal', function () {
		$(this).find('form').trigger('reset');
	})
	
	//Onchage get clients Projects
	
	/*$("#client").change(function () {
        var cleintId = $('#clientname').val();
		if(cleintId!=''){
			$('.loading_site').show();
			$.ajax({
				url: baseURL+"Schedules/ajax_getProject",
				type: 'POST',
				data: {'cid' : cleintId },
				success: function(response) {
					var responseA = JSON.parse(response);
					$('.site_div').html(responseA.resdata);
				}            
			});
		}
    });*/
	$(document).on('change','#sitename',function(){
		var project_id = this.value;
		if(project_id!=''){
			$('.loading_tasks').show();
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
     $("#addtimesheet").validate({
         rules: {
             bookingtime: {
                 required: true
             }
         },
         submitHandler: function (form) {
			 $('.opacity-add').css('opacity', '0.5');
			 $('.submiting').text('Saving....');
             $.ajax({
                 type: "POST",
                 url: baseURL + "Schedules/ajax_addSchedule",
                 data: $(form).serialize(),
                 success: function (response) {
                     var responseA = JSON.parse(response);
					 if(responseA.status=='success'){
						 $('.opacity-add').css('opacity','1');
						 $('.alert-success').show();
						 $('#addtimesheet').trigger("reset");
						 window.setTimeout(function(){
							window.location.href = '';
							}, 800);

					 }else if(responseA.status=='isOnLeave' || responseA.status=='alreadyAss'){
					 	$('.submiting').text('Add');
						 $('.opacity-add').css('opacity','1');
						 $('.alert-danger').show();
						 if(responseA.status=='alreadyAss'){
						 	$("#all_day").prop('checked',false);
						 }
						 $('.alert-danger').html(responseA.msg);
					 }else{
						 $('.submiting').text('Add');
						 $('.opacity-add').css('opacity','1');
						 $('.alert-danger').show();
						 
					 }
                 }
             });
             return false; // required to block normal submit since you used ajax
         }
     });
	$('[data-toggle="popover"]').popover({html : true});
	 /** Add / Remove Accordion Class */
	 $(".accordion-toggle").click(function(){
		 if($(this).hasClass("collapsed")){
			 $(this).removeClass("collapsed");
			 //alert('yes');
		 }else{
			 $(this).addClass("collapsed");
		 }
	 })
	 
	 /**
	  *Start Schedule Edit 
	  *view Popup only
	  */
	  $(".edit_schedule i").click(function(){
		  var shceduleId = $(this).parents('.edit_schedule').attr('data-editid');
		  $(".panel-body").css('opacity','0.5');
		  var empid = $(this).parents('.edit_schedule').attr('data-empid');
		  $.ajax({
                 type: "POST",
                 url: baseURL + "Schedules/ajax_editScheduleData",
                 data: {scheduleId:shceduleId,'epmId': empid},
                 success: function (response) {
					 $("#eid").val(empid);
					 $(".panel-body").css('opacity','1');
					$("#timesheetEditmodal").html(response);
					$("#timesheetEditmodal").modal("show");
						 
                 }
             });
		  //alert("under development ...");
	  })
	  
	  //Get project on client change
	  
	  $(document).on('change', '#editclientname', function() {
        var cleintId = this.value;
		if(cleintId!=''){
			//$('.loading_site').show();
			$.ajax({
				url: baseURL+"Schedules/ajax_getEditProject",
				type: 'POST',
				data: {'cid' : cleintId },
				success: function(response) {
					var responseA = JSON.parse(response);
					$('.edit_site_div').html(responseA.resdata);
				}            
			});
		}
    });
	
	/**
	 *@update schedule form
	 */
		$(document).on('click','#editsss', function() {
			
		 jQuery("#edittimesheet").validate({
			 rules: {
				 bookingtime: {
					 required: true
				 }
			 },
			 submitHandler: function (form) {
				 jQuery('.opacity-add').css('opacity', '0.5');
				 jQuery('.updatesubmiting').text('Saving....');
				 jQuery.ajax({
					 type: "POST",
					 url: baseURL + "Schedules/ajax_updateScheduleData",
					 data: $(form).serialize(),
					 success: function (response) {
						 console.log(response);
						 var responseA = JSON.parse(response);
						 if(responseA.status=='success'){
							 $('.opacity-add').css('opacity','1');
							 $('.alert-success').show();
							 $('#addtimesheet').trigger("reset");
							 window.setTimeout(function(){
								window.location.href = '';
								}, 800);

						 }else if(responseA.status=='alreadyAss'){
							 $('#editall_day').prop('checked',false);
						 	$('.updatesubmiting').text('Update');
							 $('.opacity-add').css('opacity','1');
							 $('.alert-danger').show();
							 $('.alert-danger').html(responseA.msg);
						 }else{
							 $('.updatesubmiting').text('Update');
							 $('.opacity-add').css('opacity','1');
							 $('.alert-danger').show();
							 
						 }
					 }
				 });
				 return false; // required to block normal submit since you used ajax
			 }
		 });
	});
	
	/**
	 *Ajax Remove Schedule
	 */
	$(document).on("keydown.autocomplete",'#editclient', function() {
	$(this).autocomplete({

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
		       label: 'No matches found', 
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
            $("#editclientname").val(ui.item.id);
            $("#editsite").val('');  
            $("#editsitename").val('');  
        },

	});
	})
	$(document).on("keydown.autocomplete",'#editsite', function() {
	$(this).autocomplete({

		source: function( request, response ) {
		var client_id = $("#editclientname").val();
		var emp_id    = $("#editeid").val();
        $.ajax({
          url: baseURL + "Schedules/get_ajaxProjects",
          dataType: "json",
          data: {
            q: request.term,
            cid: client_id,
            empid: emp_id
          },
          success: function( data ) {
          	if(!data.length){
		      var result = [
		       {
		       label: 'No matches found', 
		       value: response.term
		       }
		     ];
		       response(result);
		     }
		     else{
            response( $.map( data, function( item ) {
                return {
                    label: item.project_name,
                    value: item.project_name,
                    id: item.id
                }
            }));
        }
    }
        });
      },
      minLength: 2,
      select: function( event, ui ) {
            $("#editsitename").val(ui.item.id);
            var project_id = ui.item.id
            if(project_id!=""){
            	$('.loading_tasks').show();
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
        },

	});
})

	$(document).on("keydown.autocomplete",'#site', function() {
	$("#site").autocomplete({

		source: function( request, response ) {
		var client_id = $("#clientname").val();
		var emp_id    = $("#emp_id").val();
        $.ajax({
          url: baseURL + "Schedules/get_ajaxProjects",
          dataType: "json",
          data: {
            q: request.term,
            cid: client_id,
            empid: emp_id
          },
          success: function( data ) {
          	if(!data.length){
		      var result = [
		       {
		       label: 'No matches found', 
		       value: response.term
		       }
		     ];
		       response(result);
		     }
		     else{
            response( $.map( data, function( item ) {
                return {
                    label: item.project_name,
                    value: item.project_name,
                    id: item.id
                }
            }));
        }
    }
        });
      },
      minLength: 2,
      select: function( event, ui ) {
            $("#sitename").val(ui.item.id);
            var project_id = ui.item.id
            if(project_id!=""){
            	$('.loading_tasks').show();
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
        },

	});
})
	$(document).on("keydown.autocomplete",'#client', function() {
	$(this).autocomplete({

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
		       label: 'No matches found', 
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
            $("#site").removeAttr('disabled');  
        },

	});
})

	$(document).on('click','.edit_schedule img',function(){
		var shceduleId = $(this).parents('.edit_schedule').attr('data-editid');
	    $(".panel-body").css('opacity','0.5');
		var is_lock = $(this).parents('.edit_schedule').attr('data-isLock');
		$.ajax({
            type: "POST",
            url: baseURL + "Schedules/ajax_lockSchedule",
            data: {scheduleId:shceduleId,'is_lock': is_lock},
            success: function (response) {
				$(".panel-body").css('opacity','1');
				location.reload();		 
            }
        });
	})
	$(".unassigned_trs").sortable({
		items: "td.draggable_td",
		helper: function(event, ui){
		   var id = ui[0].getAttribute("data-id");
	       $(".unassigned_trs_"+id+" td:not(.draggable_td)").css('visibility','hidden');
	       return '<div class="draggable_td" data-id="5"><span class="fa fa-arrows">Booking Data</span></div>';
	    },
	    stop: function(event, ui){
	    	var id = ui.item[0].getAttribute("data-id");
	    	$(".unassigned_trs_"+id+" td:not(.draggable_td)").css('visibility','visible');
	    }
	});
	$( ".openmodaltime" ).parent().droppable({
	    drop: function(event,ui) {
	    	var dragDiv = ui.draggable[0];
	    	if($(dragDiv).hasClass('draggable_td')){
		        var id = ui.draggable[0].getAttribute("data-id");
		        $(".unassigned_trs_"+id).hide();
		        var empid = $(this).find('.openmodaltime').data('empid');
		        var ptype_id = $(this).find('.openmodaltime').data('ptypeid');
		        var date = $(this).find('.openmodaltime').data('date');
		        $('.subtbale_'+empid+'_'+ptype_id).css('opacity','0.5');
		        $.ajax({
		        	type: "POST",
					url: baseURL + "Schedules/ajax_saveDraggedSchedule",
					data: {id:id,empid:empid,ptype_id:ptype_id,date:date},
					success: function (response) {
						var responseA = JSON.parse(response);
						if(responseA.status=='success'){
							$('.subtbale_'+empid+'_'+ptype_id).css('opacity','1');
							location.reload();
						}else if(responseA.status=='isOnLeave'){
							$('.subtbale_'+empid+'_'+ptype_id).css('opacity','1');
							alert(responseA.msg);
						}else{
							alert(responseA.msg);
						}
					}
		        })
		    }else if($(dragDiv).hasClass('hover_popup')){
		    	var siblingDiv = $(dragDiv).siblings('.edit_schedule');
		    	var job_id = siblingDiv[0].getAttribute('data-editid');
		    	var empid = $(this).find('.openmodaltime').data('empid');
		        var ptype_id = $(this).find('.openmodaltime').data('ptypeid');
		        var date = $(this).find('.openmodaltime').data('date');
		    	var popUpList = $('<div></div>');
		    	popUpList.dialog({
		    		title : "Do you want to move or copy?",
		    		 buttons: {
			            "Move": function() {
			                $( this ).dialog( "close" );
		        			$('.subtbale_'+empid+'_'+ptype_id).css('opacity','0.5');
					        $.ajax({
					        	type: "POST",
								url: baseURL + "Schedules/ajax_moveDraggedSchedule",
								data: {job_id:job_id,empid:empid,ptype_id:ptype_id,date:date,key:1},
								success: function (response) {
									var responseA = JSON.parse(response);
									if(responseA.status=='success'){
										$('.subtbale_'+empid+'_'+ptype_id).css('opacity','1');
										location.reload();
									}else if(responseA.status=='isOnLeave'){
										$('.subtbale_'+empid+'_'+ptype_id).css('opacity','1');
										alert(responseA.msg);
									}else{
										alert(responseA.msg);
									}
								}
					        })
			            },
			            "Copy": function() {
			                $( this ).dialog( "close" );
		        			$('.subtbale_'+empid+'_'+ptype_id).css('opacity','0.5');
					        $.ajax({
					        	type: "POST",
								url: baseURL + "Schedules/ajax_moveDraggedSchedule",
								data: {job_id:job_id,empid:empid,ptype_id:ptype_id,date:date,key:0},
								success: function (response) {
									var responseA = JSON.parse(response);
									if(responseA.status=='success'){
										$('.subtbale_'+empid+'_'+ptype_id).css('opacity','1');
										location.reload();
									}else if(responseA.status=='isOnLeave'){
										$('.subtbale_'+empid+'_'+ptype_id).css('opacity','1');
										alert(responseA.msg);
									}else{
										alert(responseA.msg);
									}
								}
					        })
			            }
			          }
		    	});
		    }
	    }
	});
	$(".hover_popup").draggable({
		helper: "clone",
		start: function(e, ui) {
			var dragDiv = ui.helper[0];
			var job_name = $(dragDiv).html();
	    },
	});
	$(document).on("click"," .deleteschedulebtn", function(){
		$(this).text('Deleting...');
		var id = $(this).data('id');
		$.ajax({
			type: "POST",
			url: baseURL + "Schedules/ajax_deleteSchedule",
			data: {id:id},
			success: function (response) {
				var responseA = JSON.parse(response);
				if(responseA.status="success"){
					$('.deleteschedulebtn').text('Delete');
					location.reload();
				}

			}
		})
	})
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
});
