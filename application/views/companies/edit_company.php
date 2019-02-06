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
					  <a href="<?=base_url()?>Company" class="btn btn-success">Go Back</a>
					</div>
				</div>
				<div class="panel-body">
					<div class='col-md-9'>
					<form action="<?php echo base_url() ?>Company/editAction" name="editCompany" id="editCompany" method="post">
						<fieldset>
							<div class="form-group">
								<label>Company Name<em>*</em></label>
								<input class="form-control required" name="cname" id="cname" placeholder="Enter company name" type="text" value="<?=$companyInfo[0]->company_name?>">
								<input type="hidden" value="<?php echo $companyInfo[0]->id; ?>" name="companyId" id="companyId" /> 
							</div>
							<div class="form-group">
								<label>Company Owner<em>*</em></label>
								<input class="form-control required" name="cowner" id="cowner" placeholder="Enter company owner name" type="text" value="<?=$companyInfo[0]->company_owner?>">
							</div>
							<div class="form-group">
								<label>Company Website</label>
								<input class="form-control" name="cweb" id="cweb" placeholder="Enter company website" type="text" value="<?=$companyInfo[0]->company_website?>">
							</div>
							<div class="form-group">
								<label>Email Address<em>*</em></label>
								<input class="form-control required email" name="cemail" id="cemail" placeholder="Enter company email" type="text" value="<?=$companyInfo[0]->company_email?>">
							</div>
							<div class="form-group">
								<label>Phone Number</label>
								<input class="form-control" name="cphone" id="cphone" placeholder="Enter company phone number" type="text" value="<?=$companyInfo[0]->company_phone?>">
							</div>
							<div class="form-group">
								<label>Notes</label>
								<textarea id="notes" name="notes" rows="8" class="form-control"><?=$companyInfo[0]->notes?></textarea>
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
<script src="<?=base_url('assets/vendor/summernote/summernote.js')?>"></script>
<script>
$(document).ready(function() {
  $('textarea').summernote({
	  height: 200
  });
  $("#editCompany").validate();
});
</script>