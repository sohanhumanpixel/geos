<div class="page-content">
	<div class="row">
		<?php $this->load->view('includes/left_sidebar');?> 
		<div class="col-md-10 padding-left-right">
			<div class="content-box-large">
				<div class="panel-heading">
					<div class="panel-title">
						<h3><?=$title?></h3>
					</div>
					<div class="panel-options">
						
					  <a href="<?php echo base_url(); ?>Employee/projectTasks" ><button class="btn btn-success">Go Back</button></a>
					</div>
				</div>
				<?php //echo "<pre>";print_r($subtaskDetail);echo "</pre>"; ?>
				
				<div class="panel-body">
					<h3>Task Detail</h3>
					<div class="panel panel-primary">
						<div class="panel-heading">
							<?php echo $taskDetail[0]->title; ?>
							<span class="pull-right">
								<?php //echo "<pre>";print_r($checkCompleteTask);echo "</pre>"; ?>
								<?php if($checkCompleteTask[0]->start_task==0 && $checkCompleteTask[0]->end_task==0){ ?>
								  		<a href="javaScript:void(0)"><button class="btn btn-success start-proj-task" data-id="<?=$checkCompleteTask[0]->id?>">Start Task</button></a>
									<?php }elseif($checkCompleteTask[0]->start_task==1 && $checkCompleteTask[0]->end_task==0){ ?>
										<a href="javaScript:void(0)"><button class="btn btn-info task-progress">Task in progress</button></a>
										<a href="javaScript:void(0)"><button class="btn btn-danger end-proj-task" data-id="<?=$checkCompleteTask[0]->id?>"  data-project="<?=$checkCompleteTask[0]->project_id?>" data-emp="<?=$checkCompleteTask[0]->employee_id?>" data-client="<?=$checkCompleteTask[0]->client_id?>" data-timesheet="<?=$checkCompleteTask[0]->timesheet_id?>" data-date="<?=$checkCompleteTask[0]->schedule_date?>">End Task</button></a>
									<?php }else{ ?>
										<a href="javaScript:void(0)"><button class="btn btn-info show-comments" data-id="<?=$checkCompleteTask[0]->id?>">Comments</button></a>
										<a href="javaScript:void(0)"><button class="btn btn-info show-photos" data-id="<?=$checkCompleteTask[0]->id?>">Photos</button></a>
										<a href="javaScript:void(0)"><button class="btn btn-success">Completed</button></a>
									<?php } ?>
							</span>
						</div>
						<div class="panel-body">
							<?php echo $taskDetail[0]->description; ?>
							<div class="comment-section" style="display: none;">
								<h4 class="comment_h">Comments</h4>
								<?php foreach($taskComments as $taskComment){ ?>
									<div class="comment-view col-md-12">
										<p><strong><?=$taskComment->fname.' '.$taskComment->lname?></strong><span class="pull-right"><i class="fa fa-clock-o"></i> <?=date('d-m-Y H:i',strtotime($taskComment->commented_at))?></span></p>
										<p><?=$taskComment->comment?> <span class="pull-right" data-id="<?=$taskComment->id?>"><i class="fa fa-trash"></i></span></p>
									</div>
								<?php } ?>
								<div class="comment-div col-md-12">
									<h4>Post Comment</h4>
									<form class="cmnt_form projT" method="post">
										<div class="form-group">
											<input type="hidden" name="timesheet_id" value="<?=$checkCompleteTask[0]->timesheet_id?>">
											<input type="hidden" name="empT_id" value="<?=$checkCompleteTask[0]->id?>">
											<input type="hidden" name="task_id" value="<?php echo $taskDetail[0]->id; ?>">
											<textarea name="content" class="form-control comment-input" placeholder="Write something here...."></textarea>
										</div>
										<div class="form-group">
											<input class="btn btn-primary pull-right tasks_comment" type="submit" name="submit_comment" value="Post Comment">
										</div>
									</form>
								</div>
							</div>
							<div class="photos-section" style="display: none;">
								<h4 class="photos_h">Photos</h4>
								<?php if(!empty($taskPhotos)){ ?>
									<div class="photo-view col-md-12">
									<?php foreach($taskPhotos as $taskPhoto){ ?>
										<img src="<?=base_url()?>assets/images/tasks/<?=$taskPhoto->photo?>" class="pic_t pic_t_<?=$taskPhoto->id?>" width="100">
										<img src="<?=base_url()?>assets/images/delete-309164_960_720.png" class="remove_pic" data-id="<?=$taskPhoto->id?>">
									<?php } ?>
									</div>
								<?php }else{ ?>
										<div class="photo-view un col-md-12">
											<img src="" class="pic_t" width="100" style="display: none;">
										</div>
									<?php } ?>
								<div class="photos-div">
									<h4>Upload Photo</h4>
									<form class="photos_form projT">
										<div class="form-group">
											<input type="hidden" name="timesheet_id" value="<?=$checkCompleteTask[0]->timesheet_id?>">
											<input type="hidden" name="empT_id" value="<?=$checkCompleteTask[0]->id?>">
											<input type="hidden" name="task_id" value="<?php echo $taskDetail[0]->id; ?>">
											<input type="file" name="photo" class="form-control">
											<p id="err" class="text-danger"></p>
										</div>
										<div class="form-group">
											<input class="btn btn-primary pull-right photos_submit" type="submit" name="photos_submit" value="Upload">
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Image Modal -->
<div id="photoTaskModal" class="modal modal-wide fade">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Task Photos</h4>
        </div>
         <div id="photoT"></div>
     </div>
    </div>
</div><!-- /.modal -->
<style type="text/css">
span.pull-right button {
    position: relative;
    bottom: 6px;
}
.comment-view.col-md-12 {
    background: #e3e8ec;
    border-radius: 10px;
    padding: 6px 20px;
    margin: 3px 0px;
}

.comment-view.col-md-12 p {
    margin: 0;
}
.fa-trash{
	color: #ff0000;
	cursor: pointer;
}
img.pic_t {
    width: 100px;
    height: 75px;
    margin: 0 5px;
    border: 1px solid #a29494;
    padding: 2px;
    cursor: pointer;
}
img.pic_t:hover {
    opacity: 0.5;
}
.photo-view.col-md-12 {
    padding: 10px;
    background: #eee;
    border-radius: 10px;
    margin-bottom: 10px;
}
.photo-view.un.col-md-12 {
    background: unset;
    padding: 0;
    margin: 0;
}
img.remove_pic {
    width: 14px;
    position: absolute;
    margin-left: -20px;
    cursor: pointer;
}
#photoT {
    padding: 5px;
}
</style>
<script src="<?php echo base_url(); ?>assets/frontend/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/frontend/js/taskView.js" type="text/javascript"></script>