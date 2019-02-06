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
					  <a href="<?=base_url()?>TaskList" class="btn btn-success">Go Back</a>
					</div>
				</div>
				<div class="panel-body">
					<div class="col-md-9">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable ">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
					<div class='col-md-9'>
					<form action="<?php echo base_url() ?>TaskList/subEditAction" name="editSubTask" id="editSubTask" method="post">
						<fieldset>
							<div class="form-group col-md-10">
								<label>Title<em>*</em></label>
								<input class="form-control" name="title" id="title" placeholder="Enter Subtask Title" type="text" value="<?=$subtask[0]->title?>">
								<input type="hidden" name="subtask_id" value="<?=$subtask[0]->id?>">
							</div>
							<div class="form-group col-md-2">
								<label>Abbreviation<em>*</em></label>
								<input class="form-control" name="abbr" id="abbr" placeholder="" type="text" maxlength="4" value="<?=$subtask[0]->abbr?>">
							</div>
							<div class="form-group">
								<label>Task<em>*</em></label>
								<select name="task" class="form-control" disabled>
									<option value="<?=$taskName[0]->id?>"><?=$taskName[0]->title?> <?=$taskName[0]->abbr?></option>
								</select>
								<input type="hidden" name="task" value="<?=$taskName[0]->id?>">
							</div>
							<div class="form-group col-md-6">
								<label>Fixed Price<em>*</em></label>
								<input type="number" name="fixed_price" class="form-control" value="<?=$subtask[0]->fixed_price?>">
							</div>
							<div class="form-group col-md-6">
								<label>Hourly Rate<em>*</em></label>
								<input type="number" name="hourly_rate" class="form-control" value="<?=$subtask[0]->hourly_rate?>">
							</div>
							<div class="form-group">
								<label>Content</label>
								<textarea name="content"><?=$subtask[0]->content?></textarea>
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
<style>
.form-group.col-md-10 {
    padding: 0;
}

.form-group.col-md-2 {
    padding: 0;
    padding-left: 15px;
}
</style>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/common.js" charset="utf-8"></script>
<script src="<?=base_url('assets/vendor/summernote/summernote.js')?>"></script>
<script>
$(document).ready(function() {
  $('textarea').summernote({
  	height: 200
  });
});
</script>