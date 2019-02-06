<div class="page-content">
	<div class="row">
		<?php $this->load->view('includes/left_sidebar');?> 
		<div class="col-md-10 padding-left-right">
			<div class="content-box-large">
				<div class="panel-heading">
					<div class="panel-title">
						<h3>Your Upcoming Leave</h3>
					</div>
					<div class="panel-options">
					  <a href="<?php echo base_url(); ?>Leave/applyleave" class="btn btn-success">Apply Leave</a>
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
						<table class="table user-list">
							<thead>
								<tr>
								<th><span>From Date</span></th>
								<th><span>To date</span></th>
								<th><span>Total Days</span></th>
								<th><span>Leave Type</span></th>
								<th><span> Reason </span></th>
								<th><span> Status </span></th>
								<th>Action</th>
								</tr>
							</thead>
							<tbody>
							<?php
                    if(!empty($leaveRecords))
                    {
                        foreach($leaveRecords as $record)
                        {
						if($record->status==1){
							$statusVal = "Approved";
							$statusclass = "label label-success";
							$statustoolTip = 'Leave Approved';
						}else{
							$statusVal = "Pending";
							$statusclass = "label label-warning";
							$statustoolTip = 'Leave Peding';
						}
                    ?>	
					<tr>
                      <td><?php echo $record->leave_from_date ?></td>
                      <td><?php echo $record->leave_to_date ?></td>
                      <td><?php echo $record->no_of_days; ?></td>
					  <td><?php echo $record->leave_type_name; ?></td>
                      <td><?php echo $record->leave_reason; ?></td>
                      <td><span class="<?php echo $statusclass; ?>" data-toggle="tooltip" title="<?php echo $statustoolTip; ?>"><?php echo $statusVal; ?></span></td>
                      <td class="text-center">
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'Leave/editleave/'.base64_encode(convert_uuencode($record->id)); ?>" data-toggle="tooltip" title="Edit"><i class="glyphicon glyphicon-pencil"></i></a>
						  
                          <a class="btn btn-sm btn-danger" onclick="return confirm('Are you sure want to delete?');" href="leavedelete/<?php echo base64_encode(convert_uuencode($record->id)) ?>" data-toggle="tooltip" title="Delete"><i class="glyphicon  glyphicon-trash"></i></a>
                      </td>
                    </tr>
					<?php 
						}
					}				
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
<script>
$('[data-toggle="tooltip"]').tooltip();
</script> 