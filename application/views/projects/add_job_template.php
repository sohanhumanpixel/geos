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
					  <a href="<?=base_url()?>Projects/jobBriefs" class="btn btn-success">Go Back</a>
					</div>
				</div>
				<div class="panel-body">
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
					<div class='col-md-9'>
					<form action="<?php echo base_url() ?>Projects/addJobBriefTempAction" name="adJobTemp" id="adJobTemp" method="post" enctype="multipart/form-data">
						<fieldset>
							<div class="form-group">
								<label>Template Name<em>*</em></label>
								<input class="form-control" name="template_name" id="template_name" placeholder="Enter Job Template Name" type="text">
							</div>
							<div class="form-group">
								<label>Categories<em>*</em></label>
								<select name="categories" class="form-control">
									<option value="">Select Category</option>
									<?php foreach($categories as $category){ ?>
										<option value="<?=$category->id?>"><?=$category->category_name?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<label>Description</label>
								<textarea name="description" class="form-control"></textarea>
							</div>
							<div class="form-group">
								<label>Template File<em>*</em></label>
								<input type="file" name="template_file">
							</div>
						</fieldset>
						
						<div class="box-footer">
                            <input type="submit" class="btn btn-success" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
					</form>
					</div>
				</div>
			</div>
		</div>
	
	</div>
</div>
<?php $this->load->view('includes/footer');?>