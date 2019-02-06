<div class="page-content">
	<div class="row">
	<?php 
	$this->load->view('includes/left_sidebar');
	?>
	
	<div class="col-md-10 padding-left-right">
			<div class="content-box-large">
				<div class="panel-heading">
					<div class="panel-title">
						<h3><?=$title?></h3>
					</div>
					<div class="panel-options">
					  <a href="<?php echo base_url() ?>client" class="btn btn-success">Go Back</a>
					</div>
				</div>
				<div class="panel-body">
					<div class='col-md-9'>
					<form action="<?php echo base_url() ?>Client/editAction" name="editClient" id="editClient" method="post">
						<fieldset>
							<div class="form-group">
								<label>First Name<em>*</em></label>
								<input class="form-control" name="fname" id="fname" placeholder="Enter user's first name" type="text" value="<?php echo $clientInfo[0]->fname; ?>">
							</div>
							<div class="form-group">
								<label>Last Name<em>*</em></label>
								<input class="form-control" name="lname" id="lname" placeholder="Enter user's last name" type="text" value="<?php echo $clientInfo[0]->lname; ?>">
								 <input type="hidden" value="<?php echo $clientInfo[0]->id; ?>" name="clientId" id="clientId" />    
							</div>
							<div class="form-group">
								<label>Email Address<em>*</em></label>
								<input class="form-control required email" name="email" id="email" placeholder="Enter user's email" type="text" value="<?php echo $clientInfo[0]->email; ?>" />
							</div>
							<div class="form-group">
								<label>Phone<em>*</em></label>
						<input class="form-control" name="phone" id="phone" placeholder="Enter Phone" type="text" value="<?php echo $clientInfo[0]->phone; ?>" />
							</div>
							<div class="form-group">
								<label>Company<em>*</em></label>
								<select name="company" class="form-control">
									<option value="">Select Company</option>
									<?php if(!empty($companies)){
										foreach($companies as $company){ ?>
                                        <option value="<?=$company->id?>" <?php if($clientInfo[0]->company==$company->id){ echo "selected"; } ?>><?=$company->company_name?></option>
										<?php }
									} ?>
								</select>
							</div>
							<div class="form-group">
								<label>Notes</label>
								<textarea id="notes" name="notes" rows="8" class="form-control"><?=$clientInfo[0]->notes?></textarea>
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
<script src="<?php echo base_url(); ?>assets/frontend/js/editClient.js" type="text/javascript"></script>
<script src="<?=base_url('assets/vendor/summernote/summernote.js')?>"></script>
<script>
$(document).ready(function() {
  $('textarea').summernote({
	  height: 200
  });
});
</script>