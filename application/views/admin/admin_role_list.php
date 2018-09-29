<div class="page-content">
	<div class="row">
		<?php $this->load->view('includes/left_sidebar');?> 
		<div class="col-md-10">
			<div class="content-box-large">
				<div class="panel-heading">
					<div class="panel-title">
						<h3>All Roles</h3>
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
								<th><span>Role Name</span></th>
								</tr>
							</thead>
							<tbody>
							<?php
                    if(!empty($roles))
                    {
                       foreach($roles as $record)
                        {
                    ?>	
					<tr>
                      <td><?php echo $record->role_name; ?></td>
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