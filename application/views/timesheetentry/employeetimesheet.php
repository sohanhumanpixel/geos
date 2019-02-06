<div class="page-content">
	<div class="row">
		<?php
		//echo '<pre>';
		//print_r($memberData);
		//print_r($_GET);
		$loginUserId = $_SESSION['logged_in']['user_id'];
		$selectedUid = (isset($_GET['filters']['user'])) ? $_GET['filters']['user'] : $loginUserId;
		//echo '</pre>';
		$this->load->view('includes/left_sidebar');
		$startdate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
		$CI =& get_instance();
		$endDate = $startdate;
		$entryData = $CI->getUserEntry($selectedUid,$startdate,$endDate);
		
		    ?>
		<div class="col-md-10 padding-left-right">
			<div class="content-box-large">
				<div class="panel-heading">
					<div class="panel-title">
						<h4> Daily timesheet </h4>
					</div>
					<div class="panel-options">
						
					</div>
				</div>
				
				<div class="panel-body">
				<?php
					echo '<pre>';
		print_r($entryData);
		echo '</pre>';
		?>
					<div class="table-responsive">
					<div class="col-md-12">
						<form id="filters" method="get" action="listtimesheet" class="form-inline">
							<div class="form-group">
							  <input type="text" class="form-control" id="datefrom" placeholder="Search Date" name="date" autocomplete = "off">
							  <a class="btn btn-default" href="?date=<?php echo date('Y-m-d'); ?>" id="today">Today</a>
							</div>
							
							<div class="form-group">
							  <label for="user">Member</label>
							  <select name="filters[user]" id="user" onchange="$('#filters').submit();" class="select2 select2-hidden-accessible form-control" tabindex="-1" aria-hidden="true">
							  <?php foreach($memberData as $memVal){ ?>
							  <option value="<?php echo $memVal['id'];?>" <?php if($memVal['id']==$loginUserId){ ?> selected='selected' <?php } ?>><?php echo $memVal['fname'].' '.$memVal['lname']; ?></option>
							  <?php } ?>
							  </select>
							</div>	
						</form>
					</div>
					<div class="col-md-12">
							<div class="align-right">
						 <a href="javaScript:void(0);" class="btn btn-success" data-userid="<?php echo $selectedUid; ?>" id="addtimebtn" >Add Time</a>
						 </div>
					</div>
						<div class="table_data2">
							<table class="table has-actions">
								<thead>
								<tr>
								<th>Project</th>
								<th>Notes</th>
								<th>Duration</th>
								<th>Time span</th>
								<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								<tr class="time-entry-row">
									<td>
									<div class="project-cell-wrapper">
										<div class="time-entry-data inline-block" data-id="AZe5eqD5UACF3rqrOIXeuuNY" data-project-id="539856" data-project-name="Project2" data-task-id="" data-task-name="No task" data-user-id="384250">
									<div class="project switcher-wrapper">
										<div class="name switcher strong">Project2</div>
									</div>
									
										<div class="task switcher-wrapper"><div class="name switcher">No task</div><div class="selector hidden"></div></div>
										</div>
									</div>
								</td>
									<td>notes value</td>
									<td>3 hours</td>
									<td>3 hours</td>
									<td class="text-center">
										<a class="btn btn-sm btn-info" href="<?php echo base_url(); ?>" data-toggle="tooltip" title="Edit"><i class="glyphicon glyphicon-pencil"></i></a>
										<a class="btn btn-sm btn-danger deleteUser" href="javaScript:void(0);" data-userid="" data-toggle="tooltip" title="Delete"><i class="glyphicon glyphicon-trash"></i></a>
									</td>
								</tr>
							</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

  <!-- Edit Model --->
  <div class="modal fade" id="timesheetAddModal" role="dialog">
	
  </div>
  <style>
	.align-right {
    float: right;
    margin-right: 10px;
	}
  </style>
<?php $this->load->view('includes/footer');?>
<script type="text/javascript">
        var startdate = "<?php echo $startdate; ?>";
    </script>
<script src="<?php echo base_url(); ?>assets/frontend/js/jquery.validate.min.js" type="text/javascript"></script>
<<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/daterangepicker.css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/daterangepicker.js" charset="utf-8"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/timesheetentry.js" charset="utf-8"></script>

  