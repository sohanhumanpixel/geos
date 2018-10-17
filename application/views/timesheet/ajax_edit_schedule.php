<?php
$scheduleId = $scheduleData[0]['id'];
$clientId = $scheduleData[0]['client_id'];
$project_id = $scheduleData[0]['project_id'];
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
			</div>
			<div class="form-group">
				 <label  for="editclientname">Client Name</label>
				 <select name="editclientname" id="editclientname" class="required form-control">
					<option value="">Select Client</option>
					<?php if(!empty($cliendata)){
						foreach($cliendata as $cval){
						?>
						<option value="<?php echo $cval['clientId']; ?>" <?php if($clientId==$cval['clientId']){?> selected = 'selected' <?php } ?>><?php echo $cval['fname'].' '.$cval['lname']; ?></option>
					<?php
						}
					} ?>
				 </select>
			</div>
			<div class="form-group edit_site_div" >
				<label>Site</label>
				<select name="editsitename" id="editsitename" class="required form-control">
					<option value="">Select Project</option>
					<?php 
					if(!empty($projectData)){
						foreach($projectData as $projval){ ?>
						<option value="<?php echo $projval['pId'];?>" <?php if($projval['pId']==$project_id){ ?> selected="selected" <?php } ?>><?php echo $projval['project_name']; ?></option>
					<?php 
						}
					} ?>
				</select>
			</div>
			 <div class="form-group">
				<label for="form8">Instructions</label>
				<textarea type="text" id="instructions" name="instructions" class="required form-control" rows="4" ><?php echo $scheduleData[0]['instructions']; ?></textarea>
			 </div>
        </div>
        <div class="modal-footer d-flex justify-content-center">
		  <button class="btn btn-danger deleteschedulebtn"> Delete </button>
          <button class="btn btn-success updatesubmiting" id="editsss"> Update </button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
		</form>
      </div>
</div>