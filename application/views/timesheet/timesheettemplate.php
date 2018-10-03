<div class="page-content">
	<div class="row">
		<?php $this->load->view('includes/left_sidebar');?> 
		<div class="col-md-9">
			<div class="content-box-large">
				<div class="panel-heading">
					<div class="panel-title">
						<h3> EMPLOYEE TIMESHEET </h3>
					</div>
				</div>
				<?php
				//echo '<pre>';
				//print_r($ptypedata);
				//echo '</pre>';
				$todaydate = date('Y-m-d'); //today date
				$todayd = date('D');
				$weekOfdays = array();
				$date = new DateTime($todaydate);
				for($i=1; $i <= 6; $i++){
					$date->modify('+1 day');
					$weekOfdays[] = $date->format('D : Y-m-d');
				}
				//print_r($weekOfdays);
				$daystd = '<td>'.$todayd.' '.$todaydate.'</td>';
				foreach($weekOfdays as $weekval){
					$dateDayExp = explode(':', $weekval);
					$daystd .= '<td>'.$dateDayExp[0].' '.$dateDayExp[1].'</td>';
				}
				?>
				<div class="panel-body">
					<div class="table-responsive">
						<table>
							<tr class="date-row">
								<td>
									Employee
								</td>
								<?php echo $daystd; ?>
							</tr>
							<?php
							$CI =& get_instance();
							
								
							foreach($ptypedata as $ptypeval){
									$ptypeId = $ptypeval->id;
									$shhetData = $CI->getEmployee($ptypeId);
									//echo '<pre>';
									//print_r($shhetData);
									
									
									//echo '</pre>';
							?>
							<tr class="project_type_row">
								<td>&nbsp;</td>
								<td class="employeedata" colspan="7"><?php echo $ptypeval->project_type_name; ?></td>
							</tr>
							<?php 
							foreach($shhetData as $sheetval){
								$userData = $sheetval['userData'];
								$sheetData = $sheetval['userTimeSheetData'];
								//i need to execute CSS
								?>
							<tr>
								<td><?php echo $userData['fname'].' '.$userData['lname']; ?></td>
								<td>
									<table>
										<tr>
										<td>date5</td>
										</tr>
									</table>
								</td>
								<td>
									<table>
										<tr>
										<td>date1</td>
										</tr>
									</table>
								</td>
								<td>
									<table>
										<tr>
										<td>date1</td>
										</tr>
									</table>
								</td>
								<td>
									<table>
										<tr>
										<td>date1</td>
										</tr>
									</table>
								</td>
								<td>
									<table>
										<tr>
										<td>date1</td>
										</tr>
									</table>
								</td>
								<td>
									<table>
										<tr>
										<td>date1</td>
										</tr>
									</table>
								</td>
								<td>
									<table>
										<tr>
										<td>date7</td>
										</tr>
									</table>
								</td>
							</tr>
							<?php
							}
							
								}
								?>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<style>
 tr.project_type_row {
    background-color: #0856A2;
    color: #fff;
    font-size: 24px;
}
</style>