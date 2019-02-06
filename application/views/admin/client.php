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
					  <a href="<?php echo base_url(); ?>Client/add" class="btn btn-success">Add New Contact</a>
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
								<th><span>Name</span></th>
								<th><span>Email</span></th>
								<th><span>Phone</span></th>
								<th><span>Company</span></th>
								<th><span>Created By</span></th>
								<th>Action</th>
								</tr>
							</thead>
							<tbody>
					
							<?php
                    if(!empty($clients))
                    {
                        foreach($clients as $client)
                        {
                    ?>	
					<tr>
                      <td><a href="<?=base_url()?>Client/Detail/<?=$client->id?>"><?php echo $client->fname ?> <?php echo $client->lname ?></a></td>
                      <td><?php echo $client->email ?></td>
					  <td><?php echo $client->phone ?></td>
					  <td><?php echo $client->company_name ?></td>
                      <td><?php echo $client->firstname.' '.$client->lastname ?></td>
                      <td class="text-center">	
                      	  <a class="btn btn-sm btn-success" href="<?php echo base_url().'Client/Detail/'.$client->id; ?>" data-toggle="tooltip" title="View"><i class="glyphicon glyphicon-eye-open"></i></a>
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'Client/edit/'.base64_encode(convert_uuencode($client->id)); ?>" data-toggle="tooltip" title="Edit"><i class="glyphicon  glyphicon-pencil"></i></a>
                          <a class="btn btn-sm btn-danger deleteClient" href="javaScript:void(0);" data-userid="<?php echo $client->id; ?>" data-toggle="tooltip" title="Delete"><i class="glyphicon  glyphicon-trash"></i></a>
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