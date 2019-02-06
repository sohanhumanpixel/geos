<div class="page-content">
	<div class="row">
	<?php $this->load->view('includes/left_sidebar');?>
	
	<div class="col-md-10 padding-left-right">
			<div class="content-box-large">
				<div class="panel-heading">
					<div class="panel-title">
						<h3>New Leave Request</h3>
					</div>
					<div class="panel-options">
					  <a href="leavelist" class="btn btn-success">Go Back</a>
					</div>
				</div>
				<div class="panel-body">
					<div class='col-md-9'>
					<?php
                    //$this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
						<div class="row">
							<div class="col-md-12">
								<?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
							</div>
						</div>
					
					<form action="<?php echo base_url() ?>Leave/addleave" name="applyleave" id="applyleave" method="post">
						<fieldset>
							<div class="form-group">
								<label for="leave_type">Leave Type</label>
                                        <select class="form-control" id="leave_type" name="leave_type">
                                            <option value="">Select Leave Type</option>
                                            <?php
                                            if(!empty($leaveType))
                                            {
                                                foreach ($leaveType as $rl)
                                                {
                                                    ?>
                                                    <option value="<?php echo $rl->id; ?>"><?php echo $rl->leave_type_name; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
							</div>
							<div class="form-group">
								<label>Leave From<em>*</em></label>
								<input class="form-control" name="leave_from_date" id="leave_from_date" placeholder="Enter user's first name" type="text" value="<?php echo set_value('leave_from_date'); ?>" autocomplete="off">
							</div>
							<div class="form-group">
								<label>Leave To<em>*</em></label>
								<input class="required form-control" name="leave_to_date" id="leave_to_date" placeholder="Enter user's last name" type="text" value="<?php echo set_value('leave_to_date'); ?>" autocomplete="off">
							</div>
							<div class="form-group">
								<label>Leave Reason<em>*</em></label>
								<textarea name="leave_reason" id="leave_reason"class="required form-control"><?php echo set_value('leave_reason'); ?></textarea>
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
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/jquery-ui.css">
<script src="<?php echo base_url(); ?>assets/frontend/js/jquery-ui.js"></script>
<script type="text/javascript">

$(document).ready(function(){
	$("#leave_from_date").datepicker({
		dateFormat: "yy-mm-dd",
		minDate:0,
		changeMonth: true,
	   onSelect: function(selected) {
		$("#leave_to_date").datepicker("option","minDate", selected)
		 }
	});
	$("#leave_to_date").datepicker({
		dateFormat: "yy-mm-dd",
		minDate:0,
		changeMonth: true,
		numberOfMonths: 1,
		onSelect: function(selected) {
		   $("#leave_from_date").datepicker("option","maxDate", selected)
		}
	});
});
</script>
