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
					  <a href="<?=base_url()?>Announcement" class="btn btn-success">Go Back</a>
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
					<form action="<?php echo base_url() ?>Announcement/editAction/<?php echo base64_encode(convert_uuencode($announcement[0]->id)); ?>" name="editAnn" id="editAnn" method="post">
						<fieldset>
							<div class="form-group">
								<label>Subject<em>*</em></label>
								<input class="form-control" name="a_subject" id="a_subject" placeholder="Announcement Subject" type="text" value="<?=$announcement[0]->subject?>">
							</div>
							<div class="form-group">
								<label>Message<em>*</em></label>
								<textarea id="a_message" name="a_message" rows="8" class="form-control"><?=html_entity_decode($announcement[0]->message)?></textarea>
							</div>
							<div class="form-group">
								<label>View By</label>
								<select name="a_view" class="form-control">
									<option value="all" <?php if($announcement[0]->view=='all'){ echo "selected"; } ?>>All</option>
									<option value="management" <?php if($announcement[0]->view=='management'){ echo "selected"; } ?>>Management</option>
								</select>
							</div>
						</fieldset>
						
						<div class="box-footer">
                            <input type="submit" class="btn btn-success" value="Save" />
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
});
</script>
