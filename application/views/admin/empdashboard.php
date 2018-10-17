<div class="page-content">
	<div class="row">
	<?php $this->load->view('includes/left_sidebar');?>
		<div class="col-md-9">
			<div class="content-box-large">
				<div class="panel-heading">
					<div class="panel-title">
						<h3>Geosurv Intranet Dashboard</h3>
					</div>
				</div>
				<div class="panel-body">
					<div class="col-lg-3 col-xs-6">
						<div class="small-box bg-aqua">
							<div class="inner">
							  <h3>0</h3>
							  <p>Total Your task</p>
							</div>
						  </div>
					</div>
					<div class="col-lg-3 col-xs-6">
						<div class="small-box bg-green">
							<div class="inner">
							  <h3><?php echo $countGroup;?></h3>
							  <p>Total Groups</p>
							</div>
						  </div>
					</div>
				</div>
			</div>
			<div class="content-box-large employeecalendar">
				<div class="panel-heading">
					<div class="panel-title">
						<h3>Your Leave</h3>
					</div>
				</div>
				<div class="panel-body">
					<div class="col-lg-12">
						<div id="employeeCal"></div>
					</div>
				</div>
			</div>
		</div>
	
	</div>
</div>

<link rel="stylesheet" href="<?php echo base_url() ?>assets/frontend/fullcalendar/fullcalendar.min.css" />
<script src="<?php echo base_url() ?>assets/frontend/fullcalendar/lib/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/frontend/fullcalendar/fullcalendar.min.js"></script>
<script src="<?php echo base_url() ?>assets/frontend/fullcalendar/gcal.js"></script>
<script>
	$(document).ready(function() {
	$('#employeeCal').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay,listWeek'
      },
      eventLimit: true, // allow "more" link when too many events
        events: baseURL + 'Employee/ajax_getLeaveList',
        selectable: true,
        selectHelper: true
    });
});
</script>


<?php $this->load->view('includes/footer');?> 