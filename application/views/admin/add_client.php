<div class="page-content">
	<div class="row">
	<?php $this->load->view('includes/left_sidebar');?>
	
	<div class="col-md-9">
			<div class="content-box-large">
				<div class="panel-heading">
					<div class="panel-title">
						<h3><?=$title?></h3>
					</div>
					<div class="panel-options">
					  <a href="<?=base_url()?>client" class="btn btn-success">Go Back</a>
					</div>
				</div>
				<div class="panel-body">
					<div class='col-md-9'>
					<form action="<?php echo base_url() ?>Client/addAction" name="addClient" id="addClient" method="post">
						<fieldset>
							<div class="form-group">
								<label>First Name<em>*</em></label>
								<input class="form-control" name="fname" id="fname" placeholder="Enter client's first name" type="text">
							</div>
							<div class="form-group">
								<label>Last Name<em>*</em></label>
								<input class="form-control" name="lname" id="lname" placeholder="Enter client's last name" type="text">
							</div>
							<div class="form-group">
								<label>Email Address<em>*</em></label>
								<input class="form-control required email" name="email" id="email" placeholder="Enter client's email" type="text">
							</div>
							<div class="form-group">
								<label>Phone Number<em>*</em></label>
								<input class="form-control" name="phone" id="phone" placeholder="Enter client's phone number" type="text">
							</div>
						</fieldset>
						
						<div class="box-footer">
                            <input type="submit" class="btn btn-success" value="Submit" />
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
                <div class="alert alert-danger alert-dismissable ">
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
<script src="<?php echo base_url(); ?>assets/frontend/js/addClient.js" type="text/javascript"></script>
