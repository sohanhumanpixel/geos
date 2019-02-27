<div class="page-content">
	<div class="row">
		<?php $this->load->view('includes/left_sidebar');?> 
		<div class="col-md-10 padding-left-right">
				
				<div class="page-panel-title">
				 <div class="panel-heading">
					<div class="panel-title">
						<h2>Employee List</h2>
					</div>
					<div class="panel-options">
					  <a href="<?php echo base_url(); ?>addNewEmployee" class="btn btn-success add_new_btn button_color"><span> <i class="fa fa-plus" aria-hidden="true"></i> </span> ADD NEW</a>
					</div>
				</div>	
			</div>			
			<div class="content-box-large">
				<div class="panel-body padding-top-zero">
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
								<th><span>First Name</span></th>
								<th><span>Last Name</span></th>
								<th><span>Email</span></th>
								<th><span>Username</span></th>
								<th><span>Role</span></th>
								<th>Action</th>
								</tr>
							</thead>
							<tbody>
					<tr>
						<td><?=$currentUser[0]->fname?></td>
						<td><?=$currentUser[0]->lname?></td>
						<td><?=$currentUser[0]->email?></td>
						<td><?=$currentUser[0]->username?></td>
						<td><?=$currentUser[0]->role_name?><em>(You)</em></td>
						<td class="text-center">
						<a class="btn btn-sm btn-info" href="<?php echo base_url().'Admin/viewprofile/'.base64_encode(convert_uuencode($currentUser[0]->userId)); ?>" data-toggle="tooltip" title="View Profile"><i class="glyphicon glyphicon-search"></i></a>
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'Admin/editemp/'.base64_encode(convert_uuencode($currentUser[0]->userId)); ?>" data-toggle="tooltip" title="Edit"><i class="glyphicon glyphicon-pencil"></i></a>
                          <a class="btn btn-sm btn-danger deleteUser" href="javaScript:void(0);" data-userid="<?php echo $currentUser[0]->userId; ?>" data-toggle="tooltip" title="Delete"><i class="glyphicon glyphicon-trash"></i></a>
                      </td>
					</tr>
							<?php
                    if(!empty($userRecords))
                    {
                        foreach($userRecords as $record)
                        {
                    ?>	
					<tr>
                      <td><?php echo $record->fname ?></td>
                      <td><?php echo $record->lname ?></td>
                      <td><?php echo $record->email ?></td>
					  <td><?php echo $record->username ?></td>
                      <td><?php echo $record->role_name ?></td>
                      <td class="text-center">
						 <a class="btn btn-sm btn-info" href="<?php echo base_url().'Admin/viewprofile/'.base64_encode(convert_uuencode($record->userId)); ?>" data-toggle="tooltip" title="View More"><i class="glyphicon glyphicon-search"></i></a>
						 
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'Admin/editemp/'.base64_encode(convert_uuencode($record->userId)); ?>" data-toggle="tooltip" title="Edit"><i class="glyphicon  glyphicon-pencil"></i></a>
						  
                          <a class="btn btn-sm btn-danger deleteUser" href="javaScript:void(0);" data-userid="<?php echo $record->userId; ?>" data-toggle="tooltip" title="Delete"><i class="glyphicon  glyphicon-trash"></i></a>
                      </td>
                    </tr>
					<?php 
						}
					}				
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
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/common.js" charset="utf-8"></script>
<script>
	$('[data-toggle="tooltip"]').tooltip();
</script>