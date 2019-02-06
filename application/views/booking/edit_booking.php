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
					  <a href="<?=base_url()?>booking" class="btn btn-success">Go Back</a>
					</div>
				</div>
				<div class="panel-body">
					<div class="col-md-9">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable ">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
					<div class='col-md-9'>
					<form action="<?php echo base_url() ?>booking/editAction" name="editBooking" id="addBooking" method="post">
						<fieldset>
							<div class="form-group">
								<label>Company Name<em>*</em></label>
								<select name="company" id="company" class="form-control">
									<option value="">Select Company</option>
									<?php foreach($companies as $company){ ?>
										<option value="<?=$company->id?>" <?php if($company->id==$bookingData[0]->company_id){ echo "selected"; } ?>><?=$company->company_name?></option>
									<?php } ?>
								</select>
								<input type="hidden" name="booking_id" value="<?=$bookingData[0]->id?>">
							</div>
							<div class="form-group">
								<label>Contact Name</label>
								<select name="contact" id="contact" class="form-control">
									<option value="">Select Contact</option>
									<?php foreach($contacts as $contact){ ?>
										<option value="<?=$contact->id?>" <?php if($contact->id==$bookingData[0]->contact_id){ echo "selected"; } ?>><?=$contact->fname.' '.$contact->lname?></option>
									<?php } ?>
								</select>
							</div>
							<?php //echo "<pre>";echo "ssss";print_r($projects);echo "</pre>"; ?>
							<div class="form-group">
								<label>Project Name<em>*</em></label>
								<select name="project" id="project" class="form-control">
									<option value="">Select Project</option>
									<?php foreach($projects as $project){ ?>
										<option value="<?=$project->id?>" <?php if($project->id==$bookingData[0]->project_id){ echo "selected"; } ?>><?=$project->project_name?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group tasks_div">
								<label>Tasks</label>
								<div>
								<?php if(!empty($taskData)){
									$task_ids = explode(',', $bookingData[0]->task_ids);
									$subtask_ids = explode(',', $bookingData[0]->subtask_ids);
									foreach($taskData as $taskVal){ ?>
										<input type="checkbox" name="task_ids[]" class="t_<?=$taskVal['id']?>" value="<?=$taskVal['id']?>" <?php if(in_array($taskVal['id'], $task_ids)){ echo "checked"; } ?>><?=$taskVal['title']?> <?=$taskVal['abbr']?>
										<br><span class="st_space"></span>
										<?php
										$subtaskQu = $this->db->query("SELECT id,title,abbr FROM subtasks WHERE task_id=".$taskVal['id']." and is_deleted=0");
									 	$subtasks = $subtaskQu->result_array();
									 	foreach($subtasks as $subtask){ ?>
									 		<input name="subtask_ids[]" class="st_<?=$taskVal['id']?>" type="checkbox" data-parent="<?=$taskVal['id']?>" value="<?=$subtask['id']?>" <?php if(in_array($subtask['id'], $subtask_ids)){ echo "checked"; } ?>><?=$subtask['title'].' '.$subtask['abbr'];?>
									 	<?php }
									 	echo "<br>";
									 }
								}else{
									echo "No Tasks";
								} ?>
								</div>
								<label class="pjt_label">Project Tasks</label>
								<div>
								<?php
								if(!empty($project_tasks)){ 
									$project_task_ids = explode(',', $bookingData[0]->project_task_ids);
									foreach($project_tasks as $project_task){ ?>
										<input name="proj_task_ids[]" type="checkbox" value="<?=$project_task['id']?>" <?php if(in_array($project_task['id'], $project_task_ids)){ echo "checked"; } ?>><?=$project_task['title']?>
									 <?php }
								}else{
									echo "No Project Tasks";
								} ?>
							</div>
							</div>
							<div class="form-group col-md-6">
								<label>Preferred Date<em>*</em></label>
								<div class='input-group date' id='datetimepicker1'>
				                    <input type='text' name="pfrd_date" id="pfrd_date" class="form-control" value="<?=$bookingData[0]->pfrd_date?>" />
				                    <span class="input-group-addon">
				                        <span class="glyphicon glyphicon-calendar"></span>
				                    </span>
				                </div>
							</div>
							<div class="form-group col-md-5 col-md-offset-1">
								<label>Estimated Time<em>*</em></label>
								<input type="text" name="est_time" id="est_time" value="<?=$bookingData[0]->est_time?>" class="form-control">
							</div>
							<div class="form-group col-md-6">
								<input type="checkbox" name="must_done" id="must_done" <?php if($bookingData[0]->must_done==1){ echo "checked"; } ?> >
								<label for="must_done">Must be done on this date</label>
							</div>
							<div class="form-group col-md-5 col-md-offset-1">
								<input type="checkbox" name="all_day" id="all_day" <?php if($bookingData[0]->all_day==1){ echo "checked"; } ?>>
								<label for="all_day">All Day Job</label>
							</div>
							<div class="form-group">
								<label>Instructions<em>*</em></label>
								<textarea name="instructions" class="form-control"><?=$bookingData[0]->instructions?></textarea>
							</div>
						</fieldset>
						
						<div class="box-footer">
                            <input type="submit" class="btn btn-success" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
					</form>
					</div>
				</div>
			</div>
		</div>
	
	</div>
</div>
<?php $this->load->view('includes/footer');?>
<style type="text/css">
.form-group.col-md-6, .form-group.col-md-5 {
    padding: 0;
}
input[name="task_ids[]"], input[name="proj_task_ids[]"],input[name="subtask_ids[]"] {
    margin: 5px;
    position: relative;
    top: 1px;
}
.pjt_label{
	margin-top: 10px;
}
span.st_space {
    margin: 0 10px;
}
</style>
<!--<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/jquery.timepicker.css">-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/daterangepicker.css" />
<!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery.timepicker.min.js"></script>-->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery-ui.js" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>assets/frontend/js/jquery.validate.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/common.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/daterangepicker.js" charset="utf-8"></script>
<script type="text/javascript">
	//$('#pfrd_time').timepicker();
	$('#pfrd_date').daterangepicker({
		singleDatePicker: true,
		opens: 'left',
		locale: {
			format: 'Y-M-D'
			}
	});
</script>