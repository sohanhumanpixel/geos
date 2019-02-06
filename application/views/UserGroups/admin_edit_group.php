<div class="page-content">
	<div class="row">
	<?php $this->load->view('includes/left_sidebar');
	
	$SegmentArray = $this->uri->segment_array();
	$emplIds = array();
	if(!empty($employeeIds)){
		$emplIds = array_map (function($value){
					return $value->user_id;
		} , $employeeIds);
	}
	?>
	
	<div class="col-md-10 padding-left-right">
			<div class="content-box-large">
				<div class="panel-heading">
					<div class="panel-title">
						<h3>Edit Group</h3>
					</div>
					<div class="panel-options">
					  <a href="<?php echo base_url() ?>UserGroups/grouplist" class="btn btn-success">Go Back</a>
					</div>
				</div>
				<div class="panel-body">
					<div class='col-md-9'>
					<form action="<?php echo base_url() ?>UserGroups/editGroup/<?php echo $SegmentArray[3]; ?>" name="editGroup" id="editGroup" method="post">
						<fieldset>
							<div class="form-group">
								<label>Group Name<em>*</em></label>
								<input class="form-control" name="group_name" id="group_name" placeholder="Enter Group name" type="text" value="<?php echo $groupInfo[0]->group_name;?>" />
							</div>
							<div class="form-group">
								<label>Select Employees<em>*</em></label>
								<select name="group_emp[]" class="form-control group_emp" data-placeholder="Select Employees" multiple>
									<?php foreach($allEmployees as $employee){ ?>
										<option value="<?=$employee->id?>" <?php if(in_array($employee->id, $emplIds)){ echo "selected"; } ?>><?=$employee->fname.' '.$employee->lname?></option>
									<?php } ?>
								</select>
							</div>
						</fieldset>
						<div class="box-footer">
                            <input type="submit" class="btn btn-success" value="Submit" name="group_upate" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
					</form>
					</div>
					
					<div class="col-md-4">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
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
					
				</div>
			</div>
		</div>
	
	</div>
</div>
<?php $this->load->view('includes/footer');?> 
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/chosen/chosen.css">
<script src="<?php echo base_url(); ?>assets/frontend/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/frontend/chosen/chosen.jquery.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
	$( "#addGroup" ).validate({
		rules: {
			"group_name": {
				required: true
			},
			"group_emp[]": {
				required: true
			},
		},
		messages: {
			"group_name": "Please enter group name",
			"group_emp[]" : "Please select employees",
        }
	});
	$(".group_emp").chosen();
});
</script>
