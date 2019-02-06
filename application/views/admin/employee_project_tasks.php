<div class="page-content">
	<div class="row">
		<?php $this->load->view('includes/left_sidebar');?> 
		<div class="col-md-10 padding-left-right">
			<div class="content-box-large">
				<div class="panel-heading">
					<div class="panel-title">
						<h3><?=$title?></h3>
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
                <?php 
                foreach($taskLists as $key => $taskList){
                	$tId = $taskList->task_id;
					$q = $this->db->query("SELECT id, title FROM tasks_project WHERE id=$tId");
					$r = $q->result_array();
					$taskLists[$key]->task_names = $r[0]['title'];
				}
				//echo "<pre>"; print_r($taskLists);echo "</pre>";
                ?>
						<table class="table user-list">
							<thead>
								<tr>
									<th><span>Task Assigned</span></th>
									<th><span>Under Project</span></th>
									<th><span>Schedule Date</span></th>
									<th><span>Assigned By</span></th>
									<th><span>Status</span></th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
							<?php if(!empty($taskLists)){
							foreach($taskLists as $taskList){ ?>
								<tr>
									<td><?=$taskList->task_names?></td>
									<td><?=$taskList->project_name?></td>
									<td><?=$taskList->schedule_date?></td>
									<td><?=$taskList->creator_name?></td>
									<td><?php if($taskList->is_complete==1){
										echo "<span style='color:green;'>Complete</span>";
									}elseif($taskList->is_complete==0 && $taskList->start_task==1){
										echo "<span style='color:#0171ff;animation: blink 1s linear infinite;'>Task in Progress</span>";
									}else{
										echo "<span style='color:red;'>Incomplete</span>";
									} ?></td>
									<td>
										<a href="<?=base_url('Employee/projTaskView/'.base64_encode(convert_uuencode($taskList->task_id)).'/'.base64_encode(convert_uuencode($taskList->id)))?>">
											<button class="btn btn-success">View</button>
										</a>
									</td>
								</tr>
							<?php } ?>
								
							<?php }else{ ?>
								<tr>
									<td colspan="2">No Tasks</td>
								</tr>
							<?php } ?>
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
<style type="text/css">
	@keyframes blink{
	0%{opacity: 1;}
	50%{opacity: .5;}
	100%{opacity: 1;}
	}
</style>
<?php $this->load->view('includes/footer');?> 