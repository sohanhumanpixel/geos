<div class="page-content">
	<div class="row">
		<?php $this->load->view('includes/left_sidebar');?>
		<div class="col-md-10 padding-left-right">
			<div class="content-box-large">
				<div class="panel-heading">
					<div class="upper_head col-md-12">
						<h4 class="col-md-9"><?php echo $companyInfo[0]->company_name;?></h4>
						<div class="col-md-3">
						<a href="<?=base_url('Company')?>"><button class="btn btn-success pull-right">Back</button></a></div>
					</div>
					<div class="row">
						<?php //echo '<pre>'; print_r($companyInfo); echo '</pre>';?>
						<ul class="nav nav-tabs">
							<li class="active"><a id="detail-tab" data-toggle="tab" href="#detailtab" role="tab" aria-controls="detail" aria-selected="true">Details</a></li>
							<li><a id="tasks-tab" data-toggle="tab" href="#taskstab" role="tab" aria-controls="tasks" aria-selected="false">Tasks</a></li>
							<li><a id="notes-tab" data-toggle="tab" href="#notestab" role="tab" aria-controls="notes" aria-selected="false">Notes</a></li>
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
						<div class="tab-content company-tab" id="myTabContent">
                            <div class="tab-pane fade in active" id="detailtab" role="tabpanel" aria-labelledby="home-tab">
								<div class="row">
									<div class="col-md-5">
										<div class="col-md-12">
											<h4>Contact Details</h4>
											<div class="col-md-4">Phone</div>
											<div class="col-md-8"><?php echo $companyInfo[0]->company_phone; ?></div>
											<div class="col-md-4">Email</div>
											<div class="col-md-8"><?php echo $companyInfo[0]->company_email; ?></div>
											<div class="col-md-4">Wesite</div>
											<div class="col-md-8"><?php echo $companyInfo[0]->company_website; ?></div>
										</div>
										<div class="col-md-12 contacts">
											<div class="col-md-5 contact-head">
												<h4>Contacts</h4>
											</div>
											<div class="col-md-7 contact-add">
												<div class="right_left">
													<a href="javaScript:void(0);" class="add_contact"><i class="fa fa-plus"></i> Add Contact</a>
												</div>
											</div>
											<div class="row contactlist">
												<?php if(!empty($contacts)){
												foreach($contacts as $contact){ ?>
												<div class="contacts-list-row col-md-12">
													<h5 class="col-md-12"><?=$contact->fname.' '.$contact->lname?></h5>
													<p class="col-md-12"><?=$contact->phone?></p>
													<p class="col-md-12"><a href="mailto:<?=$contact->email?>"><?=$contact->email?></a></p>
												</div>
												<?php }
												}else{
													echo "No Contacts";
												} ?>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane fade" id="taskstab" role="tabpanel" aria-labelledby="profile-tab">
								<h3 class="col-md-6 col-md-offset-2">Add Tasks</h3>
								<form method="post" id="taskForm">
									<div class="row">
										<div class="col-md-6 col-md-offset-2">
											<div class="form-group">
												<label>Select Employee<em>*</em></label>
												<select name="employee_id" class="form-control">
													<option value="">Select Employee</option>
													<?php foreach($employees as $employee){ ?>
														<option value="<?=$employee->id?>"><?=$employee->fname.' '.$employee->lname?></option>
													<?php } ?>
												</select>
											</div>
											<div class="form-group">
												<label>Name<em>*</em></label>
												<input type="text" name="task_title" class="form-control">
												<input type="hidden" name="company_id" value="<?=$companyInfo[0]->id?>">
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
								<?php if(!empty($tasks)){ ?>
									<h3 class="col-md-6 col-md-offset-2">Tasks history</h3>
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
												<div class="col-md-2 task-action" data-id="<?=$task->id?>">
													<i class="fa fa-edit" data-title="Edit task" style="    color: #045098;" data-toggle="tooltip" title="Edit"></i>
													<i class="fa fa-trash" data-title="Delete task" data-toggle="tooltip" title="Delete" style="    color: #d82828;"></i>
												</div>
											</div>
											<div class="col-md-6 col-md-offset-2 tasks-container-hidden" style="display: none;">
												<div class="col-md-2 task-icon">
													<i class="fa fa-tasks" style="font-size: 34px; position: relative; top: 14px;color: #3c8dbc;"></i>
												</div>
												<div class="col-md-8 task-content">
													<form method="post" class="editTaskForm edit_form_<?=$task->id?>">
													<select name="edit_empid" class="form-control">
														<?php foreach($employees as $employee){ ?>
														<option value="<?=$employee->id?>" <?php if($task->employee_assigned==$employee->id){ echo "selected"; } ?>><?=$employee->fname.' '.$employee->lname?></option>
														<?php } ?>
													</select>
													<input type="text" name="edittask_title" class="form-control" value="<?=$task->title?>">
													<input type="hidden" name="edittask_id" value="<?=$task->id?>">
													<textarea name="edittask_content" class="form-control"><?=$task->description?></textarea>
													</form>
												</div>
												<div class="col-md-2 task-action" data-id="<?=$task->id?>">
													<i class="fa fa-check" data-title="Save task" style="color: #2aa52a;" data-toggle="tooltip" title="Save"></i>
													<i class="fa fa-times" data-title="Cancel" data-toggle="tooltip" title="Cancel" style="    color: #d82828;"></i>
												</div>
											</div>
										</div>
									<?php }
								} ?>
							</div>
							<div class="tab-pane fade" id="notestab" role="tabpanel" aria-labelledby="profile-tab">
								<h3 class="col-md-6 col-md-offset-2">Add Notes</h3>
								<form method="post" id="notesForm">
									<div class="row">
										<div class="col-md-6 col-md-offset-2">
											<div class="form-group">
												<label>Title<em>*</em></label>
												<input type="text" name="note_title" class="form-control">
												<input type="hidden" name="company_id" value="<?=$companyInfo[0]->id?>">
											</div>
											<div class="form-group">
												<label>Content<em>*</em></label>
												<textarea name="note_content" class="form-control"></textarea>
											</div>
											<div class="form-group">
												<input class="btn btn-primary pull-right notes_submit" type="submit" name="submit_note" value="Save">
											</div>
										</div>
									</div>
								</form>
								<?php if(!empty($notes)){ ?>
									<h3 class="col-md-6 col-md-offset-2">Notes history</h3>
									<?php foreach($notes as $note){ ?>
										<div class="row notes-row">
											<div class="col-md-6 col-md-offset-2 notes-container">
												<div class="col-md-2 note-icon">
													<i class="fa fa-tag" style="font-size: 34px; position: relative; top: 14px;color: #3c8dbc;"></i>
												</div>
												<div class="col-md-8 note-content">
													<h5><?=$note->note_title?></h5>
													<p><?php echo date('D, d M Y H:i'); ?>- Note added by <?=$note->full_name?></p>
													<p><?=$note->note_content?></p>
												</div>
												<div class="col-md-2 note-action" data-id="<?=$note->id?>">
													<i class="fa fa-edit" data-title="Edit note" data-toggle="tooltip" title="Edit" style="    color: #045098;"></i>
													<i class="fa fa-trash" data-title="Delete note" data-toggle="tooltip" title="Delete" style="    color: #d82828;"></i>
												</div>
											</div>
											<div class="col-md-6 col-md-offset-2 notes-container-hidden" style="display: none;">
												<div class="col-md-2 note-icon">
													<i class="fa fa-tag" style="font-size: 34px; position: relative; top: 14px;color: #3c8dbc;"></i>
												</div>
												<div class="col-md-8 note-content">
													<form method="post" class="editNotesForm edit_form_<?=$note->id?>">
													<input type="text" name="edit_title" class="form-control" value="<?=$note->note_title?>">
													<input type="hidden" name="edit_id" value="<?=$note->id?>">
													<textarea name="edit_content" class="form-control"><?=$note->note_content?></textarea>
													</form>
												</div>
												<div class="col-md-2 note-action" data-id="<?=$note->id?>">
													<i class="fa fa-check" data-title="Save note" data-toggle="tooltip" title="Save" style="color: #2aa52a;"></i>
													<i class="fa fa-times" data-title="Cancel" data-toggle="tooltip" title="Cancel" style="    color: #d82828;"></i>
												</div>
											</div>
										</div>
									<?php }
								} ?> 
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="addContactModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	  <form action="<?php echo base_url() ?>Company/addCompanyContact" name="addClient" id="addClient" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Contact</h4>
        </div>
        <div class="modal-body opacity-add">
			<div class="form-group">
				<label data-error="wrong" data-success="right" for="form2">First Name</label>
				<input class="form-control" name="fname" id="fname" placeholder="Enter contact first name" type="text">
				<input type="hidden" id="client_id" name="client_id" value="<?php echo $companyInfo[0]->id; ?>" class="form-control validate" readonly />
			</div>
			<div class="form-group site_div" >
				<label>Last Name<em>*</em></label>
				<input class="form-control" name="lname" id="lname" placeholder="Enter client's last name" type="text">
			</div>
			<div class="form-group tasks_div" >
				<label>Email Address<em>*</em></label>
				<input class="form-control required email" name="email" id="email" placeholder="Enter client's email" type="text">
			</div>
			<div class="form-group">
				<label>Phone Number<em>*</em></label>
				<input class="form-control" name="phone" id="phone" placeholder="Enter client's phone number" type="text">
			</div>
        </div>
        <div class="modal-footer d-flex justify-content-center">
            <button class="btn btn-success submiting"> Add </button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
		</form>
      </div>
      
    </div>
  </div>


<?php $this->load->view('includes/footer');?>
<style>
.head_left {
    float: left;
    width: 46%;
}
.right_left{
	float: left;
    width: 54%;
}
</style>
<script src="<?php echo base_url(); ?>assets/frontend/js/jquery.validate.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery-ui.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/client_company.js" charset="utf-8"></script>