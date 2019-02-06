<div class="page-content">
	<div class="row">
		<?php $this->load->view('includes/left_sidebar');?> 
		<div class="col-md-10 padding-left-right">
			<div class="content-box-large">
				<div class="panel-heading">
					<div class="panel-title">
						<h3><?=$title?></h3>
					</div>
					<div class="filter-leaves col-md-12">
						<ul class="nav nav-tabs" id="myTab" role="tablist">
	                        <li class="nav-item active">
	                            <a class="nav-link" id="all-tab" data-toggle="tab" href="#allLeave" role="tab" aria-controls="all" aria-selected="true">All</a>
	                        </li>
	                        <li class="nav-item">
	                            <a class="nav-link" id="upcoming-tab" data-toggle="tab" href="#upcomingLeave" role="tab" aria-controls="upcoming" aria-selected="false">Upcoming</a>
	                        </li>
	                        <li class="nav-item">
	                            <a class="nav-link" id="past-tab" data-toggle="tab" href="#pastLeave" role="tab" aria-controls="past" aria-selected="false">Past</a>
	                        </li>
	                    </ul>
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
                		<div class="tab-content leave-tab" id="myTabContent">
                            <div class="tab-pane fade in active" id="allLeave" role="tabpanel" aria-labelledby="all-tab">
								<table class="table user-list">
									<thead>
										<tr>
										<th><span>Employee Name</span></th>
										<th><span>From Date</span></th>
										<th><span>To Date</span></th>
										<th><span>Total Days</span></th>
										<th><span>Leave Type</span></th>
										<th><span>Reason</span></th>
										<th><span>Status</span></th>
										<th><span>Action</span></th>
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
											}else if($record->status==2){
												$statusVal = "Rejected";
												$statusclass = "label label-danger";
												$statustoolTip = 'Leave Rejected';
											}else{
												$statusVal = "Pending";
												$statusclass = "label label-warning";
												$statustoolTip = 'Leave Peding';
											}
					                    ?>	
										<tr>
										  <td><?php echo $record->employee_name ?></td>
					                      <td><?php echo date('d-m-Y',strtotime($record->leave_from_date)) ?></td>
					                      <td><?php echo date('d-m-Y',strtotime($record->leave_to_date)) ?></td>
					                      <td><?php echo $record->no_of_days; ?></td>
										  <td><?php echo $record->leave_type_name; ?></td>
					                      <td><?php echo $record->leave_reason; ?></td>
					                      <td><span class="<?php echo $statusclass; ?>" data-toggle="tooltip" title="<?php echo $statustoolTip; ?>"><?php echo $statusVal; ?></span></td>
					                      <td class="text-center">
					                      	<?php if($record->status==1){ ?>
					                      		<a href="<?=base_url()?>Employee/rejectLeave/<?=$record->id?>">
					                          	<button class="btn btn-danger">Reject</button>
					                          </a>
					                      	<?php }elseif($record->status==2){ ?>
					                      		<a href="<?=base_url()?>Employee/approveLeave/<?=$record->id?>">
					                          	<button class="btn btn-success">Approve</button>
					                          </a>
					                      	<?php }else{ ?>
					                      	  <a href="<?=base_url()?>Employee/approveLeave/<?=$record->id?>">
					                          	<button class="btn btn-success">Approve</button>
					                          </a>
					                          <a href="<?=base_url()?>Employee/rejectLeave/<?=$record->id?>">
					                          	<button class="btn btn-danger">Reject</button>
					                          </a>
					                      	<?php } ?>
					                          
					                      </td>
					                    </tr>
										<?php 
											}
										}else{ ?>
											<tr>
												<td colspan="6">No Records</td>
											</tr>
										<?php }					
										?>
									</tbody>
								</table>
								<div class="box-footer clearfix">
									<?php echo $this->pagination->create_links(); ?>
								</div>
							</div>
							<div class="tab-pane fade" id="upcomingLeave" role="tabpanel" aria-labelledby="upcoming-tab">
								<table class="table user-list">
									<thead>
										<tr>
										<th><span>Employee Name</span></th>
										<th><span>From Date</span></th>
										<th><span>To Date</span></th>
										<th><span>Total Days</span></th>
										<th><span>Leave Type</span></th>
										<th><span>Reason</span></th>
										<th><span>Status</span></th>
										<th><span>Action</span></th>
										</tr>
									</thead>
									<tbody>
									<?php
					                    if(!empty($upcomingLeaveRecords))
					                    {
					                        foreach($upcomingLeaveRecords as $upcomingRecord)
					                        {
											if($upcomingRecord->status==1){
												$statusVal = "Approved";
												$statusclass = "label label-success";
												$statustoolTip = 'Leave Approved';
											}else if($upcomingRecord->status==2){
												$statusVal = "Rejected";
												$statusclass = "label label-danger";
												$statustoolTip = 'Leave Rejected';
											}else{
												$statusVal = "Pending";
												$statusclass = "label label-warning";
												$statustoolTip = 'Leave Peding';
											}
					                    ?>	
										<tr>
										  <td><?php echo $upcomingRecord->employee_name ?></td>
					                      <td><?php echo date('d-m-Y',strtotime($upcomingRecord->leave_from_date)) ?></td>
					                      <td><?php echo date('d-m-Y',strtotime($upcomingRecord->leave_to_date)) ?></td>
					                      <td><?php echo $upcomingRecord->no_of_days; ?></td>
										  <td><?php echo $upcomingRecord->leave_type_name; ?></td>
					                      <td><?php echo $upcomingRecord->leave_reason; ?></td>
					                      <td><span class="<?php echo $statusclass; ?>" data-toggle="tooltip" title="<?php echo $statustoolTip; ?>"><?php echo $statusVal; ?></span></td>
					                      <td class="text-center">
					                      	<?php if($upcomingRecord->status==1){ ?>
					                      		<a href="<?=base_url()?>Employee/rejectLeave/<?=$upcomingRecord->id?>">
					                          	<button class="btn btn-danger">Reject</button>
					                          </a>
					                      	<?php }elseif($upcomingRecord->status==2){ ?>
					                      		<a href="<?=base_url()?>Employee/approveLeave/<?=$upcomingRecord->id?>">
					                          	<button class="btn btn-success">Approve</button>
					                          </a>
					                      	<?php }else{ ?>
					                      	  <a href="<?=base_url()?>Employee/approveLeave/<?=$upcomingRecord->id?>">
					                          	<button class="btn btn-success">Approve</button>
					                          </a>
					                          <a href="<?=base_url()?>Employee/rejectLeave/<?=$upcomingRecord->id?>">
					                          	<button class="btn btn-danger">Reject</button>
					                          </a>
					                      	<?php } ?>
					                          
					                      </td>
					                    </tr>
										<?php 
											}
										}else{ ?>
											<tr>
												<td colspan="6">No Records</td>
											</tr>
										<?php }				
										?>
									</tbody>
								</table>
								<div class="box-footer clearfix">
									<?php echo $this->pagination->create_links(); ?>
								</div>
							</div>
							<div class="tab-pane fade" id="pastLeave" role="tabpanel" aria-labelledby="past-tab">
								<table class="table user-list">
									<thead>
										<tr>
										<th><span>Employee Name</span></th>
										<th><span>From Date</span></th>
										<th><span>To Date</span></th>
										<th><span>Total Days</span></th>
										<th><span>Leave Type</span></th>
										<th><span>Reason</span></th>
										<th><span>Status</span></th>
										<th><span>Action</span></th>
										</tr>
									</thead>
									<tbody>
									<?php
					                    if(!empty($pastLeaveRecords))
					                    {
					                        foreach($pastLeaveRecords as $pastRecord)
					                        {
											if($pastRecord->status==1){
												$statusVal = "Approved";
												$statusclass = "label label-success";
												$statustoolTip = 'Leave Approved';
											}else if($pastRecord->status==2){
												$statusVal = "Rejected";
												$statusclass = "label label-danger";
												$statustoolTip = 'Leave Rejected';
											}else{
												$statusVal = "Pending";
												$statusclass = "label label-warning";
												$statustoolTip = 'Leave Peding';
											}
					                    ?>	
										<tr>
										  <td><?php echo $pastRecord->employee_name ?></td>
					                      <td><?php echo date('d-m-Y',strtotime($pastRecord->leave_from_date)) ?></td>
					                      <td><?php echo date('d-m-Y',strtotime($pastRecord->leave_to_date)) ?></td>
					                      <td><?php echo $pastRecord->no_of_days; ?></td>
										  <td><?php echo $pastRecord->leave_type_name; ?></td>
					                      <td><?php echo $pastRecord->leave_reason; ?></td>
					                      <td><span class="<?php echo $statusclass; ?>" data-toggle="tooltip" title="<?php echo $statustoolTip; ?>"><?php echo $statusVal; ?></span></td>
					                      <td class="text-center">
					                      	<?php if($pastRecord->status==1){ ?>
					                      		<a href="<?=base_url()?>Employee/rejectLeave/<?=$pastRecord->id?>">
					                          	<button class="btn btn-danger">Reject</button>
					                          </a>
					                      	<?php }elseif($pastRecord->status==2){ ?>
					                      		<a href="<?=base_url()?>Employee/approveLeave/<?=$pastRecord->id?>">
					                          	<button class="btn btn-success">Approve</button>
					                          </a>
					                      	<?php }else{ ?>
					                      	  <a href="<?=base_url()?>Employee/approveLeave/<?=$pastRecord->id?>">
					                          	<button class="btn btn-success">Approve</button>
					                          </a>
					                          <a href="<?=base_url()?>Employee/rejectLeave/<?=$pastRecord->id?>">
					                          	<button class="btn btn-danger">Reject</button>
					                          </a>
					                      	<?php } ?>
					                          
					                      </td>
					                    </tr>
										<?php 
											}
										}else{ ?>
											<tr>
												<td colspan="6">No Records</td>
											</tr>
										<?php }				
										?>
									</tbody>
								</table>
								<div class="box-footer clearfix">
									<?php echo $this->pagination->create_links(); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('includes/footer');?> 
<style type="text/css">
td.text-center a button {
    padding: 3px 7px;
    font-size: 12px;
    margin: 2px 0;
}
</style>
<script>
$('[data-toggle="tooltip"]').tooltip();
</script> 