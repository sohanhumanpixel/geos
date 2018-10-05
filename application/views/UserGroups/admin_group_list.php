<div class="page-content">
	<div class="row">
		<?php $this->load->view('includes/left_sidebar');?> 
		<div class="col-md-9">
			<div class="content-box-large">
				<div class="panel-heading">
					<div class="panel-title">
						<h3>Group List</h3>
					</div>
					<div class="panel-options">
					  <a href="<?php echo base_url(); ?>UserGroups/addGroup" class="btn btn-success">Add New Group</a>
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
								<th><span>Group Name</span></th>
								<th><span>Created By</span></th>
								<th><span>Created Date</span></th>
								<th>Action</th>
								</tr>
							</thead>
							<tbody>
							<?php
                    if(!empty($groupRecords))
                    {
                       foreach($groupRecords as $record)
                        {
                    ?>	
					<tr>
                      <td><?php echo $record->group_name; ?></td>
                      <td><?php echo $record->fname.' '.$record->lname; ?></td>
                      <td><?php echo $record->created_at; ?></td>
                      <td class="text-center">
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'UserGroups/editGroup/'.base64_encode(convert_uuencode($record->groupId)); ?>"><i class="glyphicon  glyphicon-pencil"></i></a>
                          <a class="btn btn-sm btn-danger" href="<?php echo base_url().'UserGroups/deleteGroup/'.$record->groupId; ?>" data-userid="<?php echo $record->groupId; ?>" onclick="return confirm('Are you sure want to delete group?')"><i class="glyphicon  glyphicon-trash"></i></a>
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