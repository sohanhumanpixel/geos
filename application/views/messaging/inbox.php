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
					  <a href="<?php echo base_url(); ?>Messaging/send_msg" class="btn btn-primary">Compose Message</a>
					</div>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
					<?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
						<table class="table user-list">
							<thead>
								<tr>
								<th><span>Subject</span></th>
								<th><span>Participants</span></th>
								<th>Conversation Started At</th>
								<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								//echo "<pre>";print_r($all_threads);echo "</pre>";
									if(!empty($all_threads))
				                    {
				                        foreach($all_threads as $thread)
				                        { ?>
				                        	<tr <?php if($thread['status']==0){ echo "style='background-color: #e8e8e8;'"; } ?>>
				                        		<td><a href="<?php echo base_url() ?>Messaging/conversations/<?=$thread['thread_id']?>"><?=$thread['subject']?></a></td>
				                        		<td>
				                        			<?php
				                        			$this->load->model('mahana_model');
				                        			$participants = $this->mahana_model->get_participant_list($thread['thread_id']);
				                        			$pAr = array();
				                        			foreach($participants as $participant){
				                        				array_push($pAr, $participant['user_name']);
				                        			}
				                        			echo$plist = implode(',', $pAr);
				                        			?>
				                        		</td>
				                        		<td><?=date('d-m-Y H:i',strtotime($thread['cdate']))?></td>
				                        		<td>
				                        			<a class="btn btn-sm btn-success" href="<?php echo base_url() ?>Messaging/conversations/<?=$thread['thread_id']?>" data-toggle="tooltip" title="View Message"><i class="glyphicon glyphicon-eye-open"></i></a>
				                        		</td>
				                        	</tr>
				                        <?php
				                        }
				                    }else{ ?>
				                    	<tr>
				                    		<td colspan="2">Inbox Empty</td>
				                    	</tr>
				                    <?php }
								?>
							</tbody>
						</table>
					</div>
					<div class="box-footer clearfix">
						<?php //echo $this->pagination->create_links(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('includes/footer');?> 