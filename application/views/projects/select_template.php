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
					  <a href="<?=base_url()?>Projects/History/<?=$project_id?>" class="btn btn-success">Go Back</a>
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
					<form action="<?php echo base_url() ?>Projects/generateJobBrief" name="genJobTemp" id="genJobTemp" method="post">
						<fieldset>
							<div class="form-group">
								<label>Choose Template<em>*</em></label>
								<select name="template" class="form-control">
									<option value="">Choose Template</option>
									<?php if(!empty($jobBriefs)){
									 foreach($jobBriefs as $jobBrief){ ?>
										<option value="<?=$jobBrief->id?>"><?=$jobBrief->template_name?></option>
									<?php }
									} ?>
								</select>
								<input type="hidden" name="project_id" value="<?=$project_id?>">
							</div>
						</fieldset>
						
						<div class="box-footer">
                            <input type="submit" class="btn btn-success" value="Generate" />
                        </div>
					</form>
					<?php if($this->session->flashdata('template')){
						$temp = $this->session->flashdata('template');
						?><iframe src="https://docs.google.com/viewer?embedded=true&url=https://geos.dev.humanpixel.com.au/assets/templates/<?=$temp?>" frameborder="no" style="width:100%;height:500px"></iframe><?php
					} ?>
					</div>
				</div>
			</div>
		</div>
	
	</div>
</div>
<?php $this->load->view('includes/footer');?>