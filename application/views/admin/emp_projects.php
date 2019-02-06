<div class="page-content">
	<div class="row">
		<?php $this->load->view('includes/left_sidebar');?> 
		<div class="col-md-10 padding-left-right">
			<div class="content-box-large">
				<div class="panel-heading">
					<div class="panel-title">
						<h3><?=$title?></h3>
					</div>
					<!--<div class="panel-options">
					  <a href="<?php echo base_url(); ?>UserGroups/addGroup" class="btn btn-success">Add New Group</a>
					</div>-->
				</div>
				<div class="panel-body">
					<div class="table-responsive">
					<?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
						<table class="table user-list">
							<thead>
								<tr>
									<th><span>Projects Assigned</span></th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php if(!empty($projectLists)){
									foreach($projectLists as $projectList){ ?>
										<tr>
											<td><?=$projectList->project_name?></td>
											<td>
												<a href="<?=base_url()?>Employee/projectView/<?=$projectList->id?>">
													<button class="btn btn-success">View</button>
												</a>
											</td>
										</tr>
									<?php }
								}else{
									echo "<tr><td>No Projects</td></tr>";
								} ?>
							</tbody>
						</table>
					</div>
					<div class="box-footer clearfix">
						<?php echo $this->pagination->create_links(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('includes/footer');?> 