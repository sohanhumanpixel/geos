<div class="page-content">
	<div class="row">
		<?php
		$loginUserId = $_SESSION['logged_in']['user_id'];
		$selectedUid = (isset($_GET['filters']['user'])) ? $_GET['filters']['user'] : $loginUserId;
		$this->load->view('includes/left_sidebar');
		$startdate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
		
		$CI =& get_instance();
		
		
		
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
		
		    ?>
		<div class="col-md-10 padding-left-right">
			<div class="content-box-large">
				<div class="panel-heading">
					<div class="panel-title">
						<h4>Weekly Summary - <?php echo date('D-M-j', strtotime($startdate)).' to '. date('D-M-j', strtotime($arrayDate[5])); ?> </h4>
					</div>
					<div class="panel-options">
						
					</div>
				</div>
				
				<div class="panel-body">
				<?php
					/*echo '<pre>';
		print_r($memberData);
		echo '</pre>'; */
		?>
					<div class="table-responsive">
					<div class="col-md-12">
						<form id="filters" method="get" action="listtimesheet" class="form-inline">
							<div class="form-group">
							  <input type="text" class="form-control" id="datefrom" placeholder="Search Date" name="date" autocomplete = "off">
							  <a class="btn btn-default" href="?date=<?php echo date('Y-m-d'); ?>" id="today">Today</a>
							</div>
							
							<!--<div class="form-group">
							  <label for="user">Member</label>
							  <select name="filters[user]" id="user" onchange="$('#filters').submit();" class="select2 select2-hidden-accessible form-control" tabindex="-1" aria-hidden="true">
							  <?php //foreach($memberData as $memVal){ ?>
							  <option value="<?php //echo $memVal['id'];?>" <?php //if($memVal['id']==$loginUserId){ ?> selected='selected' <?php //} ?>><?php //echo $memVal['fname'].' '.$memVal['lname']; ?></option>
							  <?php // } ?>
							  </select>
							</div>-->	
						</form>
					</div>
					<!--<div class="col-md-12">
							<div class="align-right">
						 <a href="javaScript:void(0);" class="btn btn-success" data-userid="<?php echo $selectedUid; ?>" id="addtimebtn" >Add Time</a>
						 </div>
					</div>-->
						<div class="table_data2">
							<table class="table has-actions">
								<thead>
								<tr>
								<th>Staff</th>
								<th><?php echo $todayd; ?><br><?php echo $todayDM; ?></th>
								<th><?php echo $weekOfdays[0].'</br>'.$weekOfdate[0]; ?></th>
								<th><?php echo $weekOfdays[1].'</br>'.$weekOfdate[1]; ?></th>
								<th><?php echo $weekOfdays[2].'</br>'.$weekOfdate[2]; ?></th>
								<th><?php echo $weekOfdays[3].'</br>'.$weekOfdate[3]; ?></th>
								<th><?php echo $weekOfdays[4].'</br>'.$weekOfdate[4]; ?></th>
								<th><?php echo $weekOfdays[5].'</br>'.$weekOfdate[5]; ?></th>
								<th>Total</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$datewithSatrt[] = $startdate;
								$AllDate = array_merge($datewithSatrt,$arrayDate);
								//echo '<pre>';
								//print_r($AllDate);
								$WeekTotal = 0;
								foreach($memberData as $userVal){
									$userId = $userVal['id'];
									$entryData = $CI->getUserEntry($userId,$startdate,$endDate);
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
									
									//echo '<pre>';
									//print_r($entryData);
									//print_r($arrayDate);
									//echo '</pre>';
									
									//Get Date Wise Entry
									
							?>
								<tr class="time-entry-row">
									<td>
									<div class="project-cell-wrapper">
										<a href="<?php echo base_url(); ?>Timesheetentry/resourcetimesheet/<?php echo $userVal['id'];?>/?date=<?php echo $startdate;?>"><?php echo $userVal['fname'].''.$userVal['lname'];?></a>
									</div>
								</td>
									<td><?php echo date('H:i',$totalTime1)?></td>
									<td><?php echo date('H:i',$totalTime2)?></td>
									<td><?php echo date('H:i',$totalTime3)?></td>
									<td><?php echo date('H:i',$totalTime4)?></td>
									<td><?php echo date('H:i',$totalTime5)?></td>
									<td><?php echo date('H:i',$totalTime6)?></td>
									<td><?php echo date('H:i',$totalTime7)?></td>
									<td><?php 
										$init = $WeekTotal;
										$hours = floor($init / 3600);
										$minutes = floor(($init / 60) % 60);
										echo sprintf("%02d:%02d", $hours, $minutes);
									?></td>
									
								</tr>
								<?php } ?>
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
</div>

  <!-- Edit Model --->
  <div class="modal fade" id="timesheetAddModal" role="dialog">
	
  </div>
<?php $this->load->view('includes/footer');?>
<script type="text/javascript">
        var startdate = "<?php echo $startdate; ?>";
    </script>
<script src="<?php echo base_url(); ?>assets/frontend/js/jquery.validate.min.js" type="text/javascript"></script>
<<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/daterangepicker.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/daterangepicker.js" charset="utf-8"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/timesheetentry.js" charset="utf-8"></script>

  