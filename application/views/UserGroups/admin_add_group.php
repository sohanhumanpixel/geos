<div class="page-content">
	<div class="row">
	<?php $this->load->view('includes/left_sidebar');?>
	
	<div class="col-md-10">
			<div class="content-box-large">
				<div class="panel-heading">
					<div class="panel-title">
						<h3>Add New Group</h3>
					</div>
					<div class="panel-options">
					  <a href="<?php echo base_url() ?>UserGroups/grouplist" class="btn btn-success">Go Back</a>
					</div>
				</div>
				<div class="panel-body">
					<div class='col-md-9'>
					<form action="<?php echo base_url() ?>UserGroups/addNewGroup" name="addGroup" id="addGroup" method="post">
						<fieldset>
							<div class="form-group">
								<label>Group Name<em>*</em></label>
								<input class="form-control" name="group_name" id="group_name" placeholder="Enter Group name" type="text">
							</div>
							
						</fieldset>
						<div class="box-footer">
                            <input type="submit" class="btn btn-success" value="Submit" />
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
<script src="<?php echo base_url(); ?>assets/frontend/js/jquery.validate.min.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
	$( "#addGroup" ).validate({
				rules: {
				group_name: {
  					required: true
  				},
				},
				messages: {
					group_name: "Please enter group name",

			  }
			});
});
</script>
