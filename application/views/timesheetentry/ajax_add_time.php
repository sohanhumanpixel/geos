<div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
	  <form name="addTimeEntry" id="addTimeEntry" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Time</h4>
        </div>
        <div class="modal-body opacity-add">
			<div class="alert alert-success" style="display:none">
				<strong>Success!</strong> Indicates a successful or positive action.
			</div>
		<div class="form-group">
                <label>Staff Information:</label>
				<span class="empname">
					<?php echo $userData[0]['fname'].' '.$userData[0]['lname']; ?>
				</span>
				<input type="hidden" id="emp_id" name="user_id" class="form-control validate" readonly value="<?php echo $userData[0]['userid']; ?>" />
          </div>
		  
		  <div class="form-group">
			<div class="row">
				<div class="col-sm-4">
					<label for="">Date</label>
					<input type="text"  class="form-control" name="start_date" id= "start_date" autocomplete ="off" />
				</div>
				<div class="col-sm-3">
					<label for="">Start Time</label>
					<input type="text" class="form-control" name="from_time" id= "from_time" placeholder = "12:00" />
				</div>
				<div class="col-sm-3">
					<label for="">Finish Time</label>
					<input type="text" class="form-control" name="to_time" id= "to_time" placeholder = "12:00" />
				</div>
			</div>
			</div>
			<div class="form-group">
				 <label  for="client">Client Name</label>
				 <input type="text" name="client" class="form-control required" id="client">
				 <input type="hidden" name="clientname" id="clientname">
			</div>

			<div class="form-group site_div" >
				<label for="site">Project</label>
				<input type="text" name="site" class="form-control required" id="site" disabled>
				<input type="hidden" name="sitename" id="sitename">
			</div>
			<div class="form-group tasks_div" >
				<label class = 'loading_tasks' style="display:none;">Loading...</label>
			</div>
			<!--<div class="form-group edit_site_div" >
				<label>Project<em>*</em></label>
				<select name="project_id" id="project_id" class="required form-control">
					<option value="">Select Project</option>
					<?php 
					if(!empty($projectData)){
						foreach($projectData as $projval){ ?>
						<option value="<?php echo $projval['pId'];?>" ><?php echo $projval['project_name']; ?></option>
					<?php 
						}
					} ?>
				</select>
			</div>
			<div class="form-group">
				 <label  for="editclientname">Task</label>
				 <select name="task_id" id="task_id" class="required form-control" disabled>
					<option value="">Select Client</option>
				 </select>
			</div>-->
			 <div class="form-group">
				<label for="form8">Note</label>
				<textarea type="text" id="note_text" name="note_text" class="required form-control" rows="4" ></textarea>
			 </div>
			<div class="alert alert-danger" style="display:none">
				Indicates a dangerous or potentially negative action.
			</div>
        </div>
        
        <div class="modal-footer d-flex justify-content-center">
          <button class="btn btn-success updatesubmiting" id="addtimebtnajax"> Save </button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
		</form>
      </div>
</div>