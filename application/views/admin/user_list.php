<div class="page-content">
	<div class="row">
		<?php $this->load->view('includes/left_sidebar');?> 
		<div class="col-md-10">
			<div class="content-box-large">
				<div class="panel-heading">
					<div class="panel-title">
						<h3>Employee List</h3>
					</div>
					<div class="panel-options">
					  <a href="<?php echo base_url(); ?>addNewEmployee" class="btn btn-success">Add New User</a>
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
								<th><span>First Name</span></th>
								<th><span>Last Name</span></th>
								<th><span>Email</span></th>
								<th><span>Username</span></th>
								<th><span>Role</span></th>
								<th>Action</th>
								</tr>
							</thead>
							<tbody>
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
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'Admin/editemp/'.base64_encode(convert_uuencode($record->userId)); ?>"><i class="glyphicon  glyphicon-pencil"></i></a>
                          <a class="btn btn-sm btn-danger deleteUser" href="javaScript:void(0);" data-userid="<?php echo $record->userId; ?>"><i class="glyphicon  glyphicon-trash"></i></a>
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
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/common.js" charset="utf-8"></script>