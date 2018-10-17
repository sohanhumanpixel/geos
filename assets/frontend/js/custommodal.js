/**
 * @author Human Pixel
 * @created date: 03-10-2018
 */
 
jQuery(document).ready(function(){
	
	//Add New time sheet
	
	$(".openmodaltime").click(function(){
		 var timesheetIdId = $(this).attr('data-ptypeid');
		 var dateselected = $(this).attr('data-date');
		 $("#bookingtime").val(dateselected);
		 $("#project_type_id").val(timesheetIdId);
		 var empid = $(this).attr('data-empid');
		 $("#emp_id").val(empid);
		 $('.empname').text($(this).attr('data-empname'));
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
	
	$("#clientname").change(function () {
        var cleintId = this.value;
		if(cleintId!=''){
			$('.loading_site').show();
			$.ajax({
				url: baseURL+"TimeSheet/ajax_getProject",
				type: 'POST',
				data: {'cid' : cleintId },
				success: function(response) {
					var responseA = JSON.parse(response);
					$('.site_div').html(responseA.resdata);
				}            
			});
		}
    });
	 
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
                 url: baseURL + "TimeSheet/ajax_addSchedule",
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
	  $(".edit_schedule").click(function(){
		  var shceduleId = $(this).attr('data-editid');
		  $(".panel-body").css('opacity','0.5');
		  $.ajax({
                 type: "POST",
                 url: baseURL + "TimeSheet/ajax_editScheduleData",
                 data: {scheduleId:shceduleId},
                 success: function (response) {
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
				url: baseURL+"TimeSheet/ajax_getEditProject",
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
					 url: baseURL + "TimeSheet/ajax_updateScheduleData",
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
	
	
});
