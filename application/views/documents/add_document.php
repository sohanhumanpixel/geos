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
					  <a href="<?=base_url()?>Documents" class="btn btn-success">Go Back</a>
					</div>
				</div>
				<?php if(validation_errors()) { ?>

                  <div class="calert alert alert-danger">

                    <?php echo validation_errors(); ?>

                  </div>

                <?php } ?>
                <?php if($this->session->flashdata()) {
                  $flashdata = $this->session->flashdata(); ?>

                  <div class="calert alert alert-<?=$flashdata['type']?>">

                    <?=$flashdata['msg']?>

                  </div>

                <?php  } ?>
				<div class="panel-body">
					<div class='col-md-9'>
		<form name="addDocument" id="addDocument" action="/Documents/addAction" method="post" enctype="multipart/form-data">
					<?php //echo form_open_multipart('Documents/addAction','id="addDocument"');?>
						<fieldset>
							<div class="form-group">
								<label>Title<em>*</em></label>
								<input class="required form-control" name="document_title" id="document_title" placeholder="Title" type="text">
							</div>
							<div class="form-group">
								<label>Uploade File<em>*</em></label>
								<input class="required form-control" name="document_name" id="document_name" placeholder="Title" type="file">
							</div>
							<div class="form-group">
								<label>About Document<em>*</em></label>
								<textarea id="descriptions" name="descriptions" rows="8" class="form-control"></textarea>
							</div>
							
						</fieldset>
						
						<div class="box-footer">
                            <input type="submit" class="btn btn-success" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
					</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('includes/footer');?> 
<script src="<?php echo base_url(); ?>assets/frontend/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?=base_url('assets/vendor/summernote/summernote.js')?>"></script>
<script>
$(document).ready(function() {
  $('textarea').summernote({
	  height: 200
  });
  $("#addDocument").validate();
});
</script>
