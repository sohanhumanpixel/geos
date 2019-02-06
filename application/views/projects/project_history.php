<div class="page-content">
	<div class="row">
		<?php $this->load->view('includes/left_sidebar');?>
		<div class="col-md-10 padding-left-right">
			<div class="content-box-large">
				<div class="panel-heading">
					<div class="upper_head col-md-12">
						<h4 class="col-md-9"><?php //echo $clientInfo[0]->fname.' '.$clientInfo[0]->lname;?></h4>
						<div class="col-md-3">
						<a href="<?=base_url()?>Projects/selectTemplate/<?=$project_id?>"><button class="btn btn-info">Generate Job Brief</button></a>
						<a href="<?=$backUrl?>"><button class="btn btn-success pull-right">Back</button></a></div>
					</div>
					<div class="row">
						<ul class="nav nav-tabs">
							<li class="active"><a id="detail-tab" data-toggle="tab" href="#tasksTab" role="tab" aria-controls="detail" aria-selected="true">Tasks</a></li>
							<li><a id="tasks-tab" data-toggle="tab" href="#projecttaskstab" role="tab" aria-controls="tasks" aria-selected="false">Project Tasks</a></li>
							<li><a id="add_tasks-tab" data-toggle="tab" href="#addprojecttaskstab" role="tab" aria-controls="add_tasks" aria-selected="false">Add Project Tasks</a></li>
						</ul>
					</div>
				</div>
				<div class="panel-body">
					<div class="contanior_details">
					<?php
                    if($this->session->flashdata('success'))
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php }else if($this->session->flashdata('error')){ ?>
					<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
				<?php } ?>
						<div class="tab-content client-tab" id="myTabContent">
							<?php //echo "<pre>";print_r($projectHistory);echo "</pre>"; ?>
                           <div class="tab-pane fade in active" id="tasksTab" role="tabpanel" aria-labelledby="home-tab">
                           	<div class="row">
                           		<div class="col-md-12">
									<div class="header_billing col-md-12">
										<table style="width: 100%" class="compTaskTable">
											<tr>
												<td colspan="2"><strong> Completed Tasks</strong></td>
												<td colspan="4"><button id="showIncompTask" class="btn btn-danger pull-right"> Show Incomplete</button></td>
											</tr>
											<tr>
												<td><strong>Task Title</strong></td>
												<td><strong>Employee Name</strong></td>
												<td><strong>Schedule Date</strong></td>
												<td><strong>Status</strong></td>
												<td><strong>Comments</strong></td>
												<td><strong>Photos</strong></td>
											</tr>
											<?php 
											//echo "<pre>";print_r($projectHistory);echo "</pre>";
											if(!empty($projectHistory)){
											foreach($projectHistory as $prjV){ ?>
													<tr>
														<td class="openSub" data-id="<?=$prjV['emp_tId']?>" style="cursor: pointer;color: #045098;"><?=$prjV['title']?> <?=$prjV['abbr']?></td>
														<td><?=$prjV['employee_name']?></td>
														<td><?=date('d-m-Y',strtotime($prjV['schedule_date']))?></td>
														<td><?php if($prjV['partial_complete']==1 && $prjV['is_complete']==0){
															echo "Partially Complete";
														}else{
															echo "Completed";
														} ?></td>
														<td><a href="javascript:void(0)" class="show_comments" data-id="<?=$prjV['emp_tId']?>">View</a></td>
														<td><a href="javascript:void(0)" class="show_photos" data-id="<?=$prjV['emp_tId']?>">View</a></td>
													</tr>
													<?php
													$qu = $this->db->query("SELECT timesheet_id,task_id FROM employee_tasks WHERE id=".$prjV['emp_tId']);
											    	$re = $qu->result_array();
											    	$timesheet_id = $re[0]['timesheet_id'];
											    	$task_id = $re[0]['task_id'];
											    	$this->db->select("st.*,et.is_complete,et.id as empTaskId");
											        $this->db->from("subtasks as st");
											        $this->db->join('employee_tasks as et', 'st.id = et.task_id');
											        $this->db->where("st.task_id",$prjV['task_id']);
											        $this->db->where("et.parent_task",$task_id);
											        $this->db->where("et.timesheet_id",$timesheet_id);
											        $this->db->where("et.is_complete",1);
											        $query = $this->db->get();
											        $subres = $query->result_array(); 
											       // echo "<pre>";print_r($subres);echo "</pre>";
													foreach($subres as $subTs){
													 ?>
														<tr class="subts subts-<?=$prjV['emp_tId']?>" style="display: none;">
															<td class="text-right"><?=$subTs['title']?> <?=$subTs['abbr']?></td>
															<td class="text-right"><?=$prjV['employee_name']?></td>
															<td class="text-right"><?=date('d-m-Y',strtotime($prjV['schedule_date']))?></td>
															<td></td>
															<td><a href="javascript:void(0)" class="show_comments" data-id="<?=$subTs['empTaskId']?>">View</a></td>
															<td><a href="javascript:void(0)" class="show_photos" data-id="<?=$subTs['empTaskId']?>">View</a></td>
														</tr>
													<?php } ?>
												<?php }
											 }else{
											 	echo "<tr><td colspan=3>No Records</td></tr>";
											 } ?>
										</table>
										<table style="width: 100%; display: none;" class="incompTaskTable">
											<tr>
												<td colspan="2"><strong> Incompleted Tasks</strong></td>
												<td colspan="4"><button id="showcompTask" class="btn btn-success pull-right">Show Complete</button></td>
											</tr>
											<tr>
												<td><strong>Task Title</strong></td>
												<td><strong>Employee Name</strong></td>
												<td><strong>Schedule Date</strong></td>
												<td><strong>Comments</strong></td>
												<td><strong>Photos</strong></td>
											</tr>
											<?php 
											//echo "<pre>";print_r($incompProjects);echo "</pre>";
											if(!empty($incompProjects)){
											foreach($incompProjects as $incomprjV){ ?>
													<tr>
														<td class="openSub" data-id="<?=$incomprjV['emp_tId']?>" style="cursor: pointer;color: #045098;"><?=$incomprjV['title']?> <?=$incomprjV['abbr']?></td>
														<td><?=$incomprjV['employee_name']?></td>
														<td><?=date('d-m-Y',strtotime($incomprjV['schedule_date']))?></td>
														<td><a href="javascript:void(0)" class="show_comments" data-id="<?=$incomprjV['emp_tId']?>">View</a></td>
														<td><a href="javascript:void(0)" class="show_photos" data-id="<?=$incomprjV['emp_tId']?>">View</a></td>
													</tr>
													<?php
													$qu = $this->db->query("SELECT timesheet_id,task_id FROM employee_tasks WHERE id=".$incomprjV['emp_tId']);
											    	$re = $qu->result_array();
											    	$timesheet_id = $re[0]['timesheet_id'];
											    	$task_id = $re[0]['task_id'];
											    	$this->db->select("st.*,et.is_complete,et.id as empTaskId");
											        $this->db->from("subtasks as st");
											        $this->db->join('employee_tasks as et', 'st.id = et.task_id');
											        $this->db->where("st.task_id",$incomprjV['task_id']);
											        $this->db->where("et.parent_task",$task_id);
											        $this->db->where("et.timesheet_id",$timesheet_id);
											        $this->db->where("et.is_complete",0);
											        $query = $this->db->get();
											        $subres = $query->result_array(); 
											       // echo "<pre>";print_r($subres);echo "</pre>";
													foreach($subres as $subTs){
													 ?>
														<tr class="subts subts-<?=$incomprjV['emp_tId']?>" style="display: none;">
															<td class="text-right"><?=$subTs['title']?> <?=$subTs['abbr']?></td>
															<td class="text-right"><?=$incomprjV['employee_name']?></td>
															<td class="text-right"><?=date('d-m-Y',strtotime($incomprjV['schedule_date']))?></td>
															<td><a href="javascript:void(0)" class="show_comments" data-id="<?=$subTs['empTaskId']?>">View</a></td>
															<td><a href="javascript:void(0)" class="show_photos" data-id="<?=$subTs['empTaskId']?>">View</a></td>
														</tr>
													<?php } ?>
												<?php }
											 }else{
											 	echo "<tr><td colspan=3>No Records</td></tr>";
											 } ?>
										</table>
									</div> 
								</div>
                           	</div>
                           	<div class="row">
	                           	<div class="comment_section col-md-7" style="display: none;">
	                           		
	                           	</div>
	                        </div>
	                        <div class="row">
	                           	<div class="photos_section col-md-7" style="display: none;">
	                           		
	                           	</div>
	                        </div>
                           </div>
                           <div class="tab-pane fade" id="projecttaskstab" role="tabpanel" aria-labelledby="profile-tab">
                           		<div class="row">
	                           		<div class="col-md-12">
										<div class="header_billing col-md-12">
											<table style="width: 100%" class="compProjTaskTable">
												<tr>
													<td colspan="2"><strong> Completed Tasks</strong></td>
													<td colspan="4"><button id="showIncompProjTask" class="btn btn-danger pull-right"> Show Incomplete</button></td>
												</tr>
												<tr>
													<td><strong>Task Title</strong></td>
													<td><strong>Employee Name</strong></td>
													<td><strong>Schedule Date</strong></td>
													<td><strong>Comments</strong></td>
													<td><strong>Photos</strong></td>
												</tr>
												<?php 
												//echo "<pre>";print_r($projectHistory);echo "</pre>";
												if(!empty($compProjTasks)){
												foreach($compProjTasks as $prjV){ ?>
														<tr>
															<td class="openSub" data-id="<?=$prjV['emp_tId']?>" style="cursor: pointer;color: #045098;"><?=$prjV['title']?></td>
															<td><?=$prjV['employee_name']?></td>
															<td><?=date('d-m-Y',strtotime($prjV['schedule_date']))?></td>
															<td><a href="javascript:void(0)" class="show_proj_comments" data-id="<?=$prjV['emp_tId']?>">View</a></td>
															<td><a href="javascript:void(0)" class="show_proj_photos" data-id="<?=$prjV['emp_tId']?>">View</a></td>
														</tr>
													<?php }
												 }else{
												 	echo "<tr><td colspan=3>No Records</td></tr>";
												 } ?>
											</table>
											<table style="width: 100%; display: none;" class="incompProjTaskTable">
												<tr>
													<td colspan="2"><strong> Incompleted Tasks</strong></td>
													<td colspan="4"><button id="showcompProjTask" class="btn btn-success pull-right">Show Complete</button></td>
												</tr>
												<tr>
													<td><strong>Task Title</strong></td>
													<td><strong>Employee Name</strong></td>
													<td><strong>Schedule Date</strong></td>
													<td><strong>Comments</strong></td>
													<td><strong>Photos</strong></td>
												</tr>
												<?php 
												//echo "<pre>";print_r($incompProjTasks);echo "</pre>";
												if(!empty($incompProjTasks)){
												foreach($incompProjTasks as $incomprjV){ ?>
														<tr>
															<td class="openSub" data-id="<?=$incomprjV['emp_tId']?>" style="cursor: pointer;color: #045098;"><?=$incomprjV['title']?></td>
															<td><?=$incomprjV['employee_name']?></td>
															<td><?=date('d-m-Y',strtotime($incomprjV['schedule_date']))?></td>
															<td><a href="javascript:void(0)" class="show_proj_comments" data-id="<?=$incomprjV['emp_tId']?>">View</a></td>
															<td><a href="javascript:void(0)" class="show_proj_photos" data-id="<?=$incomprjV['emp_tId']?>">View</a></td>
														</tr>
													<?php }
												 }else{
												 	echo "<tr><td colspan=3>No Records</td></tr>";
												 } ?>
											</table>
										</div> 
									</div>
	                           	</div>
	                           	<div class="row">
	                           	<div class="comment_section col-md-7" style="display: none;">
	                           		
	                           	</div>
		                        </div>
		                        <div class="row">
		                           	<div class="photos_section col-md-7" style="display: none;">
		                           		
		                           	</div>
		                        </div>
							</div>
							<div class="tab-pane fade in" id="addprojecttaskstab" role="tabpanel" aria-labelledby="add_tasks-tab">
								<h3 class="col-md-6 col-md-offset-2">Add Tasks</h3>
								<form method="post" id="taskForm">
									<div class="row">
										<div class="col-md-6 col-md-offset-2">
											<!--<div class="form-group">
												<label>Select Employee<em>*</em></label>
												<select name="employee_id" class="form-control">
													<option value="">Select Employee</option>
													<?php foreach($employees as $employee){ ?>
														<option value="<?=$employee->id?>"><?=$employee->fname.' '.$employee->lname?></option>
													<?php } ?>
												</select>
											</div>-->
											<div class="form-group">
												<label>Name<em>*</em></label>
												<input type="text" name="task_title" class="form-control">
												<input type="hidden" name="project_id" value="<?=$projectInfo[0]->id?>">
											</div>
											<div class="form-group">
												<label>Description<em>*</em></label>
												<textarea name="task_content" class="form-control"></textarea>
											</div>
											<div class="form-group">
												<input class="btn btn-primary pull-right tasks_submit" type="submit" name="submit_tasks" value="Save">
											</div>
										</div>
									</div>
								</form>
								
									<h3 class="col-md-6 col-md-offset-2">Tasks history</h3>
									<?php if(!empty($tasks)){ ?>
									<?php foreach($tasks as $task){ ?>
										<div class="row tasks-row">
											<div class="col-md-6 col-md-offset-2 tasks-container">
												<div class="col-md-2 task-icon">
													<i class="fa fa-tasks" style="font-size: 34px; position: relative; top: 14px;color: #3c8dbc;"></i>
												</div>
												<div class="col-md-8 task-content">
													<h5><?=$task->title?></h5>
													<p><?php echo date('D, d M Y H:i'); ?>- Task added by <?=$task->full_name?></p>
													<p><?=$task->description?></p>
												</div>
												<?php if($adminAccess=='true'){ ?>
													<div class="col-md-2 task-action" data-id="<?=$task->id?>">
														<i class="fa fa-edit" data-title="Edit task" style="    color: #045098;" data-toggle="tooltip" title="Edit"></i>
														<i class="fa fa-trash" data-title="Delete task" data-toggle="tooltip" title="Delete" style="    color: #d82828;"></i>
													</div>
												<?php } ?>
											</div>
											<div class="col-md-6 col-md-offset-2 tasks-container-hidden" style="display: none;">
												<div class="col-md-2 task-icon">
													<i class="fa fa-tasks" style="font-size: 34px; position: relative; top: 14px;color: #3c8dbc;"></i>
												</div>
												<div class="col-md-8 task-content">
													<form method="post" class="editTaskForm edit_form_<?=$task->id?>">
													<!--<select name="edit_empid" class="form-control">
														<?php foreach($employees as $employee){ ?>
														<option value="<?=$employee->id?>" <?php if($task->employee_assigned==$employee->id){ echo "selected"; } ?>><?=$employee->fname.' '.$employee->lname?></option>
														<?php } ?>
													</select>-->
													<input type="text" name="edittask_title" class="form-control" value="<?=$task->title?>">
													<input type="hidden" name="edittask_id" value="<?=$task->id?>">
													<textarea name="edittask_content" class="form-control"><?=$task->description?></textarea>
													</form>
												</div>
												<?php if($adminAccess=='true'){ ?>
													<div class="col-md-2 task-action" data-id="<?=$task->id?>">
														<i class="fa fa-check" data-title="Save task" style="color: #2aa52a;" data-toggle="tooltip" title="Save"></i>
														<i class="fa fa-times" data-title="Cancel" data-toggle="tooltip" title="Cancel" style="    color: #d82828;"></i>
													</div>
												<?php } ?>
											</div>
										</div>
									<?php }
								}else{ ?>
									<div class="row tasks-row no-task">
										<div class="col-md-6 col-md-offset-2 tasks-container">
											<p>No Tasks</p>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Image Modal -->
<div id="photoTaskModal" class="modal modal-wide fade">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Task Photos</h4>
        </div>
         <div id="photoT"></div>
     </div>
    </div>
</div><!-- /.modal -->
<?php $this->load->view('includes/footer');?>
<style type="text/css">
.comment-view.col-md-12 {
    background: #e3e8ec;
    border-radius: 10px;
    padding: 6px 20px;
    margin: 3px 0px;
}

.comment-view.col-md-12 p {
    margin: 0;
}
img.pic_t {
    width: 100px;
    height: 75px;
    margin: 0 5px;
    border: 1px solid #a29494;
    padding: 2px;
    cursor: pointer;
}
img.pic_t:hover {
    opacity: 0.5;
}
.photo-view.col-md-12 {
    padding: 10px;
    background: #eee;
    border-radius: 10px;
    margin-bottom: 10px;
}
#photoT {
    padding: 5px;
}
</style>
<script src="<?php echo base_url(); ?>assets/frontend/js/jquery.validate.min.js" type="text/javascript"></script>
<script type="text/javascript">
	$( "#taskForm" ).validate({
		rules: {
			employee_id: "required",
			task_title: "required",
			task_content: "required",
			},
		messages: {
			employee_id: "Please select employee",
			task_title: "Please enter task name",
			task_content: "Please enter task description",
	    },
		submitHandler: function (form,e) {
			e.preventDefault();
		  	$(".tasks_submit").val('Saving...');
		  	$(".tasks_submit").attr('disabled','disabled');
		  	$.ajax({
		  		type: "POST",
				url: baseURL + "Projects/addTasksAjax",
				data: $(form).serialize(),
				success: function (response) {
					var responseA = JSON.parse(response);
					if(responseA.status=='success'){
						$(".tasks_submit").val('Save');
		  				$(".tasks_submit").removeAttr('disabled');
		  				$(form).find("input[type=text],select, textarea").val("");
		  				$("#addprojecttaskstab .tasks-row:nth-child(4)").before('<div class="row tasks-row"><div class="col-md-6 col-md-offset-2 tasks-container"><div class="col-md-2 task-icon"><i class="fa fa-tasks" style="font-size: 34px; position: relative; top: 14px;color: #3c8dbc;"></i></div><div class="col-md-8 task-content"><h5>'+responseA.task_title+'</h5><p>'+responseA.date+'- Note added by '+responseA.created_by+'</p><p>'+responseA.task_content+'</p></div><div class="col-md-2 task-action" data-id="'+responseA.task_id+'"><i class="fa fa-edit" data-title="Edit task" style="color: #045098;"></i><i class="fa fa-trash" data-title="Delete task" style="color: #d82828;"></i></div></div><div class="col-md-6 col-md-offset-2 tasks-container-hidden" style="display: none;"><div class="col-md-2 task-icon"><i class="fa fa-tasks" style="font-size: 34px; position: relative; top: 14px;color: #3c8dbc;"></i></div><div class="col-md-8 task-content"><form method="post" class="editTaskForm edit_form_'+responseA.task_id+'"><select name="edit_empid" class="form-control">'+responseA.empHtml+'</select><input type="text" name="edittask_title" class="form-control" value="'+responseA.task_title+'"><input type="hidden" name="edittask_id" value="'+responseA.task_id+'"><textarea name="edittask_content" class="form-control">'+responseA.task_content+'</textarea></form></div><div class="col-md-2 task-action" data-id="'+responseA.task_id+'"><i class="fa fa-check" data-title="Save task" style="color: #2aa52a;"></i><i class="fa fa-times" data-title="Cancel" style="    color: #d82828;"></i></div></div></div>');
		  				$(".row.no-task").remove();
					}else{
						$(".tasks_submit").val('Save');
		  				$(".tasks_submit").removeAttr('disabled');
		  				alert('Error!:'+responseA.msg);
					}
				 }
		  	})
		}
	})
	$(document).on('click','.task-action .fa-edit', function(){
		$(this).parents('.tasks-container').hide();
		$(this).parents('.tasks-container').siblings('.tasks-container-hidden').show();
	})
	$(document).on('click','.task-action .fa-times', function(){
		$(this).parents('.tasks-container-hidden').hide();
		$(this).parents('.tasks-container-hidden').siblings('.tasks-container').show();
	})
	$(document).on('click','.task-action .fa-trash', function(){
		var task_id = $(this).parent().data('id');
		var current_row = $(this).parents(".tasks-container");
		if(confirm("Are you sure to delete this task?")){
			$(this).parents(".tasks-container").css('opacity','0.5');
			$.ajax({
				type: "POST",
				url: baseURL + "Projects/deleteTasksAjax",
				data: {'task_id':task_id},
				success: function (response) {
					var responseA = JSON.parse(response);
					if(responseA.status=='success'){
						current_row.css('opacity','1');
						current_row.fadeTo("slow",0.7, function(){
				            $(this).remove();
				        })
					}else{
						current_row.css('opacity','1');
						alert('Error!:'+responseA.msg);
					}
				}
			})
		}
	})
	$(document).on('click','.task-action .fa-check', function(){
		var task_id = $(this).parent().data('id');
		$(this).parents(".tasks-container-hidden").css('opacity','0.5');
		$.ajax({
			type: "POST",
			url: baseURL + "Projects/saveTasksAjax",
			data: $('.edit_form_'+task_id).serialize(),
			success: function (response) {
				var responseA = JSON.parse(response);
				if(responseA.status=='success'){
					$('.edit_form_'+task_id).parents('.tasks-container-hidden').css('opacity','1');
					$('.edit_form_'+task_id).parents('.tasks-container-hidden').hide();
					$('.edit_form_'+task_id).parents('.tasks-container-hidden').siblings('.tasks-container').show();
					$('.edit_form_'+task_id).parents('.tasks-container-hidden').siblings('.tasks-container').find('.task-content h5').html(responseA.task_title);
					$('.edit_form_'+task_id).parents('.tasks-container-hidden').siblings('.tasks-container').find('.task-content p:nth-child(3)').html(responseA.task_content);
				}else{
					$('.edit_form_'+task_id).parents('.tasks-container-hidden').css('opacity','1');
					alert('Error!:'+responseA.msg);
				}
			}
		})
	})
	$(".openSub").click(function(){
		var id = $(this).data('id');
		$(".subts-"+id).toggle(500);
	})
	$(".show_comments").click(function(){
		var id = $(this).data('id');
		$(".photos_section").hide();
		$.ajax({
			type: "POST",
			url: baseURL + "Projects/ajax_getCommentsByTask",
			data: {emp_tId:id},
			success: function (response) {
				$('tr').css('background','unset');
				$(".show_comments[data-id="+id+"]").parents('tr').css('background','#ddd');
				var responseA = JSON.parse(response);
				if(responseA.status=='success'){
					$(".comment_section").html(responseA.msg).fadeIn(500);;
				}
			}
		})
	})
	$(".show_photos").click(function(){
		var id = $(this).data('id');
		$(".comment_section").hide();
		$.ajax({
			type: "POST",
			url: baseURL + "Projects/ajax_getPhotosByTask",
			data: {emp_tId:id},
			success: function (response) {
				$('tr').css('background','unset');
				$(".show_comments[data-id="+id+"]").parents('tr').css('background','#ddd');
				var responseA = JSON.parse(response);
				if(responseA.status=='success'){
					$(".photos_section").html(responseA.msg).fadeIn(500);
				}
			}
		})
	})
	$(".show_proj_comments").click(function(){
		var id = $(this).data('id');
		$(".photos_section").hide();
		$.ajax({
			type: "POST",
			url: baseURL + "Projects/ajax_getProjCommentsByTask",
			data: {emp_tId:id},
			success: function (response) {
				$('tr').css('background','unset');
				$(".show_proj_comments[data-id="+id+"]").parents('tr').css('background','#ddd');
				var responseA = JSON.parse(response);
				if(responseA.status=='success'){
					$(".comment_section").html(responseA.msg).fadeIn(500);;
				}
			}
		})
	})
	$(".show_proj_photos").click(function(){
		var id = $(this).data('id');
		$(".comment_section").hide();
		$.ajax({
			type: "POST",
			url: baseURL + "Projects/ajax_getProjPhotosByTask",
			data: {emp_tId:id},
			success: function (response) {
				$('tr').css('background','unset');
				$(".show_proj_comments[data-id="+id+"]").parents('tr').css('background','#ddd');
				var responseA = JSON.parse(response);
				if(responseA.status=='success'){
					$(".photos_section").html(responseA.msg).fadeIn(500);
				}
			}
		})
	})
	$(document).on("click",".pic_t",function(){
	    var src  = $(this).attr("src");
	    $('#photoT').html('<img src="'+src+'" class="img-responsive" width="100%">');
	    $("#photoTaskModal").modal("show");
	});
	$("#showIncompTask").click(function(){
		$(this).parents('table').hide();
		$(".comment_section").hide();
		$(".photos_section").hide();
		$(".incompTaskTable").show();
	})
	$("#showcompTask").click(function(){
		$(this).parents('table').hide();
		$(".comment_section").hide();
		$(".photos_section").hide();
		$(".compTaskTable").show();
	})
	$("#showIncompProjTask").click(function(){
		$('.compProjTaskTable').hide();
		$(".comment_section").hide();
		$(".photos_section").hide();
		$(".incompProjTaskTable").show();
	})
	$("#showcompProjTask").click(function(){
		$('.incompProjTaskTable').hide();
		$(".comment_section").hide();
		$(".photos_section").hide();
		$(".compProjTaskTable").show();
	})
</script>