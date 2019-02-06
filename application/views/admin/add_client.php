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
							<div class="form-group">
								<label>Company Name<em>*</em></label>
								<input type="text" name="client" class="form-control" id="client" placeholder="Enter Company name">
				 				<input type="hidden" name="client_name" id="clientname">
							</div>
							<div class="form-group">
								<label>Notes</label>
								<textarea id="notes" name="notes" rows="8" class="form-control"></textarea>
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
<div class="modal fade" id="CompanyAddModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	  <form action="<?php echo base_url() ?>Company/addAction" name="addCompany" id="addCompany" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add New Company</h4>
        </div>
        <div class="modal-body">
        	<fieldset>
	        	<div class="form-group">
					<label>Company Name<em>*</em></label>
					<input class="form-control required" name="cname" id="cname" placeholder="Enter company name" type="text">
				</div>
				<div class="form-group">
					<label>Company Owner<em>*</em></label>
					<input class="form-control required" name="cowner" id="cowner" placeholder="Enter company owner name" type="text">
				</div>
				<div class="form-group">
					<label>Company Website</label>
					<input class="form-control" name="cweb" id="cweb" placeholder="Enter company website" type="text">
				</div>
				<div class="form-group">
					<label>Email Address<em>*</em></label>
					<input class="form-control required email" name="cemail" id="cemail" placeholder="Enter company email" type="text">
				</div>
				<div class="form-group">
					<label>Phone Number</label>
					<input class="form-control" name="cphone" id="cphone" placeholder="Enter company phone number" type="text">
				</div>
				<div class="form-group">
					<label>Notes</label>
					<textarea id="notes" name="notes" rows="8" class="form-control"></textarea>
				</div>
			</fieldset>
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
<script src="<?php echo base_url(); ?>assets/frontend/js/jquery.validate.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/jquery-ui.css">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery-ui.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/common.js" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>assets/frontend/js/addClient.js" type="text/javascript"></script>
<script src="<?=base_url('assets/vendor/summernote/summernote.js')?>"></script>
<script>
$(document).ready(function() {
  $('#notes').summernote({
	  height: 200
  });
});
</script>