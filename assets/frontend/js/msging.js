/**
 * @author Human Pixel
 * @created date: 29-12-2018
 */
 
jQuery(document).ready(function(){
	$("#to_msg").autocomplete({

		source: function( request, response ) {
        $.ajax({
          url: baseURL + "Admin/get_ajaxUsers",
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
                    label: item.fullname,
                    value: item.fullname,
                    id: item.id
                }
            }));
        }
    }
        });
      },
      minLength: 2,
      select: function( event, ui ) {
      		$("#recipient").val(ui.item.id);
        },

	});
})