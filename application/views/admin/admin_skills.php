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
					  <a href="<?php echo base_url(); ?>Employee/addSkill" class="btn btn-success">Add New Skill</a>
					</div>
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
								<th><span>Skill</span></th>
								<th><span>Created By</span></th>
								<th><span>Created Date</span></th>
								<th>Action</th>
								</tr>
							</thead>
							<tbody>
							<?php
                    if(!empty($skills))
                    {
                       foreach($skills as $skill)
                        {
                    ?>	
					<tr>
                      <td><?php echo $skill->skill_name; ?></td>
                      <td><?php echo $skill->fname.' '.$skill->lname; ?></td>
                      <td><?php echo $skill->created_at; ?></td>
                      <td class="text-center">
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'Employee/editSkill/'.base64_encode(convert_uuencode($skill->id)); ?>"><i class="glyphicon  glyphicon-pencil"></i></a>
                          <a class="btn btn-sm btn-danger" href="<?php echo base_url().'Employee/deleteSkill/'.$skill->id; ?>" data-userid="<?php echo $skill->id; ?>" onclick="return confirm('Are you sure want to delete this skill?')"><i class="glyphicon  glyphicon-trash"></i></a>
                      </td>
                    </tr>
					<?php 
						}
					}				
					?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('includes/footer');?> 