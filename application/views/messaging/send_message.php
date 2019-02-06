<?php
$replyMode = false;
if(isset($_GET['msg-id']) && isset($_GET['sid'])){
	$msg_id = $_GET['msg-id'];
	$sender_id = $_GET['sid'];
	$replyMode = true;
}

?>
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
					  <a href="<?php echo $this->session->userdata('back_url'); ?>" class="btn btn-success">Go Back</a>
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
                <?php
                $success = $this->session->flashdata('success');
                if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable ">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>                    
                </div>
                <?php }
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
					<div class='col-md-9'>
					<form action="<?php echo base_url() ?>Messaging/send_msgAction" name="sendMsg" id="sendMsg" method="post">
						<fieldset>
							<div class="form-group">
								<label>From</label>
								<p><strong><?=$username?> (<?=$usermail?>)</strong></p>
								<input type="hidden" name="sender_id" value="<?=$userId?>">
								
							</div>
							<div class="form-group">
								<label>To<em>*</em></label>
								<?php if($replyMode){
								$this->load->model('users');
								$userInfo = $this->users->getUserInfo($sender_id); ?>
									<p><strong><?=$userInfo[0]->fname.' '.$userInfo[0]->lname?></strong></p>
									<input type="hidden" name="recipient" id="recipient" value="<?=$sender_id?>">
									<input type="hidden" name="msg_id" value="<?=$msg_id?>">
								<?php }else{ ?>
									<input type="text" name="to_msg" id="to_msg" class="form-control">
									<input type="hidden" name="recipient" id="recipient">
								<?php } ?>
								
							</div>
							<?php if(!$replyMode){ ?>
								<div class="form-group">
									<label>Subject<em>*</em></label>
									<input type="text" name="subject_msg" class="form-control">
								</div>
							<?php } ?>
							
							<div class="form-group">
								<label>Message<em>*</em></label>
								<textarea name="message_msg" class="form-control"></textarea>
							</div>
						</fieldset>
						
						<div class="box-footer">
                            <input type="submit" class="btn btn-success" value="Start Conversation" />
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
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/jquery-ui.css">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery-ui.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/msging.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery.validate.min.js" charset="utf-8"></script>
<script src="<?=base_url('assets/vendor/summernote/summernote.js')?>"></script>
<script>
$(document).ready(function() {
  $("#sendMsg").validate({
  	rules:{
  		to_msg: "required",
  		subject_msg: "required",
  		message_msg: "required"
  	},
  	messages:{
  		to_msg: "Please enter recipient name",
  		subject_msg: "Please enter subject title",
  		message_msg: "Please write message"
  	}
  })
});
</script>
