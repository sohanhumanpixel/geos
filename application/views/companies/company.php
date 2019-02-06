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
					  <a href="<?php echo base_url(); ?>Company/add" class="btn btn-success">Add New Company</a>
					</div>
					<form>
					  <div class="form-group col-md-4">
						  <input type="text" name="search" id="search_text" placeholder="Search by Company name" value="<?=$toSearch?>" class="form-control col-md-10" />
						  <?php if(isset($_GET['sort']) && $_GET['sort']!=""){ ?>
						  <input type="hidden" name="sort" value="<?=$_GET['sort']?>">
						  <?php } ?>
						  <input type="submit" name="" class="form-control col-md-2" value="Go">
					  </div>
					</form>
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
                <?php if(isset($_GET['search'])){
                	$append_url = '&search='.$_GET['search'];
                }else{
                	$append_url = '';
                } ?>
						<table class="table user-list">
							<thead>
								<tr>
								<th><span><a href="?sort=<?=$toSort?><?=$append_url?>"> Company Name <i class="fa fa-sort-<?=$toSort?>"></i></a></span></th>
								<th><span>Company Website</span></th>
								<th><span>Email</span></th>
								<th><span>Phone</span></th>
								<th><span>Created By</span></th>
								<th>Action</th>
								</tr>
							</thead>
							<tbody>
					
							<?php
                    if(!empty($companies))
                    {
                        foreach($companies as $company)
                        {
                    ?>	
					<tr>
                      <td><a href="Company/Detail/<?php echo $company->id; ?>"><?php echo $company->company_name ?></a></td>
                      <td><?php echo $company->company_website ?></td>
                      <td><?php echo $company->company_email ?></td>
					  <td><?php echo $company->company_phone ?></td>
                      <td><?php echo $company->firstname.' '.$company->lastname ?></td>
                      <td class="text-center">
                      	  <a class="btn btn-sm btn-success" href="<?php echo base_url().'Company/Detail/'.$company->id; ?>" data-toggle="tooltip" title="View"><i class="glyphicon glyphicon-eye-open"></i></a>
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'Company/edit/'.base64_encode(convert_uuencode($company->id)); ?>" data-toggle="tooltip" title="Edit"><i class="glyphicon  glyphicon-pencil"></i></a>
                          <a class="btn btn-sm btn-danger deleteCompany" href="javaScript:void(0);" data-userid="<?php echo $company->id; ?>" data-toggle="tooltip" title="Delete"><i class="glyphicon  glyphicon-trash"></i></a>
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
<style type="text/css">
input.form-control.col-md-2 {
    width: 15%;
}
input.form-control.col-md-10 {
    width: 85%;
}
</style> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/common.js" charset="utf-8"></script>