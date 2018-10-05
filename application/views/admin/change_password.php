<div class="page-content">
	<div class="row">
	<?php 
	$this->load->view('includes/left_sidebar');
	?>
	
	<div class="col-md-9">
			<div class="content-box-large">
				<div class="panel-heading">
					<div class="panel-title">
						<h3><?=$title?></h3>
					</div>
					<?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="calert alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
					<div class="panel-options">
					  <a href="<?php echo base_url() ?>Profile" class="btn btn-success">Go Back</a>
					</div>
				</div>
				<div class="panel-body">
					<div class='col-md-9'>
					<form action="<?php echo base_url() ?>Profile/changePass" name="editUser" id="editUser" method="post">
						<fieldset>
							<div class="form-group">
								<label>Current Password<em>*</em></label>
								<input class="form-control" name="password" id="password" placeholder="Enter your current password" type="password" value="">
							</div>
							<div class="form-group">
								<label>New Password<em>*</em></label>
								<input class="form-control" name="new_pass" id="new_pass" placeholder="Enter your new password" type="password" value="">  
							</div>
							<div class="form-group">
								<label>Confirm New Password<em>*</em></label>
								<input class="form-control" name="confirm_pass" id="confirm_pass" placeholder="Enter new password again" type="password" value="" />
							</div>
						</fieldset>
						
						<div class="box-footer">
                            <input type="submit" class="btn btn-success" value="Change" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
					</form>
					</div>
					
					<div class="col-md-9">
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