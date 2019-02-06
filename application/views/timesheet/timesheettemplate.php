<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/jquery-ui.css">
<div class="page-content">
	<div class="row">
	<?php $this->load->view('includes/left_sidebar');?>
		<!--<?php //$this->load->view('includes/left_sidebar');?> -->
		<?php
		/* echo '<pre>';
		print_r($bookingData);
		echo '</pre>'; */
		$todaydate = isset($_GET['pevnextdate']) ? $_GET['pevnextdate'] : date('Y-m-d');
		$prev_date = date('Y-m-d', strtotime($todaydate .' -1 day'));
		$next_date = date('Y-m-d', strtotime($todaydate .' +1 day'));
		$prevcont = round((time() - strtotime($prev_date))/(60 * 60 * 24));
		$nextcont = round((strtotime($next_date) - time())/(60 * 60 * 24));
		$prevanchor = ($prevcont<5) ? "?pevnextdate=$prev_date" : "javaScript:void(0);";
		$nextanchorval = ($nextcont<5) ? "?pevnextdate=$next_date" : "javaScript:void(0);";
			//$todaydate = date('Y-m-d'); //today date
			//$todayd = date('D');
			$todayd = date('D', strtotime($todaydate));;
			$weekOfdays = array();
			$date = new DateTime($todaydate);
			/* $date->modify('+1 day');
			$dateDay2 = $date->format('D');
			$date2 = $date->format('Y-m-d');
			//Third Day
			$date->modify('+1 day');
			$dateDay3 = $date->format('D');
			$date3 = $date->format('Y-m-d'); */
			
				for($i=1; $i <= 6; $i++){
					$date->modify('+1 day');
					$weekOfdays[] = $date->format('D');
					$weekOfdate[] = $date->format('Y-m-d');
				}
				//echo "<pre>";print_r($weekOfdate);echo "</pre>";
				/*$daystd = '<td>'.$todayd.' '.$todaydate.'</td>';
				foreach($weekOfdays as $weekval){
					$dateDayExp = explode(':', $weekval);
					$daystdday .= '<td>'.$dateDayExp[0].'</td>';
					$daystdate.= '<td>'.$dateDayExp[1].'</td>';
				} */

		    ?>
		<div class="col-md-10 padding-left-right">
			<div class="row panel-heading">
				<div class="col-md-2">
					<div class="panel-title">
						<h3> SCHEDULE </h3>
					</div>
				</div>
				<div class="col-md-7" style="padding: 0">
					<h3>Unassigned Bookings</h3>
					<div class="unassigned_div">
						<table class="table table-bordered">
							<tbody>
							<?php if(!empty($bookingData)){
								$taskName = '';
								foreach($bookingData as $bookval){
									if($bookval->task_ids!=''){
										$taskIds = $bookval->task_ids;
										$taskQuery = $this->db->query("SELECT id, CONCAT(title, ' ', abbr) AS task_names FROM tasks WHERE id IN($taskIds)");
										
										$taskResult = $taskQuery->result_array();
										
										$stringVal =  array_values(array_column($taskResult, 'task_names'));
										
										$taskName = implode(', ', $stringVal);
									}
									$project_id = $bookval->project_id;
									$projQu = $this->db->query("SELECT id,project_name FROM projects WHERE id=$project_id");
									$projRes = $projQu->result_array();
									$project_n = $projRes[0]['project_name'];
								?>
								<tr class="unassigned_trs unassigned_trs_<?=$bookval->id;?>" data-id="<?=$bookval->id;?>">
									<td class="draggable_td" data-id="<?php echo $bookval->id; ?>"><span class="fa fa-arrows"></span></td>
									<td><?php echo $bookval->company_name;?></td>
									<td><?php echo $bookval->contact_name;?></td>
									<td><?php echo $bookval->pfrd_date;?></td>
									<td><?php echo $bookval->est_time;?></td>
									<td><?php echo $project_n;?></td>
									<td><?php echo $taskName;?></td>
								</tr>
							<?php
								}
							} ?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="col-md-3">
					<ul class="pager">
						<li><a class="" href="<?php echo $prevanchor; ?>">Previous Date</a></li>
						<li><a class="" href="<?php echo $nextanchorval; ?>">Next Date</a></li>
					</ul>
					<div class="text-center">
						<a href="javascript:void(0)" id="lockAll">Lock Schedule</a>
					</div>
				</div>
				
			</div>
				<!--<div class="col-md-10">
					<div class="row">
					<div class="col-md-8">
						<div class="col-md-4">
							<a class="prev btn btn-default" data-date="<?php echo $prevanchor; ?>" href="<?php echo $prevanchor; ?>"><span class="glyphicon glyphicon-arrow-left"></span></a>
						
						<a class="next btn btn-default" data-date="<?php echo $nextanchorval; ?>" href="<?php echo $nextanchorval; ?>"><i class="glyphicon glyphicon-arrow-right"></i></a>
						</div>
						<div class="col-md-4">
						<a class="datepicker weekly-range-input margin-bottom-sm margin-right-10">
						<input class="form-control" data-auto-update-input="false" data-date="<?php echo $todaydate; ?>" data-min-date="2015-10-01" data-start-week-on="0" value="Mon, Oct 8, 2018 - Sun, Oct 14, 2018"></a>
						</div>
						<div class="col-md-4">
						<a class="today btn btn-default margin-bottom-xs js-filter-date-actions" data-date="<?php echo $currentDate;?>" data-date-end="2018-10-14" href="<?php echo $currentDate;?>">Today</a>
						</div>
					</div>
				
						
						
					</div>
				</div>-->
				
				
				<div class="panel-body">
					
					<div class="table-responsive">
						<div class="table_data">
						<table class="table table-striped text-center" border="1">
							 <tr class="table_heading border_bottom" height="24" style=''>
								  <td height="24"  width="94">Employees</td>
								  <td class=""  style='width:60pt'>Tasks</td>
								  <td class=""  style='width:188pt'><?php echo $todayd; ?> <?php echo $todaydate; ?></td>
								  <td class="" style='width:209pt'><?php echo $weekOfdays[0]; ?> <?php echo $weekOfdate[0]; ?></td>
								  <td class=""  style='width:188pt'><?php echo $weekOfdays[1]; ?> <?php echo $weekOfdate[1]; ?></td>
								  <td class=""  style='width:188pt'><?php echo $weekOfdays[2];?> <?php echo $weekOfdate[2]; ?> </td>
								  <td class=""  style='width:188pt'><?php echo $weekOfdays[3]; ?> <?php echo $weekOfdate[3]; ?> </td>
								  <td class=""  style='width:188pt'><?php echo $weekOfdays[4]; ?> <?php echo $weekOfdate[4]; ?> </td>
								  <td class=""  style='width:188pt'><?php echo $weekOfdays[5]; ?> <?php echo $weekOfdate[5]; ?> </td>
								 </tr>
						 
								 <!---<tr class="table_heading  border_bottom" height="24">
								  <td height="24" style='height:18.0pt'>&nbsp;</td>
								  <td>&nbsp;</td>
								  <td><?php echo $todaydate; ?></td>
								  <td><?php echo $weekOfdate[0]; ?></td>
								  <td><?php echo $weekOfdate[1]; ?></td>
								  <td><?php echo $weekOfdate[2]; ?></td>
								  <td><?php echo $weekOfdate[3]; ?></td>
								 </tr>-->
								 
								 <?php
								 $CI =& get_instance();
								 //foreach($ptypedata as $ptkey=>$ptypeval){
									$ptypeId = 1;
									$shhetData = $CI->getEmployee($todaydate);
									//echo '<pre>';print_r($shhetData);echo '</pre>sss';
									foreach($shhetData as $key => $shtVal){
										//echo '<pre>';print_r($shtVal);echo '</pre>';
										foreach($shtVal['userTimeSheetData'] as $k => $val){
											if($val['task_ids']!=""){
												$tIDs = explode(',', $val['task_ids']);
												$taskNAr = array();
												$task_number = $val['job_number'];
												foreach($tIDs as $tId){
													$q = $this->db->query("SELECT id, title, abbr FROM tasks WHERE id=$tId");
													$r = $q->result_array();
													$task_number .= '-'.$r[0]['abbr'];
													array_push($taskNAr, $r[0]['title'].' '.$r[0]['abbr']);
												}
												$taskNames = implode(',', $taskNAr);
												$shhetData[$key]['userTimeSheetData'][$k]['task_ids'] = $taskNames;
												$shhetData[$key]['userTimeSheetData'][$k]['task_number'] = $task_number;
											}else{
												$tIDs = '';
												$shhetData[$key]['userTimeSheetData'][$k]['task_ids'] = 'No Tasks';
												$shhetData[$key]['userTimeSheetData'][$k]['task_number'] = '';
											}
										}
										
									}
									
									//echo '<pre>';print_r($shhetData);echo '</pre>';
									$collapsedcls = 'collapsed';
									$accoinout = 'out';
									//if($ptkey == 0 ){
										//$collapsedcls = '';
										//$accoinout = 'in';
									//}
								 ?>
								 
								  <!--<tr class="table_heading border_accordian" data-pid="<?=$ptypeId?>" height="24">
									  <td height="24" colspan="7">
									  <div class="accordion-toggle <?php echo $collapsedcls;?> " ><?php echo $ptypeval->project_type_name; ?></div>
									  </td>
								  </tr>-->
								<?php
								foreach($shhetData as $key => $sheetval){
									$userData = $sheetval['userData'];
									$sheetData = $sheetval['userTimeSheetData'];
									
									//echo '<pre>'; print_r($sheetData);
									
									$fullname = $userData['fname'].' '.$userData['lname'];
									if(!empty($sheetData)){
										$td1_1100 = '<td '.$this->timesheetsModel->checkAllDay($todaydate,$userData['userId']).'><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$todaydate.'" data-empname="'.$fullname.'">Add</button></td>';
										
										$td2_1100 = '<td '.$this->timesheetsModel->checkAllDay($weekOfdate[0],$userData['userId']).'><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[0].'" data-empname="'.$fullname.'">Add</button></td>';
										
										$td3_1100 = '<td '.$this->timesheetsModel->checkAllDay($weekOfdate[1],$userData['userId']).'><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[1].'" data-empname="'.$fullname.'">Add</button></td>';
										
										$td4_1100 = '<td '.$this->timesheetsModel->checkAllDay($weekOfdate[2],$userData['userId']).'><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[2].'" data-empname="'.$fullname.'">Add</button></td>';
										
										$td5_1100 = '<td '.$this->timesheetsModel->checkAllDay($weekOfdate[3],$userData['userId']).'><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[3].'" data-empname="'.$fullname.'">Add</button></td>';

										$td6_1100 = '<td '.$this->timesheetsModel->checkAllDay($weekOfdate[4],$userData['userId']).'><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[4].'" data-empname="'.$fullname.'">Add</button></td>';

										$td7_1100 = '<td '.$this->timesheetsModel->checkAllDay($weekOfdate[5],$userData['userId']).'><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[5].'" data-empname="'.$fullname.'">Add</button></td>';

										$td1_1400 = '<td '.$this->timesheetsModel->checkAllDay($todaydate,$userData['userId']).'><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$todaydate.'" data-empname="'.$fullname.'">Add</button></td>';
										
										$td2_1400 = '<td '.$this->timesheetsModel->checkAllDay($weekOfdate[0],$userData['userId']).'><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[0].'" data-empname="'.$fullname.'">Add</button></td>';
										
										$td3_1400 = '<td '.$this->timesheetsModel->checkAllDay($weekOfdate[1],$userData['userId']).'><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[1].'" data-empname="'.$fullname.'">Add</button></td>';
										
										
										$td4_1400 = '<td '.$this->timesheetsModel->checkAllDay($weekOfdate[2],$userData['userId']).'><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[2].'" data-empname="'.$fullname.'">Add</button></td>';
										
										$td5_1400 = '<td '.$this->timesheetsModel->checkAllDay($weekOfdate[3],$userData['userId']).'><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[3].'" data-empname="'.$fullname.'">Add</button></td>';

										$td6_1400 = '<td '.$this->timesheetsModel->checkAllDay($weekOfdate[4],$userData['userId']).'><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[4].'" data-empname="'.$fullname.'">Add</button></td>';

										$td7_1400 = '<td '.$this->timesheetsModel->checkAllDay($weekOfdate[5],$userData['userId']).'><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[5].'" data-empname="'.$fullname.'">Add</button></td>';
										
										$td1_t4 = '<td '.$this->timesheetsModel->checkAllDay($todaydate,$userData['userId']).'><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$todaydate.'" data-empname="'.$fullname.'">Add</button></td>';
										
										$td2_t4 = '<td '.$this->timesheetsModel->checkAllDay($weekOfdate[0],$userData['userId']).'><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[0].'" data-empname="'.$fullname.'">Add</button></td>';
										
										$td3_t4 = '<td '.$this->timesheetsModel->checkAllDay($weekOfdate[1],$userData['userId']).'><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[1].'" data-empname="'.$fullname.'">Add</button></td>';
										
										
										$td4_t4 = '<td '.$this->timesheetsModel->checkAllDay($weekOfdate[2],$userData['userId']).'><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[2].'" data-empname="'.$fullname.'">Add</button></td>';
										
										$td5_t4 = '<td '.$this->timesheetsModel->checkAllDay($weekOfdate[3],$userData['userId']).'><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[3].'" data-empname="'.$fullname.'">Add</button></td>';

										$td6_t4 = '<td '.$this->timesheetsModel->checkAllDay($weekOfdate[4],$userData['userId']).'><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[4].'" data-empname="'.$fullname.'">Add</button></td>';

										$td7_t4 = '<td '.$this->timesheetsModel->checkAllDay($weekOfdate[5],$userData['userId']).'><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[5].'" data-empname="'.$fullname.'">Add</button></td>';
										
										$td1_t5 = '<td '.$this->timesheetsModel->checkAllDay($todaydate,$userData['userId']).'><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$todaydate.'" data-empname="'.$fullname.'">Add</button></td>';
										
										$td2_t5= '<td '.$this->timesheetsModel->checkAllDay($weekOfdate[0],$userData['userId']).'><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[0].'" data-empname="'.$fullname.'">Add</button></td>';
										
										$td3_t5 = '<td '.$this->timesheetsModel->checkAllDay($weekOfdate[1],$userData['userId']).'><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[1].'" data-empname="'.$fullname.'">Add</button></td>';
										
										$td4_t5 = '<td '.$this->timesheetsModel->checkAllDay($weekOfdate[2],$userData['userId']).'><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[2].'" data-empname="'.$fullname.'">Add</button></td>';
										
										$td5_t5 = '<td '.$this->timesheetsModel->checkAllDay($weekOfdate[3],$userData['userId']).'><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[3].'" data-empname="'.$fullname.'">Add</button></td>';

										$td6_t5 = '<td '.$this->timesheetsModel->checkAllDay($weekOfdate[4],$userData['userId']).'><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[4].'" data-empname="'.$fullname.'">Add</button></td>';

										$td7_t5 = '<td '.$this->timesheetsModel->checkAllDay($weekOfdate[5],$userData['userId']).'><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[5].'" data-empname="'.$fullname.'">Add</button></td>';

										$td1_t6 = '<td '.$this->timesheetsModel->checkAllDay($todaydate,$userData['userId']).'><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$todaydate.'" data-empname="'.$fullname.'">Add</button></td>';
										
										$td2_t6 = '<td '.$this->timesheetsModel->checkAllDay($weekOfdate[0],$userData['userId']).'><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[0].'" data-empname="'.$fullname.'">Add</button></td>';
										
										$td3_t6 = '<td '.$this->timesheetsModel->checkAllDay($weekOfdate[1],$userData['userId']).'><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[1].'" data-empname="'.$fullname.'">Add</button></td>';
										
										
										$td4_t6 = '<td '.$this->timesheetsModel->checkAllDay($weekOfdate[2],$userData['userId']).'><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[2].'" data-empname="'.$fullname.'">Add</button></td>';
										
										$td5_t6 = '<td '.$this->timesheetsModel->checkAllDay($weekOfdate[3],$userData['userId']).'><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[3].'" data-empname="'.$fullname.'">Add</button></td>';

										$td6_t6 = '<td '.$this->timesheetsModel->checkAllDay($weekOfdate[4],$userData['userId']).'><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[4].'" data-empname="'.$fullname.'">Add</button></td>';

										$td7_t6 = '<td '.$this->timesheetsModel->checkAllDay($weekOfdate[5],$userData['userId']).'><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[5].'" data-empname="'.$fullname.'">Add</button></td>';
										
										$TodayFilter = $CI->filtersamedate($sheetData,$todaydate);
										//echo "<pre>";print_r($TodayFilter);echo "</pre>";
										$rowsQu = $this->db->query('SELECT * FROM employee_rows WHERE employee_id='.$userData['userId'].' AND project_type_id='.$ptypeId.'');
										$rowsR = $rowsQu->result_array();
										if(!empty($rowsR)){
											$countRows = $rowsR[0]['total_rows'];
										}else{
											$countRows = 3;
										}
										if(@$TodayFilter[0]['is_locked']==0){
											$is_locked_t_0 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_t_0 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>'; 
										}else{
											$is_locked_t_0 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_t_0 = "";
										}
										if(@$TodayFilter[1]['is_locked']==0){
											$is_locked_t_1 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_t_1 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_t_1 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_t_1 = '';
										}
										if(@$TodayFilter[2]['is_locked']==0){
											$is_locked_t_2 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_t_2 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_t_2 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_t_2 = '';
										}
										if(@$TodayFilter[3]['is_locked']==0){
											$is_locked_t_3 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_t_3 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_t_3 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_t_3 = '';
										}
										if(@$TodayFilter[4]['is_locked']==0){
											$is_locked_t_4 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_t_4 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_t_4 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_t_4 = '';
										}
										if(@$TodayFilter[5]['is_locked']==0){
											$is_locked_t_5 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_t_5 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_t_5 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_t_5 = '';
										}

										$rowSpan_t_0 = @$TodayFilter[0]['all_day']==1 ? $countRows : "";
										$rowSpan_t_1 = @$TodayFilter[1]['all_day']==1 ? $countRows : "";
										$rowSpan_t_2 = @$TodayFilter[2]['all_day']==1 ? $countRows : "";
										$rowSpan_t_3 = @$TodayFilter[3]['all_day']==1 ? $countRows : "";
										$rowSpan_t_4 = @$TodayFilter[4]['all_day']==1 ? $countRows : "";
										$rowSpan_t_5 = @$TodayFilter[5]['all_day']==1 ? $countRows : "";

											switch (count($TodayFilter)) {
				
											case 1:
											$hover_cont  = 'hover_container';
												$td1_700 = '<td rowspan="'.$rowSpan_t_0.'"><div style="background-color:'.$TodayFilter[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$TodayFilter[0]['job_number'].'</h4><h4>Task Number:'.$TodayFilter[0]['task_number'].'</h4><h4>Booking Time:'.$TodayFilter[0]['schedule_date'].'</h4><h4>Site:'.$TodayFilter[0]['project_name'].'</h4><h4>Client:'.$TodayFilter[0]['client_name'].'</h4><h4>Tasks:'.$TodayFilter[0]['task_ids'].'</h4><h4>Contact:'.$TodayFilter[0]['project_address'].'</h4><h4>Instructions:'.$TodayFilter[0]['instructions'].'</h4></div>">'.$TodayFilter[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$TodayFilter[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$TodayFilter[0]['is_locked'].'">'.$is_edit_t_0.''.$is_locked_t_0.'</div></td>';
												break;
											case 2:
												$td1_700 = '<td rowspan="'.$rowSpan_t_0.'"><div style="background-color:'.$TodayFilter[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$TodayFilter[0]['job_number'].'</h4><h4>Task Number:'.$TodayFilter[0]['task_number'].'</h4><h4>Booking Time:'.$TodayFilter[0]['schedule_date'].'</h4><h4>Site:'.$TodayFilter[0]['project_name'].'</h4><h4>Client:'.$TodayFilter[0]['client_name'].'</h4><h4>Tasks:'.$TodayFilter[0]['task_ids'].'</h4><h4>Contact:'.$TodayFilter[0]['project_address'].'</h4><h4>Instructions:'.$TodayFilter[0]['instructions'].'</h4></div>">'.$TodayFilter[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$TodayFilter[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$TodayFilter[0]['is_locked'].'">'.$is_edit_t_0.''.$is_locked_t_0.'</div></td>';
												$td1_1100 = '<td rowspan="'.$rowSpan_t_1.'"><div style="background-color:'.$TodayFilter[1]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$TodayFilter[1]['job_number'].'</h4><h4>Task Number:'.$TodayFilter[1]['task_number'].'</h4><h4>Booking Time:'.$TodayFilter[1]['schedule_date'].'</h4><h4>Site:'.$TodayFilter[1]['project_name'].'</h4><h4>Client:'.$TodayFilter[1]['client_name'].'</h4><h4>Tasks:'.$TodayFilter[1]['task_ids'].'</h4><h4>Contact:'.$TodayFilter[1]['project_address'].'</h4><h4>Instructions:'.$TodayFilter[1]['instructions'].'</h4></div>">'.$TodayFilter[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$TodayFilter[1]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$TodayFilter[1]['is_locked'].'">'.$is_edit_t_1.''.$is_locked_t_1.'</div></td>';
												break;
											case 3:
												$td1_700 = '<td rowspan="'.$rowSpan_t_0.'"><div style="background-color:'.$TodayFilter[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$TodayFilter[0]['job_number'].'</h4><h4>Task Number:'.$TodayFilter[0]['task_number'].'</h4><h4>Booking Time:'.$TodayFilter[0]['schedule_date'].'</h4><h4>Site:'.$TodayFilter[0]['project_name'].'</h4><h4>Client:'.$TodayFilter[0]['client_name'].'</h4><h4>Tasks:'.$TodayFilter[0]['task_ids'].'</h4><h4>Contact:'.$TodayFilter[0]['project_address'].'</h4><h4>Instructions:'.$TodayFilter[0]['instructions'].'</h4></div>">'.$TodayFilter[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$TodayFilter[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$TodayFilter[0]['is_locked'].'">'.$is_edit_t_0.''.$is_locked_t_0.'</div></td>';
												$td1_1100 = '<td rowspan="'.$rowSpan_t_1.'"><div style="background-color:'.$TodayFilter[1]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$TodayFilter[1]['job_number'].'</h4><h4>Task Number:'.$TodayFilter[1]['task_number'].'</h4><h4>Booking Time:'.$TodayFilter[1]['schedule_date'].'</h4><h4>Site:'.$TodayFilter[1]['project_name'].'</h4><h4>Client:'.$TodayFilter[1]['client_name'].'</h4><h4>Tasks:'.$TodayFilter[1]['task_ids'].'</h4><h4>Contact:'.$TodayFilter[1]['project_address'].'</h4><h4>Instructions:'.$TodayFilter[1]['instructions'].'</h4></div>">'.$TodayFilter[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$TodayFilter[1]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$TodayFilter[1]['is_locked'].'">'.$is_edit_t_1.''.$is_locked_t_1.'</div></td>';
												$td1_1400 = '<td rowspan="'.$rowSpan_t_2.'"><div style="background-color:'.$TodayFilter[2]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$TodayFilter[2]['job_number'].'</h4><h4>Task Number:'.$TodayFilter[2]['task_number'].'</h4><h4>Booking Time:'.$TodayFilter[2]['schedule_date'].'</h4><h4>Site:'.$TodayFilter[2]['project_name'].'</h4><h4>Client:'.$TodayFilter[2]['client_name'].'</h4><h4>Tasks:'.$TodayFilter[2]['task_ids'].'</h4><h4>Contact:'.$TodayFilter[2]['project_address'].'</h4><h4>Instructions:'.$TodayFilter[2]['instructions'].'</h4></div>">'.$TodayFilter[2]['instructions'].'</div><div class="edit_schedule" data-editid="'.$TodayFilter[2]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$TodayFilter[2]['is_locked'].'">'.$is_edit_t_2.''.$is_locked_t_2.'</div></td>';
												break;
											case 4:
												$td1_700 = '<td rowspan="'.$rowSpan_t_0.'"><div style="background-color:'.$TodayFilter[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$TodayFilter[0]['job_number'].'</h4><h4>Task Number:'.$TodayFilter[0]['task_number'].'</h4><h4>Booking Time:'.$TodayFilter[0]['schedule_date'].'</h4><h4>Site:'.$TodayFilter[0]['project_name'].'</h4><h4>Client:'.$TodayFilter[0]['client_name'].'</h4><h4>Tasks:'.$TodayFilter[0]['task_ids'].'</h4><h4>Contact:'.$TodayFilter[0]['project_address'].'</h4><h4>Instructions:'.$TodayFilter[0]['instructions'].'</h4></div>">'.$TodayFilter[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$TodayFilter[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$TodayFilter[0]['is_locked'].'">'.$is_edit_t_0.''.$is_locked_t_0.'</div></td>';
												$td1_1100 = '<td rowspan="'.$rowSpan_t_1.'"><div style="background-color:'.$TodayFilter[1]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$TodayFilter[1]['job_number'].'</h4><h4>Task Number:'.$TodayFilter[1]['task_number'].'</h4><h4>Booking Time:'.$TodayFilter[1]['schedule_date'].'</h4><h4>Site:'.$TodayFilter[1]['project_name'].'</h4><h4>Client:'.$TodayFilter[1]['client_name'].'</h4><h4>Tasks:'.$TodayFilter[1]['task_ids'].'</h4><h4>Contact:'.$TodayFilter[1]['project_address'].'</h4><h4>Instructions:'.$TodayFilter[1]['instructions'].'</h4></div>">'.$TodayFilter[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$TodayFilter[1]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$TodayFilter[1]['is_locked'].'">'.$is_edit_t_1.''.$is_locked_t_1.'</div></td>';
												$td1_1400 = '<td rowspan="'.$rowSpan_t_2.'"><div style="background-color:'.$TodayFilter[2]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$TodayFilter[2]['job_number'].'</h4><h4>Task Number:'.$TodayFilter[2]['task_number'].'</h4><h4>Booking Time:'.$TodayFilter[2]['schedule_date'].'</h4><h4>Site:'.$TodayFilter[2]['project_name'].'</h4><h4>Client:'.$TodayFilter[2]['client_name'].'</h4><h4>Tasks:'.$TodayFilter[2]['task_ids'].'</h4><h4>Contact:'.$TodayFilter[2]['project_address'].'</h4><h4>Instructions:'.$TodayFilter[2]['instructions'].'</h4></div>">'.$TodayFilter[2]['instructions'].'</div><div class="edit_schedule" data-editid="'.$TodayFilter[2]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$TodayFilter[2]['is_locked'].'">'.$is_edit_t_2.''.$is_locked_t_2.'</div></td>';
												$td1_t4 = '<td rowspan="'.$rowSpan_t_3.'"><div style="background-color:'.$TodayFilter[3]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$TodayFilter[3]['job_number'].'</h4><h4>Task Number:'.$TodayFilter[3]['task_number'].'</h4><h4>Booking Time:'.$TodayFilter[3]['schedule_date'].'</h4><h4>Site:'.$TodayFilter[3]['project_name'].'</h4><h4>Client:'.$TodayFilter[3]['client_name'].'</h4><h4>Tasks:'.$TodayFilter[3]['task_ids'].'</h4><h4>Contact:'.$TodayFilter[3]['project_address'].'</h4><h4>Instructions:'.$TodayFilter[3]['instructions'].'</h4></div>">'.$TodayFilter[3]['instructions'].'</div><div class="edit_schedule" data-editid="'.$TodayFilter[3]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$TodayFilter[3]['is_locked'].'">'.$is_edit_t_3.''.$is_locked_t_3.'</div></td>';
												break;
											case 5:
												$td1_700 = '<td rowspan="'.$rowSpan_t_0.'"><div style="background-color:'.$TodayFilter[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$TodayFilter[0]['job_number'].'</h4><h4>Task Number:'.$TodayFilter[0]['task_number'].'</h4><h4>Booking Time:'.$TodayFilter[0]['schedule_date'].'</h4><h4>Site:'.$TodayFilter[0]['project_name'].'</h4><h4>Client:'.$TodayFilter[0]['client_name'].'</h4><h4>Tasks:'.$TodayFilter[0]['task_ids'].'</h4><h4>Contact:'.$TodayFilter[0]['project_address'].'</h4><h4>Instructions:'.$TodayFilter[0]['instructions'].'</h4></div>">'.$TodayFilter[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$TodayFilter[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$TodayFilter[0]['is_locked'].'">'.$is_edit_t_0.''.$is_locked_t_0.'</div></td>';
												$td1_1100 = '<td rowspan="'.$rowSpan_t_1.'"><div style="background-color:'.$TodayFilter[1]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$TodayFilter[1]['job_number'].'</h4><h4>Task Number:'.$TodayFilter[1]['task_number'].'</h4><h4>Booking Time:'.$TodayFilter[1]['schedule_date'].'</h4><h4>Site:'.$TodayFilter[1]['project_name'].'</h4><h4>Client:'.$TodayFilter[1]['client_name'].'</h4><h4>Tasks:'.$TodayFilter[1]['task_ids'].'</h4><h4>Contact:'.$TodayFilter[1]['project_address'].'</h4><h4>Instructions:'.$TodayFilter[1]['instructions'].'</h4></div>">'.$TodayFilter[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$TodayFilter[1]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$TodayFilter[1]['is_locked'].'">'.$is_edit_t_1.''.$is_locked_t_1.'</div></td>';
												$td1_1400 = '<td rowspan="'.$rowSpan_t_2.'"><div style="background-color:'.$TodayFilter[2]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$TodayFilter[2]['job_number'].'</h4><h4>Task Number:'.$TodayFilter[2]['task_number'].'</h4><h4>Booking Time:'.$TodayFilter[2]['schedule_date'].'</h4><h4>Site:'.$TodayFilter[2]['project_name'].'</h4><h4>Client:'.$TodayFilter[2]['client_name'].'</h4><h4>Tasks:'.$TodayFilter[2]['task_ids'].'</h4><h4>Contact:'.$TodayFilter[2]['project_address'].'</h4><h4>Instructions:'.$TodayFilter[2]['instructions'].'</h4></div>">'.$TodayFilter[2]['instructions'].'</div><div class="edit_schedule" data-editid="'.$TodayFilter[2]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$TodayFilter[2]['is_locked'].'">'.$is_edit_t_2.''.$is_locked_t_2.'</div></td>';
												$td1_t4 = '<td rowspan="'.$rowSpan_t_3.'"><div style="background-color:'.$TodayFilter[3]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$TodayFilter[3]['job_number'].'</h4><h4>Task Number:'.$TodayFilter[3]['task_number'].'</h4><h4>Booking Time:'.$TodayFilter[3]['schedule_date'].'</h4><h4>Site:'.$TodayFilter[3]['project_name'].'</h4><h4>Client:'.$TodayFilter[3]['client_name'].'</h4><h4>Tasks:'.$TodayFilter[3]['task_ids'].'</h4><h4>Contact:'.$TodayFilter[3]['project_address'].'</h4><h4>Instructions:'.$TodayFilter[3]['instructions'].'</h4></div>">'.$TodayFilter[3]['instructions'].'</div><div class="edit_schedule" data-editid="'.$TodayFilter[3]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$TodayFilter[3]['is_locked'].'">'.$is_edit_t_3.''.$is_locked_t_3.'</div></td>';
												$td1_t5 = '<td rowspan="'.$rowSpan_t_4.'"><div style="background-color:'.$TodayFilter[4]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$TodayFilter[4]['job_number'].'</h4><h4>Task Number:'.$TodayFilter[4]['task_number'].'</h4><h4>Booking Time:'.$TodayFilter[4]['schedule_date'].'</h4><h4>Site:'.$TodayFilter[4]['project_name'].'</h4><h4>Client:'.$TodayFilter[4]['client_name'].'</h4><h4>Tasks:'.$TodayFilter[4]['task_ids'].'</h4><h4>Contact:'.$TodayFilter[4]['project_address'].'</h4><h4>Instructions:'.$TodayFilter[4]['instructions'].'</h4></div>">'.$TodayFilter[4]['instructions'].'</div><div class="edit_schedule" data-editid="'.$TodayFilter[4]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$TodayFilter[4]['is_locked'].'">'.$is_edit_t_4.''.$is_locked_t_4.'</div></td>';
												break;
											case 6:
												$td1_700 = '<td rowspan="'.$rowSpan_t_0.'"><div style="background-color:'.$TodayFilter[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$TodayFilter[0]['job_number'].'</h4><h4>Task Number:'.$TodayFilter[0]['task_number'].'</h4><h4>Booking Time:'.$TodayFilter[0]['schedule_date'].'</h4><h4>Site:'.$TodayFilter[0]['project_name'].'</h4><h4>Client:'.$TodayFilter[0]['client_name'].'</h4><h4>Tasks:'.$TodayFilter[0]['task_ids'].'</h4><h4>Contact:'.$TodayFilter[0]['project_address'].'</h4><h4>Instructions:'.$TodayFilter[0]['instructions'].'</h4></div>">'.$TodayFilter[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$TodayFilter[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$TodayFilter[0]['is_locked'].'">'.$is_edit_t_0.''.$is_locked_t_0.'</div></td>';
												$td1_1100 = '<td rowspan="'.$rowSpan_t_1.'"><div style="background-color:'.$TodayFilter[1]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$TodayFilter[1]['job_number'].'</h4><h4>Task Number:'.$TodayFilter[1]['task_number'].'</h4><h4>Booking Time:'.$TodayFilter[1]['schedule_date'].'</h4><h4>Site:'.$TodayFilter[1]['project_name'].'</h4><h4>Client:'.$TodayFilter[1]['client_name'].'</h4><h4>Tasks:'.$TodayFilter[1]['task_ids'].'</h4><h4>Contact:'.$TodayFilter[1]['project_address'].'</h4><h4>Instructions:'.$TodayFilter[1]['instructions'].'</h4></div>">'.$TodayFilter[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$TodayFilter[1]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$TodayFilter[1]['is_locked'].'">'.$is_edit_t_1.''.$is_locked_t_1.'</div></td>';
												$td1_1400 = '<td rowspan="'.$rowSpan_t_2.'"><div style="background-color:'.$TodayFilter[2]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$TodayFilter[2]['job_number'].'</h4><h4>Task Number:'.$TodayFilter[2]['task_number'].'</h4><h4>Booking Time:'.$TodayFilter[2]['schedule_date'].'</h4><h4>Site:'.$TodayFilter[2]['project_name'].'</h4><h4>Client:'.$TodayFilter[2]['client_name'].'</h4><h4>Tasks:'.$TodayFilter[2]['task_ids'].'</h4><h4>Contact:'.$TodayFilter[2]['project_address'].'</h4><h4>Instructions:'.$TodayFilter[2]['instructions'].'</h4></div>">'.$TodayFilter[2]['instructions'].'</div><div class="edit_schedule" data-editid="'.$TodayFilter[2]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$TodayFilter[2]['is_locked'].'">'.$is_edit_t_2.''.$is_locked_t_2.'</div></td>';
												$td1_t4 = '<td rowspan="'.$rowSpan_t_3.'"><div style="background-color:'.$TodayFilter[3]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$TodayFilter[3]['job_number'].'</h4><h4>Task Number:'.$TodayFilter[3]['task_number'].'</h4><h4>Booking Time:'.$TodayFilter[3]['schedule_date'].'</h4><h4>Site:'.$TodayFilter[3]['project_name'].'</h4><h4>Client:'.$TodayFilter[3]['client_name'].'</h4><h4>Tasks:'.$TodayFilter[3]['task_ids'].'</h4><h4>Contact:'.$TodayFilter[3]['project_address'].'</h4><h4>Instructions:'.$TodayFilter[3]['instructions'].'</h4></div>">'.$TodayFilter[3]['instructions'].'</div><div class="edit_schedule" data-editid="'.$TodayFilter[3]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$TodayFilter[3]['is_locked'].'">'.$is_edit_t_3.''.$is_locked_t_3.'</div></td>';
												$td1_t5 = '<td rowspan="'.$rowSpan_t_4.'"><div style="background-color:'.$TodayFilter[4]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$TodayFilter[4]['job_number'].'</h4><h4>Task Number:'.$TodayFilter[4]['task_number'].'</h4><h4>Booking Time:'.$TodayFilter[4]['schedule_date'].'</h4><h4>Site:'.$TodayFilter[4]['project_name'].'</h4><h4>Client:'.$TodayFilter[4]['client_name'].'</h4><h4>Tasks:'.$TodayFilter[4]['task_ids'].'</h4><h4>Contact:'.$TodayFilter[4]['project_address'].'</h4><h4>Instructions:'.$TodayFilter[4]['instructions'].'</h4></div>">'.$TodayFilter[4]['instructions'].'</div><div class="edit_schedule" data-editid="'.$TodayFilter[4]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$TodayFilter[4]['is_locked'].'">'.$is_edit_t_4.''.$is_locked_t_4.'</div></td>';
												$td1_t6 = '<td rowspan="'.$rowSpan_t_5.'"><div style="background-color:'.$TodayFilter[5]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$TodayFilter[5]['job_number'].'</h4><h4>Task Number:'.$TodayFilter[5]['task_number'].'</h4><h4>Booking Time:'.$TodayFilter[5]['schedule_date'].'</h4><h4>Site:'.$TodayFilter[5]['project_name'].'</h4><h4>Client:'.$TodayFilter[5]['client_name'].'</h4><h4>Tasks:'.$TodayFilter[5]['task_ids'].'</h4><h4>Contact:'.$TodayFilter[5]['project_address'].'</h4><h4>Instructions:'.$TodayFilter[5]['instructions'].'</h4></div>">'.$TodayFilter[5]['instructions'].'</div><div class="edit_schedule" data-editid="'.$TodayFilter[5]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$TodayFilter[5]['is_locked'].'">'.$is_edit_t_5.''.$is_locked_t_5.'</div></td>';
												break;
											default:
												$td1_700 = '<td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$todaydate.'" data-empname="'.$fullname.'">Add</button></td>';
												$td1_1100 = '<td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$todaydate.'" data-empname="'.$fullname.'">Add</button></td>';
												
											}
										
										$nextday1 = $CI->filtersamedate($sheetData,$weekOfdate[0]);
										//echo "<pre>";print_r($nextday1);echo "</pre>";
										if(@$nextday1[0]['is_locked']==0){
											$is_locked_n1_0 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_n1_0 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_n1_0 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_n1_0 = '';
										}
										if(@$nextday1[1]['is_locked']==0){
											$is_locked_n1_1 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_n1_1 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_n1_1 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_n1_1 = '';
										}
										if(@$nextday1[2]['is_locked']==0){
											$is_locked_n1_2 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_n1_2 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_n1_2 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_n1_2 = '';
										}
										if(@$nextday1[3]['is_locked']==0){
											$is_locked_n1_3 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_n1_3 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_n1_3 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_n1_3 = '';
										}
										if(@$nextday1[4]['is_locked']==0){
											$is_locked_n1_4 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_n1_4 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_n1_4 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_n1_4 = '';
										}
										if(@$nextday1[5]['is_locked']==0){
											$is_locked_n1_5 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_n1_5 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_n1_5 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_n1_5 = '';
										}

										$rowSpan_n1_0 = @$nextday1[0]['all_day']==1 ? $countRows : "";
										$rowSpan_n1_1 = @$nextday1[1]['all_day']==1 ? $countRows : "";
										$rowSpan_n1_2 = @$nextday1[2]['all_day']==1 ? $countRows : "";
										$rowSpan_n1_3 = @$nextday1[3]['all_day']==1 ? $countRows : "";
										$rowSpan_n1_4 = @$nextday1[4]['all_day']==1 ? $countRows : "";
										$rowSpan_n1_5 = @$nextday1[5]['all_day']==1 ? $countRows : "";

											switch (count($nextday1)) {
											case 1:
												$td2_700 = '<td rowspan="'.$rowSpan_n1_0.'"><div style="background-color:'.$nextday1[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday1[0]['job_number'].'</h4><h4>Task Number:'.$nextday1[0]['task_number'].'</h4><h4>Booking Time:'.$nextday1[0]['schedule_date'].'</h4><h4>Site:'.$nextday1[0]['project_name'].'</h4><h4>Client:'.$nextday1[0]['client_name'].'</h4><h4>Tasks:'.$nextday1[0]['task_ids'].'</h4><h4>Contact:'.$nextday1[0]['project_address'].'</h4><h4>Instructions:'.$nextday1[0]['instructions'].'</h4></div>">'.$nextday1[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday1[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday1[0]['is_locked'].'">'.$is_edit_n1_0.''.$is_locked_n1_0.'</div></td>';
												break;
											case 2:
												$td2_700 = '<td rowspan="'.$rowSpan_n1_0.'"><div style="background-color:'.$nextday1[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday1[0]['job_number'].'</h4><h4>Task Number:'.$nextday1[0]['task_number'].'</h4><h4>Booking Time:'.$nextday1[0]['schedule_date'].'</h4><h4>Site:'.$nextday1[0]['project_name'].'</h4><h4>Client:'.$nextday1[0]['client_name'].'</h4><h4>Tasks:'.$nextday1[0]['task_ids'].'</h4><h4>Contact:'.$nextday1[0]['project_address'].'</h4><h4>Instructions:'.$nextday1[0]['instructions'].'</h4></div>">'.$nextday1[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday1[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday1[0]['is_locked'].'">'.$is_edit_n1_0.''.$is_locked_n1_0.'</div></td>';
												$td2_1100 = '<td rowspan="'.$rowSpan_n1_1.'"><div style="background-color:'.$nextday1[1]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday1[1]['job_number'].'</h4><h4>Task Number:'.$nextday1[1]['task_number'].'</h4><h4>Booking Time:'.$nextday1[1]['schedule_date'].'</h4><h4>Site:'.$nextday1[1]['project_name'].'</h4><h4>Client:'.$nextday1[1]['client_name'].'</h4><h4>Tasks:'.$nextday1[1]['task_ids'].'</h4><h4>Contact:'.$nextday1[1]['project_address'].'</h4><h4>Instructions:'.$nextday1[1]['instructions'].'</h4></div>">'.$nextday1[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday1[1]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday1[1]['is_locked'].'">'.$is_edit_n1_1.''.$is_locked_n1_1.'</div></td>';
												break;
											case 3:
												$td2_700 = '<td rowspan="'.$rowSpan_n1_0.'"><div style="background-color:'.$nextday1[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday1[0]['job_number'].'</h4><h4>Task Number:'.$nextday1[0]['task_number'].'</h4><h4>Booking Time:'.$nextday1[0]['schedule_date'].'</h4><h4>Site:'.$nextday1[0]['project_name'].'</h4><h4>Client:'.$nextday1[0]['client_name'].'</h4><h4>Tasks:'.$nextday1[0]['task_ids'].'</h4><h4>Contact:'.$nextday1[0]['project_address'].'</h4><h4>Instructions:'.$nextday1[0]['instructions'].'</h4></div>">'.$nextday1[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday1[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday1[0]['is_locked'].'">'.$is_edit_n1_0.''.$is_locked_n1_0.'</div></td>';
												$td2_1100 = '<td rowspan="'.$rowSpan_n1_1.'"><div style="background-color:'.$nextday1[1]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday1[1]['job_number'].'</h4><h4>Task Number:'.$nextday1[1]['task_number'].'</h4><h4>Booking Time:'.$nextday1[1]['schedule_date'].'</h4><h4>Site:'.$nextday1[1]['project_name'].'</h4><h4>Client:'.$nextday1[1]['client_name'].'</h4><h4>Tasks:'.$nextday1[1]['task_ids'].'</h4><h4>Contact:'.$nextday1[1]['project_address'].'</h4><h4>Instructions:'.$nextday1[1]['instructions'].'</h4></div>">'.$nextday1[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday1[1]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday1[1]['is_locked'].'">'.$is_edit_n1_1.''.$is_locked_n1_1.'</div></td>';
												$td2_1400 = '<td rowspan="'.$rowSpan_n1_2.'"><div style="background-color:'.$nextday1[2]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday1[2]['job_number'].'</h4><h4>Task Number:'.$nextday1[2]['task_number'].'</h4><h4>Booking Time:'.$nextday1[2]['schedule_date'].'</h4><h4>Site:'.$nextday1[2]['project_name'].'</h4><h4>Client:'.$nextday1[2]['client_name'].'</h4><h4>Tasks:'.$nextday1[2]['task_ids'].'</h4><h4>Contact:'.$nextday1[2]['project_address'].'</h4><h4>Instructions:'.$nextday1[2]['instructions'].'</h4></div>">'.$nextday1[2]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday1[2]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday1[2]['is_locked'].'">'.$is_edit_n1_2.''.$is_locked_n1_2.'</div></td>';
												break;
											case 4:
												$td2_700 = '<td rowspan="'.$rowSpan_n1_0.'"><div style="background-color:'.$nextday1[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday1[0]['job_number'].'</h4><h4>Task Number:'.$nextday1[0]['task_number'].'</h4><h4>Booking Time:'.$nextday1[0]['schedule_date'].'</h4><h4>Site:'.$nextday1[0]['project_name'].'</h4><h4>Client:'.$nextday1[0]['client_name'].'</h4><h4>Tasks:'.$nextday1[0]['task_ids'].'</h4><h4>Contact:'.$nextday1[0]['project_address'].'</h4><h4>Instructions:'.$nextday1[0]['instructions'].'</h4></div>">'.$nextday1[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday1[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday1[0]['is_locked'].'">'.$is_edit_n1_0.''.$is_locked_n1_0.'</div></td>';
												$td2_1100 = '<td rowspan="'.$rowSpan_n1_1.'"><div style="background-color:'.$nextday1[1]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday1[1]['job_number'].'</h4><h4>Task Number:'.$nextday1[1]['task_number'].'</h4><h4>Booking Time:'.$nextday1[1]['schedule_date'].'</h4><h4>Site:'.$nextday1[1]['project_name'].'</h4><h4>Client:'.$nextday1[1]['client_name'].'</h4><h4>Tasks:'.$nextday1[1]['task_ids'].'</h4><h4>Contact:'.$nextday1[1]['project_address'].'</h4><h4>Instructions:'.$nextday1[1]['instructions'].'</h4></div>">'.$nextday1[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday1[1]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday1[1]['is_locked'].'">'.$is_edit_n1_1.''.$is_locked_n1_1.'</div></td>';
												$td2_1400 = '<td rowspan="'.$rowSpan_n1_2.'"><div style="background-color:'.$nextday1[2]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday1[2]['job_number'].'</h4><h4>Task Number:'.$nextday1[2]['task_number'].'</h4><h4>Booking Time:'.$nextday1[2]['schedule_date'].'</h4><h4>Site:'.$nextday1[2]['project_name'].'</h4><h4>Client:'.$nextday1[2]['client_name'].'</h4><h4>Tasks:'.$nextday1[2]['task_ids'].'</h4><h4>Contact:'.$nextday1[2]['project_address'].'</h4><h4>Instructions:'.$nextday1[2]['instructions'].'</h4></div>">'.$nextday1[2]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday1[2]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday1[2]['is_locked'].'">'.$is_edit_n1_2.''.$is_locked_n1_2.'</div></td>';
												$td2_t4 = '<td rowspan="'.$rowSpan_n1_3.'"><div style="background-color:'.$nextday1[3]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday1[3]['job_number'].'</h4><h4>Task Number:'.$nextday1[3]['task_number'].'</h4><h4>Booking Time:'.$nextday1[3]['schedule_date'].'</h4><h4>Site:'.$nextday1[3]['project_name'].'</h4><h4>Client:'.$nextday1[3]['client_name'].'</h4><h4>Tasks:'.$nextday1[3]['task_ids'].'</h4><h4>Contact:'.$nextday1[3]['project_address'].'</h4><h4>Instructions:'.$nextday1[3]['instructions'].'</h4></div>">'.$nextday1[3]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday1[3]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday1[3]['is_locked'].'">'.$is_edit_n1_3.''.$is_locked_n1_3.'</div></td>';
												break;
											case 5:
												$td2_700 = '<td rowspan="'.$rowSpan_n1_0.'"><div style="background-color:'.$nextday1[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday1[0]['job_number'].'</h4><h4>Task Number:'.$nextday1[0]['task_number'].'</h4><h4>Booking Time:'.$nextday1[0]['schedule_date'].'</h4><h4>Site:'.$nextday1[0]['project_name'].'</h4><h4>Client:'.$nextday1[0]['client_name'].'</h4><h4>Tasks:'.$nextday1[0]['task_ids'].'</h4><h4>Contact:'.$nextday1[0]['project_address'].'</h4><h4>Instructions:'.$nextday1[0]['instructions'].'</h4></div>">'.$nextday1[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday1[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday1[0]['is_locked'].'">'.$is_edit_n1_0.''.$is_locked_n1_0.'</div></td>';
												$td2_1100 = '<td rowspan="'.$rowSpan_n1_1.'"><div style="background-color:'.$nextday1[1]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday1[1]['job_number'].'</h4><h4>Task Number:'.$nextday1[1]['task_number'].'</h4><h4>Booking Time:'.$nextday1[1]['schedule_date'].'</h4><h4>Site:'.$nextday1[1]['project_name'].'</h4><h4>Client:'.$nextday1[1]['client_name'].'</h4><h4>Tasks:'.$nextday1[1]['task_ids'].'</h4><h4>Contact:'.$nextday1[1]['project_address'].'</h4><h4>Instructions:'.$nextday1[1]['instructions'].'</h4></div>">'.$nextday1[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday1[1]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday1[1]['is_locked'].'">'.$is_edit_n1_1.''.$is_locked_n1_1.'</div></td>';
												$td2_1400 = '<td rowspan="'.$rowSpan_n1_2.'"><div style="background-color:'.$nextday1[2]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday1[2]['job_number'].'</h4><h4>Task Number:'.$nextday1[2]['task_number'].'</h4><h4>Booking Time:'.$nextday1[2]['schedule_date'].'</h4><h4>Site:'.$nextday1[2]['project_name'].'</h4><h4>Client:'.$nextday1[2]['client_name'].'</h4><h4>Tasks:'.$nextday1[2]['task_ids'].'</h4><h4>Contact:'.$nextday1[2]['project_address'].'</h4><h4>Instructions:'.$nextday1[2]['instructions'].'</h4></div>">'.$nextday1[2]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday1[2]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday1[2]['is_locked'].'">'.$is_edit_n1_2.''.$is_locked_n1_2.'</div></td>';
												$td2_t4 = '<td rowspan="'.$rowSpan_n1_3.'"><div style="background-color:'.$nextday1[3]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday1[3]['job_number'].'</h4><h4>Task Number:'.$nextday1[3]['task_number'].'</h4><h4>Booking Time:'.$nextday1[3]['schedule_date'].'</h4><h4>Site:'.$nextday1[3]['project_name'].'</h4><h4>Client:'.$nextday1[3]['client_name'].'</h4><h4>Tasks:'.$nextday1[3]['task_ids'].'</h4><h4>Contact:'.$nextday1[3]['project_address'].'</h4><h4>Instructions:'.$nextday1[3]['instructions'].'</h4></div>">'.$nextday1[3]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday1[3]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday1[3]['is_locked'].'">'.$is_edit_n1_3.''.$is_locked_n1_3.'</div></td>';
												$td2_t5 = '<td rowspan="'.$rowSpan_n1_4.'"><div style="background-color:'.$nextday1[4]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday1[4]['job_number'].'</h4><h4>Task Number:'.$nextday1[4]['task_number'].'</h4><h4>Booking Time:'.$nextday1[4]['schedule_date'].'</h4><h4>Site:'.$nextday1[4]['project_name'].'</h4><h4>Client:'.$nextday1[4]['client_name'].'</h4><h4>Tasks:'.$nextday1[4]['task_ids'].'</h4><h4>Contact:'.$nextday1[4]['project_address'].'</h4><h4>Instructions:'.$nextday1[4]['instructions'].'</h4></div>">'.$nextday1[4]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday1[4]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday1[4]['is_locked'].'">'.$is_edit_n1_4.''.$is_locked_n1_4.'</div></td>';
												break;
											case 6:
												$td2_700 = '<td rowspan="'.$rowSpan_n1_0.'"><div style="background-color:'.$nextday1[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday1[0]['job_number'].'</h4><h4>Task Number:'.$nextday1[0]['task_number'].'</h4><h4>Booking Time:'.$nextday1[0]['schedule_date'].'</h4><h4>Site:'.$nextday1[0]['project_name'].'</h4><h4>Client:'.$nextday1[0]['client_name'].'</h4><h4>Tasks:'.$nextday1[0]['task_ids'].'</h4><h4>Contact:'.$nextday1[0]['project_address'].'</h4><h4>Instructions:'.$nextday1[0]['instructions'].'</h4></div>">'.$nextday1[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday1[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday1[0]['is_locked'].'">'.$is_edit_n1_0.''.$is_locked_n1_0.'</div></td>';
												$td2_1100 = '<td rowspan="'.$rowSpan_n1_1.'"><div style="background-color:'.$nextday1[1]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday1[1]['job_number'].'</h4><h4>Task Number:'.$nextday1[1]['task_number'].'</h4><h4>Booking Time:'.$nextday1[1]['schedule_date'].'</h4><h4>Site:'.$nextday1[1]['project_name'].'</h4><h4>Client:'.$nextday1[1]['client_name'].'</h4><h4>Tasks:'.$nextday1[1]['task_ids'].'</h4><h4>Contact:'.$nextday1[1]['project_address'].'</h4><h4>Instructions:'.$nextday1[1]['instructions'].'</h4></div>">'.$nextday1[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday1[1]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday1[1]['is_locked'].'">'.$is_edit_n1_1.''.$is_locked_n1_1.'</div></td>';
												$td2_1400 = '<td rowspan="'.$rowSpan_n1_2.'"><div style="background-color:'.$nextday1[2]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday1[2]['job_number'].'</h4><h4>Task Number:'.$nextday1[2]['task_number'].'</h4><h4>Booking Time:'.$nextday1[2]['schedule_date'].'</h4><h4>Site:'.$nextday1[2]['project_name'].'</h4><h4>Client:'.$nextday1[2]['client_name'].'</h4><h4>Tasks:'.$nextday1[2]['task_ids'].'</h4><h4>Contact:'.$nextday1[2]['project_address'].'</h4><h4>Instructions:'.$nextday1[2]['instructions'].'</h4></div>">'.$nextday1[2]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday1[2]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday1[2]['is_locked'].'">'.$is_edit_n1_2.''.$is_locked_n1_2.'</div></td>';
												$td2_t4 = '<td rowspan="'.$rowSpan_n1_3.'"><div style="background-color:'.$nextday1[3]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday1[3]['job_number'].'</h4><h4>Task Number:'.$nextday1[3]['task_number'].'</h4><h4>Booking Time:'.$nextday1[3]['schedule_date'].'</h4><h4>Site:'.$nextday1[3]['project_name'].'</h4><h4>Client:'.$nextday1[3]['client_name'].'</h4><h4>Tasks:'.$nextday1[3]['task_ids'].'</h4><h4>Contact:'.$nextday1[3]['project_address'].'</h4><h4>Instructions:'.$nextday1[3]['instructions'].'</h4></div>">'.$nextday1[3]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday1[3]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday1[3]['is_locked'].'">'.$is_edit_n1_3.''.$is_locked_n1_3.'</div></td>';
												$td2_t5 = '<td rowspan="'.$rowSpan_n1_4.'"><div style="background-color:'.$nextday1[4]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday1[4]['job_number'].'</h4><h4>Task Number:'.$nextday1[4]['task_number'].'</h4><h4>Booking Time:'.$nextday1[4]['schedule_date'].'</h4><h4>Site:'.$nextday1[4]['project_name'].'</h4><h4>Client:'.$nextday1[4]['client_name'].'</h4><h4>Tasks:'.$nextday1[4]['task_ids'].'</h4><h4>Contact:'.$nextday1[4]['project_address'].'</h4><h4>Instructions:'.$nextday1[4]['instructions'].'</h4></div>">'.$nextday1[4]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday1[4]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday1[4]['is_locked'].'">'.$is_edit_n1_4.''.$is_locked_n1_4.'</div></td>';
												$td2_t6 = '<td rowspan="'.$rowSpan_n1_5.'"><div style="background-color:'.$nextday1[5]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday1[5]['job_number'].'</h4><h4>Task Number:'.$nextday1[5]['task_number'].'</h4><h4>Booking Time:'.$nextday1[5]['schedule_date'].'</h4><h4>Site:'.$nextday1[5]['project_name'].'</h4><h4>Client:'.$nextday1[5]['client_name'].'</h4><h4>Tasks:'.$nextday1[5]['task_ids'].'</h4><h4>Contact:'.$nextday1[5]['project_address'].'</h4><h4>Instructions:'.$nextday1[5]['instructions'].'</h4></div>">'.$nextday1[5]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday1[5]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday1[5]['is_locked'].'">'.$is_edit_n1_5.''.$is_locked_n1_5.'</div></td>';
												break;
											default:
												$td2_700 = '<td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[0].'" data-empname="'.$fullname.'">Add</button></td>';
											}
										
										
										
										$nextday2 = $CI->filtersamedate($sheetData,$weekOfdate[1]);
										if(@$nextday2[0]['is_locked']==0){
											$is_locked_n2_0 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_n2_0 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_n2_0 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_n2_0 = '';
										}
										if(@$nextday2[1]['is_locked']==0){
											$is_locked_n2_1 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_n2_1 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_n2_1 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_n2_1 = '';
										}
										if(@$nextday2[2]['is_locked']==0){
											$is_locked_n2_2 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_n2_2 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_n2_2 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_n2_2 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}
										if(@$nextday2[3]['is_locked']==0){
											$is_locked_n2_3 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_n2_3 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_n2_3 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_n2_3 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}
										if(@$nextday2[4]['is_locked']==0){
											$is_locked_n2_4 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_n2_4 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_n2_4 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_n2_4 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}
										if(@$nextday2[5]['is_locked']==0){
											$is_locked_n2_5 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_n2_5 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_n2_5 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_n2_5 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}

										$rowSpan_n2_0 = @$nextday2[0]['all_day']==1 ? $countRows : "";
										$rowSpan_n2_1 = @$nextday2[1]['all_day']==1 ? $countRows : "";
										$rowSpan_n2_2 = @$nextday2[2]['all_day']==1 ? $countRows : "";
										$rowSpan_n2_3 = @$nextday2[3]['all_day']==1 ? $countRows : "";
										$rowSpan_n2_4 = @$nextday2[4]['all_day']==1 ? $countRows : "";
										$rowSpan_n2_5 = @$nextday2[5]['all_day']==1 ? $countRows : "";

										switch (count($nextday2)) {
											case 1:
												$td3_700 = '<td rowspan="'.$rowSpan_n2_0.'"><div style="background-color:'.$nextday2[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday2[0]['job_number'].'</h4><h4>Task Number:'.$nextday2[0]['task_number'].'</h4><h4>Booking Time:'.$nextday2[0]['schedule_date'].'</h4><h4>Site:'.$nextday2[0]['project_name'].'</h4><h4>Client:'.$nextday2[0]['client_name'].'</h4><h4>Tasks:'.$nextday2[0]['task_ids'].'</h4><h4>Contact:'.$nextday2[0]['project_address'].'</h4><h4>Instructions:'.$nextday2[0]['instructions'].'</h4></div>">'.$nextday2[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday2[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday2[0]['is_locked'].'">'.$is_edit_n2_0.''.$is_locked_n2_0.'</div></td>';
												break;
											case 2:
												$td3_700 = '<td rowspan="'.$rowSpan_n2_0.'"><div style="background-color:'.$nextday2[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday2[0]['job_number'].'</h4><h4>Task Number:'.$nextday2[0]['task_number'].'</h4><h4>Booking Time:'.$nextday2[0]['schedule_date'].'</h4><h4>Site:'.$nextday2[0]['project_name'].'</h4><h4>Client:'.$nextday2[0]['client_name'].'</h4><h4>Tasks:'.$nextday2[0]['task_ids'].'</h4><h4>Contact:'.$nextday2[0]['project_address'].'</h4><h4>Instructions:'.$nextday2[0]['instructions'].'</h4></div>">'.$nextday2[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday2[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday2[0]['is_locked'].'">'.$is_edit_n2_0.''.$is_locked_n2_0.'</div></td>';
												$td3_1100 = '<td rowspan="'.$rowSpan_n2_1.'"><div style="background-color:'.$nextday2[1]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday2[1]['job_number'].'</h4><h4>Task Number:'.$nextday2[1]['task_number'].'</h4><h4>Booking Time:'.$nextday2[1]['schedule_date'].'</h4><h4>Site:'.$nextday2[1]['project_name'].'</h4><h4>Client:'.$nextday2[1]['client_name'].'</h4><h4>Tasks:'.$nextday2[1]['task_ids'].'</h4><h4>Contact:'.$nextday2[1]['project_address'].'</h4><h4>Instructions:'.$nextday2[1]['instructions'].'</h4></div>">'.$nextday2[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday2[1]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday2[1]['is_locked'].'">'.$is_edit_n2_1.''.$is_locked_n2_1.'</div></td>';
												break;
											case 3:
												$td3_700 = '<td rowspan="'.$rowSpan_n2_0.'"><div style="background-color:'.$nextday2[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday2[0]['job_number'].'</h4><h4>Task Number:'.$nextday2[0]['task_number'].'</h4><h4>Booking Time:'.$nextday2[0]['schedule_date'].'</h4><h4>Site:'.$nextday2[0]['project_name'].'</h4><h4>Client:'.$nextday2[0]['client_name'].'</h4><h4>Tasks:'.$nextday2[0]['task_ids'].'</h4><h4>Contact:'.$nextday2[0]['project_address'].'</h4><h4>Instructions:'.$nextday2[0]['instructions'].'</h4></div>">'.$nextday2[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday2[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday2[0]['is_locked'].'">'.$is_edit_n2_0.''.$is_locked_n2_0.'</div></td>';
												$td3_1100 = '<td rowspan="'.$rowSpan_n2_1.'"><div style="background-color:'.$nextday2[1]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday2[1]['job_number'].'</h4><h4>Task Number:'.$nextday2[1]['task_number'].'</h4><h4>Booking Time:'.$nextday2[1]['schedule_date'].'</h4><h4>Site:'.$nextday2[1]['project_name'].'</h4><h4>Client:'.$nextday2[1]['client_name'].'</h4><h4>Tasks:'.$nextday2[1]['task_ids'].'</h4><h4>Contact:'.$nextday2[1]['project_address'].'</h4><h4>Instructions:'.$nextday2[1]['instructions'].'</h4></div>">'.$nextday2[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday2[1]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday2[1]['is_locked'].'">'.$is_edit_n2_1.''.$is_locked_n2_1.'</div></td>';
												$td3_1400 = '<td rowspan="'.$rowSpan_n2_2.'"><div style="background-color:'.$nextday2[2]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday2[2]['job_number'].'</h4><h4>Task Number:'.$nextday2[2]['task_number'].'</h4><h4>Booking Time:'.$nextday2[2]['schedule_date'].'</h4><h4>Site:'.$nextday2[2]['project_name'].'</h4><h4>Client:'.$nextday2[2]['client_name'].'</h4><h4>Tasks:'.$nextday2[2]['task_ids'].'</h4><h4>Contact:'.$nextday2[2]['project_address'].'</h4><h4>Instructions:'.$nextday2[2]['instructions'].'</h4></div>">'.$nextday2[2]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday2[2]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday2[2]['is_locked'].'">'.$is_edit_n2_2.''.$is_locked_n2_2.'</div></td>';
												break;
											case 4:
												$td3_700 = '<td rowspan="'.$rowSpan_n2_0.'"><div style="background-color:'.$nextday2[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday2[0]['job_number'].'</h4><h4>Task Number:'.$nextday2[0]['task_number'].'</h4><h4>Booking Time:'.$nextday2[0]['schedule_date'].'</h4><h4>Site:'.$nextday2[0]['project_name'].'</h4><h4>Client:'.$nextday2[0]['client_name'].'</h4><h4>Tasks:'.$nextday2[0]['task_ids'].'</h4><h4>Contact:'.$nextday2[0]['project_address'].'</h4><h4>Instructions:'.$nextday2[0]['instructions'].'</h4></div>">'.$nextday2[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday2[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday2[0]['is_locked'].'">'.$is_edit_n2_0.''.$is_locked_n2_0.'</div></td>';
												$td3_1100 = '<td rowspan="'.$rowSpan_n2_1.'"><div style="background-color:'.$nextday2[1]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday2[1]['job_number'].'</h4><h4>Task Number:'.$nextday2[1]['task_number'].'</h4><h4>Booking Time:'.$nextday2[1]['schedule_date'].'</h4><h4>Site:'.$nextday2[1]['project_name'].'</h4><h4>Client:'.$nextday2[1]['client_name'].'</h4><h4>Tasks:'.$nextday2[1]['task_ids'].'</h4><h4>Contact:'.$nextday2[1]['project_address'].'</h4><h4>Instructions:'.$nextday2[1]['instructions'].'</h4></div>">'.$nextday2[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday2[1]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday2[1]['is_locked'].'">'.$is_edit_n2_1.''.$is_locked_n2_1.'</div></td>';
												$td3_1400 = '<td rowspan="'.$rowSpan_n2_2.'"><div style="background-color:'.$nextday2[2]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday2[2]['job_number'].'</h4><h4>Task Number:'.$nextday2[2]['task_number'].'</h4><h4>Booking Time:'.$nextday2[2]['schedule_date'].'</h4><h4>Site:'.$nextday2[2]['project_name'].'</h4><h4>Client:'.$nextday2[2]['client_name'].'</h4><h4>Tasks:'.$nextday2[2]['task_ids'].'</h4><h4>Contact:'.$nextday2[2]['project_address'].'</h4><h4>Instructions:'.$nextday2[2]['instructions'].'</h4></div>">'.$nextday2[2]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday2[2]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday2[2]['is_locked'].'">'.$is_edit_n2_2.''.$is_locked_n2_2.'</div></td>';
												$td3_t4 = '<td rowspan="'.$rowSpan_n2_3.'"><div style="background-color:'.$nextday2[3]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday2[3]['job_number'].'</h4><h4>Task Number:'.$nextday2[3]['task_number'].'</h4><h4>Booking Time:'.$nextday2[3]['schedule_date'].'</h4><h4>Site:'.$nextday2[3]['project_name'].'</h4><h4>Client:'.$nextday2[3]['client_name'].'</h4><h4>Tasks:'.$nextday2[3]['task_ids'].'</h4><h4>Contact:'.$nextday2[3]['project_address'].'</h4><h4>Instructions:'.$nextday2[3]['instructions'].'</h4></div>">'.$nextday2[3]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday2[3]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday2[3]['is_locked'].'">'.$is_edit_n2_3.''.$is_locked_n2_3.'</div></td>';
												break;
											case 5:
												$td3_700 = '<td rowspan="'.$rowSpan_n2_0.'"><div style="background-color:'.$nextday2[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday2[0]['job_number'].'</h4><h4>Task Number:'.$nextday2[0]['task_number'].'</h4><h4>Booking Time:'.$nextday2[0]['schedule_date'].'</h4><h4>Site:'.$nextday2[0]['project_name'].'</h4><h4>Client:'.$nextday2[0]['client_name'].'</h4><h4>Tasks:'.$nextday2[0]['task_ids'].'</h4><h4>Contact:'.$nextday2[0]['project_address'].'</h4><h4>Instructions:'.$nextday2[0]['instructions'].'</h4></div>">'.$nextday2[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday2[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday2[0]['is_locked'].'">'.$is_edit_n2_0.''.$is_locked_n2_0.'</div></td>';
												$td3_1100 = '<td rowspan="'.$rowSpan_n2_1.'"><div style="background-color:'.$nextday2[1]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday2[1]['job_number'].'</h4><h4>Task Number:'.$nextday2[1]['task_number'].'</h4><h4>Booking Time:'.$nextday2[1]['schedule_date'].'</h4><h4>Site:'.$nextday2[1]['project_name'].'</h4><h4>Client:'.$nextday2[1]['client_name'].'</h4><h4>Tasks:'.$nextday2[1]['task_ids'].'</h4><h4>Contact:'.$nextday2[1]['project_address'].'</h4><h4>Instructions:'.$nextday2[1]['instructions'].'</h4></div>">'.$nextday2[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday2[1]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday2[1]['is_locked'].'">'.$is_edit_n2_1.''.$is_locked_n2_1.'</div></td>';
												$td3_1400 = '<td rowspan="'.$rowSpan_n2_2.'"><div style="background-color:'.$nextday2[2]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday2[2]['job_number'].'</h4><h4>Task Number:'.$nextday2[2]['task_number'].'</h4><h4>Booking Time:'.$nextday2[2]['schedule_date'].'</h4><h4>Site:'.$nextday2[2]['project_name'].'</h4><h4>Client:'.$nextday2[2]['client_name'].'</h4><h4>Tasks:'.$nextday2[2]['task_ids'].'</h4><h4>Contact:'.$nextday2[2]['project_address'].'</h4><h4>Instructions:'.$nextday2[2]['instructions'].'</h4></div>">'.$nextday2[2]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday2[2]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday2[2]['is_locked'].'">'.$is_edit_n2_2.''.$is_locked_n2_2.'</div></td>';
												$td3_t4 = '<td rowspan="'.$rowSpan_n2_3.'"><div style="background-color:'.$nextday2[3]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday2[3]['job_number'].'</h4><h4>Task Number:'.$nextday2[3]['task_number'].'</h4><h4>Booking Time:'.$nextday2[3]['schedule_date'].'</h4><h4>Site:'.$nextday2[3]['project_name'].'</h4><h4>Client:'.$nextday2[3]['client_name'].'</h4><h4>Tasks:'.$nextday2[3]['task_ids'].'</h4><h4>Contact:'.$nextday2[3]['project_address'].'</h4><h4>Instructions:'.$nextday2[3]['instructions'].'</h4></div>">'.$nextday2[3]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday2[3]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday2[3]['is_locked'].'">'.$is_edit_n2_3.''.$is_locked_n2_3.'</div></td>';
												$td3_t5 = '<td rowspan="'.$rowSpan_n2_4.'"><div style="background-color:'.$nextday2[4]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday2[4]['job_number'].'</h4><h4>Task Number:'.$nextday2[4]['task_number'].'</h4><h4>Booking Time:'.$nextday2[4]['schedule_date'].'</h4><h4>Site:'.$nextday2[4]['project_name'].'</h4><h4>Client:'.$nextday2[4]['client_name'].'</h4><h4>Tasks:'.$nextday2[4]['task_ids'].'</h4><h4>Contact:'.$nextday2[4]['project_address'].'</h4><h4>Instructions:'.$nextday2[4]['instructions'].'</h4></div>">'.$nextday2[4]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday2[4]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday2[4]['is_locked'].'">'.$is_edit_n2_4.''.$is_locked_n2_4.'</div></td>';
												break;
											case 6:
												$td3_700 = '<td rowspan="'.$rowSpan_n2_0.'"><div style="background-color:'.$nextday2[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday2[0]['job_number'].'</h4><h4>Task Number:'.$nextday2[0]['task_number'].'</h4><h4>Booking Time:'.$nextday2[0]['schedule_date'].'</h4><h4>Site:'.$nextday2[0]['project_name'].'</h4><h4>Client:'.$nextday2[0]['client_name'].'</h4><h4>Tasks:'.$nextday2[0]['task_ids'].'</h4><h4>Contact:'.$nextday2[0]['project_address'].'</h4><h4>Instructions:'.$nextday2[0]['instructions'].'</h4></div>">'.$nextday2[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday2[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday2[0]['is_locked'].'">'.$is_edit_n2_0.''.$is_locked_n2_0.'</div></td>';
												$td3_1100 = '<td rowspan="'.$rowSpan_n2_1.'"><div style="background-color:'.$nextday2[1]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday2[1]['job_number'].'</h4><h4>Task Number:'.$nextday2[1]['task_number'].'</h4><h4>Booking Time:'.$nextday2[1]['schedule_date'].'</h4><h4>Site:'.$nextday2[1]['project_name'].'</h4><h4>Client:'.$nextday2[1]['client_name'].'</h4><h4>Tasks:'.$nextday2[1]['task_ids'].'</h4><h4>Contact:'.$nextday2[1]['project_address'].'</h4><h4>Instructions:'.$nextday2[1]['instructions'].'</h4></div>">'.$nextday2[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday2[1]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday2[1]['is_locked'].'">'.$is_edit_n2_1.''.$is_locked_n2_1.'</div></td>';
												$td3_1400 = '<td rowspan="'.$rowSpan_n2_2.'"><div style="background-color:'.$nextday2[2]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday2[2]['job_number'].'</h4><h4>Task Number:'.$nextday2[2]['task_number'].'</h4><h4>Booking Time:'.$nextday2[2]['schedule_date'].'</h4><h4>Site:'.$nextday2[2]['project_name'].'</h4><h4>Client:'.$nextday2[2]['client_name'].'</h4><h4>Tasks:'.$nextday2[2]['task_ids'].'</h4><h4>Contact:'.$nextday2[2]['project_address'].'</h4><h4>Instructions:'.$nextday2[2]['instructions'].'</h4></div>">'.$nextday2[2]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday2[2]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday2[2]['is_locked'].'">'.$is_edit_n2_2.''.$is_locked_n2_2.'</div></td>';
												$td3_t4 = '<td rowspan="'.$rowSpan_n2_3.'"><div style="background-color:'.$nextday2[3]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday2[3]['job_number'].'</h4><h4>Task Number:'.$nextday2[3]['task_number'].'</h4><h4>Booking Time:'.$nextday2[3]['schedule_date'].'</h4><h4>Site:'.$nextday2[3]['project_name'].'</h4><h4>Client:'.$nextday2[3]['client_name'].'</h4><h4>Tasks:'.$nextday2[3]['task_ids'].'</h4><h4>Contact:'.$nextday2[3]['project_address'].'</h4><h4>Instructions:'.$nextday2[3]['instructions'].'</h4></div>">'.$nextday2[3]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday2[3]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday2[3]['is_locked'].'">'.$is_edit_n2_3.''.$is_locked_n2_3.'</div></td>';
												$td3_t5 = '<td rowspan="'.$rowSpan_n2_4.'"><div style="background-color:'.$nextday2[4]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday2[4]['job_number'].'</h4><h4>Task Number:'.$nextday2[4]['task_number'].'</h4><h4>Booking Time:'.$nextday2[4]['schedule_date'].'</h4><h4>Site:'.$nextday2[4]['project_name'].'</h4><h4>Client:'.$nextday2[4]['client_name'].'</h4><h4>Tasks:'.$nextday2[4]['task_ids'].'</h4><h4>Contact:'.$nextday2[4]['project_address'].'</h4><h4>Instructions:'.$nextday2[4]['instructions'].'</h4></div>">'.$nextday2[4]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday2[4]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday2[4]['is_locked'].'">'.$is_edit_n2_4.''.$is_locked_n2_4.'</div></td>';
												$td3_t6 = '<td rowspan="'.$rowSpan_n2_5.'"><div style="background-color:'.$nextday2[5]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday2[5]['job_number'].'</h4><h4>Task Number:'.$nextday2[5]['task_number'].'</h4><h4>Booking Time:'.$nextday2[5]['schedule_date'].'</h4><h4>Site:'.$nextday2[5]['project_name'].'</h4><h4>Client:'.$nextday2[5]['client_name'].'</h4><h4>Tasks:'.$nextday2[5]['task_ids'].'</h4><h4>Contact:'.$nextday2[5]['project_address'].'</h4><h4>Instructions:'.$nextday2[5]['instructions'].'</h4></div>">'.$nextday2[5]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday2[5]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday2[5]['is_locked'].'">'.$is_edit_n2_5.''.$is_locked_n2_5.'</div></td>';
												break;
											default:
												$td3_700 = '<td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[1].'" data-empname="'.$fullname.'">Add</button></td>';
												
											}
										
										
										
										$nextday3 = $CI->filtersamedate($sheetData,$weekOfdate[2]);
										if(@$nextday3[0]['is_locked']==0){
											$is_locked_n3_0 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_n3_0 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_n3_0 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_n3_0 = '';
										}
										if(@$nextday3[1]['is_locked']==0){
											$is_locked_n3_1 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_n3_1 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_n3_1 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_n3_1 = '';
										}
										if(@$nextday3[2]['is_locked']==0){
											$is_locked_n3_2 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_n3_2 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_n3_2 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_n3_2 = '';
										}
										if(@$nextday3[3]['is_locked']==0){
											$is_locked_n3_3 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_n3_3 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_n3_3 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_n3_3 = '';
										}
										if(@$nextday3[4]['is_locked']==0){
											$is_locked_n3_4 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_n3_4 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_n3_4 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_n3_4 = '';
										}
										if(@$nextday3[5]['is_locked']==0){
											$is_locked_n3_5 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_n3_5 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_n3_5 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_n3_5 = '';
										}

										$rowSpan_n3_0 = @$nextday3[0]['all_day']==1 ? $countRows : "";
										$rowSpan_n3_1 = @$nextday3[1]['all_day']==1 ? $countRows : "";
										$rowSpan_n3_2 = @$nextday3[2]['all_day']==1 ? $countRows : "";
										$rowSpan_n3_3 = @$nextday3[3]['all_day']==1 ? $countRows : "";
										$rowSpan_n3_4 = @$nextday3[4]['all_day']==1 ? $countRows : "";
										$rowSpan_n3_5 = @$nextday3[5]['all_day']==1 ? $countRows : "";

										switch (count($nextday3)) {
											case 1:
												$td4_700 = '<td rowspan="'.$rowSpan_n3_0.'"><div style="background-color:'.$nextday3[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday3[0]['job_number'].'</h4><h4>Task Number:'.$nextday3[0]['task_number'].'</h4><h4>Booking Time:'.$nextday3[0]['schedule_date'].'</h4><h4>Site:'.$nextday3[0]['project_name'].'</h4><h4>Client:'.$nextday3[0]['client_name'].'</h4><h4>Tasks:'.$nextday3[0]['task_ids'].'</h4><h4>Contact:'.$nextday3[0]['project_address'].'</h4><h4>Instructions:'.$nextday3[0]['instructions'].'</h4></div>">'.$nextday3[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday3[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday3[0]['is_locked'].'">'.$is_edit_n3_0.''.$is_locked_n3_0.'</div></td>';
												break;
											case 2:
												$td4_700 = '<td rowspan="'.$rowSpan_n3_0.'"><div style="background-color:'.$nextday3[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday3[0]['job_number'].'</h4><h4>Task Number:'.$nextday3[0]['task_number'].'</h4><h4>Booking Time:'.$nextday3[0]['schedule_date'].'</h4><h4>Site:'.$nextday3[0]['project_name'].'</h4><h4>Client:'.$nextday3[0]['client_name'].'</h4><h4>Tasks:'.$nextday3[0]['task_ids'].'</h4><h4>Contact:'.$nextday3[0]['project_address'].'</h4><h4>Instructions:'.$nextday3[0]['instructions'].'</h4></div>">'.$nextday3[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday3[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday3[0]['is_locked'].'">'.$is_edit_n3_0.''.$is_locked_n3_0.'</div></td>';
												$td4_1100 = '<td rowspan="'.$rowSpan_n3_1.'"><div style="background-color:'.$nextday3[1]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday3[1]['job_number'].'</h4><h4>Task Number:'.$nextday3[1]['task_number'].'</h4><h4>Booking Time:'.$nextday3[1]['schedule_date'].'</h4><h4>Site:'.$nextday3[1]['project_name'].'</h4><h4>Client:'.$nextday3[1]['client_name'].'</h4><h4>Tasks:'.$nextday3[1]['task_ids'].'</h4><h4>Contact:'.$nextday3[1]['project_address'].'</h4><h4>Instructions:'.$nextday3[1]['instructions'].'</h4></div>">'.$nextday3[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday3[1]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday3[1]['is_locked'].'">'.$is_edit_n3_1.''.$is_locked_n3_1.'</div></td>';
												break;
											case 3:
												$td4_700 = '<td rowspan="'.$rowSpan_n3_0.'"><div style="background-color:'.$nextday3[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday3[0]['job_number'].'</h4><h4>Task Number:'.$nextday3[0]['task_number'].'</h4><h4>Booking Time:'.$nextday3[0]['schedule_date'].'</h4><h4>Site:'.$nextday3[0]['project_name'].'</h4><h4>Client:'.$nextday3[0]['client_name'].'</h4><h4>Tasks:'.$nextday3[0]['task_ids'].'</h4><h4>Contact:'.$nextday3[0]['project_address'].'</h4><h4>Instructions:'.$nextday3[0]['instructions'].'</h4></div>">'.$nextday3[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday3[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday3[0]['is_locked'].'">'.$is_edit_n3_0.''.$is_locked_n3_0.'</div></td>';
												$td4_1100 = '<td rowspan="'.$rowSpan_n3_1.'"><div style="background-color:'.$nextday3[1]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday3[1]['job_number'].'</h4><h4>Task Number:'.$nextday3[1]['task_number'].'</h4><h4>Booking Time:'.$nextday3[0]['schedule_date'].'</h4><h4>Site:'.$nextday3[1]['project_name'].'</h4><h4>Client:'.$nextday3[1]['client_name'].'</h4><h4>Tasks:'.$nextday3[1]['task_ids'].'</h4><h4>Contact:'.$nextday3[1]['project_address'].'</h4><h4>Instructions:'.$nextday3[1]['instructions'].'</h4></div>">'.$nextday3[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday3[1]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday3[1]['is_locked'].'">'.$is_edit_n3_1.''.$is_locked_n3_1.'</div></td>';
												$td4_1400 = '<td rowspan="'.$rowSpan_n3_2.'"><div style="background-color:'.$nextday3[2]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday3[2]['job_number'].'</h4><h4>Task Number:'.$nextday3[2]['task_number'].'</h4><h4>Booking Time:'.$nextday3[2]['schedule_date'].'</h4><h4>Site:'.$nextday3[2]['project_name'].'</h4><h4>Client:'.$nextday3[2]['client_name'].'</h4><h4>Tasks:'.$nextday3[2]['task_ids'].'</h4><h4>Contact:'.$nextday3[2]['project_address'].'</h4><h4>Instructions:'.$nextday3[2]['instructions'].'</h4></div>">'.$nextday3[2]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday3[2]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday3[2]['is_locked'].'">'.$is_edit_n3_2.''.$is_locked_n3_2.'</div></td>';
												break;
											case 4:
												$td4_700 = '<td rowspan="'.$rowSpan_n3_0.'"><div style="background-color:'.$nextday3[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday3[0]['job_number'].'</h4><h4>Task Number:'.$nextday3[0]['task_number'].'</h4><h4>Booking Time:'.$nextday3[0]['schedule_date'].'</h4><h4>Site:'.$nextday3[0]['project_name'].'</h4><h4>Client:'.$nextday3[0]['client_name'].'</h4><h4>Tasks:'.$nextday3[0]['task_ids'].'</h4><h4>Contact:'.$nextday3[0]['project_address'].'</h4><h4>Instructions:'.$nextday3[0]['instructions'].'</h4></div>">'.$nextday3[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday3[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday3[0]['is_locked'].'">'.$is_edit_n3_0.''.$is_locked_n3_0.'</div></td>';
												$td4_1100 = '<td rowspan="'.$rowSpan_n3_1.'"><div style="background-color:'.$nextday3[1]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday3[1]['job_number'].'</h4><h4>Task Number:'.$nextday3[1]['task_number'].'</h4><h4>Booking Time:'.$nextday3[0]['schedule_date'].'</h4><h4>Site:'.$nextday3[1]['project_name'].'</h4><h4>Client:'.$nextday3[1]['client_name'].'</h4><h4>Tasks:'.$nextday3[1]['task_ids'].'</h4><h4>Contact:'.$nextday3[1]['project_address'].'</h4><h4>Instructions:'.$nextday3[1]['instructions'].'</h4></div>">'.$nextday3[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday3[1]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday3[1]['is_locked'].'">'.$is_edit_n3_1.''.$is_locked_n3_1.'</div></td>';
												$td4_1400 = '<td rowspan="'.$rowSpan_n3_2.'"><div style="background-color:'.$nextday3[2]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday3[2]['job_number'].'</h4><h4>Task Number:'.$nextday3[2]['task_number'].'</h4><h4>Booking Time:'.$nextday3[2]['schedule_date'].'</h4><h4>Site:'.$nextday3[2]['project_name'].'</h4><h4>Client:'.$nextday3[2]['client_name'].'</h4><h4>Tasks:'.$nextday3[2]['task_ids'].'</h4><h4>Contact:'.$nextday3[2]['project_address'].'</h4><h4>Instructions:'.$nextday3[2]['instructions'].'</h4></div>">'.$nextday3[2]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday3[2]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday3[2]['is_locked'].'">'.$is_edit_n3_2.''.$is_locked_n3_2.'</div></td>';
												$td4_t4 = '<td rowspan="'.$rowSpan_n3_3.'"><div style="background-color:'.$nextday3[3]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday3[3]['job_number'].'</h4><h4>Task Number:'.$nextday3[3]['task_number'].'</h4><h4>Booking Time:'.$nextday3[3]['schedule_date'].'</h4><h4>Site:'.$nextday3[3]['project_name'].'</h4><h4>Client:'.$nextday3[3]['client_name'].'</h4><h4>Tasks:'.$nextday3[3]['task_ids'].'</h4><h4>Contact:'.$nextday3[3]['project_address'].'</h4><h4>Instructions:'.$nextday3[3]['instructions'].'</h4></div>">'.$nextday3[3]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday3[3]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday3[3]['is_locked'].'">'.$is_edit_n3_3.''.$is_locked_n3_3.'</div></td>';
												break;
											case 5:
												$td4_700 = '<td rowspan="'.$rowSpan_n3_0.'"><div style="background-color:'.$nextday3[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday3[0]['job_number'].'</h4><h4>Task Number:'.$nextday3[0]['task_number'].'</h4><h4>Booking Time:'.$nextday3[0]['schedule_date'].'</h4><h4>Site:'.$nextday3[0]['project_name'].'</h4><h4>Client:'.$nextday3[0]['client_name'].'</h4><h4>Tasks:'.$nextday3[0]['task_ids'].'</h4><h4>Contact:'.$nextday3[0]['project_address'].'</h4><h4>Instructions:'.$nextday3[0]['instructions'].'</h4></div>">'.$nextday3[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday3[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday3[0]['is_locked'].'">'.$is_edit_n3_0.''.$is_locked_n3_0.'</div></td>';
												$td4_1100 = '<td rowspan="'.$rowSpan_n3_1.'"><div style="background-color:'.$nextday3[1]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday3[1]['job_number'].'</h4><h4>Task Number:'.$nextday3[1]['task_number'].'</h4><h4>Booking Time:'.$nextday3[0]['schedule_date'].'</h4><h4>Site:'.$nextday3[1]['project_name'].'</h4><h4>Client:'.$nextday3[1]['client_name'].'</h4><h4>Tasks:'.$nextday3[1]['task_ids'].'</h4><h4>Contact:'.$nextday3[1]['project_address'].'</h4><h4>Instructions:'.$nextday3[1]['instructions'].'</h4></div>">'.$nextday3[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday3[1]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday3[1]['is_locked'].'">'.$is_edit_n3_1.''.$is_locked_n3_1.'</div></td>';
												$td4_1400 = '<td rowspan="'.$rowSpan_n3_2.'"><div style="background-color:'.$nextday3[2]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday3[2]['job_number'].'</h4><h4>Task Number:'.$nextday3[2]['task_number'].'</h4><h4>Booking Time:'.$nextday3[2]['schedule_date'].'</h4><h4>Site:'.$nextday3[2]['project_name'].'</h4><h4>Client:'.$nextday3[2]['client_name'].'</h4><h4>Tasks:'.$nextday3[2]['task_ids'].'</h4><h4>Contact:'.$nextday3[2]['project_address'].'</h4><h4>Instructions:'.$nextday3[2]['instructions'].'</h4></div>">'.$nextday3[2]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday3[2]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday3[2]['is_locked'].'">'.$is_edit_n3_2.''.$is_locked_n3_2.'</div></td>';
												$td4_t4 = '<td rowspan="'.$rowSpan_n3_3.'"><div style="background-color:'.$nextday3[3]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday3[3]['job_number'].'</h4><h4>Task Number:'.$nextday3[3]['task_number'].'</h4><h4>Booking Time:'.$nextday3[3]['schedule_date'].'</h4><h4>Site:'.$nextday3[3]['project_name'].'</h4><h4>Client:'.$nextday3[3]['client_name'].'</h4><h4>Tasks:'.$nextday3[3]['task_ids'].'</h4><h4>Contact:'.$nextday3[3]['project_address'].'</h4><h4>Instructions:'.$nextday3[3]['instructions'].'</h4></div>">'.$nextday3[3]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday3[3]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday3[3]['is_locked'].'">'.$is_edit_n3_3.''.$is_locked_n3_3.'</div></td>';
												$td4_t5 = '<td rowspan="'.$rowSpan_n3_4.'"><div style="background-color:'.$nextday3[4]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday3[4]['job_number'].'</h4><h4>Task Number:'.$nextday3[4]['task_number'].'</h4><h4>Booking Time:'.$nextday3[4]['schedule_date'].'</h4><h4>Site:'.$nextday3[4]['project_name'].'</h4><h4>Client:'.$nextday3[4]['client_name'].'</h4><h4>Tasks:'.$nextday3[4]['task_ids'].'</h4><h4>Contact:'.$nextday3[4]['project_address'].'</h4><h4>Instructions:'.$nextday3[4]['instructions'].'</h4></div>">'.$nextday3[4]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday3[4]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday3[4]['is_locked'].'">'.$is_edit_n3_4.''.$is_locked_n3_4.'</div></td>';
												break;
											case 6:
												$td4_700 = '<td rowspan="'.$rowSpan_n3_0.'"><div style="background-color:'.$nextday3[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday3[0]['job_number'].'</h4><h4>Task Number:'.$nextday3[0]['task_number'].'</h4><h4>Booking Time:'.$nextday3[0]['schedule_date'].'</h4><h4>Site:'.$nextday3[0]['project_name'].'</h4><h4>Client:'.$nextday3[0]['client_name'].'</h4><h4>Tasks:'.$nextday3[0]['task_ids'].'</h4><h4>Contact:'.$nextday3[0]['project_address'].'</h4><h4>Instructions:'.$nextday3[0]['instructions'].'</h4></div>">'.$nextday3[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday3[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday3[0]['is_locked'].'">'.$is_edit_n3_0.''.$is_locked_n3_0.'</div></td>';
												$td4_1100 = '<td rowspan="'.$rowSpan_n3_1.'"><div style="background-color:'.$nextday3[1]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday3[1]['job_number'].'</h4><h4>Task Number:'.$nextday3[1]['task_number'].'</h4><h4>Booking Time:'.$nextday3[0]['schedule_date'].'</h4><h4>Site:'.$nextday3[1]['project_name'].'</h4><h4>Client:'.$nextday3[1]['client_name'].'</h4><h4>Tasks:'.$nextday3[1]['task_ids'].'</h4><h4>Contact:'.$nextday3[1]['project_address'].'</h4><h4>Instructions:'.$nextday3[1]['instructions'].'</h4></div>">'.$nextday3[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday3[1]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday3[1]['is_locked'].'">'.$is_edit_n3_1.''.$is_locked_n3_1.'</div></td>';
												$td4_1400 = '<td rowspan="'.$rowSpan_n3_2.'"><div style="background-color:'.$nextday3[2]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday3[2]['job_number'].'</h4><h4>Task Number:'.$nextday3[2]['task_number'].'</h4><h4>Booking Time:'.$nextday3[2]['schedule_date'].'</h4><h4>Site:'.$nextday3[2]['project_name'].'</h4><h4>Client:'.$nextday3[2]['client_name'].'</h4><h4>Tasks:'.$nextday3[2]['task_ids'].'</h4><h4>Contact:'.$nextday3[2]['project_address'].'</h4><h4>Instructions:'.$nextday3[2]['instructions'].'</h4></div>">'.$nextday3[2]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday3[2]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday3[2]['is_locked'].'">'.$is_edit_n3_2.''.$is_locked_n3_2.'</div></td>';
												$td4_t4 = '<td rowspan="'.$rowSpan_n3_3.'"><div style="background-color:'.$nextday3[3]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday3[3]['job_number'].'</h4><h4>Task Number:'.$nextday3[3]['task_number'].'</h4><h4>Booking Time:'.$nextday3[3]['schedule_date'].'</h4><h4>Site:'.$nextday3[3]['project_name'].'</h4><h4>Client:'.$nextday3[3]['client_name'].'</h4><h4>Tasks:'.$nextday3[3]['task_ids'].'</h4><h4>Contact:'.$nextday3[3]['project_address'].'</h4><h4>Instructions:'.$nextday3[3]['instructions'].'</h4></div>">'.$nextday3[3]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday3[3]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday3[3]['is_locked'].'">'.$is_edit_n3_3.''.$is_locked_n3_3.'</div></td>';
												$td4_t5 = '<td rowspan="'.$rowSpan_n3_4.'"><div style="background-color:'.$nextday3[4]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday3[4]['job_number'].'</h4><h4>Task Number:'.$nextday3[4]['task_number'].'</h4><h4>Booking Time:'.$nextday3[4]['schedule_date'].'</h4><h4>Site:'.$nextday3[4]['project_name'].'</h4><h4>Client:'.$nextday3[4]['client_name'].'</h4><h4>Tasks:'.$nextday3[4]['task_ids'].'</h4><h4>Contact:'.$nextday3[4]['project_address'].'</h4><h4>Instructions:'.$nextday3[4]['instructions'].'</h4></div>">'.$nextday3[4]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday3[4]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday3[4]['is_locked'].'">'.$is_edit_n3_4.''.$is_locked_n3_4.'</div></td>';
												$td4_t6 = '<td rowspan="'.$rowSpan_n3_5.'"><div style="background-color:'.$nextday3[5]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday3[5]['job_number'].'</h4><h4>Task Number:'.$nextday3[5]['task_number'].'</h4><h4>Booking Time:'.$nextday3[5]['schedule_date'].'</h4><h4>Site:'.$nextday3[5]['project_name'].'</h4><h4>Client:'.$nextday3[5]['client_name'].'</h4><h4>Tasks:'.$nextday3[5]['task_ids'].'</h4><h4>Contact:'.$nextday3[5]['project_address'].'</h4><h4>Instructions:'.$nextday3[5]['instructions'].'</h4></div>">'.$nextday3[5]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday3[5]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday3[5]['is_locked'].'">'.$is_edit_n3_5.''.$is_locked_n3_5.'</div></td>';
												break;
											default:
												$td4_700 = '<td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[2].'" data-empname="'.$fullname.'">Add</button></td>';
												
											}
										
										
										
										$nextday4 = $CI->filtersamedate($sheetData,$weekOfdate[3]);
										if(@$nextday4[0]['is_locked']==0){
											$is_locked_n4_0 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_n4_0 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_n4_0 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_n4_0 = '';
										}
										if(@$nextday4[1]['is_locked']==0){
											$is_locked_n4_1 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_n4_1 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_n4_1 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_n4_1 = '';
										}
										if(@$nextday4[2]['is_locked']==0){
											$is_locked_n4_2 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_n4_2 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_n4_2 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_n4_2 = '';
										}
										if(@$nextday4[3]['is_locked']==0){
											$is_locked_n4_3 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_n4_3 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_n4_3 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_n4_3 = '';
										}
										if(@$nextday4[4]['is_locked']==0){
											$is_locked_n4_4 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_n4_4 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_n4_4 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_n4_4 = '';
										}
										if(@$nextday4[5]['is_locked']==0){
											$is_locked_n4_5 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_n4_5 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_n4_5 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_n4_5 = '';
										}

										$rowSpan_n4_0 = @$nextday4[0]['all_day']==1 ? $countRows : "";
										$rowSpan_n4_1 = @$nextday4[1]['all_day']==1 ? $countRows : "";
										$rowSpan_n4_2 = @$nextday4[2]['all_day']==1 ? $countRows : "";
										$rowSpan_n4_3 = @$nextday4[3]['all_day']==1 ? $countRows : "";
										$rowSpan_n4_4 = @$nextday4[4]['all_day']==1 ? $countRows : "";
										$rowSpan_n4_5 = @$nextday4[5]['all_day']==1 ? $countRows : "";

										switch (count($nextday4)) {
											case 1:
												$td5_700 = '<td rowspan="'.$rowSpan_n4_0.'"><div style="background-color:'.$nextday4[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday4[0]['job_number'].'</h4><h4>Task Number:'.$nextday4[0]['task_number'].'</h4><h4>Booking Time:'.$nextday4[0]['schedule_date'].'</h4><h4>Site:'.$nextday4[0]['project_name'].'</h4><h4>Client:'.$nextday4[0]['client_name'].'</h4><h4>Tasks:'.$nextday4[0]['task_ids'].'</h4><h4>Contact:'.$nextday4[0]['project_address'].'</h4><h4>Instructions:'.$nextday4[0]['instructions'].'</h4></div>">'.$nextday4[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday4[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday4[0]['is_locked'].'">'.$is_edit_n4_0.''.$is_locked_n4_0.'</div></td>';
												break;
											case 2:
												$td5_700 = '<td rowspan="'.$rowSpan_n4_0.'"><div style="background-color:'.$nextday4[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday4[0]['job_number'].'</h4><h4>Task Number:'.$nextday4[0]['task_number'].'</h4><h4>Booking Time:'.$nextday4[0]['schedule_date'].'</h4><h4>Site:'.$nextday4[0]['project_name'].'</h4><h4>Client:'.$nextday4[0]['client_name'].'</h4><h4>Tasks:'.$nextday4[0]['task_ids'].'</h4><h4>Contact:'.$nextday4[0]['project_address'].'</h4><h4>Instructions:'.$nextday4[0]['instructions'].'</h4></div>">'.$nextday4[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday4[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday4[0]['is_locked'].'">'.$is_edit_n4_0.''.$is_locked_n4_0.'</div></td>';
												$td5_1100 = '<td rowspan="'.$rowSpan_n4_1.'"><div style="background-color:'.$nextday4[1]['color_code'].'" class="hover_popup" data-toggle="popover" data-placement="left" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday4[1]['job_number'].'</h4><h4>Task Number:'.$nextday4[1]['task_number'].'</h4><h4>Booking Time:'.$nextday4[1]['schedule_date'].'</h4><h4>Site:'.$nextday4[1]['project_name'].'</h4><h4>Client:'.$nextday4[1]['client_name'].'</h4><h4>Tasks:'.$nextday4[0]['task_ids'].'</h4><h4>Contact:'.$nextday4[1]['project_address'].'</h4><h4>Instructions:'.$nextday4[1]['instructions'].'</h4></div>">'.$nextday4[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday4[1]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday4[1]['is_locked'].'">'.$is_edit_n4_1.''.$is_locked_n4_1.'</div></td>';
												break;
											case 3:
												$td5_700 = '<td rowspan="'.$rowSpan_n4_0.'"><div style="background-color:'.$nextday4[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday4[0]['job_number'].'</h4><h4>Task Number:'.$nextday4[0]['task_number'].'</h4><h4>Booking Time:'.$nextday4[0]['schedule_date'].'</h4><h4>Site:'.$nextday4[0]['project_name'].'</h4><h4>Client:'.$nextday4[0]['client_name'].'</h4><h4>Tasks:'.$nextday4[0]['task_ids'].'</h4><h4>Contact:'.$nextday4[0]['project_address'].'</h4><h4>Instructions:'.$nextday4[0]['instructions'].'</h4></div>">'.$nextday4[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday4[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday4[0]['is_locked'].'">'.$is_edit_n4_0.''.$is_locked_n4_0.'</div></td>';
												$td5_1100 = '<td rowspan="'.$rowSpan_n4_1.'"><div style="background-color:'.$nextday4[1]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday4[1]['job_number'].'</h4><h4>Task Number:'.$nextday4[1]['task_number'].'</h4><h4>Booking Time:'.$nextday4[1]['schedule_date'].'</h4><h4>Site:'.$nextday4[1]['project_name'].'</h4><h4>Client:'.$nextday4[1]['client_name'].'</h4><h4>Tasks:'.$nextday4[1]['task_ids'].'</h4><h4>Contact:'.$nextday4[1]['project_address'].'</h4><h4>Instructions:'.$nextday4[1]['instructions'].'</h4></div>">'.$nextday4[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday4[1]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday4[1]['is_locked'].'">'.$is_edit_n4_1.''.$is_locked_n4_1.'</div></td>';
												$td5_1400 = '<td rowspan="'.$rowSpan_n4_2.'"><div style="background-color:'.$nextday4[2]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday4[2]['job_number'].'</h4><h4>Task Number:'.$nextday4[2]['task_number'].'</h4><h4>Booking Time:'.$nextday4[2]['schedule_date'].'</h4><h4>Site:'.$nextday4[2]['project_name'].'</h4><h4>Client:'.$nextday4[2]['client_name'].'</h4><h4>Tasks:'.$nextday4[2]['task_ids'].'</h4><h4>Contact:'.$nextday4[2]['project_address'].'</h4><h4>Instructions:'.$nextday4[2]['instructions'].'</h4></div>">'.$nextday4[2]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday4[2]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday4[2]['is_locked'].'">'.$is_edit_n4_2.''.$is_locked_n4_2.'</div></td>';
												break;
											case 4:
												$td5_700 = '<td rowspan="'.$rowSpan_n4_0.'"><div style="background-color:'.$nextday4[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday4[0]['job_number'].'</h4><h4>Task Number:'.$nextday4[0]['task_number'].'</h4><h4>Booking Time:'.$nextday4[0]['schedule_date'].'</h4><h4>Site:'.$nextday4[0]['project_name'].'</h4><h4>Client:'.$nextday4[0]['client_name'].'</h4><h4>Tasks:'.$nextday4[0]['task_ids'].'</h4><h4>Contact:'.$nextday4[0]['project_address'].'</h4><h4>Instructions:'.$nextday4[0]['instructions'].'</h4></div>">'.$nextday4[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday4[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday4[0]['is_locked'].'">'.$is_edit_n4_0.''.$is_locked_n4_0.'</div></td>';
												$td5_1100 = '<td rowspan="'.$rowSpan_n4_1.'"><div style="background-color:'.$nextday4[1]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday4[1]['job_number'].'</h4><h4>Task Number:'.$nextday4[1]['task_number'].'</h4><h4>Booking Time:'.$nextday4[1]['schedule_date'].'</h4><h4>Site:'.$nextday4[1]['project_name'].'</h4><h4>Client:'.$nextday4[1]['client_name'].'</h4><h4>Tasks:'.$nextday4[1]['task_ids'].'</h4><h4>Contact:'.$nextday4[1]['project_address'].'</h4><h4>Instructions:'.$nextday4[1]['instructions'].'</h4></div>">'.$nextday4[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday4[1]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday4[1]['is_locked'].'">'.$is_edit_n4_1.''.$is_locked_n4_1.'</div></td>';
												$td5_1400 = '<td rowspan="'.$rowSpan_n4_2.'"><div style="background-color:'.$nextday4[2]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday4[2]['job_number'].'</h4><h4>Task Number:'.$nextday4[2]['task_number'].'</h4><h4>Booking Time:'.$nextday4[2]['schedule_date'].'</h4><h4>Site:'.$nextday4[2]['project_name'].'</h4><h4>Client:'.$nextday4[2]['client_name'].'</h4><h4>Tasks:'.$nextday4[2]['task_ids'].'</h4><h4>Contact:'.$nextday4[2]['project_address'].'</h4><h4>Instructions:'.$nextday4[2]['instructions'].'</h4></div>">'.$nextday4[2]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday4[2]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday4[2]['is_locked'].'">'.$is_edit_n4_2.''.$is_locked_n4_2.'</div></td>';
												$td5_t4 = '<td rowspan="'.$rowSpan_n4_3.'"><div style="background-color:'.$nextday4[3]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday4[3]['job_number'].'</h4><h4>Task Number:'.$nextday4[3]['task_number'].'</h4><h4>Booking Time:'.$nextday4[3]['schedule_date'].'</h4><h4>Site:'.$nextday4[3]['project_name'].'</h4><h4>Client:'.$nextday4[3]['client_name'].'</h4><h4>Tasks:'.$nextday4[3]['task_ids'].'</h4><h4>Contact:'.$nextday4[3]['project_address'].'</h4><h4>Instructions:'.$nextday4[3]['instructions'].'</h4></div>">'.$nextday4[3]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday4[3]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday4[3]['is_locked'].'">'.$is_edit_n4_3.''.$is_locked_n4_3.'</div></td>';
												break;
											case 5:
												$td5_700 = '<td rowspan="'.$rowSpan_n4_0.'"><div style="background-color:'.$nextday4[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday4[0]['job_number'].'</h4><h4>Task Number:'.$nextday4[0]['task_number'].'</h4><h4>Booking Time:'.$nextday4[0]['schedule_date'].'</h4><h4>Site:'.$nextday4[0]['project_name'].'</h4><h4>Client:'.$nextday4[0]['client_name'].'</h4><h4>Tasks:'.$nextday4[0]['task_ids'].'</h4><h4>Contact:'.$nextday4[0]['project_address'].'</h4><h4>Instructions:'.$nextday4[0]['instructions'].'</h4></div>">'.$nextday4[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday4[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday4[0]['is_locked'].'">'.$is_edit_n4_0.''.$is_locked_n4_0.'</div></td>';
												$td5_1100 = '<td rowspan="'.$rowSpan_n4_1.'"><div style="background-color:'.$nextday4[1]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday4[1]['job_number'].'</h4><h4>Task Number:'.$nextday4[1]['task_number'].'</h4><h4>Booking Time:'.$nextday4[1]['schedule_date'].'</h4><h4>Site:'.$nextday4[1]['project_name'].'</h4><h4>Client:'.$nextday4[1]['client_name'].'</h4><h4>Tasks:'.$nextday4[1]['task_ids'].'</h4><h4>Contact:'.$nextday4[1]['project_address'].'</h4><h4>Instructions:'.$nextday4[1]['instructions'].'</h4></div>">'.$nextday4[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday4[1]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday4[1]['is_locked'].'">'.$is_edit_n4_1.''.$is_locked_n4_1.'</div></td>';
												$td5_1400 = '<td rowspan="'.$rowSpan_n4_2.'"><div style="background-color:'.$nextday4[2]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday4[2]['job_number'].'</h4><h4>Task Number:'.$nextday4[2]['task_number'].'</h4><h4>Booking Time:'.$nextday4[2]['schedule_date'].'</h4><h4>Site:'.$nextday4[2]['project_name'].'</h4><h4>Client:'.$nextday4[2]['client_name'].'</h4><h4>Tasks:'.$nextday4[2]['task_ids'].'</h4><h4>Contact:'.$nextday4[2]['project_address'].'</h4><h4>Instructions:'.$nextday4[2]['instructions'].'</h4></div>">'.$nextday4[2]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday4[2]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday4[2]['is_locked'].'">'.$is_edit_n4_2.''.$is_locked_n4_2.'</div></td>';
												$td5_t4 = '<td rowspan="'.$rowSpan_n4_3.'"><div style="background-color:'.$nextday4[3]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday4[3]['job_number'].'</h4><h4>Task Number:'.$nextday4[3]['task_number'].'</h4><h4>Booking Time:'.$nextday4[3]['schedule_date'].'</h4><h4>Site:'.$nextday4[3]['project_name'].'</h4><h4>Client:'.$nextday4[3]['client_name'].'</h4><h4>Tasks:'.$nextday4[3]['task_ids'].'</h4><h4>Contact:'.$nextday4[3]['project_address'].'</h4><h4>Instructions:'.$nextday4[3]['instructions'].'</h4></div>">'.$nextday4[3]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday4[3]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday4[3]['is_locked'].'">'.$is_edit_n4_3.''.$is_locked_n4_3.'</div></td>';
												$td5_t5 = '<td rowspan="'.$rowSpan_n4_4.'"><div style="background-color:'.$nextday4[4]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday4[4]['job_number'].'</h4><h4>Task Number:'.$nextday4[4]['task_number'].'</h4><h4>Booking Time:'.$nextday4[4]['schedule_date'].'</h4><h4>Site:'.$nextday4[4]['project_name'].'</h4><h4>Client:'.$nextday4[4]['client_name'].'</h4><h4>Tasks:'.$nextday4[4]['task_ids'].'</h4><h4>Contact:'.$nextday4[4]['project_address'].'</h4><h4>Instructions:'.$nextday4[4]['instructions'].'</h4></div>">'.$nextday4[4]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday4[4]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday4[4]['is_locked'].'">'.$is_edit_n4_4.''.$is_locked_n4_4.'</div></td>';
												break;
											case 6:
												$td5_700 = '<td rowspan="'.$rowSpan_n4_0.'"><div style="background-color:'.$nextday4[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday4[0]['job_number'].'</h4><h4>Task Number:'.$nextday4[0]['task_number'].'</h4><h4>Booking Time:'.$nextday4[0]['schedule_date'].'</h4><h4>Site:'.$nextday4[0]['project_name'].'</h4><h4>Client:'.$nextday4[0]['client_name'].'</h4><h4>Tasks:'.$nextday4[0]['task_ids'].'</h4><h4>Contact:'.$nextday4[0]['project_address'].'</h4><h4>Instructions:'.$nextday4[0]['instructions'].'</h4></div>">'.$nextday4[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday4[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday4[0]['is_locked'].'">'.$is_edit_n4_0.''.$is_locked_n4_0.'</div></td>';
												$td5_1100 = '<td rowspan="'.$rowSpan_n4_1.'"><div style="background-color:'.$nextday4[1]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday4[1]['job_number'].'</h4><h4>Task Number:'.$nextday4[1]['task_number'].'</h4><h4>Booking Time:'.$nextday4[1]['schedule_date'].'</h4><h4>Site:'.$nextday4[1]['project_name'].'</h4><h4>Client:'.$nextday4[1]['client_name'].'</h4><h4>Tasks:'.$nextday4[1]['task_ids'].'</h4><h4>Contact:'.$nextday4[1]['project_address'].'</h4><h4>Instructions:'.$nextday4[1]['instructions'].'</h4></div>">'.$nextday4[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday4[1]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday4[1]['is_locked'].'">'.$is_edit_n4_1.''.$is_locked_n4_1.'</div></td>';
												$td5_1400 = '<td rowspan="'.$rowSpan_n4_2.'"><div style="background-color:'.$nextday4[2]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday4[2]['job_number'].'</h4><h4>Task Number:'.$nextday4[2]['task_number'].'</h4><h4>Booking Time:'.$nextday4[2]['schedule_date'].'</h4><h4>Site:'.$nextday4[2]['project_name'].'</h4><h4>Client:'.$nextday4[2]['client_name'].'</h4><h4>Tasks:'.$nextday4[2]['task_ids'].'</h4><h4>Contact:'.$nextday4[2]['project_address'].'</h4><h4>Instructions:'.$nextday4[2]['instructions'].'</h4></div>">'.$nextday4[2]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday4[2]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday4[2]['is_locked'].'">'.$is_edit_n4_2.''.$is_locked_n4_2.'</div></td>';
												$td5_t4 = '<td rowspan="'.$rowSpan_n4_3.'"><div style="background-color:'.$nextday4[3]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday4[3]['job_number'].'</h4><h4>Task Number:'.$nextday4[3]['task_number'].'</h4><h4>Booking Time:'.$nextday4[3]['schedule_date'].'</h4><h4>Site:'.$nextday4[3]['project_name'].'</h4><h4>Client:'.$nextday4[3]['client_name'].'</h4><h4>Tasks:'.$nextday4[3]['task_ids'].'</h4><h4>Contact:'.$nextday4[3]['project_address'].'</h4><h4>Instructions:'.$nextday4[3]['instructions'].'</h4></div>">'.$nextday4[3]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday4[3]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday4[3]['is_locked'].'">'.$is_edit_n4_3.''.$is_locked_n4_3.'</div></td>';
												$td5_t5 = '<td rowspan="'.$rowSpan_n4_4.'"><div style="background-color'.$nextday4[4]['color_code'].' class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday4[4]['job_number'].'</h4><h4>Task Number:'.$nextday4[4]['task_number'].'</h4><h4>Booking Time:'.$nextday4[4]['schedule_date'].'</h4><h4>Site:'.$nextday4[4]['project_name'].'</h4><h4>Client:'.$nextday4[4]['client_name'].'</h4><h4>Tasks:'.$nextday4[4]['task_ids'].'</h4><h4>Contact:'.$nextday4[4]['project_address'].'</h4><h4>Instructions:'.$nextday4[4]['instructions'].'</h4></div>">'.$nextday4[4]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday4[4]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday4[4]['is_locked'].'">'.$is_edit_n4_4.''.$is_locked_n4_4.'</div></td>';
												$td5_t6 = '<td rowspan="'.$rowSpan_n4_5.'"><div style="background-color:'.$nextday4[5]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday4[5]['job_number'].'</h4><h4>Task Number:'.$nextday4[5]['task_number'].'</h4><h4>Booking Time:'.$nextday4[5]['schedule_date'].'</h4><h4>Site:'.$nextday4[5]['project_name'].'</h4><h4>Client:'.$nextday4[5]['client_name'].'</h4><h4>Tasks:'.$nextday4[5]['task_ids'].'</h4><h4>Contact:'.$nextday4[5]['project_address'].'</h4><h4>Instructions:'.$nextday4[5]['instructions'].'</h4></div>">'.$nextday4[5]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday4[5]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday4[5]['is_locked'].'">'.$is_edit_n4_5.''.$is_locked_n4_5.'</div></td>';
												break;
											default:
												$td5_700 = '<td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[3].'" data-empname="'.$fullname.'">Add</button></td>';
												
												$td5_1400 = '<td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[3].'" data-empname="'.$fullname.'">Add</button></td>';
											}
										
										$nextday5 = $CI->filtersamedate($sheetData,$weekOfdate[4]);
										if(@$nextday5[0]['is_locked']==0){
											$is_locked_n5_0 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_n5_0 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_n5_0 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_n5_0 = '';
										}
										if(@$nextday5[1]['is_locked']==0){
											$is_locked_n5_1 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_n5_1 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_n5_1 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_n5_1 = '';
										}
										if(@$nextday5[2]['is_locked']==0){
											$is_locked_n5_2 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_n5_2 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_n5_2 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_n5_2 = '';
										}
										if(@$nextday5[3]['is_locked']==0){
											$is_locked_n5_3 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_n5_3 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_n5_3 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_n5_3 = '';
										}
										if(@$nextday5[4]['is_locked']==0){
											$is_locked_n5_4 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_n5_4 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_n5_4 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_n5_4 = '';
										}
										if(@$nextday5[5]['is_locked']==0){
											$is_locked_n5_5 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_n5_5 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_n5_5 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_n5_5 = '';
										}

										$rowSpan_n5_0 = @$nextday5[0]['all_day']==1 ? $countRows : "";
										$rowSpan_n5_1 = @$nextday5[1]['all_day']==1 ? $countRows : "";
										$rowSpan_n5_2 = @$nextday5[2]['all_day']==1 ? $countRows : "";
										$rowSpan_n5_3 = @$nextday5[3]['all_day']==1 ? $countRows : "";
										$rowSpan_n5_4 = @$nextday5[4]['all_day']==1 ? $countRows : "";
										$rowSpan_n5_5 = @$nextday5[5]['all_day']==1 ? $countRows : "";

										switch (count($nextday5)) {
											case 1:
												$td6_700 = '<td rowspan="'.$rowSpan_n5_0.'"><div style="background-color:'.$nextday5[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday5[0]['job_number'].'</h4><h4>Task Number:'.$nextday5[0]['task_number'].'</h4><h4>Booking Time:'.$nextday5[0]['schedule_date'].'</h4><h4>Site:'.$nextday5[0]['project_name'].'</h4><h4>Client:'.$nextday5[0]['client_name'].'</h4><h4>Tasks:'.$nextday5[0]['task_ids'].'</h4><h4>Contact:'.$nextday5[0]['project_address'].'</h4><h4>Instructions:'.$nextday5[0]['instructions'].'</h4></div>">'.$nextday5[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday5[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday5[0]['is_locked'].'">'.$is_edit_n5_0.''.$is_locked_n5_0.'</div></td>';
												break;
											case 2:
												$td6_700 = '<td rowspan="'.$rowSpan_n5_0.'"><div style="background-color:'.$nextday5[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday5[0]['job_number'].'</h4><h4>Task Number:'.$nextday5[0]['task_number'].'</h4><h4>Booking Time:'.$nextday5[0]['schedule_date'].'</h4><h4>Site:'.$nextday5[0]['project_name'].'</h4><h4>Client:'.$nextday5[0]['client_name'].'</h4><h4>Tasks:'.$nextday5[0]['task_ids'].'</h4><h4>Contact:'.$nextday5[0]['project_address'].'</h4><h4>Instructions:'.$nextday5[0]['instructions'].'</h4></div>">'.$nextday5[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday5[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday5[0]['is_locked'].'">'.$is_edit_n5_0.''.$is_locked_n5_0.'</div></td>';
												$td6_1100 = '<td rowspan="'.$rowSpan_n5_1.'"><div style="background-color:'.$nextday5[1]['color_code'].'" class="hover_popup" data-toggle="popover" data-placement="left" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday5[1]['job_number'].'</h4><h4>Task Number:'.$nextday5[1]['task_number'].'</h4><h4>Booking Time:'.$nextday5[1]['schedule_date'].'</h4><h4>Site:'.$nextday5[1]['project_name'].'</h4><h4>Client:'.$nextday5[1]['client_name'].'</h4><h4>Tasks:'.$nextday5[0]['task_ids'].'</h4><h4>Contact:'.$nextday5[1]['project_address'].'</h4><h4>Instructions:'.$nextday5[1]['instructions'].'</h4></div>">'.$nextday5[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday5[1]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday5[1]['is_locked'].'">'.$is_edit_n5_1.''.$is_locked_n5_1.'</div></td>';
												break;
											case 3:
												$td6_700 = '<td rowspan="'.$rowSpan_n5_0.'"><div style="background-color:'.$nextday5[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday5[0]['job_number'].'</h4><h4>Task Number:'.$nextday5[0]['task_number'].'</h4><h4>Booking Time:'.$nextday5[0]['schedule_date'].'</h4><h4>Site:'.$nextday5[0]['project_name'].'</h4><h4>Client:'.$nextday5[0]['client_name'].'</h4><h4>Tasks:'.$nextday5[0]['task_ids'].'</h4><h4>Contact:'.$nextday5[0]['project_address'].'</h4><h4>Instructions:'.$nextday5[0]['instructions'].'</h4></div>">'.$nextday5[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday5[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday5[0]['is_locked'].'">'.$is_edit_n5_0.''.$is_locked_n5_0.'</div></td>';
												$td6_1100 = '<td rowspan="'.$rowSpan_n5_1.'"><div style="background-color:'.$nextday5[1]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday5[1]['job_number'].'</h4><h4>Task Number:'.$nextday5[1]['task_number'].'</h4><h4>Booking Time:'.$nextday5[1]['schedule_date'].'</h4><h4>Site:'.$nextday5[1]['project_name'].'</h4><h4>Client:'.$nextday5[1]['client_name'].'</h4><h4>Tasks:'.$nextday5[1]['task_ids'].'</h4><h4>Contact:'.$nextday5[1]['project_address'].'</h4><h4>Instructions:'.$nextday5[1]['instructions'].'</h4></div>">'.$nextday5[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday5[1]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday5[1]['is_locked'].'">'.$is_edit_n5_1.''.$is_locked_n5_1.'</div></td>';
												$td6_1400 = '<td rowspan="'.$rowSpan_n5_2.'"><div style="background-color:'.$nextday5[2]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday5[2]['job_number'].'</h4><h4>Task Number:'.$nextday5[2]['task_number'].'</h4><h4>Booking Time:'.$nextday5[2]['schedule_date'].'</h4><h4>Site:'.$nextday5[2]['project_name'].'</h4><h4>Client:'.$nextday5[2]['client_name'].'</h4><h4>Tasks:'.$nextday5[2]['task_ids'].'</h4><h4>Contact:'.$nextday5[2]['project_address'].'</h4><h4>Instructions:'.$nextday5[2]['instructions'].'</h4></div>">'.$nextday5[2]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday5[2]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday5[2]['is_locked'].'">'.$is_edit_n5_2.''.$is_locked_n5_2.'</div></td>';
												break;
											case 4:
												$td6_700 = '<td rowspan="'.$rowSpan_n5_0.'"><div style="background-color:'.$nextday5[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday5[0]['job_number'].'</h4><h4>Task Number:'.$nextday5[0]['task_number'].'</h4><h4>Booking Time:'.$nextday5[0]['schedule_date'].'</h4><h4>Site:'.$nextday5[0]['project_name'].'</h4><h4>Client:'.$nextday5[0]['client_name'].'</h4><h4>Tasks:'.$nextday5[0]['task_ids'].'</h4><h4>Contact:'.$nextday5[0]['project_address'].'</h4><h4>Instructions:'.$nextday5[0]['instructions'].'</h4></div>">'.$nextday5[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday5[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday5[0]['is_locked'].'">'.$is_edit_n5_0.''.$is_locked_n5_0.'</div></td>';
												$td6_1100 = '<td rowspan="'.$rowSpan_n5_1.'"><div style="background-color:'.$nextday5[1]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday5[1]['job_number'].'</h4><h4>Task Number:'.$nextday5[1]['task_number'].'</h4><h4>Booking Time:'.$nextday5[1]['schedule_date'].'</h4><h4>Site:'.$nextday5[1]['project_name'].'</h4><h4>Client:'.$nextday5[1]['client_name'].'</h4><h4>Tasks:'.$nextday5[1]['task_ids'].'</h4><h4>Contact:'.$nextday5[1]['project_address'].'</h4><h4>Instructions:'.$nextday5[1]['instructions'].'</h4></div>">'.$nextday5[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday5[1]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday5[1]['is_locked'].'">'.$is_edit_n5_1.''.$is_locked_n5_1.'</div></td>';
												$td6_1400 = '<td rowspan="'.$rowSpan_n5_2.'"><div style="background-color:'.$nextday5[2]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday5[2]['job_number'].'</h4><h4>Task Number:'.$nextday5[2]['task_number'].'</h4><h4>Booking Time:'.$nextday5[2]['schedule_date'].'</h4><h4>Site:'.$nextday5[2]['project_name'].'</h4><h4>Client:'.$nextday5[2]['client_name'].'</h4><h4>Tasks:'.$nextday5[2]['task_ids'].'</h4><h4>Contact:'.$nextday5[2]['project_address'].'</h4><h4>Instructions:'.$nextday5[2]['instructions'].'</h4></div>">'.$nextday5[2]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday5[2]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday5[2]['is_locked'].'">'.$is_edit_n5_2.''.$is_locked_n5_2.'</div></td>';
												$td6_t4 = '<td rowspan="'.$rowSpan_n5_3.'"><div style="background-color:'.$nextday5[3]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday5[3]['job_number'].'</h4><h4>Task Number:'.$nextday5[3]['task_number'].'</h4><h4>Booking Time:'.$nextday5[3]['schedule_date'].'</h4><h4>Site:'.$nextday5[3]['project_name'].'</h4><h4>Client:'.$nextday5[3]['client_name'].'</h4><h4>Tasks:'.$nextday5[3]['task_ids'].'</h4><h4>Contact:'.$nextday5[3]['project_address'].'</h4><h4>Instructions:'.$nextday5[3]['instructions'].'</h4></div>">'.$nextday5[3]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday5[3]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday5[3]['is_locked'].'">'.$is_edit_n5_3.''.$is_locked_n5_3.'</div></td>';
												break;
											case 5:
												$td6_700 = '<td rowspan="'.$rowSpan_n5_0.'"><div style="background-color:'.$nextday5[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday5[0]['job_number'].'</h4><h4>Task Number:'.$nextday5[0]['task_number'].'</h4><h4>Booking Time:'.$nextday5[0]['schedule_date'].'</h4><h4>Site:'.$nextday5[0]['project_name'].'</h4><h4>Client:'.$nextday5[0]['client_name'].'</h4><h4>Tasks:'.$nextday5[0]['task_ids'].'</h4><h4>Contact:'.$nextday5[0]['project_address'].'</h4><h4>Instructions:'.$nextday5[0]['instructions'].'</h4></div>">'.$nextday5[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday5[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday5[0]['is_locked'].'">'.$is_edit_n5_0.''.$is_locked_n5_0.'</div></td>';
												$td6_1100 = '<td rowspan="'.$rowSpan_n5_1.'"><div style="background-color:'.$nextday5[1]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday5[1]['job_number'].'</h4><h4>Task Number:'.$nextday5[1]['task_number'].'</h4><h4>Booking Time:'.$nextday5[1]['schedule_date'].'</h4><h4>Site:'.$nextday5[1]['project_name'].'</h4><h4>Client:'.$nextday5[1]['client_name'].'</h4><h4>Tasks:'.$nextday5[1]['task_ids'].'</h4><h4>Contact:'.$nextday5[1]['project_address'].'</h4><h4>Instructions:'.$nextday5[1]['instructions'].'</h4></div>">'.$nextday5[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday5[1]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday5[1]['is_locked'].'">'.$is_edit_n5_1.''.$is_locked_n5_1.'</div></td>';
												$td6_1400 = '<td rowspan="'.$rowSpan_n5_2.'"><div style="background-color:'.$nextday5[2]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday5[2]['job_number'].'</h4><h4>Task Number:'.$nextday5[2]['task_number'].'</h4><h4>Booking Time:'.$nextday5[2]['schedule_date'].'</h4><h4>Site:'.$nextday5[2]['project_name'].'</h4><h4>Client:'.$nextday5[2]['client_name'].'</h4><h4>Tasks:'.$nextday5[2]['task_ids'].'</h4><h4>Contact:'.$nextday5[2]['project_address'].'</h4><h4>Instructions:'.$nextday5[2]['instructions'].'</h4></div>">'.$nextday5[2]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday5[2]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday5[2]['is_locked'].'">'.$is_edit_n5_2.''.$is_locked_n5_2.'</div></td>';
												$td6_t4 = '<td rowspan="'.$rowSpan_n5_3.'"><div style="background-color:'.$nextday5[3]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday5[3]['job_number'].'</h4><h4>Task Number:'.$nextday5[3]['task_number'].'</h4><h4>Booking Time:'.$nextday5[3]['schedule_date'].'</h4><h4>Site:'.$nextday5[3]['project_name'].'</h4><h4>Client:'.$nextday5[3]['client_name'].'</h4><h4>Tasks:'.$nextday5[3]['task_ids'].'</h4><h4>Contact:'.$nextday5[3]['project_address'].'</h4><h4>Instructions:'.$nextday5[3]['instructions'].'</h4></div>">'.$nextday5[3]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday5[3]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday5[3]['is_locked'].'">'.$is_edit_n5_3.''.$is_locked_n5_3.'</div></td>';
												$td6_t5 = '<td rowspan="'.$rowSpan_n5_4.'"><div style="background-color:'.$nextday5[4]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday5[4]['job_number'].'</h4><h4>Task Number:'.$nextday5[4]['task_number'].'</h4><h4>Booking Time:'.$nextday5[4]['schedule_date'].'</h4><h4>Site:'.$nextday5[4]['project_name'].'</h4><h4>Client:'.$nextday5[4]['client_name'].'</h4><h4>Tasks:'.$nextday5[4]['task_ids'].'</h4><h4>Contact:'.$nextday5[4]['project_address'].'</h4><h4>Instructions:'.$nextday5[4]['instructions'].'</h4></div>">'.$nextday5[4]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday5[4]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday5[4]['is_locked'].'">'.$is_edit_n5_4.''.$is_locked_n5_4.'</div></td>';
												break;
											case 6:
												$td6_700 = '<td rowspan="'.$rowSpan_n5_0.'"><div style="background-color:'.$nextday5[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday5[0]['job_number'].'</h4><h4>Task Number:'.$nextday5[0]['task_number'].'</h4><h4>Booking Time:'.$nextday5[0]['schedule_date'].'</h4><h4>Site:'.$nextday5[0]['project_name'].'</h4><h4>Client:'.$nextday5[0]['client_name'].'</h4><h4>Tasks:'.$nextday5[0]['task_ids'].'</h4><h4>Contact:'.$nextday5[0]['project_address'].'</h4><h4>Instructions:'.$nextday5[0]['instructions'].'</h4></div>">'.$nextday5[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday5[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday5[0]['is_locked'].'">'.$is_edit_n5_0.''.$is_locked_n5_0.'</div></td>';
												$td6_1100 = '<td rowspan="'.$rowSpan_n5_1.'"><div style="background-color:'.$nextday5[1]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday5[1]['job_number'].'</h4><h4>Task Number:'.$nextday5[1]['task_number'].'</h4><h4>Booking Time:'.$nextday5[1]['schedule_date'].'</h4><h4>Site:'.$nextday5[1]['project_name'].'</h4><h4>Client:'.$nextday5[1]['client_name'].'</h4><h4>Tasks:'.$nextday5[1]['task_ids'].'</h4><h4>Contact:'.$nextday5[1]['project_address'].'</h4><h4>Instructions:'.$nextday5[1]['instructions'].'</h4></div>">'.$nextday5[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday5[1]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday5[1]['is_locked'].'">'.$is_edit_n5_1.''.$is_locked_n5_1.'</div></td>';
												$td6_1400 = '<td rowspan="'.$rowSpan_n5_2.'"><div style="background-color:'.$nextday5[2]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday5[2]['job_number'].'</h4><h4>Task Number:'.$nextday5[2]['task_number'].'</h4><h4>Booking Time:'.$nextday5[2]['schedule_date'].'</h4><h4>Site:'.$nextday5[2]['project_name'].'</h4><h4>Client:'.$nextday5[2]['client_name'].'</h4><h4>Tasks:'.$nextday5[2]['task_ids'].'</h4><h4>Contact:'.$nextday5[2]['project_address'].'</h4><h4>Instructions:'.$nextday5[2]['instructions'].'</h4></div>">'.$nextday5[2]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday5[2]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday5[2]['is_locked'].'">'.$is_edit_n5_2.''.$is_locked_n5_2.'</div></td>';
												$td6_t4 = '<td rowspan="'.$rowSpan_n5_3.'"><div style="background-color:'.$nextday5[3]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday5[3]['job_number'].'</h4><h4>Task Number:'.$nextday5[3]['task_number'].'</h4><h4>Booking Time:'.$nextday5[3]['schedule_date'].'</h4><h4>Site:'.$nextday5[3]['project_name'].'</h4><h4>Client:'.$nextday5[3]['client_name'].'</h4><h4>Tasks:'.$nextday5[3]['task_ids'].'</h4><h4>Contact:'.$nextday5[3]['project_address'].'</h4><h4>Instructions:'.$nextday5[3]['instructions'].'</h4></div>">'.$nextday5[3]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday5[3]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday5[3]['is_locked'].'">'.$is_edit_n5_3.''.$is_locked_n5_3.'</div></td>';
												$td6_t5 = '<td rowspan="'.$rowSpan_n5_4.'"><div style="background-color'.$nextday5[4]['color_code'].' class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday5[4]['job_number'].'</h4><h4>Task Number:'.$nextday5[4]['task_number'].'</h4><h4>Booking Time:'.$nextday5[4]['schedule_date'].'</h4><h4>Site:'.$nextday5[4]['project_name'].'</h4><h4>Client:'.$nextday5[4]['client_name'].'</h4><h4>Tasks:'.$nextday5[4]['task_ids'].'</h4><h4>Contact:'.$nextday5[4]['project_address'].'</h4><h4>Instructions:'.$nextday5[4]['instructions'].'</h4></div>">'.$nextday5[4]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday5[4]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday5[4]['is_locked'].'">'.$is_edit_n5_4.''.$is_locked_n5_4.'</div></td>';
												$td6_t6 = '<td rowspan="'.$rowSpan_n5_5.'"><div style="background-color:'.$nextday5[5]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday5[5]['job_number'].'</h4><h4>Task Number:'.$nextday5[5]['task_number'].'</h4><h4>Booking Time:'.$nextday5[5]['schedule_date'].'</h4><h4>Site:'.$nextday5[5]['project_name'].'</h4><h4>Client:'.$nextday5[5]['client_name'].'</h4><h4>Tasks:'.$nextday5[5]['task_ids'].'</h4><h4>Contact:'.$nextday5[5]['project_address'].'</h4><h4>Instructions:'.$nextday5[5]['instructions'].'</h4></div>">'.$nextday5[5]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday5[5]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday5[5]['is_locked'].'">'.$is_edit_n5_5.''.$is_locked_n5_5.'</div></td>';
												break;
											default:
												$td6_700 = '<td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[4].'" data-empname="'.$fullname.'">Add</button></td>';
												
												$td6_1400 = '<td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[4].'" data-empname="'.$fullname.'">Add</button></td>';
											}
										
										$nextday6 = $CI->filtersamedate($sheetData,$weekOfdate[5]);
										if(@$nextday6[0]['is_locked']==0){
											$is_locked_n6_0 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_n6_0 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_n6_0 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_n6_0 = '';
										}
										if(@$nextday6[1]['is_locked']==0){
											$is_locked_n6_1 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_n6_1 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_n6_1 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_n6_1 = '';
										}
										if(@$nextday6[2]['is_locked']==0){
											$is_locked_n6_2 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_n6_2 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_n6_2 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_n6_2 = '';
										}
										if(@$nextday6[3]['is_locked']==0){
											$is_locked_n6_3 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_n6_3 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_n6_3 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_n6_3 = '';
										}
										if(@$nextday6[4]['is_locked']==0){
											$is_locked_n6_4 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_n6_4 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_n6_4 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_n6_4 = '';
										}
										if(@$nextday6[5]['is_locked']==0){
											$is_locked_n6_5 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock-unlock.png"></a>';
											$is_edit_n6_5 = '<a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a>';
										}else{
											$is_locked_n6_5 = '<a href="javaScript:void(0);"><img src="'.base_url().'/assets/images/padlock.png"></a>';
											$is_edit_n6_5 = '';
										}

										$rowSpan_n6_0 = @$nextday6[0]['all_day']==1 ? $countRows : "";
										$rowSpan_n6_1 = @$nextday6[1]['all_day']==1 ? $countRows : "";
										$rowSpan_n6_2 = @$nextday6[2]['all_day']==1 ? $countRows : "";
										$rowSpan_n6_3 = @$nextday6[3]['all_day']==1 ? $countRows : "";
										$rowSpan_n6_4 = @$nextday6[4]['all_day']==1 ? $countRows : "";
										$rowSpan_n6_5 = @$nextday6[5]['all_day']==1 ? $countRows : "";

										switch (count($nextday6)) {
											case 1:
												$td7_700 = '<td rowspan="'.$rowSpan_n6_0.'"><div style="background-color:'.$nextday6[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday6[0]['job_number'].'</h4><h4>Task Number:'.$nextday6[0]['task_number'].'</h4><h4>Booking Time:'.$nextday6[0]['schedule_date'].'</h4><h4>Site:'.$nextday6[0]['project_name'].'</h4><h4>Client:'.$nextday6[0]['client_name'].'</h4><h4>Tasks:'.$nextday6[0]['task_ids'].'</h4><h4>Contact:'.$nextday6[0]['project_address'].'</h4><h4>Instructions:'.$nextday6[0]['instructions'].'</h4></div>">'.$nextday6[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday6[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday6[0]['is_locked'].'">'.$is_edit_n6_0.''.$is_locked_n6_0.'</div></td>';
												break;
											case 2:
												$td7_700 = '<td rowspan="'.$rowSpan_n6_0.'"><div style="background-color:'.$nextday6[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday6[0]['job_number'].'</h4><h4>Task Number:'.$nextday6[0]['task_number'].'</h4><h4>Booking Time:'.$nextday6[0]['schedule_date'].'</h4><h4>Site:'.$nextday6[0]['project_name'].'</h4><h4>Client:'.$nextday6[0]['client_name'].'</h4><h4>Tasks:'.$nextday6[0]['task_ids'].'</h4><h4>Contact:'.$nextday6[0]['project_address'].'</h4><h4>Instructions:'.$nextday6[0]['instructions'].'</h4></div>">'.$nextday6[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday6[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday6[0]['is_locked'].'">'.$is_edit_n6_0.''.$is_locked_n6_0.'</div></td>';
												$td7_1100 = '<td rowspan="'.$rowSpan_n6_1.'"><div style="background-color:'.$nextday6[1]['color_code'].'" class="hover_popup" data-toggle="popover" data-placement="left" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday6[1]['job_number'].'</h4><h4>Task Number:'.$nextday6[1]['task_number'].'</h4><h4>Booking Time:'.$nextday6[1]['schedule_date'].'</h4><h4>Site:'.$nextday6[1]['project_name'].'</h4><h4>Client:'.$nextday6[1]['client_name'].'</h4><h4>Tasks:'.$nextday6[0]['task_ids'].'</h4><h4>Contact:'.$nextday6[1]['project_address'].'</h4><h4>Instructions:'.$nextday6[1]['instructions'].'</h4></div>">'.$nextday6[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday6[1]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday6[1]['is_locked'].'">'.$is_edit_n6_1.''.$is_locked_n6_1.'</div></td>';
												break;
											case 3:
												$td7_700 = '<td rowspan="'.$rowSpan_n6_0.'"><div style="background-color:'.$nextday6[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday6[0]['job_number'].'</h4><h4>Task Number:'.$nextday6[0]['task_number'].'</h4><h4>Booking Time:'.$nextday6[0]['schedule_date'].'</h4><h4>Site:'.$nextday6[0]['project_name'].'</h4><h4>Client:'.$nextday6[0]['client_name'].'</h4><h4>Tasks:'.$nextday6[0]['task_ids'].'</h4><h4>Contact:'.$nextday6[0]['project_address'].'</h4><h4>Instructions:'.$nextday6[0]['instructions'].'</h4></div>">'.$nextday6[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday6[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday6[0]['is_locked'].'">'.$is_edit_n6_0.''.$is_locked_n6_0.'</div></td>';
												$td7_1100 = '<td rowspan="'.$rowSpan_n6_1.'"><div style="background-color:'.$nextday6[1]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday6[1]['job_number'].'</h4><h4>Task Number:'.$nextday6[1]['task_number'].'</h4><h4>Booking Time:'.$nextday6[1]['schedule_date'].'</h4><h4>Site:'.$nextday6[1]['project_name'].'</h4><h4>Client:'.$nextday6[1]['client_name'].'</h4><h4>Tasks:'.$nextday6[1]['task_ids'].'</h4><h4>Contact:'.$nextday6[1]['project_address'].'</h4><h4>Instructions:'.$nextday6[1]['instructions'].'</h4></div>">'.$nextday6[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday6[1]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday6[1]['is_locked'].'">'.$is_edit_n6_1.''.$is_locked_n6_1.'</div></td>';
												$td7_1400 = '<td rowspan="'.$rowSpan_n6_2.'"><div style="background-color:'.$nextday6[2]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday6[2]['job_number'].'</h4><h4>Task Number:'.$nextday6[2]['task_number'].'</h4><h4>Booking Time:'.$nextday6[2]['schedule_date'].'</h4><h4>Site:'.$nextday6[2]['project_name'].'</h4><h4>Client:'.$nextday6[2]['client_name'].'</h4><h4>Tasks:'.$nextday6[2]['task_ids'].'</h4><h4>Contact:'.$nextday6[2]['project_address'].'</h4><h4>Instructions:'.$nextday6[2]['instructions'].'</h4></div>">'.$nextday6[2]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday6[2]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday6[2]['is_locked'].'">'.$is_edit_n6_2.''.$is_locked_n6_2.'</div></td>';
												break;
											case 4:
												$td7_700 = '<td rowspan="'.$rowSpan_n6_0.'"><div style="background-color:'.$nextday6[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday6[0]['job_number'].'</h4><h4>Task Number:'.$nextday6[0]['task_number'].'</h4><h4>Booking Time:'.$nextday6[0]['schedule_date'].'</h4><h4>Site:'.$nextday6[0]['project_name'].'</h4><h4>Client:'.$nextday6[0]['client_name'].'</h4><h4>Tasks:'.$nextday6[0]['task_ids'].'</h4><h4>Contact:'.$nextday6[0]['project_address'].'</h4><h4>Instructions:'.$nextday6[0]['instructions'].'</h4></div>">'.$nextday6[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday6[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday6[0]['is_locked'].'">'.$is_edit_n6_0.''.$is_locked_n6_0.'</div></td>';
												$td7_1100 = '<td rowspan="'.$rowSpan_n6_1.'"><div style="background-color:'.$nextday6[1]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday6[1]['job_number'].'</h4><h4>Task Number:'.$nextday6[1]['task_number'].'</h4><h4>Booking Time:'.$nextday6[1]['schedule_date'].'</h4><h4>Site:'.$nextday6[1]['project_name'].'</h4><h4>Client:'.$nextday6[1]['client_name'].'</h4><h4>Tasks:'.$nextday6[1]['task_ids'].'</h4><h4>Contact:'.$nextday6[1]['project_address'].'</h4><h4>Instructions:'.$nextday6[1]['instructions'].'</h4></div>">'.$nextday6[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday6[1]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday6[1]['is_locked'].'">'.$is_edit_n6_1.''.$is_locked_n6_1.'</div></td>';
												$td7_1400 = '<td rowspan="'.$rowSpan_n6_2.'"><div style="background-color:'.$nextday6[2]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday6[2]['job_number'].'</h4><h4>Task Number:'.$nextday6[2]['task_number'].'</h4><h4>Booking Time:'.$nextday6[2]['schedule_date'].'</h4><h4>Site:'.$nextday6[2]['project_name'].'</h4><h4>Client:'.$nextday6[2]['client_name'].'</h4><h4>Tasks:'.$nextday6[2]['task_ids'].'</h4><h4>Contact:'.$nextday6[2]['project_address'].'</h4><h4>Instructions:'.$nextday6[2]['instructions'].'</h4></div>">'.$nextday6[2]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday6[2]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday6[2]['is_locked'].'">'.$is_edit_n6_2.''.$is_locked_n6_2.'</div></td>';
												$td7_t4 = '<td rowspan="'.$rowSpan_n6_3.'"><div style="background-color:'.$nextday6[3]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday6[3]['job_number'].'</h4><h4>Task Number:'.$nextday6[3]['task_number'].'</h4><h4>Booking Time:'.$nextday6[3]['schedule_date'].'</h4><h4>Site:'.$nextday6[3]['project_name'].'</h4><h4>Client:'.$nextday6[3]['client_name'].'</h4><h4>Tasks:'.$nextday6[3]['task_ids'].'</h4><h4>Contact:'.$nextday6[3]['project_address'].'</h4><h4>Instructions:'.$nextday6[3]['instructions'].'</h4></div>">'.$nextday6[3]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday6[3]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday6[3]['is_locked'].'">'.$is_edit_n6_3.''.$is_locked_n6_3.'</div></td>';
												break;
											case 5:
												$td7_700 = '<td rowspan="'.$rowSpan_n6_0.'"><div style="background-color:'.$nextday6[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday6[0]['job_number'].'</h4><h4>Task Number:'.$nextday6[0]['task_number'].'</h4><h4>Booking Time:'.$nextday6[0]['schedule_date'].'</h4><h4>Site:'.$nextday6[0]['project_name'].'</h4><h4>Client:'.$nextday6[0]['client_name'].'</h4><h4>Tasks:'.$nextday6[0]['task_ids'].'</h4><h4>Contact:'.$nextday6[0]['project_address'].'</h4><h4>Instructions:'.$nextday6[0]['instructions'].'</h4></div>">'.$nextday6[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday6[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday6[0]['is_locked'].'">'.$is_edit_n6_0.''.$is_locked_n6_0.'</div></td>';
												$td7_1100 = '<td rowspan="'.$rowSpan_n6_1.'"><div style="background-color:'.$nextday6[1]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday6[1]['job_number'].'</h4><h4>Task Number:'.$nextday6[1]['task_number'].'</h4><h4>Booking Time:'.$nextday6[1]['schedule_date'].'</h4><h4>Site:'.$nextday6[1]['project_name'].'</h4><h4>Client:'.$nextday6[1]['client_name'].'</h4><h4>Tasks:'.$nextday6[1]['task_ids'].'</h4><h4>Contact:'.$nextday6[1]['project_address'].'</h4><h4>Instructions:'.$nextday6[1]['instructions'].'</h4></div>">'.$nextday6[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday6[1]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday6[1]['is_locked'].'">'.$is_edit_n6_1.''.$is_locked_n6_1.'</div></td>';
												$td7_1400 = '<td rowspan="'.$rowSpan_n6_2.'"><div style="background-color:'.$nextday6[2]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday6[2]['job_number'].'</h4><h4>Task Number:'.$nextday6[2]['task_number'].'</h4><h4>Booking Time:'.$nextday6[2]['schedule_date'].'</h4><h4>Site:'.$nextday6[2]['project_name'].'</h4><h4>Client:'.$nextday6[2]['client_name'].'</h4><h4>Tasks:'.$nextday6[2]['task_ids'].'</h4><h4>Contact:'.$nextday6[2]['project_address'].'</h4><h4>Instructions:'.$nextday6[2]['instructions'].'</h4></div>">'.$nextday6[2]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday6[2]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday6[2]['is_locked'].'">'.$is_edit_n6_2.''.$is_locked_n6_2.'</div></td>';
												$td7_t4 = '<td rowspan="'.$rowSpan_n6_3.'"><div style="background-color:'.$nextday6[3]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday6[3]['job_number'].'</h4><h4>Task Number:'.$nextday6[3]['task_number'].'</h4><h4>Booking Time:'.$nextday6[3]['schedule_date'].'</h4><h4>Site:'.$nextday6[3]['project_name'].'</h4><h4>Client:'.$nextday6[3]['client_name'].'</h4><h4>Tasks:'.$nextday6[3]['task_ids'].'</h4><h4>Contact:'.$nextday6[3]['project_address'].'</h4><h4>Instructions:'.$nextday6[3]['instructions'].'</h4></div>">'.$nextday6[3]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday6[3]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday6[3]['is_locked'].'">'.$is_edit_n6_3.''.$is_locked_n6_3.'</div></td>';
												$td7_t5 = '<td rowspan="'.$rowSpan_n6_4.'"><div style="background-color:'.$nextday6[4]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday6[4]['job_number'].'</h4><h4>Task Number:'.$nextday6[4]['task_number'].'</h4><h4>Booking Time:'.$nextday6[4]['schedule_date'].'</h4><h4>Site:'.$nextday6[4]['project_name'].'</h4><h4>Client:'.$nextday6[4]['client_name'].'</h4><h4>Tasks:'.$nextday6[4]['task_ids'].'</h4><h4>Contact:'.$nextday6[4]['project_address'].'</h4><h4>Instructions:'.$nextday6[4]['instructions'].'</h4></div>">'.$nextday6[4]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday6[4]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday6[4]['is_locked'].'">'.$is_edit_n6_4.''.$is_locked_n6_4.'</div></td>';
												break;
											case 6:
												$td7_700 = '<td rowspan="'.$rowSpan_n6_0.'"><div style="background-color:'.$nextday6[0]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday6[0]['job_number'].'</h4><h4>Task Number:'.$nextday6[0]['task_number'].'</h4><h4>Booking Time:'.$nextday6[0]['schedule_date'].'</h4><h4>Site:'.$nextday6[0]['project_name'].'</h4><h4>Client:'.$nextday6[0]['client_name'].'</h4><h4>Tasks:'.$nextday6[0]['task_ids'].'</h4><h4>Contact:'.$nextday6[0]['project_address'].'</h4><h4>Instructions:'.$nextday6[0]['instructions'].'</h4></div>">'.$nextday6[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday6[0]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday6[0]['is_locked'].'">'.$is_edit_n6_0.''.$is_locked_n6_0.'</div></td>';
												$td7_1100 = '<td rowspan="'.$rowSpan_n6_1.'"><div style="background-color:'.$nextday6[1]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday6[1]['job_number'].'</h4><h4>Task Number:'.$nextday6[1]['task_number'].'</h4><h4>Booking Time:'.$nextday6[1]['schedule_date'].'</h4><h4>Site:'.$nextday6[1]['project_name'].'</h4><h4>Client:'.$nextday6[1]['client_name'].'</h4><h4>Tasks:'.$nextday6[1]['task_ids'].'</h4><h4>Contact:'.$nextday6[1]['project_address'].'</h4><h4>Instructions:'.$nextday6[1]['instructions'].'</h4></div>">'.$nextday6[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday6[1]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday6[1]['is_locked'].'">'.$is_edit_n6_1.''.$is_locked_n6_1.'</div></td>';
												$td7_1400 = '<td rowspan="'.$rowSpan_n6_2.'"><div style="background-color:'.$nextday6[2]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday6[2]['job_number'].'</h4><h4>Task Number:'.$nextday6[2]['task_number'].'</h4><h4>Booking Time:'.$nextday6[2]['schedule_date'].'</h4><h4>Site:'.$nextday6[2]['project_name'].'</h4><h4>Client:'.$nextday6[2]['client_name'].'</h4><h4>Tasks:'.$nextday6[2]['task_ids'].'</h4><h4>Contact:'.$nextday6[2]['project_address'].'</h4><h4>Instructions:'.$nextday6[2]['instructions'].'</h4></div>">'.$nextday6[2]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday6[2]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday6[2]['is_locked'].'">'.$is_edit_n6_2.''.$is_locked_n6_2.'</div></td>';
												$td7_t4 = '<td rowspan="'.$rowSpan_n6_3.'"><div style="background-color:'.$nextday6[3]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday6[3]['job_number'].'</h4><h4>Task Number:'.$nextday6[3]['task_number'].'</h4><h4>Booking Time:'.$nextday6[3]['schedule_date'].'</h4><h4>Site:'.$nextday6[3]['project_name'].'</h4><h4>Client:'.$nextday6[3]['client_name'].'</h4><h4>Tasks:'.$nextday6[3]['task_ids'].'</h4><h4>Contact:'.$nextday6[3]['project_address'].'</h4><h4>Instructions:'.$nextday6[3]['instructions'].'</h4></div>">'.$nextday6[3]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday6[3]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday6[3]['is_locked'].'">'.$is_edit_n6_3.''.$is_locked_n6_3.'</div></td>';
												$td7_t5 = '<td rowspan="'.$rowSpan_n6_4.'"><div style="background-color'.$nextday6[4]['color_code'].' class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday6[4]['job_number'].'</h4><h4>Task Number:'.$nextday6[4]['task_number'].'</h4><h4>Booking Time:'.$nextday6[4]['schedule_date'].'</h4><h4>Site:'.$nextday6[4]['project_name'].'</h4><h4>Client:'.$nextday6[4]['client_name'].'</h4><h4>Tasks:'.$nextday6[4]['task_ids'].'</h4><h4>Contact:'.$nextday6[4]['project_address'].'</h4><h4>Instructions:'.$nextday6[4]['instructions'].'</h4></div>">'.$nextday6[4]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday6[4]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday6[4]['is_locked'].'">'.$is_edit_n6_4.''.$is_locked_n6_4.'</div></td>';
												$td7_t6 = '<td rowspan="'.$rowSpan_n6_5.'"><div style="background-color:'.$nextday6[5]['color_code'].'" class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday6[5]['job_number'].'</h4><h4>Task Number:'.$nextday6[5]['task_number'].'</h4><h4>Booking Time:'.$nextday6[5]['schedule_date'].'</h4><h4>Site:'.$nextday6[5]['project_name'].'</h4><h4>Client:'.$nextday6[5]['client_name'].'</h4><h4>Tasks:'.$nextday6[5]['task_ids'].'</h4><h4>Contact:'.$nextday6[5]['project_address'].'</h4><h4>Instructions:'.$nextday6[5]['instructions'].'</h4></div>">'.$nextday6[5]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday6[5]['schedule_id'].'" data-empid="'.$userData['userId'].'" data-isLock="'.$nextday6[5]['is_locked'].'">'.$is_edit_n6_5.''.$is_locked_n6_5.'</div></td>';
												break;
											default:
												$td7_700 = '<td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[5].'" data-empname="'.$fullname.'">Add</button></td>';
												
												$td7_1400 = '<td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[5].'" data-empname="'.$fullname.'">Add</button></td>';
											}
										
										//$nextday5 = $CI->filtersamedate($sheetData,$weekOfdate[4]);
										//all next days data with filter
										//After all
										
										$td700 = $td1_700.''.$td2_700.''.$td3_700.''.$td4_700.''.$td5_700.''.$td6_700.''.$td7_700;
										$td1100 = $td1_1100.''.$td2_1100.''.$td3_1100.''.$td4_1100.''.$td5_1100.''.$td6_1100.''.$td6_1100;
										$td1400 = $td1_1400.''.$td2_1400.''.$td3_1400.''.$td4_1400.''.$td5_1400.''.$td6_1400.''.$td7_1400;
										$tdt4 = $td1_t4.''.$td2_t4.''.$td3_t4.''.$td4_t4.''.$td5_t4.''.$td6_t4.''.$td7_t4;
										$tdt5 = $td1_t5.''.$td2_t5.''.$td3_t5.''.$td4_t5.''.$td5_t5.''.$td6_t5.''.$td6_t5;
										$tdt6 = $td1_t6.''.$td2_t6.''.$td3_t6.''.$td4_t6.''.$td5_t6.''.$td6_t6.''.$td7_t6;
									}else{	
										$td700 = '<td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$todaydate.'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[0].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[1].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[2].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[3].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[4].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[5].'" data-empname="'.$fullname.'">Add</button></td>';
										$td1100 = '<td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$todaydate.'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[0].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[1].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[2].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[3].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[4].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[5].'" data-empname="'.$fullname.'">Add</button></td>';
										$td1400 = '<td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$todaydate.'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[0].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[1].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[2].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[3].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[4].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[5].'" data-empname="'.$fullname.'">Add</button></td>';

										$tdt4 = '<td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$todaydate.'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[0].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[1].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[2].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[3].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[4].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[5].'" data-empname="'.$fullname.'">Add</button></td>';
										$tdt5 = '<td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$todaydate.'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[0].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[1].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[2].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[3].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[4].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[5].'" data-empname="'.$fullname.'">Add</button></td>';
										$tdt6 = '<td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$todaydate.'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[0].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[1].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[2].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[3].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[4].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[5].'" data-empname="'.$fullname.'">Add</button></td>';
									}
								?>
									<?php 
									//if($ptkey == 0){
										if($key==0){
											$upper_accoinout = 'out';
											$lower_accoinout = 'in';
										}else{
											$upper_accoinout = 'in';
											$lower_accoinout = 'out';
										}
									//}else{
										//$upper_accoinout = 'out';
										//$lower_accoinout = 'out';
									//}
								if($key==0){
										$upper_tr = 'upper_tr_0';
										$lower_trs = 'lower_trs_0';
									}else{
										$upper_tr = '';
										$lower_trs = '';
									} ?>
								  <tr class="top_tr top_tr_<?php echo $userData['userId']?>_<?php echo $ptypeId; ?> collapse <?php echo $upper_accoinout; ?> accordion_<?php echo $ptypeId; ?> upper_tr <?=$upper_tr?>" data-pid="<?php echo $ptypeId; ?>" data-id="<?php echo $userData['userId']?>" style="/*display:none;*/" >
                            <td colspan="9" class="empcolp"><?php echo $userData['fname'].' '.$userData['lname']; 
							
									?></td>
									<?php
									$rowsQu = $this->db->query('SELECT * FROM employee_rows WHERE employee_id='.$userData['userId'].' AND project_type_id='.$ptypeId.'');
									$rowsR = $rowsQu->result_array();
									if(!empty($rowsR)){
										$countRows = $rowsR[0]['total_rows'];
									}else{
										$countRows = 3;
									}
									?>
                        </tr>
								 <tr height="20" class="collapse <?php echo $lower_accoinout; ?> accordion_<?php echo $ptypeId; ?> subtbale_<?php echo $userData['userId'];?>_<?php echo $ptypeId; ?> lower_trs <?=$lower_trs?>">
								  <td class="datacolp" data-pid="<?php echo $ptypeId; ?>" data-id="<?php echo $userData['userId']?>" rowspan="<?=$countRows?>" height="60"  width="94" style='height:45.0pt;
								  border-top:none;width:71pt'><span class="datacolp-span" data-toggle="tooltip" title="Collapse Row"><?php echo $userData['fname'].'<br>'.$userData['lname']; ?></span><p><?php if($countRows<6){ ?><span class="add_row_e" data-row="<?=$countRows?>" data-toggle="tooltip" title="Add Row"><i class="fa fa-plus"></i></span><?php } ?><?php if($countRows>3){ ?><span class="rmv_row_e" data-row="<?=$countRows?>" data-toggle="tooltip" title="Remove Row"><i class="fa fa-minus"></i></span><?php } ?></p></td>
								  <td style='border-top:none;border-left:none'>Task 1</td>
								    <?php echo $td700; ?>
								 </tr>
								  <tr height="20" class="collapse <?php echo $lower_accoinout; ?> accordion_<?php echo $ptypeId; ?>  subtbale_<?php echo $userData['userId'];?>_<?php echo $ptypeId; ?> lower_trs <?=$lower_trs?>">
								  <td height="20" style='height:15.0pt;border-top:none;
								  border-left:none'>Task 2</td>
								 <?php echo $td1100; ?>
								 </tr>
								 <tr height="20" class="collapse <?php echo $lower_accoinout; ?> accordion_<?php echo $ptypeId; ?>  subtbale_<?php echo $userData['userId'];?>_<?php echo $ptypeId; ?> lower_trs <?=$lower_trs?>">
									  <td height="20"  style='height:15.0pt;border-top:none;
									  border-left:none'>Task 3</td>
									   <?php echo $td1400; ?>
									 </tr>
									 <?php //echo "<pre>";print_r($sheetval);echo "</pre>";
									 
									 //echo "<pre>";print_r($rowsR);echo "</pre>";
									 if(!empty($rowsR)){
									 	$rowsR = $rowsR[0];
									 	for($i=1;$i<=$rowsR['extra_rows'];$i++){
									 		$co = $i+3; ?>
									 		<tr height="20" class="collapse <?php echo $lower_accoinout; ?> accordion_<?php echo $ptypeId; ?>  subtbale_<?php echo $userData['userId'];?>_<?php echo $ptypeId; ?> lower_trs <?=$lower_trs?>">
											  <td height="20"  style='height:15.0pt;border-top:none;
											  border-left:none'>Task <?php echo $co; ?></td>
											   <?php if($co==4){
													   echo $tdt4;
													}elseif($co==5){
													   echo $tdt5;
													}else{
													   echo $tdt6;
													}
											    ?>
											</tr>
									 	<?php } ?>
									 <?php } ?>
							
								<?php } ?>
							<?php //} ?>
							</table>
						</div>
					</div>
				</div>
		</div>
	</div>
</div>

<!-- Add Timesheet Modal -->
<?php 
	$cliendata = $CI->getAllClient();
?>
  <div class="modal fade" id="timesheetmodal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	  <form name="addtimesheet" id="addtimesheet" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Schedule</h4>
        </div>
        <div class="modal-body opacity-add">
			<div class="alert alert-success" style="display:none">
				<strong>Success!</strong> Indicates a successful or positive action.
			</div>
			<div class="alert alert-danger" style="display:none">
				Indicates a dangerous or potentially negative action.
			</div>
			<!--<div style="width:100%; text-align:center;"><img src="<?php // echo base_url();?>assets/images/ajax-loader.gif" /></div>-->
		<div class="md-form mb-5">
                <label>Selected Employee:</label>
				<span class="empname"></span>
          </div>
			<div class="form-group">
				<label data-error="wrong" data-success="right" for="form2">Booking Date</label>
				<input type="text" id="bookingtime" name="bookingtime" class="required form-control" readonly />
				<input type="hidden" id="emp_id" name="emp_id" class="form-control validate" readonly />
			</div>

			<div class="form-group">
				 <label  for="client">Client Name</label>
				 <input type="text" name="client" class="form-control required" id="client">
				 <input type="hidden" name="clientname" id="clientname">
				 <!--<select name="clientname" id="clientname" class="required form-control">
					<option value="">Select Client</option>
					<?php if(!empty($cliendata)){
						foreach($cliendata as $cval){
						?>
						<option value="<?php echo $cval['clientId']; ?>"><?php echo $cval['fname'].' '.$cval['lname']; ?></option>
					<?php
						}
					} ?>
				 </select>-->
			</div>
			<div class="form-group ptype_div" >
				<label for="ptype">Project Type</label>
				<select class="form-control" name="project_type_id" id="ptype">
					<option>Type of Project</option>
					<?php foreach($ptypedata as $ptypeVal){ ?>
						<option value="<?=$ptypeVal->id?>"><?=$ptypeVal->project_type_name?></option>
					<?php } ?>
				</select>
			</div>
			<div class="form-group site_div" >
				<label for="site">Site Name</label>
				<input type="text" name="site" class="form-control required" id="site" disabled>
				<input type="hidden" name="sitename" id="sitename">
			</div>
			<div class="form-group tasks_div" >
				<label class = 'loading_tasks' style="display:none;">Loading...</label>
			</div>
			<div class="form-group " >
				<input type="checkbox" name="all_day" id="all_day" >
				<label for="all_day">All Day Job</label>
			</div>
			<div class="form-group " >
				<label>Status</label>
				<select name="status" class="form-control">
					<option>Select Status</option>
					<?php
					foreach($scheduleStatus as $stat){ ?>
						<option value="<?=$stat->id?>"><?=$stat->status?></option>
					<?php }
					?>
				</select>
			</div>
			 <div class="form-group">
				<label for="form8">Instructions</label>
				<textarea type="text" id="instructions" name="instructions" class="required form-control" rows="4" ></textarea>
			 </div>
        </div>
        <div class="modal-footer d-flex justify-content-center">
            <button class="btn btn-success submiting"> Add </button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
		</form>
      </div>
      
    </div>
  </div>
  
  <!-- Edit Model --->
  <div class="modal fade" id="timesheetEditmodal" role="dialog">
	
  </div>
  
  <?php $this->load->view('includes/footer');?> 

<style>
 tr.project_type_row {
    background-color: #0856A2;
    color: #fff;
    font-size: 24px;
}
.glyphicon {
    margin-left: -12px;
    margin-right: 8px;
}
td.draggable_td.ui-sortable-handle {
    cursor: all-scroll;
}
table.table-bordered > tbody > tr > td{
    border:1px solid #000;
	border-top:1px solid #000 !important;
	padding: 7px;
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
td.ui-droppable.ui-droppable-hover {
    transform: scale(1.2);
    border: 2px dotted #353535 !important;
}
.hover_popup.ui-draggable.ui-draggable-handle {
    cursor: all-scroll;
}
.helper-job, .hover_popup.ui-draggable.ui-draggable-handle.ui-draggable-dragging {
	width: 150px;
    background: #f1efef;
    z-index: 1;
}
a#lockAll {
    padding: 5px 14px;
    background-color: #ffffff;
    border: 1px solid #ddd;
}
.ui-dialog .ui-dialog-content {
    display: none !important;
}

.ui-dialog-buttonpane.ui-widget-content.ui-helper-clearfix {
    margin: 0;
}
.ui-dialog .ui-dialog-buttonpane .ui-dialog-buttonset {
    float: unset;
    text-align: center;
}
.table_heading td {
    font-size: 13px;
}
.btn-group-sm>.btn, .btn-sm{
	font-size: 12px;
	padding: 3px 10px;
}
span.datacolp-span,.edit_schedule{
	font-size: 12px;
}
.hover_popup.ui-draggable.ui-draggable-handle {
    font-size: 12px;
    padding: 2px;
}
.fa-plus:before, .fa-minus:before {
    font-size: 10px;
}
td.empcolp {
    font-size: 12px;
    padding: 7px !important;
    font-weight: 500;
}
.edit_schedule img {
    width: 14px;
}
</style>
<script src="<?php echo base_url(); ?>assets/frontend/js/jquery.validate.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery-ui.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/custommodal.js" charset="utf-8"></script>

<script>
jQuery(document).ready(function($){
    $(".datacolp-span").click(function(){
		var id = $(this).parent().data('id');
		var pid = $(this).parent().data('pid');
        $(this).closest('tr').siblings(".top_tr_"+id+"_"+pid).addClass('in');
		$(".subtbale_"+id+"_"+pid).removeClass('in');
    });
	
	
	 $(".top_tr").click(function(){
		 var sid = $(this).data('id');
		 var pid = $(this).data('pid');
		 $(this).removeClass('in');
		 $(".subtbale_"+sid+"_"+pid).addClass('in');
    });
	$(".accordion-toggle").click(function(){
		var pid = $(this).parents('.table_heading ').data('pid');
		if($(this).hasClass('collapsed')){
			$(".accordion_"+pid).removeClass('in');
		}else{
			$(".accordion_"+pid+".upper_tr").addClass('in');
			$(".accordion_"+pid+".upper_tr_0").removeClass('in');
			$(".accordion_"+pid+".lower_trs_0").addClass('in');
		}
	})
	$("#lockAll").click(function(){
		$(".panel-body").css('opacity','0.5');
		var todayDate = '<?=$todaydate ?>';
		$.ajax({
			type: "POST",
			url: baseURL + "Schedules/ajax_lockAllSchedule",
			data: {todaydate:todayDate},
			success: function(response){
				var responseA = JSON.parse(response);
				if(responseA.status=='success'){
					$(".panel-body").css('opacity','1');
					location.reload();
				}else{
					alert(responseA.msg);
				}
			}
		})
	})
	$(".add_row_e").click(function(e){
		e.preventDefault();
		var eid = $(this).parents('.datacolp').data('id');
		var pid = $(this).parents('.datacolp').data('pid');
		var row = $(this).data('row');
		var todayDate = '<?=$todaydate ?>';
		$(".subtbale_"+eid+"_"+pid).css('opacity','0.5');
		$.ajax({
			type: "POST",
			url: baseURL + "Schedules/ajax_addRowEmp",
			data: {eid:eid,pid:pid,row:row,todayDate:todayDate},
			success: function(response){
				location.reload();
			}
		})
	})
	$(".rmv_row_e").click(function(){
		var eid = $(this).parents('.datacolp').data('id');
		var pid = $(this).parents('.datacolp').data('pid');
		var row = $(this).data('row');
		$(".subtbale_"+eid+"_"+pid).css('opacity','0.5');
		$.ajax({
			type: "POST",
			url: baseURL + "Schedules/ajax_minusRowEmp",
			data: {eid:eid,pid:pid,row:row},
			success: function(response){
				location.reload();
			}
		})
	})
});
</script>
