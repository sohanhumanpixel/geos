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
					  <a href="<?php echo base_url(); ?>Announcement/add" class="btn btn-success">Add New </a>
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
								<th><span>Subject</span></th>
								<th><span>Message</span></th>
								<th>Created By</th>
								<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
							<?php
                    if(!empty($announcements))
                    {
                        foreach($announcements as $announcement)
                        {
                    ?>	
					<tr>
                      <td><?php echo $announcement->subject ?></td>
                      <td><?php echo html_entity_decode($announcement->message) ?></td>
                      <td><?php echo $announcement->fname.' '.$announcement->lname ?></td>
                      <td class="text-center">
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'Announcement/editann/'.base64_encode(convert_uuencode($announcement->id)); ?>" data-toggle="tooltip" title="Edit"><i class="glyphicon  glyphicon-pencil"></i></a>
                          <a class="btn btn-sm btn-danger deleteUser" href="<?php echo base_url().'Announcement/delann/'.base64_encode(convert_uuencode($announcement->id)); ?>" data-toggle="tooltip" title="Delete" data-userid="<?php echo $announcement->id; ?>"><i class="glyphicon  glyphicon-trash"></i></a>
                          <?php if($announcement->active==0){ ?>
                              <a class="btn btn-sm btn-success" href="<?php echo base_url().'Announcement/statusActive/'.base64_encode(convert_uuencode($announcement->id)); ?>" data-toggle="tooltip" title="Currently Inactive" data-userid="<?php echo $announcement->id; ?>">Active</a>
                          <?php }else{ ?>
                              <a class="btn btn-sm btn-danger" href="<?php echo base_url().'Announcement/statusInactive/'.base64_encode(convert_uuencode($announcement->id)); ?>" data-toggle="tooltip" title="Currently active" data-userid="<?php echo $announcement->id; ?>">Inactive</a>
                          <?php } ?>
                          
                      </td>
                    </tr>
					<?php 
						}
					}				
					?>
							</tbody>
						</table>
					</div>
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
					<div class="box-footer clearfix">
						<?php echo $this->pagination->create_links(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('includes/footer');?> 