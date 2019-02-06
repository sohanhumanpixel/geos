<div class="page-content">
	<div class="row">
		<?php $this->load->view('includes/left_sidebar');?> 
		<div class="col-md-10 padding-left-right">
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
				/* echo '<pre>';
				print_r($weekOfdays); */
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
										<td><div class="already">date5</div></td>
										</tr>
									</table>
								</td>
								<td>
									<table>
										<tr>
										<td>
										<div class="add_timesheet_div"><button type="button" class="btn btn-info btn-sm openmodaltime" data-empid="<?php echo $userData['userId']; ?>" data-ptypeid="<?php echo $ptypeId; ?>" data-date="<?php echo $weekOfdays[0]; ?>" data-empname="<?php echo $userData['fname'].' '.$userData['lname']; ?>">Add</button></div></td>
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
<!-- Add Timesheet Modal -->
  <div class="modal fade" id="timesheetmodal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	  <form name="addtimesheet" id="addtimesheet" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Time Sheet</h4>
        </div>
        <div class="modal-body">
		
		<div class="md-form mb-5">
                <label>Selected Employee:</label>
				<span class="empname"></span>
          </div>
          <div class="md-form mb-5">
				 <label data-error="wrong" for="form3">Job Number ID</label>
                <input type="text" id="jobnumber" name="jobnumber" required class="form-control">
          </div>
			<div class="form-group">
				<label data-error="wrong" data-success="right" for="form2">Booking Date</label>
				<input type="text" id="bookingtime" name="bookingtime" class="form-control validate" readonly />
				<input type="hidden" id="emp_id" name="emp_id" class="form-control validate" readonly />
				<input type="hidden" id="project_type_id" name="project_type_id" class="form-control validate" readonly />
			</div>
			<div class="form-group">
				 <label data-error="wrong" for="form3">Client Name</label>
                <input type="text" id="clientname" name="clientname" required class="form-control">
          </div>
			<div class="form-group">
				 <label data-error="wrong" for="form3">Site</label>
                <input type="text" id="sitename" name="sitename" required class="form-control">
			</div>
			 <div class="form-group">
				<label data-error="wrong" data-success="right" for="form8">Instructions</label>
				<textarea type="text" id="form8" class="form-control" rows="4" required ></textarea>
			 </div>
        </div>
        <div class="modal-footer d-flex justify-content-center">
            <button class="btn btn-success"> Add </button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
		</form>
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
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/custommodal.js" charset="utf-8"></script>