<div class="page-content">
	<div class="row">
		<?php $this->load->view('includes/left_sidebar');?>
		<div class="col-md-10 padding-left-right">
		<div class="heading_title">
		   <h2>Hello Adam!</h2>
		</div>
		<!--<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators 
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides
    <div class="carousel-inner" role="listbox">
      <div class="item active">
        <img src="<?php echo base_url();?>assets/images/home-slider-bg1.jpg" alt="" >
        <div class="carousel-caption">
          <h2>GEOSURV LAND & CONSTRUCTION SURVEYORS</h2>
		  <h4>Our innovative and solutions based approach is our commitment to you</h4>
        </div>      
      </div>

      <div class="item">
        <img src="<?php echo base_url();?>assets/images/home-slider-bg2.jpg" alt="" >
        <div class="carousel-caption">
        </div>      
      </div>
    
      <div class="item">
        <img src="<?php echo base_url();?>assets/images/home-slider-bg3.jpg" alt="" >
        <div class="carousel-caption">
        </div>      
      </div>
    </div>

    <!-- Left and right controls 
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
</div>-->
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
							  <h3><?=$projectCount?></h3>
							  <p>Number of Projects</p>
							</div>
						  </div>
					</div>
					<div class="col-lg-3 col-xs-6">
						<div class="small-box bg-green">
							<div class="inner">
							  <h3><?=$employeeCount?></h3>
							  <p>Number of Employees</p>
							</div>
						  </div>
					</div>
				</div>
			</div>
			<?php if(!empty($announcements)){ ?>
			<div class="content-box-large announcements">
				<div class="panel-heading board">
					<div class="panel-title">
						<h3>Announcements</h3>
					</div>
				</div>
				<?php foreach($announcements as $announcement){ ?>
                    <div class="panel-body message">
						<h4><?=$announcement->subject?></h4>
						<p><?=html_entity_decode($announcement->message)?></p>
					</div>
				<?php } ?>
				
			</div>
		    <?php } ?>
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