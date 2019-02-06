jQuery(document).ready(function(){
	
	/**
	 *Add a method
	 */
	jQuery.validator.addMethod("timeValidator",
   function (value, element, params) {
   var val = new Date('1/1/1991' + ' ' + value);       
   var par = new Date('1/1/1991' + ' ' + $(params).val());
   if (!/Invalid|NaN/.test(new Date(val))) {
           return new Date(val) > new Date(par);
       }

       return isNaN(val) && isNaN(par)
           || (Number(val) > Number(par));
}, 'End Time must be greater than Start Time.');


	//get Entry Modal
	$("#addtimebtn").click(function(){
		 var userId = $(this).attr('data-userid');
		 $.ajax({
                 type: "POST",
                 url: baseURL + "Timesheetentry/ajax_getTimeModal",
                 data: {user_id:userId},
                 success: function (response) {
					 $(".panel-body").css('opacity','1');
					$("#timesheetAddModal").html(response);
					$("#timesheetAddModal").modal("show");
					$("#start_date").daterangepicker({
						singleDatePicker: true,
						opens: 'left',
						locale: {
							format: 'Y-M-D'
							}
						});
						
						
						 
                 }
             });
	})
	
	 $('#datefrom').daterangepicker({
		  singleDatePicker: true,
		  opens: 'left',
		  "startDate": startdate,
		  locale: {
			format: 'Y-M-D'
			}
	 }, function(start, end, label) {
		 $("#datefrom").val(start.format('YYYY-MM-DD'));
		$('#filters').submit();
	});
	 
	/**
	*@save Data
	*/
	
	$(document).on('click','#addtimebtnajax', function() {
		 jQuery("#addTimeEntry").validate({
			 rules: {
				 start_date: {
					 required: true
				 },
				 from_time: {
					 required: true
				 },
				 to_time: {
					 required: true,
					 timeValidator: "#from_time"
				 }
			 },
			 submitHandler: function (form) {
				 jQuery('.opacity-add').css('opacity', '0.5');
				 jQuery('.updatesubmiting').text('Saving....');
				 jQuery.ajax({
					 type: "POST",
					 url: baseURL + "Timesheetentry/ajax_addTimeEntry",
					 data: $(form).serialize(),
					 success: function (response) {
						 console.log(response);
						 var responseA = JSON.parse(response);
						 if(responseA.status=='success'){
							 $('.opacity-add').css('opacity','1');
							 $('.alert-success').show();
							 $('#addTimeEntry').trigger("reset");
							 window.setTimeout(function(){
								window.location.href = '';
								}, 800);

						 }else if(responseA.status=='multiple_task_error'){
							 $('.updatesubmiting').text('Update');
							 $('.opacity-add').css('opacity','1');
							 $('.alert-danger').show();
							 $('.alert-danger').text(responseA.message);

						 }else{
							 $('.updatesubmiting').text('Update');
							 $('.opacity-add').css('opacity','1');
							 $('.alert-danger').show();
							 
						 }
					 }
				 });
				 return false;
			 }
		 });
	});
	
   $(document).on('change','#from_time', function() {
        var isValid = /^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$/.test($(this).val());
        if (isValid) {
            $(this).css('border-color','green');
			$('#addtimebtnajax').prop("disabled", false);
        } else {
             $(this).css('border-color','red');
			 $('#addtimebtnajax').prop("disabled", true);
        }

        return isValid;
   })
   
   $(document).on('change','#to_time', function() {
        var isValid = /^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$/.test($(this).val());
        if (isValid) {
            $(this).css('border-color','green');
			$('#addtimebtnajax').prop("disabled", false);
			 
        } else {
             $(this).css('border-color','red');
			 $('#addtimebtnajax').prop("disabled", true);
        }

        return isValid;
   })
	
})