$(".cmnt_form").validate({
	rules: {
		content: "required"
	},
	messages: {
		content: "Write Comment"
	},
	submitHandler: function(form)
	{
		$('.tasks_comment').css('opacity', '0.5');
		$('.tasks_comment').val('Posting...');
		var url_ajx = baseURL + "Employee/ajax_postTaskComment";
		if($(".cmnt_form").hasClass('projT')){
			url_ajx = baseURL + "Employee/ajax_postProjTaskComment";
		}
		$.ajax({
			type: "POST",
			url: url_ajx,
			data: $(form).serialize(),
			success: function (response) {
				var responseA = JSON.parse(response);
				if(responseA.status=='success'){
					$('.tasks_comment').css('opacity', '1');
					$('.tasks_comment').val('Post Comment');
					$(".comment-input").val('');
					$('.comment-section h4.comment_h').after('<div class="comment-view col-md-12"><p><strong>'+responseA.name+'</strong><span class="pull-right"><i class="fa fa-clock-o"></i> '+responseA.date+'</span></p><p>'+responseA.comment+'<span class="pull-right" data-id="'+responseA.id+'"><i class="fa fa-trash"></i></span></p></div>');
				}else{
					$('.tasks_comment').css('opacity', '1');
					$('.tasks_comment').val('Post Comment');
					$(".comment-input").val('');
					alert(responseA.msg);
				}
			}
		})
	}
})
$(document).on('click','.fa-trash',function(){
	var id = $(this).parent().data('id');
	var current_row = $(this).parents(".comment-view");
	$(this).parents(".comment-view").css('opacity','0.5');
	var url_ajx = baseURL + "Employee/ajax_postDeleteComment";
	if($(".cmnt_form").hasClass('projT')){
		url_ajx = baseURL + "Employee/ajax_postDeleteProjComment";
	}
	$.ajax({
		type: "POST",
		url: url_ajx,
		data: {id:id},
		success: function (response) {
			var responseA = JSON.parse(response);
			current_row.css('opacity','1');
			current_row.fadeTo("slow",0.7, function(){
	            $(this).remove();
	        })
		}
	})
})
$(".show-comments").click(function(){
	$(".photos-section").hide();
	$(".details-section").hide();
	$(".comment-section").slideToggle();
})
$(".show-photos").click(function(){
	$(".comment-section").hide();
	$(".details-section").hide();
	$(".photos-section").slideToggle();
})
$(".show-details").click(function(){
	$(".comment-section").hide();
	$(".photos-section").hide();
	$(".details-section").slideToggle();
})
$('.sub_cmnt_form').each(function(){
	$(this).validate({
		rules: {
			content: "required"
		},
		messages: {
			content: "Write Comment"
		},
		submitHandler: function(form)
		{
			$(form).find('.subtasks_comment').css('opacity', '0.5');
			$(form).find('.subtasks_comment').val('Posting...');
			$.ajax({
				type: "POST",
				url: baseURL + "Employee/ajax_postSubTaskComment",
				data: $(form).serialize(),
				success: function (response) {
					var responseA = JSON.parse(response);
					if(responseA.status=='success'){
						$('.subtasks_comment').css('opacity', '1');
						$('.subtasks_comment').val('Post Comment');
						$(".comment-input").val('');
						$('.comment_sub_'+responseA.sub_id+' h4.sub_comment_h').after('<div class="comment-view col-md-12"><p><strong>'+responseA.name+'</strong><span class="pull-right"><i class="fa fa-clock-o"></i> '+responseA.date+'</span></p><p>'+responseA.comment+'<span class="pull-right" data-id="'+responseA.id+'"><i class="fa fa-trash"></i></span></p></div>');
					}else{
						$('.subtasks_comment').css('opacity', '1');
						$('.subtasks_comment').val('Post Comment');
						$(".comment-input").val('');
						alert(responseA.msg);
					}
				}
			})
		}
	})
})
$(".show-sub-comments").click(function(){
	var id = $(this).data('id');
	$(".photo_sub_"+id).hide();
	$(".detail_sub_"+id).hide();
	$(".comment_sub_"+id).slideToggle();
})
$(".show-sub-photos").click(function(){
	var id = $(this).data('id');
	$(".comment_sub_"+id).hide();
	$(".detail_sub_"+id).hide();
	$(".photo_sub_"+id).slideToggle();
})
$(".show-sub-details").click(function(){
	var id = $(this).data('id');
	$(".photo_sub_"+id).hide();
	$(".comment_sub_"+id).hide();
	$(".detail_sub_"+id).slideToggle();
})
$(".photos_form").on('submit',(function(e) {
	e.preventDefault();
	$('.photos_form .photos_submit').css('opacity', '0.5');
	$('.photos_form .photos_submit').val('Uploading...');
	$(".photos_form .photos_submit").prop( "disabled", true );
	$("#err").hide();
	var url_ajx = baseURL + "Employee/ajax_uploadTaskPhoto";
	if($(".photos_form").hasClass('projT')){
		url_ajx = baseURL + "Employee/ajax_uploadProjTaskPhoto";
	}
	$.ajax({
		type: "POST",
		url: url_ajx,
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		success: function (response) {
			$(".photos_form .photos_submit").css('opacity','1');
			$(".photos_form .photos_submit").val('Upload');
			$(".photos_form .photos_submit").prop( "disabled", false );
			var responseA = JSON.parse(response);
			if(responseA.status=='success')
			{
			 $(".photos_form")[0].reset();
			 if($(".photos-section .photo-view").hasClass("un")){
			 	$(".photos-section .photo-view").removeClass("un");
			 }
			 $(".photos-section .photo-view img:last-child").after('<img src="'+responseA.message+'" class="pic_t pic_t_'+responseA.id+'" width="100"><img src="https://geos.dev.humanpixel.com.au/assets/images/delete-309164_960_720.png" class="remove_pic" data-id="'+responseA.id+'">');
			}
			else
			{
			 $(".photos_form .photos_submit").css('opacity','1');
			 $(".photos_form .photos_submit").val('Upload');
			 $(".photos_form .photos_submit").prop( "disabled", false );
			 $("#err").show();
			 $("#err").html(responseA.message).fadeIn();
			}    
		}
	})
}))
$('.sub_photos_form').each(function(){
	$(this).on('submit',function(e){
		e.preventDefault();
		$(this).find('.subphotos_submit').css('opacity', '0.5');
		$(this).find('.subphotos_submit').val('Uploading...');
		$(this).find(".subphotos_submit").prop( "disabled", true );
		$(this).find(".sub_err").hide();
		$.ajax({
			type: "POST",
			url: baseURL + "Employee/ajax_uploadSubTaskPhoto",
			data:  new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			success: function (response) {
				var responseA = JSON.parse(response);
				$(".photo_sub_"+responseA.sub_id+" .subphotos_submit").css('opacity','1');
				$(".photo_sub_"+responseA.sub_id+" .subphotos_submit").val('Upload');
				$(".photo_sub_"+responseA.sub_id+" .subphotos_submit").prop( "disabled", false );
				if(responseA.status=='success')
				{
				 $(".photo_sub_"+responseA.sub_id+" .sub_photos_form")[0].reset();
				 if($(".photo_sub_"+responseA.sub_id+" .photo-view").hasClass("un")){
				 	$(".photo_sub_"+responseA.sub_id+" .photo-view").removeClass("un");
				 }
				 $(".photo_sub_"+responseA.sub_id+" .photo-view img:last-child").after('<img src="'+responseA.message+'" class="pic_t pic_t_'+responseA.id+'" width="100"><img src="https://geos.dev.humanpixel.com.au/assets/images/delete-309164_960_720.png" class="remove_pic" data-id="'+responseA.id+'">');
				}
				else
				{
				 $(".photo_sub_"+responseA.sub_id+" .subphotos_submit").css('opacity','1');
				 $(".photo_sub_"+responseA.sub_id+" .subphotos_submit").val('Upload');
				 $(".photo_sub_"+responseA.sub_id+" .subphotos_submit").prop( "disabled", false );
				 $(".photo_sub_"+responseA.sub_id+" .sub_err").show();
				 $(".photo_sub_"+responseA.sub_id+" .sub_err").html(responseA.message).fadeIn();
				}    
			}
		})
	})
})
$(document).on("click",'.remove_pic',function(){
	var id = $(this).data('id');
	$(".pic_t_"+id).css("opacity",'0.5');
	var url_ajx = baseURL + "Employee/ajax_deleteTaskPhoto";
	if($(".photos_form").hasClass('projT')){
		url_ajx = baseURL + "Employee/ajax_deleteProjTaskPhoto";
	}
	$.ajax({
		type: "POST",
		url: url_ajx,
		data:  {id:id},
		success: function(response){
			var responseA = JSON.parse(response);
			$(".pic_t_"+id).css("opacity",'0.5');
			$(".pic_t_"+id).fadeTo("slow",0.7, function(){
	            $(this).remove();
	        })
			$(".remove_pic[data-id='"+id+"']").hide();
		}
	})
})
$(document).on("click",".pic_t",function(){
    var src  = $(this).attr("src");
    $('#photoT').html('<img src="'+src+'" class="img-responsive" width="100%">');
    $("#photoTaskModal").modal("show");
});
$(".start-task").click(function(){
	if(confirm('Are you sure to start this task?')){
		$(this).css('opacity','0.5');
		$(this).attr('disabled','disabled');
		$(this).text('Starting...');
		var id = $(this).data('id');
		var parent_task = $(this).data('parent');
		var timesheetId = $(this).data('timesheet');
		$.ajax({
			type : "POST",
			url : baseURL + "Employee/ajax_startTask",
			data : { id : id, parent_task : parent_task, timesheetId : timesheetId },
			success: function(response) {
				if(response=='true'){
		            location.reload();
				}else{
					alert(response);
					$(".start-task").css('opacity','1');
					$(".start-task").removeAttr('disabled');
					$(".start-task").text('Start Task');
				}
			} 
		})
	}
})
$(".end-task").click(function(){
	if(confirm('Are you sure to end this task?')){
		$(this).css('opacity','0.5');
		$(this).attr('disabled','disabled');
		$(this).text('Ending...');
		var id = $(this).data('id');
		var parent_task = $(this).data('parent');
		var project_id = $(this).data('project');
		var empId = $(this).data('emp');
		var clientId = $(this).data('client');
		var timesheetId = $(this).data('timesheet');
		$.ajax({
			type : "POST",
			url : baseURL + "Employee/ajax_endTask",
			data : { id : id, parent_task : parent_task, project_id : project_id, empId : empId, clientId : clientId, timesheetId : timesheetId },
			success: function(response) {
				if(response=='true'){
					location.reload();
				}
			} 
		})
	}
})
$(".start-proj-task").click(function(){
	if(confirm('Are you sure to start this task?')){
		$(this).css('opacity','0.5');
		$(this).attr('disabled','disabled');
		$(this).text('Starting...');
		var id = $(this).data('id');
		$.ajax({
			type : "POST",
			url : baseURL + "Employee/ajax_startProjTask",
			data : { id : id },
			success: function(response) {
				if(response=='true'){
		            location.reload();
				}
			} 
		})
	}
})
$(".end-proj-task").click(function(){
	if(confirm('Are you sure to end this task?')){
		$(this).css('opacity','0.5');
		$(this).attr('disabled','disabled');
		$(this).text('Ending...');
		var id = $(this).data('id');
		var sch_date = $(this).data('date');
		var project_id = $(this).data('project');
		var empId = $(this).data('emp');
		var clientId = $(this).data('client');
		var timesheetId = $(this).data('timesheet');
		$.ajax({
			type : "POST",
			url : baseURL + "Employee/ajax_endProjTask",
			data : { id : id, sch_date : sch_date, project_id : project_id, empId : empId, clientId : clientId, timesheetId : timesheetId },
			success: function(response) {
				if(response=='true'){
					location.reload();
				}
			} 
		})
	}
})