<div class="page-content">
	<div class="row">
	<?php $this->load->view('includes/left_sidebar');?>
	<?php 
	$inductionStyle = "display:none;";
	$checked = '';
	 if($projectInfo[0]->is_induction ==1){
		 $inductionStyle = '';
		 $checked = "checked=checked";
	 }
	 
	?>
	<div class="col-md-10 padding-left-right">
			<div class="content-box-large">
				<div class="panel-heading">
					<div class="panel-title">
						<h3><?=$title?></h3>
					</div>
					<div class="panel-options">
					  <a href="<?=base_url()?>projects" class="btn btn-success">Go Back</a>
					</div>
				</div>
				<div class="panel-body">
					<div class='col-md-9'>
					<form action="<?php echo base_url() ?>Projects/editAction" name="adProject" id="adProject" method="post">
						<fieldset>
							<div class="form-group">
								<label>Project Name<em>*</em></label>
								<input class="form-control" name="project_name" id="project_name" placeholder="Enter project name" type="text" value="<?=$projectInfo[0]->project_name?>">
								<input type="hidden" name="project_id" value="<?=$projectInfo[0]->id?>">
							</div>
							<div class="form-group">
								<label>Company Name<em>*</em></label>
								<select name="client_name" class="form-control">
									<option value="">Select Company</option>
									<?php foreach($companies as $company){ ?>
                                    <option value="<?=$company->id?>" <?php if($projectInfo[0]->client_id==$company->id){ echo "selected"; } ?>><?=$company->company_name?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<label>Project Site Address<em>*</em></label>
								<input class="form-control" name="site_address" id="site_address" placeholder="Enter project site address" type="text" value="<?=$projectInfo[0]->project_address?>">
							</div>
							<div class="form-group">
								<span class="induction_lbl">Online Induction</span>
								<span class="induction_chk"> 
								<input type="checkbox" name="is_induction" id="is_induction" <?php echo $checked; ?> value="1" />
								</span>
							</div>
							<div class="form-group inductionurl" style="<?php echo $inductionStyle; ?>">
								<label>Induction URL<em>*</em></label>
								<input type="url" name="induction_url" id="induction_url" class="form-control" value="<?php echo $projectInfo[0]->induction_url; ?>" data-urlval = "<?php echo $projectInfo[0]->induction_url; ?>" />
							</div>
							<div class="form-group">
								<label class="ch">Online Induction Instructions</label>
								<input class="form-control" name="induction_instruction" id="induction_instruction" placeholder="Enter induction instructions" type="text" value="<?=$projectInfo[0]->instructions?>">
							</div>
							<div class="form-group">
								<label>Categories</label>
								<select name="categories" class="form-control">
									<option value="">Select Category</option>
									<?php foreach($categories as $category){ ?>
										<option value="<?=$category->id?>" <?php if($category->id==$projectInfo[0]->category_id){ echo "selected"; } ?>><?=$category->category_name?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<label>States</label>
								<select name="states" class="form-control">
									<option value="">Select State</option>
									<?php foreach($states as $state){ ?>
										<option value="<?=$state->id?>" <?php if($state->id==$projectInfo[0]->state_id){ echo "selected"; } ?>><?=$state->state_name?>(<?=$state->state_rate?> AUD$)</option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<label class="ch">Type of Project<em>*</em></label>
								<?php foreach($project_types as $project_type){ ?>
								<div class="form-control ptype">
									
									<input class="project_type" name="project_type[]" type="checkbox" value="<?=$project_type->id?>" <?php if(in_array($project_type->id, explode(',', $projectInfo[0]->project_type))){ echo "checked"; } ?>><?=$project_type->project_type_name?>
									
								</div>
								<?php } ?>
							</div>
							<div class="form-group">
								<label class="ch">Select Tasks<em>*</em></label>
								<?php foreach($tasks as $task){ ?>
								<div class="form-control ptype">
									<input class="task" name="task[]" type="checkbox" value="<?=$task->id?>" <?php if(in_array($task->id, explode(',', $projectInfo[0]->task_ids))){ echo "checked"; } ?>><?=$task->title?> <?=$task->abbr?>
									
								</div>
								<?php } ?>
							</div>
						</fieldset>
						
						<div class="box-footer">
                            <input type="submit" class="btn btn-success" value="Update" />
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
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/common.js" charset="utf-8"></script>