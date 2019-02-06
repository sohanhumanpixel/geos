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
					  <a href="<?php echo base_url(); ?>TaskList" class="btn btn-success">Back to Task List</a>
					  <a href="<?php echo base_url(); ?>TaskList/addsub/<?=$taskID?>" class="btn btn-success">Add New Subtask</a>
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
								<th><span>Subtask Title</span></th>
								<th><span>Under Task</span></th>
								<th><span>Fixed Price(AUD$)</span></th>
								<th><span>Hourly Rate(AUD$/hr)</span></th>
								<th><span>Created By</span></th>
								<th>Action</th>
								</tr>
							</thead>
							<tbody>
					
							<?php
                    if(!empty($subtasks))
                    {
                        foreach($subtasks as $subtask)
                        {
                    ?>	
					<tr>
                      <td><?php echo $subtask->title.' '.$subtask->abbr ?></td>
                      <td><?php echo $subtask->taskTitle.' '.$subtask->taskAbbr ?></td>
                      <td><?php echo $subtask->fixed_price ?></td>
                      <td><?php echo $subtask->hourly_rate ?></td>
                      <td><?php echo $subtask->firstname.' '.$subtask->lastname ?></td>
                      <td>
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'TaskList/editsub/'.base64_encode(convert_uuencode($subtask->id)); ?>"><i class="glyphicon  glyphicon-pencil"></i></a>
                          <a class="btn btn-sm btn-danger deleteSubTask" href="javaScript:void(0);" data-id="<?php echo $subtask->id; ?>"><i class="glyphicon  glyphicon-trash"></i></a>
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
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/common.js" charset="utf-8"></script>