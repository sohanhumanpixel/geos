<div class="page-content">
	<div class="row">
		<?php $this->load->view('includes/left_sidebar');?> 
		<div class="col-md-10 padding-left-right">
			<div class="content-box-large">
				<div class="panel-heading">
					<div class="panel-title">
						<h3><?=$title?></h3>
					</div>
					<div class="panel-options">
					  <a href="<?php echo base_url(); ?>booking/add" class="btn btn-success">Add New Booking</a>
					</div>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
					<?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
						<table class="table list">
							<thead>
								<tr>
									<th><span>Company Name</span></th>
									<th><span>Contact Name</span></th>
									<th><span>Preferred Date</span></th>
									<th><span>Estimated Time</span></th>
									<th><span>Project</span></th>
									<th><span>Task List</span></th>
									<th><span>Created By</span></th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
					
							<?php
                    if(!empty($bookings))
                    {
                    	foreach($bookings as $k=>$booking){
                    		if($booking->task_ids!=""){
								$tIDs = explode(',', $booking->task_ids);
								$taskNAr = array();
								foreach($tIDs as $tId){
									$q = $this->db->query("SELECT id, title, abbr FROM tasks WHERE id=$tId");
									$r = $q->result_array();
									array_push($taskNAr, $r[0]['title'].' '.$r[0]['abbr']);
								}
								$taskNames = implode(',', $taskNAr);
								$bookings[$k]->task_names = $taskNames;
	                    	}else{
	                    		$bookings[$k]->task_names = '';
	                    	}
	                    }
                        foreach($bookings as $booking)
                        { 
                    ?>	
					<tr>
						<td><?=$booking->company_name?></td>
						<td><?=$booking->contact_name?></td>
						<td><?=date('d-m-Y',strtotime($booking->pfrd_date))?></td>
						<td><?=$booking->est_time?></td>
						<td><?=$booking->project_name?></td>
						<td><?=$booking->task_names?></td>
						<td><?=$booking->firstname.' '.$booking->lastname?></td>
						<td>
                            <a class="btn btn-sm btn-info" href="<?php echo base_url().'booking/edit/'.base64_encode(convert_uuencode($booking->id)); ?>" data-toggle="tooltip" title="Edit"><i class="glyphicon  glyphicon-pencil"></i></a>
                            <a class="btn btn-sm btn-danger deleteBooking" href="javaScript:void(0);" data-userid="<?php echo $booking->id; ?>" data-toggle="tooltip" title="Delete"><i class="glyphicon  glyphicon-trash"></i></a>
						</td>
                    </tr>
					<?php 
						}
					}else{ ?>
						<tr>
							<td>No Records</td>
						</tr>
					<?php }			
					?>
							</tbody>
						</table>
					</div>
					<div class="box-footer clearfix">
						<?php echo $this->pagination->create_links(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('includes/footer');?>
<script type="text/javascript">
	jQuery(document).on("click", ".deleteBooking", function(){
		var id = $(this).data("userid");
		var	currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this booking ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : baseURL + "Booking/ajax_deleteBooking",
			data : { id : id } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Booking successfully deleted"); }
				else if(data.status = false) { alert("Booking deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
</script> 