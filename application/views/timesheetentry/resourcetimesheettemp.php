<div class="page-content">
	<div class="row">
	<?php
		$this->load->view('includes/left_sidebar');
		$startdate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
		$todayd = date('D', strtotime($startdate));
		$todayDM = date('M j', strtotime($startdate));
		$weekOfdays = array();
		$date = new DateTime($startdate);
		for($i=1; $i <= 6; $i++){
					$date->modify('+1 day');
					$weekOfdays[] = $date->format('D');
					$weekOfdate[] = $date->format('M j');
					$arrayDate[] = $date->format('Y-m-d');
			}
		$endDate = $arrayDate[5];
		$datewithSatrt[] = $startdate;
		$AllDate = array_merge($datewithSatrt,$arrayDate);
		$CI =& get_instance();
		//$entryData = $CI->getUserEntryReso($singleStaff[0]['id'],$startdate,$endDate);
		
		//Total Calculation start here
		$AllDate = array_merge($datewithSatrt,$arrayDate);
		$WeekTotal = 0;
					
		$entryData = $CI->getUserEntry($singleStaff[0]['id'],$startdate,$endDate);
		$stratdata = '';		
			$totalTime1 = 0;
			$totalTime2 = 0;
			$totalTime3 = 0;
			$totalTime4 = 0;
			$totalTime5 = 0;
			$totalTime6 = 0;
			$totalTime7 = 0;
			
			if(!empty($entryData)){
				foreach($entryData as $entryVal){
					$entryDate = trim($entryVal['start_date']);
				switch ($entryDate) {
					case $AllDate[0]:
						$totalTime1 = $entryVal['totaltime'];
						break;
					case $AllDate[1]:
						$totalTime2 = $entryVal['totaltime'];
						break;
					case $AllDate[2]:
						$totalTime3 = $entryVal['totaltime'];
						break;
					case $AllDate[3]:
						$totalTime4 = $entryVal['totaltime'];
						break;
					case $AllDate[4]:
						$totalTime5 = $entryVal['totaltime'];
						break;
					case $AllDate[5]:
						$totalTime6 = $entryVal['totaltime'];
						break;
						break;
					case $AllDate[6]:
						$totalTime7 = $entryVal['totaltime'];
						break;
					}
					
				}
			}				
			$WeekTotal = $totalTime1 + $totalTime2 + $totalTime3+ $totalTime4 + $totalTime5 + $totalTime6+$totalTime7;
		
		
	?>
	<div class="col-md-10 padding-left-right">
		<div class="content-box-large">
			<div class="col-md-12 staffinfoheader">
				<div class="col-md-12 staffheading">
				<label>Staff Information</label>
				</div>
			<div class="col-sm-3">
				<label>Name:</label>
			</div>
			<div class="col-sm-6">
				<?php echo $singleStaff[0]['fname'].' '.$singleStaff[0]['lname']; ?>
			</div>
			</div>
			<div class="panel-heading">
				<div class="panel-title">
					<h4>Weekly Summary - <?php echo date('D-M-j', strtotime($startdate)).' to '. date('D-M-j', strtotime($arrayDate[5])); ?> </h4>
				</div>
				<div class="panel-options">
				</div>
			</div>
			<div class="col-md-12">
				<div class="align-right">
					<a href="javaScript:void(0);" class="btn btn-success" data-userid="<?php echo $singleStaff[0]['id']; ?>" id="addtimebtn" >Enter Time Sheet</a>
				</div>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-bordered">
					<?php
						/* echo '<pre>';
						print_r($allSheetData); */
					?>
						<thead>
								<tr>
								<th>
								<span class="geos-summary-heading"><?php echo $todayd; ?><br><?php echo $todayDM; ?></span>
								<span class="geos-summary-text"><?php echo date('H:i',$totalTime1); ?></span></th>
								<th>
									<span class="geos-summary-heading"><?php echo $weekOfdays[0].'</br>'.$weekOfdate[0]; ?></span>
									<span class="geos-summary-text"><?php echo date('H:i',$totalTime2)?>
								</span>
								</th>
								<th>
									<span class="geos-summary-heading"><?php echo $weekOfdays[1].'</br>'.$weekOfdate[1]; ?></span>
									<span class="geos-summary-text"><?php echo date('H:i',$totalTime3);?></span>
								</th>
								<th>
								<span class="geos-summary-heading">
								<?php echo $weekOfdays[2].'</br>'.$weekOfdate[2]?></span>
								<span class="geos-summary-text">
								<?php echo date('H:i',$totalTime4); ?>
								</span>
								</th>
								<th>
								<span class="geos-summary-heading"><?php echo $weekOfdays[3].'</br>'.$weekOfdate[3]; ?></span>
								<span class="geos-summary-text">
								<?php echo date('H:i',$totalTime5); ?></span>
								</th>
								<th>
								<span class="geos-summary-heading">
								<?php echo $weekOfdays[4].'</br>'.$weekOfdate[4]; ?></span>
								<span class="geos-summary-text"><?php echo date('H:i',$totalTime6); ?></span>
								</th>
								
								<th><span class="geos-summary-heading"><?php echo $weekOfdays[5].'</br>'.$weekOfdate[5];?></span>
								<span class="geos-summary-text">
								<?php echo date('H:i',$totalTime7); ?></th>
								
								<th><span class="geos-summary-heading">Total<br></span>
									<span class="geos-summary-text">
									<?php
									$init = $WeekTotal;
									$hours = floor($init / 3600);
									$minutes = floor(($init / 60) % 60);
									echo sprintf("%02d:%02d", $hours, $minutes);?>
									</span>
								</th>
								</tr>
							</thead>
					</table>
					</div>
					<div class="col-md-12 sheetlist">
						<table class="table">
						<?php if(!empty($allSheetData)){?>
							<thead>
								<tr>
								 <th>Date</th>
								 <th>Client Name</th>
								 <th>Note</th>
								 <th>Project</th>
								 <th>Task</th>
								 <th>Time</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($allSheetData as $entryval){ ?>
								<tr>
									<td><?php echo $entryval['start_date']; ?></td>
									<td><?php echo $entryval['company_name']?></td>
									<td><?php echo $entryval['note_text']; ?></td>
									<td><?php echo $entryval['project_name'];?></td>
									<td>
										<?php 
										$CI =& get_instance();
										if($entryval['task_id']!=0){
											$CI->load->model('task_list');
											$subQ = $CI->task_list->getSubTaskById($entryval['subtask_id']);
											if(!empty($subQ))
												echo $subQ[0]->title.' '.$subQ[0]->abbr;
										}else{
											$CI->load->model('project_type');
											$projTQ = $CI->project_type->getProjectTaskById($entryval['project_task_id']);
											if(!empty($projTQ))
												echo $projTQ[0]->title;
										} ?>
									</td>
									<td><span class="duration"><?php echo date('H:i', $entryval['time_entry_duration']);?></span>
									<span><?php echo $entryval['time_from'].'-'.$entryval['time_to']?></span>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						<?php } ?>
						</table>
					
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
 .geos-summary-heading {
    width: 100%;
    float: left;
}
.sheetlist{ margin-top:3%; }
span.duration {
    float: left;
    width: 100%;
}
.geos-summary-text {
    font-size: 22px;
    color: #048abb;
}
input[name="task_ids[]"], input[name="proj_task_ids[]"],input[name="subtask_ids[]"] {
    margin: 5px;
    position: relative;
    top: 1px;
}
.pjt_label{
	margin-top: 10px;
}
span.st_space {
    margin: 0 10px;
}
 </style>
<?php $this->load->view('includes/footer');?>
<script type="text/javascript">
        var startdate = "<?php echo $startdate; ?>";
</script>
<script src="<?php echo base_url(); ?>assets/frontend/js/jquery.validate.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/daterangepicker.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/jquery-ui.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/daterangepicker.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/timesheetentry.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery-ui.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/custommodal.js" charset="utf-8"></script>

