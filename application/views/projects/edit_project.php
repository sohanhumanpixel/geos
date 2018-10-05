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
								<label>Client Name<em>*</em></label>
								<select name="client_name" class="form-control">
									<option value="">Select Client</option>
									<?php foreach($clients as $client){ ?>
                                    <option value="<?=$client->id?>" <?php if($projectInfo[0]->client_id==$client->id){ echo "selected"; } ?>><?=$client->fname.' '.$client->lname?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<label>Project Site Address<em>*</em></label>
								<input class="form-control" name="site_address" id="site_address" placeholder="Enter project site address" type="text" value="<?=$projectInfo[0]->project_address?>">
							</div>
							<div class="form-group">
								<label class="ch">Online Induction<em>*</em></label>
								<?php foreach($inductions as $induction){ ?>
								<div class="form-control ptype">
									
									<input class="induction" name="induction[]" <?php if(in_array($induction->id, explode(',', $projectInfo[0]->induction))){ echo "checked"; } ?> type="checkbox" value="<?=$induction->id?>"><?=ucfirst(strtolower($induction->name))?>
									
								</div>
								<?php } ?>
							</div>
							<div class="form-group">
								<label class="ch">Online Induction Instructions</label>
								<input class="form-control" name="induction_instruction" id="induction_instruction" placeholder="Enter induction instructions" type="text" value="<?=$projectInfo[0]->instructions?>">
							</div>
							<div class="form-group">
								<label class="ch">Type of Project<em>*</em></label>
								<?php foreach($project_types as $project_type){ ?>
								<div class="form-control ptype">
									
									<input class="project_type" name="project_type[]" type="checkbox" value="<?=$project_type->id?>" <?php if(in_array($project_type->id, explode(',', $projectInfo[0]->project_type))){ echo "checked"; } ?>><?=$project_type->project_type_name?>
									
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