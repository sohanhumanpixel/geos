<div class="page-content">
	<div class="row">
	<?php $this->load->view('includes/left_sidebar');?>
	
	<div class="col-md-10">
			<div class="content-box-large">
				<div class="panel-heading">
					<div class="panel-title">
						<h3>Add New User</h3>
					</div>
					<div class="panel-options">
					  <a href="employee_list" class="btn btn-success">Go Back</a>
					</div>
				</div>
				<div class="panel-body">
					<div class='col-md-9'>
					<form action="<?php echo base_url() ?>Admin/addNewUser" name="addUser" id="addUser" method="post">
						<fieldset>
							<div class="form-group">
								<label>First Name<em>*</em></label>
								<input class="form-control" name="fname" id="fname" placeholder="Enter user's first name" type="text">
							</div>
							<div class="form-group">
								<label>Last Name<em>*</em></label>
								<input class="form-control" name="lname" id="lname" placeholder="Enter user's last name" type="text">
							</div>
							<div class="form-group">
								<label>Emil Address<em>*</em></label>
								<input class="form-control required email" name="email" id="email" placeholder="Enter user's email" type="text">
							</div>
							<div class="form-group">
								<label>Username<em>*</em></label>
						<input class="form-control" name="username" id="username" placeholder="Enter username" type="text">
							</div>
							<div class="form-group">
								<label>Password<em>*</em></label>
								<input type="password" class="form-control" name = "password" placeholder="Enter Password" id="password" />
							</div>
							<div class="form-group">
								<label>Confirm Password<em>*</em></label>
								<input type="password" class="form-control" name="cpassword" placeholder="Enter Confirm Password" id="cpassword"/>
							</div>
							<div class="form-group">
								<label for="role">Role</label>
                                        <select class="form-control required" id="role" name="role">
                                            <option value="">Select Role</option>
                                            <?php
                                            if(!empty($roles))
                                            {
                                                foreach ($roles as $rl)
                                                {
                                                    ?>
                                                    <option value="<?php echo $rl->roleId ?>"><?php echo $rl->role_name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
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
<script src="<?php echo base_url(); ?>assets/frontend/js/addUser.js" type="text/javascript"></script>
