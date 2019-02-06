<div class="page-content">
	<div class="row">
		<?php $this->load->view('includes/left_sidebar');?>
		<div class="col-md-10 padding-left-right">
			<div class="content-box-large">
				<div class="panel-heading">
					<div class="upper_head col-md-12">
						<h4 class="col-md-9"><?php echo $clientInfo[0]->fname.' '.$clientInfo[0]->lname;?></h4>
						<div class="col-md-3">
						<a href="<?=base_url('Client')?>"><button class="btn btn-success pull-right">Back</button></a></div>
					</div>
					<div class="row">
						<ul class="nav nav-tabs">
							<li class="active"><a id="detail-tab" data-toggle="tab" href="#detailtab" role="tab" aria-controls="detail" aria-selected="true">Details</a></li>
						</ul>
					</div>
				</div>
				<div class="panel-body">
					<div class="contanior_details">
					<?php
                    if($this->session->flashdata('success'))
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php }else if($this->session->flashdata('error')){ ?>
					<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
				<?php } ?>
						<div class="tab-content client-tab" id="myTabContent">
                           <div class="tab-pane fade in active" id="detailtab" role="tabpanel" aria-labelledby="home-tab">
                           	<div class="row">
                           		<div class="col-md-5">
									<div class="header_billing col-md-12">
										<table style="width: 100%">
											<tr>
												<td colspan="2"><strong> Contact Details</strong></td>
											</tr>
											<tr>
												<td>Name</td>
												<td><?php echo $clientInfo[0]->fname.' '.$clientInfo[0]->lname;?></td>
											</tr>
											<tr>
												<td>Phone</td>
												<td><?=$clientInfo[0]->phone?></td>
											</tr>
											<tr>
												<td>Email</td>
												<td><a href="mailto:<?=$clientInfo[0]->email?>"><?=$clientInfo[0]->email?></a></td>
											</tr>
										</table>
									</div> 
								</div>
                           	</div>
                           </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('includes/footer');?>