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
					  <a href="<?php echo base_url() ?>Employee/skills" class="btn btn-success">Go Back</a>
					</div>
				</div>
				<div class="panel-body">
					<div class='col-md-9'>
					<form action="<?php echo base_url() ?>Employee/addSkillAction" name="addSkill" id="addSkill" method="post">
						<fieldset>
							<div class="form-group">
								<label>Skill Name<em>*</em></label>
								<input class="form-control" name="skill_name" id="skill_name" placeholder="Enter Skill name" type="text">
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
<?php $this->load->view('includes/footer');?> 
<script src="<?php echo base_url(); ?>assets/frontend/js/jquery.validate.min.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
	$( "#addSkill" ).validate({
		rules: {
			"skill_name": {
				required: true
			},
		},
		messages: {
			"skill_name": "Please enter skill name",
        }
	});
});
</script>
