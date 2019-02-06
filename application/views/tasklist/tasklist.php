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
					  <a href="<?php echo base_url(); ?>TaskList/add" class="btn btn-success">Add New Task</a>
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
								<th><span>Task Title</span></th>
								<th><span>Subtasks</span></th>
								<th><span>Fixed Price(AUD$)</span></th>
								<th><span>Hourly Rate(AUD$/hr)</span></th>
								<th><span>Created By</span></th>
								<th>Action</th>
								</tr>
							</thead>
							<tbody>
					
							<?php
                    if(!empty($tasks))
                    {
                        foreach($tasks as $task)
                        {
                    ?>	
					<tr>
                      <td><?php echo $task->title; ?> <?php echo $task->abbr; ?></td>
                      <td><?php echo '<a href="'.base_url().'TaskList/sub/'.base64_encode(convert_uuencode($task->id)).'">'.$this->task_list->subTaskCount('',$task->id).'</a>'; ?></td>
                      <td><?php echo $this->task_list->addFixedPrice($task->id) ?></td>
                      <td><?php echo $this->task_list->addHourlyRatePrice($task->id) ?></td>
                      <td><?php echo $task->firstname.' '.$task->lastname; ?></td>
                      <td>
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'TaskList/edit/'.base64_encode(convert_uuencode($task->id)); ?>"><i class="glyphicon  glyphicon-pencil"></i></a>
                          <a class="btn btn-sm btn-danger deleteTask" href="javaScript:void(0);" data-id="<?php echo $task->id; ?>"><i class="glyphicon  glyphicon-trash"></i></a>
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