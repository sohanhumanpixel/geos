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
					  <a href="<?php echo base_url(); ?>Projects/addCategory" class="btn btn-success">Add New Category</a>
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
								<th><span>Category</span></th>
								<th><span>Created By</span></th>
								<th>Action</th>
								</tr>
							</thead>
							<tbody>
					
							<?php
                    if(!empty($categories))
                    {
                        foreach($categories as $category)
                        {
                    ?>	
					<tr>
                      <td><?php echo $category->category_name ?></td>
                      <td><?php echo $category->fname.' '.$category->lname ?></td>
                      <td>
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'Projects/editCategory/'.$category->id; ?>" data-toggle="tooltip" title="Edit"><i class="glyphicon  glyphicon-pencil"></i></a>
                          <a class="btn btn-sm btn-danger deleteCategory" href="<?php echo base_url().'Projects/deleteCategory/'.$category->id; ?>" data-toggle="tooltip" title="Delete"><i class="glyphicon  glyphicon-trash"></i></a>
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