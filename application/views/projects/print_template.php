<div class="page-content">
	<div class="row">
	<?php $this->load->view('includes/left_sidebar');?>
	
	<div class="col-md-10 padding-left-right">
			<div class="content-box-large">
				<div class="panel-heading">
					<div class="panel-title">
						<h3><?=$title?></h3>
					</div>
				</div>
				<div class="panel-body">
					<div class='col-md-9'>
						<iframe src="https://docs.google.com/viewer?embedded=true&url=<?=base_url()?>assets/subby_templates/<?=$template?>" frameborder="no" style="width:100%;height:900px"></iframe>
					</div>
				</div>
			</div>
		</div>
	
	</div>
</div>
<?php $this->load->view('includes/footer');?>