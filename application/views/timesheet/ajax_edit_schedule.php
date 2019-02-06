<?php
$scheduleId = $scheduleData[0]['id'];
$clientId = $scheduleData[0]['client_id'];
$project_id = $scheduleData[0]['project_id'];
$task_ids = explode(',', $scheduleData[0]['task_ids']);
$subtask_ids = explode(',', $scheduleData[0]['subtask_ids']);
$project_task_ids = explode(',', $scheduleData[0]['project_task_ids']);
$cNameQu = $this->db->query("SELECT company_name FROM companies WHERE id=$clientId");
$clientName = $cNameQu->result_array();
$pNameQu = $this->db->query("SELECT project_name FROM projects WHERE id=$project_id");
$projectName = $pNameQu->result_array();
?>
<div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
	  <form name="edittimesheet" id="edittimesheet" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Schedule</h4>
        </div>
        <div class="modal-body opacity-add">
			<div class="alert alert-success" style="display:none">
				<strong>Success!</strong> Indicates a successful or positive action.
			</div>
			<div class="alert alert-danger" style="display:none">
				Indicates a dangerous or potentially negative action.
			</div>
		<div class="md-form mb-5">
                <label>Selected Employee:</label>
				<span class="empname">
					<?php echo $scheduleData[0]['emplyeename']; ?>
				</span>
          </div>
			<div class="form-group">
				<label data-error="wrong" data-success="right" for="form2">Booking Date</label>
				<input type="text" id="editbookingtime" name="editbookingtime" class="required form-control" value="<?php echo $scheduleData[0]['schedule_date']; ?>" readonly />
				<input type="hidden" id="schedule_id" name="schedule_id" class="form-control validate" readonly value="<?php echo $scheduleId; ?>" />
				<input type="hidden" id="project_type_id" name="project_type_id" class="form-control validate" value="<?php echo $scheduleData[0]['project_type_id']; ?>" readonly />
				<input type="hidden" id="editeid" name="emp_id" value="<?php echo $empId;?>" class="form-control validate" readonly />
			</div>
			<div class="form-group">
				 <label  for="client">Client Name</label>
				 <input type="text" name="editclient" class="form-control" id="editclient" value="<?=$clientName[0]['company_name']?>">
				 <input type="hidden" name="editclientname" id="editclientname" value="<?=$clientId?>">
			</div>
			<div class="form-group ptype_div" >
				<label for="ptype">Project Type</label>
				<select class="form-control" name="project_type_id" id="ptype">
					<option>Type of Project</option>
					<?php foreach($ptypedata as $ptypeVal){ ?>
						<option value="<?=$ptypeVal->id?>" <?php if($ptypeVal->id==$scheduleData[0]['project_type_id']){ echo "selected"; } ?>><?=$ptypeVal->project_type_name?></option>
					<?php } ?>
				</select>
			</div>
			<div class="form-group edit_site_div" >
				<label for="site">Site Name</label>
				<input type="text" name="editsite" class="form-control" id="editsite" value="<?=$projectName[0]['project_name']?>">
				<input type="hidden" name="editsitename" id="editsitename" value="<?=$project_id?>">
			</div>
			<div class="form-group tasks_div" >
				<label>Tasks</label>
					<div>
					<?php if(!empty($taskData)){
						
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
						
						foreach($project_tasks as $project_task){ ?>
							<input name="proj_task_ids[]" type="checkbox" value="<?=$project_task['id']?>" <?php if(in_array($project_task['id'], $project_task_ids)){ echo "checked"; } ?>><?=$project_task['title']?>
						 <?php }
					}else{
						echo "No Project Tasks";
					} ?>
				</div>
				</div>
				<div class="form-group " >
					<input type="checkbox" name="all_day" id="editall_day" <?php if($scheduleData[0]['all_day']==1){ echo "checked"; } ?>>
					<label for="all_day">All Day Job</label>
				</div>
				<div class="form-group " >
				<label>Status</label>
				<select name="status" class="form-control">
					<option>Select Status</option>
					<?php
					foreach($scheduleStatus as $stat){ ?>
						<option value="<?=$stat->id?>" <?php if($stat->id==$scheduleData[0]['status_id']){ echo "selected"; } ?>><?=$stat->status?></option>
					<?php }
					?>
				</select>
			</div>
			 <div class="form-group">
				<label for="form8">Instructions</label>
				<textarea type="text" id="instructions" name="instructions" class="required form-control" rows="4" ><?php echo $scheduleData[0]['instructions']; ?></textarea>
			 </div>
			</div>
        <div class="modal-footer d-flex justify-content-center">
		  <a href="javaScript:void(0)" class="btn btn-danger deleteschedulebtn" data-id="<?php echo $scheduleData[0]['id']; ?>"> Delete </a>
          <button class="btn btn-success updatesubmiting" id="editsss"> Update </button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
		</form>
      </div>
</div>