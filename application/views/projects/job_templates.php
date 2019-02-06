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
					  <a href="<?php echo base_url(); ?>Projects/addJobBriefTemp" class="btn btn-success">Add Job Template</a>
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
								<th><span>Template Name</span></th>
								<th><span>Template File</span></th>
								<th><span>Category</span></th>
								<th><span>Description</span></th>
								<th><span>Created By</span></th>
								<th>Action</th>
								</tr>
							</thead>
							<tbody>
					
							<?php
                    if(!empty($jobBriefs))
                    {
                        foreach($jobBriefs as $jobBrief)
                        {
                    ?>	
					<tr>
                      <td><?php echo $jobBrief->template_name ?></td>
                      <td><a target="_blank" href="<?php echo base_url() ?>assets/templates/<?=$jobBrief->template_file?>"><?=$jobBrief->template_real?></a></td>
                      <td><?php echo $jobBrief->category_name ?></td>
                      <td><?php echo $jobBrief->description ?></td>
                      <td><?php echo $jobBrief->fname.' '.$jobBrief->lname ?></td>
                      <td>
                      	  <a class="btn btn-sm btn-info" download href="<?php echo base_url().'assets/templates/'.$jobBrief->template_file; ?>" data-toggle="tooltip" title="Download"><i class="glyphicon  glyphicon-download"></i></a>
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'Projects/editJobBriefTemp/'.$jobBrief->id; ?>" data-toggle="tooltip" title="Edit"><i class="glyphicon  glyphicon-pencil"></i></a>
                          <a class="btn btn-sm btn-danger deleteJobTemplate" href="<?php echo base_url().'Projects/deleteJobTemp/'.$jobBrief->id; ?>" data-toggle="tooltip" title="Delete"><i class="glyphicon  glyphicon-trash"></i></a>
                      </td>
                    </tr>
					<?php 
						}
					}else{ ?>
						<tr>
							<td>No Records</td>
						</tr>
					<?php }			
					?>
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