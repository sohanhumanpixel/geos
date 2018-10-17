<div class="page-content">
	<div class="row">
		<?php $this->load->view('includes/left_sidebar');?> 
		<div class="col-md-9">
			<div class="content-box-large">
				<div class="panel-heading">
					<div class="panel-title">
						<h3>Document List</h3>
					</div>
					<div class="panel-options">
					  <a href="<?php echo base_url(); ?>Documents/add" class="btn btn-success">Upload New Document</a>
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
								<th><span>Title</span></th>
								<th><span>File Name</span></th>
								<th><span>Type</span></th>
								<th><span>Description</span></th>
								<th><span>Created Date</span></th>
								<th><span>Action</span></th>
								</tr>
							</thead>
							<tbody>
					<?php
                    if(!empty($documentData))
                    {
                        foreach($documentData as $record)
                        {
                    ?>	
					<tr>
						<td><?=$record->document_title?></td>
						<td><a href="<?php echo base_url().'assets/documentupload/'.$record->document_name; ?>"><?=$record->document_real_name?></a></td>
						<td><?=$record->document_type?></td>
						<td><?=$record->descriptions?></td>
						<td><?=$record->created_at?></td>
						<td class="text-center">
						  <a class="btn btn-sm btn-info" download href="<?php echo base_url().'assets/documentupload/'.$record->document_name; ?>" data-toggle="tooltip" title="Download"><i class="glyphicon  glyphicon-download"></i></a>
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'Documents/editdocu/'.base64_encode(convert_uuencode($record->id)); ?>" data-toggle="tooltip" title="Edit"><i class="glyphicon  glyphicon-pencil"></i></a>
                          <a class="btn btn-sm btn-danger deletedocument" onclick="return confirm('Are you sure want delete?');"href="Documents/deltedocu/<?php echo base64_encode(convert_uuencode($record->id)) ?>" data-toggle="tooltip" title="Delete"><i class="glyphicon  glyphicon-trash"></i></a>
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
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();   
	});
</script>