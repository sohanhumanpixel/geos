<div class="page-content">
	<div class="row">
		<!--<?php //$this->load->view('includes/left_sidebar');?> -->
		<?php
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
				
				/*$daystd = '<td>'.$todayd.' '.$todaydate.'</td>';
				foreach($weekOfdays as $weekval){
					$dateDayExp = explode(':', $weekval);
					$daystdday .= '<td>'.$dateDayExp[0].'</td>';
					$daystdate.= '<td>'.$dateDayExp[1].'</td>';
				} */
				
		    ?>
		<div class="col-md-12">
				<div class="panel-heading">
					<div class="panel-title">
						<h4> SCHEDULE </h4>
					</div>
					<div class="panel-options">
						<ul class="pager">
							<li><a class="" href="<?php echo $prevanchor; ?>">Previous Date</a></li>
							<li><a class="" href="<?php echo $nextanchorval; ?>">Next Date</a></li>
						</ul>
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
							 <tr class="table_heading" height="24" style=''>
								  <td height="24"  width="94">&nbsp;</td>
								  <td class=""  style='width:30pt'>&nbsp;</td>
								  <td class=""  style='width:188pt'><?php echo $todayd; ?></td>
								  <td class="" style='width:209pt'><?php echo $weekOfdays[0]; ?></td>
								  <td class=""  style='width:188pt'><?php echo $weekOfdays[1]; ?></td>
								  <td class=""  style='width:188pt'><?php echo $weekOfdays[2]; ?></td>
								  <td class=""  style='width:188pt'><?php echo $weekOfdays[3]; ?></td>
								 </tr>
						 
								 <tr class="table_heading  border_bottom" height="24">
								  <td height="24" style='height:18.0pt'>&nbsp;</td>
								  <td>&nbsp;</td>
								  <td><?php echo $todaydate; ?></td>
								  <td><?php echo $weekOfdate[0]; ?></td>
								  <td><?php echo $weekOfdate[1]; ?></td>
								  <td><?php echo $weekOfdate[2]; ?></td>
								  <td><?php echo $weekOfdate[3]; ?></td>
								 </tr>
								 
								 <?php
								 $CI =& get_instance();
							foreach($ptypedata as $ptkey=>$ptypeval){
									$ptypeId = $ptypeval->id;
									$shhetData = $CI->getEmployee($ptypeId,$todaydate);
									//echo '<pre>';
									//print_r($shhetData);
									//echo '</pre>';
									$collapsedcls = 'collapsed';
									$accoinout = 'out';
									if($ptkey == 0 ){
										$collapsedcls = '';
										$accoinout = 'in';
									}
								 ?>
								 
								  <tr class="table_heading border_accordian" height="24">
									  <td height="24" colspan="7">
									  <div class="accordion-toggle <?php echo $collapsedcls;?>" data-toggle="collapse" data-target=".accordion_<?php echo $ptypeId; ?>"><?php echo $ptypeval->project_type_name; ?></div>
									  </td>
								  </tr>
								<?php
								foreach($shhetData as $sheetval){
									$userData = $sheetval['userData'];
									$sheetData = $sheetval['userTimeSheetData'];
									
									//print_r($sheetData);
									
									$fullname = $userData['fname'].' '.$userData['lname'];
									if(!empty($sheetData)){
										
										$td1_1100 = '<td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$todaydate.'" data-empname="'.$fullname.'">Add</button></td>';
										
										$td2_1100 = '<td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[0].'" data-empname="'.$fullname.'">Add</button></td>';
										
										$td3_1100 = '<td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[1].'" data-empname="'.$fullname.'">Add</button></td>';
										
										$td4_1100 = '<td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[2].'" data-empname="'.$fullname.'">Add</button></td>';
										
										$td1_1400 = '<td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$todaydate.'" data-empname="'.$fullname.'">Add</button></td>';
										
										$td2_1400 = '<td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[0].'" data-empname="'.$fullname.'">Add</button></td>';
										
										$td3_1400 = '<td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[1].'" data-empname="'.$fullname.'">Add</button></td>';
										
										
										$td4_1400 = '<td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[2].'" data-empname="'.$fullname.'">Add</button></td>';
										
										$td5_1100 = '<td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[3].'" data-empname="'.$fullname.'">Add</button></td>';
										
										
										
										$TodayFilter = $CI->filtersamedate($sheetData,$todaydate);
											switch (count($TodayFilter)) {
				
											case 1:
											$hover_cont  = 'hover_container';
												$td1_700 = '<td><div class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$TodayFilter[0]['job_number'].'</h4><h4>Booking Time:'.$TodayFilter[0]['schedule_date'].'</h4><h4>Site:'.$TodayFilter[0]['project_name'].'</h4><h4>Client:'.$TodayFilter[0]['client_name'].'</h4><h4>Contact:'.$TodayFilter[0]['project_address'].'</h4><h4>Instructions:'.$TodayFilter[0]['instructions'].'</h4></div>">'.$TodayFilter[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$TodayFilter[0]['schedule_id'].'"><a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a></div></td>';
												break;
											case 2:
												$td1_700 = '<td><div class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$TodayFilter[0]['job_number'].'</h4><h4>Booking Time:'.$TodayFilter[0]['schedule_date'].'</h4><h4>Site:'.$TodayFilter[0]['project_name'].'</h4><h4>Client:'.$TodayFilter[0]['client_name'].'</h4><h4>Contact:'.$TodayFilter[0]['project_address'].'</h4><h4>Instructions:'.$TodayFilter[0]['instructions'].'</h4></div>">'.$TodayFilter[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$TodayFilter[0]['schedule_id'].'"><a href="javaScript:void(0)"><i class="glyphicon  glyphicon-pencil"></i></a></div></td>';
												$td1_1100 = '<td><div class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$TodayFilter[1]['job_number'].'</h4><h4>Booking Time:'.$TodayFilter[1]['schedule_date'].'</h4><h4>Site:'.$TodayFilter[1]['project_name'].'</h4><h4>Client:'.$TodayFilter[1]['client_name'].'</h4><h4>Contact:'.$TodayFilter[1]['project_address'].'</h4><h4>Instructions:'.$TodayFilter[1]['instructions'].'</h4></div>">'.$TodayFilter[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$TodayFilter[1]['schedule_id'].'"><a href="javaScript:void(0)"><i class="glyphicon  glyphicon-pencil"></i></a></div></td>';
												break;
											case 3:
											case 4:
											case 5:
											case 6:
											case 7:
												$td1_700 = '<td><div class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$TodayFilter[0]['job_number'].'</h4><h4>Booking Time:'.$TodayFilter[0]['schedule_date'].'</h4><h4>Site:'.$TodayFilter[0]['project_name'].'</h4><h4>Client:'.$TodayFilter[0]['client_name'].'</h4><h4>Contact:'.$TodayFilter[0]['project_address'].'</h4><h4>Instructions:'.$TodayFilter[0]['instructions'].'</h4></div>">'.$TodayFilter[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$TodayFilter[0]['schedule_id'].'"><a href="javaScript:void(0)"><i class="glyphicon  glyphicon-pencil"></i></a></div></td>';
												$td1_1100 = '<td><div class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$TodayFilter[1]['job_number'].'</h4><h4>Booking Time:'.$TodayFilter[1]['schedule_date'].'</h4><h4>Site:'.$TodayFilter[1]['project_name'].'</h4><h4>Client:'.$TodayFilter[1]['client_name'].'</h4><h4>Contact:'.$TodayFilter[1]['project_address'].'</h4><h4>Instructions:'.$TodayFilter[1]['instructions'].'</h4></div>">'.$TodayFilter[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$TodayFilter[1]['schedule_id'].'"><a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a></div></td>';
												$td1_1400 = '<td><div class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$TodayFilter[2]['job_number'].'</h4><h4>Booking Time:'.$TodayFilter[2]['schedule_date'].'</h4><h4>Site:'.$TodayFilter[2]['project_name'].'</h4><h4>Client:'.$TodayFilter[2]['client_name'].'</h4><h4>Contact:'.$TodayFilter[2]['project_address'].'</h4><h4>Instructions:'.$TodayFilter[2]['instructions'].'</h4></div>">'.$TodayFilter[2]['instructions'].'</div><div class="edit_schedule" data-editid="'.$TodayFilter[2]['schedule_id'].'"><a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a></div></td>';
												break;
											default:
												$td1_700 = '<td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$todaydate.'" data-empname="'.$fullname.'">Add</button></td>';
												$td1_1100 = '<td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$todaydate.'" data-empname="'.$fullname.'">Add</button></td>';
												
											}
										
										$nextday1 = $CI->filtersamedate($sheetData,$weekOfdate[0]);
										
											switch (count($nextday1)) {
											case 1:
												$td2_700 = '<td><div class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday1[0]['job_number'].'</h4><h4>Booking Time:'.$nextday1[0]['schedule_date'].'</h4><h4>Site:'.$nextday1[0]['project_name'].'</h4><h4>Client:'.$nextday1[0]['client_name'].'</h4><h4>Contact:'.$nextday1[0]['project_address'].'</h4><h4>Instructions:'.$nextday1[0]['instructions'].'</h4></div>">'.$nextday1[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday1[0]['schedule_id'].'"><a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a></div></td>';
												break;
											case 2:
												$td2_700 = '<td><div class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday1[0]['job_number'].'</h4><h4>Booking Time:'.$nextday1[0]['schedule_date'].'</h4><h4>Site:'.$nextday1[0]['project_name'].'</h4><h4>Client:'.$nextday1[0]['client_name'].'</h4><h4>Contact:'.$nextday1[0]['project_address'].'</h4><h4>Instructions:'.$nextday1[0]['instructions'].'</h4></div>">'.$nextday1[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday1[0]['schedule_id'].'"><a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a></div></td>';
												$td2_1100 = '<td><div class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday1[1]['job_number'].'</h4><h4>Booking Time:'.$nextday1[1]['schedule_date'].'</h4><h4>Site:'.$nextday1[1]['project_name'].'</h4><h4>Client:'.$nextday1[1]['client_name'].'</h4><h4>Contact:'.$nextday1[1]['project_address'].'</h4><h4>Instructions:'.$nextday1[1]['instructions'].'</h4></div>">'.$nextday1[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday1[1]['schedule_id'].'"><a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a></div></td>';
												break;
											case 3:
											case 4:
											case 5:
											case 6:
											case 7:
												$td2_700 = '<td><div class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday1[0]['job_number'].'</h4><h4>Booking Time:'.$nextday1[0]['schedule_date'].'</h4><h4>Site:'.$nextday1[0]['project_name'].'</h4><h4>Client:'.$nextday1[0]['client_name'].'</h4><h4>Contact:'.$nextday1[0]['project_address'].'</h4><h4>Instructions:'.$nextday1[0]['instructions'].'</h4></div>">'.$nextday1[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday1[0]['schedule_id'].'"><a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a></div></td>';
												$td2_1100 = '<td><div class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday1[1]['job_number'].'</h4><h4>Booking Time:'.$nextday1[1]['schedule_date'].'</h4><h4>Site:'.$nextday1[1]['project_name'].'</h4><h4>Client:'.$nextday1[1]['client_name'].'</h4><h4>Contact:'.$nextday1[1]['project_address'].'</h4><h4>Instructions:'.$nextday1[1]['instructions'].'</h4></div>">'.$nextday1[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday1[1]['schedule_id'].'"><a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a></div></td>';
												$td2_1400 = '<td><div class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday1[2]['job_number'].'</h4><h4>Booking Time:'.$nextday1[2]['schedule_date'].'</h4><h4>Site:'.$nextday1[2]['project_name'].'</h4><h4>Client:'.$nextday1[2]['client_name'].'</h4><h4>Contact:'.$nextday1[2]['project_address'].'</h4><h4>Instructions:'.$nextday1[2]['instructions'].'</h4></div>">'.$nextday1[2]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday1[2]['schedule_id'].'"><a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a></div></td>';
												break;
											default:
												$td2_700 = '<td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[0].'" data-empname="'.$fullname.'">Add</button></td>';
											}
										
										
										
										$nextday2 = $CI->filtersamedate($sheetData,$weekOfdate[1]);
										
										switch (count($nextday2)) {
											case 1:
												$td3_700 = '<td><div class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday2[0]['job_number'].'</h4><h4>Booking Time:'.$nextday2[0]['schedule_date'].'</h4><h4>Site:'.$nextday2[0]['project_name'].'</h4><h4>Client:'.$nextday2[0]['client_name'].'</h4><h4>Contact:'.$nextday2[0]['project_address'].'</h4><h4>Instructions:'.$nextday2[0]['instructions'].'</h4></div>">'.$nextday2[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday2[0]['schedule_id'].'"><a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a></div></td>';
												break;
											case 2:
												$td3_700 = '<td><div class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday2[0]['job_number'].'</h4><h4>Booking Time:'.$nextday2[0]['schedule_date'].'</h4><h4>Site:'.$nextday2[0]['project_name'].'</h4><h4>Client:'.$nextday2[0]['client_name'].'</h4><h4>Contact:'.$nextday2[0]['project_address'].'</h4><h4>Instructions:'.$nextday2[0]['instructions'].'</h4></div>">'.$nextday2[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday2[0]['schedule_id'].'"><a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a></div></td>';
												$td3_1100 = '<td><div class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday2[1]['job_number'].'</h4><h4>Booking Time:'.$nextday2[1]['schedule_date'].'</h4><h4>Site:'.$nextday2[1]['project_name'].'</h4><h4>Client:'.$nextday2[1]['client_name'].'</h4><h4>Contact:'.$nextday2[1]['project_address'].'</h4><h4>Instructions:'.$nextday2[1]['instructions'].'</h4></div>">'.$nextday2[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday2[1]['schedule_id'].'"><a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a></div></td>';
												break;
											case 3:
											case 4:
											case 5:
											case 6:
											case 7:
												$td3_700 = '<td><div class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday2[0]['job_number'].'</h4><h4>Booking Time:'.$nextday2[0]['schedule_date'].'</h4><h4>Site:'.$nextday2[0]['project_name'].'</h4><h4>Client:'.$nextday2[0]['client_name'].'</h4><h4>Contact:'.$nextday2[0]['project_address'].'</h4><h4>Instructions:'.$nextday2[0]['instructions'].'</h4></div>">'.$nextday2[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday2[0]['schedule_id'].'"><a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a></div></td>';
												$td3_1100 = '<td><div class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday2[1]['job_number'].'</h4><h4>Booking Time:'.$nextday2[1]['schedule_date'].'</h4><h4>Site:'.$nextday2[1]['project_name'].'</h4><h4>Client:'.$nextday2[1]['client_name'].'</h4><h4>Contact:'.$nextday2[1]['project_address'].'</h4><h4>Instructions:'.$nextday2[1]['instructions'].'</h4></div>">'.$nextday2[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday2[1]['schedule_id'].'"><a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a></div></td>';
												$td3_1400 = '<td><div class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday2[2]['job_number'].'</h4><h4>Booking Time:'.$nextday2[2]['schedule_date'].'</h4><h4>Site:'.$nextday2[2]['project_name'].'</h4><h4>Client:'.$nextday2[2]['client_name'].'</h4><h4>Contact:'.$nextday2[2]['project_address'].'</h4><h4>Instructions:'.$nextday2[2]['instructions'].'</h4></div>">'.$nextday2[2]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday2[2]['schedule_id'].'"><a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a></div></td>';
												break;
											default:
												$td3_700 = '<td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[1].'" data-empname="'.$fullname.'">Add</button></td>';
												
											}
										
										
										
										$nextday3 = $CI->filtersamedate($sheetData,$weekOfdate[2]);
										
										switch (count($nextday3)) {
											case 1:
												$td4_700 = '<td><div class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday3[0]['job_number'].'</h4><h4>Booking Time:'.$nextday3[0]['schedule_date'].'</h4><h4>Site:'.$nextday3[0]['project_name'].'</h4><h4>Client:'.$nextday3[0]['client_name'].'</h4><h4>Contact:'.$nextday3[0]['project_address'].'</h4><h4>Instructions:'.$nextday3[0]['instructions'].'</h4></div>">'.$nextday3[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday3[0]['schedule_id'].'"><a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a></div></td>';
												break;
											case 2:
												$td4_700 = '<td><div class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday3[0]['job_number'].'</h4><h4>Booking Time:'.$nextday3[0]['schedule_date'].'</h4><h4>Site:'.$nextday3[0]['project_name'].'</h4><h4>Client:'.$nextday3[0]['client_name'].'</h4><h4>Contact:'.$nextday3[0]['project_address'].'</h4><h4>Instructions:'.$nextday3[0]['instructions'].'</h4></div>">'.$nextday3[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday3[0]['schedule_id'].'"><a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a></div></td>';
												$td4_1100 = '<td><div class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday3[1]['job_number'].'</h4><h4>Booking Time:'.$nextday3[1]['schedule_date'].'</h4><h4>Site:'.$nextday3[1]['project_name'].'</h4><h4>Client:'.$nextday3[1]['client_name'].'</h4><h4>Contact:'.$nextday3[1]['project_address'].'</h4><h4>Instructions:'.$nextday3[1]['instructions'].'</h4></div>">'.$nextday3[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday3[1]['schedule_id'].'"><a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a></div></td>';
												break;
											case 3:
											case 4:
											case 5:
											case 6:
											case 7:
												$td4_700 = '<td><div class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday3[0]['job_number'].'</h4><h4>Booking Time:'.$nextday3[0]['schedule_date'].'</h4><h4>Site:'.$nextday3[0]['project_name'].'</h4><h4>Client:'.$nextday3[0]['client_name'].'</h4><h4>Contact:'.$nextday3[0]['project_address'].'</h4><h4>Instructions:'.$nextday3[0]['instructions'].'</h4></div>">'.$nextday3[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday3[0]['schedule_id'].'"><a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a></div></td>';
												$td4_1100 = '<td><div class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday3[1]['job_number'].'</h4><h4>Booking Time:'.$nextday3[0]['schedule_date'].'</h4><h4>Site:'.$nextday3[1]['project_name'].'</h4><h4>Client:'.$nextday3[1]['client_name'].'</h4><h4>Contact:'.$nextday3[1]['project_address'].'</h4><h4>Instructions:'.$nextday3[1]['instructions'].'</h4></div>">'.$nextday3[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday3[1]['schedule_id'].'"><a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a></div></td>';
												$td4_1400 = '<td><div class="hover_popup" data-toggle="popover" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday3[2]['job_number'].'</h4><h4>Booking Time:'.$nextday3[2]['schedule_date'].'</h4><h4>Site:'.$nextday3[2]['project_name'].'</h4><h4>Client:'.$nextday3[2]['client_name'].'</h4><h4>Contact:'.$nextday3[2]['project_address'].'</h4><h4>Instructions:'.$nextday3[2]['instructions'].'</h4></div>">'.$nextday3[2]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday3[2]['schedule_id'].'"><a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a></div></td>';
												break;
											default:
												$td4_700 = '<td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[2].'" data-empname="'.$fullname.'">Add</button></td>';
												
											}
										
										
										
										$nextday4 = $CI->filtersamedate($sheetData,$weekOfdate[3]);
										
										switch (count($nextday4)) {
											case 1:
												$td5_700 = '<td><div class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday4[0]['job_number'].'</h4><h4>Booking Time:'.$nextday4[0]['schedule_date'].'</h4><h4>Site:'.$nextday4[0]['project_name'].'</h4><h4>Client:'.$nextday4[0]['client_name'].'</h4><h4>Contact:'.$nextday4[0]['project_address'].'</h4><h4>Instructions:'.$nextday4[0]['instructions'].'</h4></div>">'.$nextday4[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday4[0]['schedule_id'].'"><a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a></div></td>';
												break;
											case 2:
												$td5_700 = '<td><div class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday4[0]['job_number'].'</h4><h4>Booking Time:'.$nextday4[0]['schedule_date'].'</h4><h4>Site:'.$nextday4[0]['project_name'].'</h4><h4>Client:'.$nextday4[0]['client_name'].'</h4><h4>Contact:'.$nextday4[0]['project_address'].'</h4><h4>Instructions:'.$nextday4[0]['instructions'].'</h4></div>">'.$nextday4[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday4[0]['schedule_id'].'"><a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a></div></td>';
												$td5_1100 = '<td><div class="hover_popup" data-toggle="popover" data-placement="left" data-trigger="hover" data-content="<div ><h4>Job Number:'.$nextday4[1]['job_number'].'</h4><h4>Booking Time:'.$nextday4[1]['schedule_date'].'</h4><h4>Site:'.$nextday4[1]['project_name'].'</h4><h4>Client:'.$nextday4[1]['client_name'].'</h4><h4>Contact:'.$nextday4[1]['project_address'].'</h4><h4>Instructions:'.$nextday4[1]['instructions'].'</h4></div>">'.$nextday4[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday4[1]['schedule_id'].'"><a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a></div></td>';
												break;
											case 3:
											case 4:
											case 5:
											case 6:
											case 7:
												$td5_700 = '<td><div class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday4[0]['job_number'].'</h4><h4>Booking Time:'.$nextday4[0]['schedule_date'].'</h4><h4>Site:'.$nextday4[0]['project_name'].'</h4><h4>Client:'.$nextday4[0]['client_name'].'</h4><h4>Contact:'.$nextday4[0]['project_address'].'</h4><h4>Instructions:'.$nextday4[0]['instructions'].'</h4></div>">'.$nextday4[0]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday4[0]['schedule_id'].'"><a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a></div></td>';
												$td5_1100 = '<td><div class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday4[1]['job_number'].'</h4><h4>Booking Time:'.$nextday4[1]['schedule_date'].'</h4><h4>Site:'.$nextday4[1]['project_name'].'</h4><h4>Client:'.$nextday4[1]['client_name'].'</h4><h4>Contact:'.$nextday4[1]['project_address'].'</h4><h4>Instructions:'.$nextday4[1]['instructions'].'</h4></div>">'.$nextday4[1]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday4[1]['schedule_id'].'"><a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a></div></td>';
												$td5_1400 = '<td><div class="hover_popup" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<div ><h4>Job Number:'.$nextday4[2]['job_number'].'</h4><h4>Booking Time:'.$nextday4[2]['schedule_date'].'</h4><h4>Site:'.$nextday4[2]['project_name'].'</h4><h4>Client:'.$nextday4[2]['client_name'].'</h4><h4>Contact:'.$nextday4[2]['project_address'].'</h4><h4>Instructions:'.$nextday4[2]['instructions'].'</h4></div>">'.$nextday4[2]['instructions'].'</div><div class="edit_schedule" data-editid="'.$nextday4[2]['schedule_id'].'"><a href="javaScript:void(0);"><i class="glyphicon  glyphicon-pencil"></i></a></div></td>';
												break;
											default:
												$td5_700 = '<td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[3].'" data-empname="'.$fullname.'">Add</button></td>';
												
												$td5_1400 = '<td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[3].'" data-empname="'.$fullname.'">Add</button></td>';
											}
										
										
										
										
										//$nextday5 = $CI->filtersamedate($sheetData,$weekOfdate[4]);
										//all next days data with filter
										//After all
										
										$td700 = $td1_700.''.$td2_700.''.$td3_700.''.$td4_700.''.$td5_700;
										$td1100 = $td1_1100.''.$td2_1100.''.$td3_1100.''.$td4_1100.''.$td5_1100;
										$td1400 = $td1_1400.''.$td2_1400.''.$td3_1400.''.$td4_1400.''.$td4_1400;
										
									}else{	
										$td700 = '<td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$todaydate.'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[0].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[1].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[2].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[3].'" data-empname="'.$fullname.'">Add</button></td>';
										$td1100 = '<td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$todaydate.'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[0].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[1].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[2].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[3].'" data-empname="'.$fullname.'">Add</button>';
										$td1400 = '<td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$todaydate.'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[0].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[1].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[2].'" data-empname="'.$fullname.'">Add</button></td><td style="border-top:none;width:209pt"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="'.$userData['userId'].'" data-ptypeid="'.$ptypeId.'" data-date="'.$weekOfdate[3].'" data-empname="'.$fullname.'">Add</button>';
									}
								?>
								 <tr height="20" class="collapse <?php echo $accoinout; ?> accordion_<?php echo $ptypeId; ?>">
								  <td rowspan="3" height="60"  width="94" style='height:45.0pt;
								  border-top:none;width:71pt'><?php echo $userData['fname'].'<br>'.$userData['lname']; ?></td>
								  <td style='border-top:none;border-left:none'>700</td>
								    <?php echo $td700; ?>
								 </tr>
								  <tr height="20" class="collapse <?php echo $accoinout; ?> accordion_<?php echo $ptypeId; ?>">
								  <td height="20" style='height:15.0pt;border-top:none;
								  border-left:none'>1100</td>
								 <?php echo $td1100; ?>
								 </tr>
								 <tr height="20" class="collapse <?php echo $accoinout; ?> accordion_<?php echo $ptypeId; ?>">
									  <td height="20"  style='height:15.0pt;border-top:none;
									  border-left:none'>1400</td>
									   <?php echo $td1400; ?>
									 </tr>
									 
							
								<?php } ?>
							<?php } ?>
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
				<input type="hidden" id="project_type_id" name="project_type_id" class="form-control validate" readonly />
			</div>
			<div class="form-group">
				 <label  for="clientname">Client Name</label>
				 <select name="clientname" id="clientname" class="required form-control">
					<option value="">Select Client</option>
					<?php if(!empty($cliendata)){
						foreach($cliendata as $cval){
						?>
						<option value="<?php echo $cval['clientId']; ?>"><?php echo $cval['fname'].' '.$cval['lname']; ?></option>
					<?php
						}
					} ?>
				 </select>
			</div>
			<div class="form-group site_div" >
				<label class = 'loading_site' style="display:none;">Loading...</label>
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
</style>
<script src="<?php echo base_url(); ?>assets/frontend/js/jquery.validate.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/custommodal.js" charset="utf-8"></script>