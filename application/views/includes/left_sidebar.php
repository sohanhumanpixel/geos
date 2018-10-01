<div class="col-md-2">
	<div class="sidebar content-box" style="display: block;">
		<ul class="nav">
		<?php
		$userLogin = $this->session->userdata ( 'logged_in' );
		if($userLogin['role_id'] == ROLE_ADMIN || $userLogin['role_id'] == ROLE_MANAGER){ ?>
		 <li class="current">
			<a href="<?php echo base_url() ?>dashboard"><i class="glyphicon glyphicon-home"></i> Dashboard</a>
		 </li>
		 <li class="">
			<a href="<?php echo base_url() ?>employee_list"><i class="glyphicon glyphicon-user"></i>Employee List </a>
		  </li>
		 <li class="">
			<a href="<?php echo base_url() ?>Admin/roleList"><i class="glyphicon glyphicon-plus"></i>Roles List </a>
		 </li>
		<li class="">
			<a href="<?php echo base_url() ?>UserGroups/grouplist"><i class="glyphicon glyphicon-list"></i>Groups</a>
		</li>
		<li class="">
			<a href="<?php echo base_url() ?>Projects/ProjectList"><i class="glyphicon glyphicon-list"></i>Project List</a>
		</li>
		<li class="">
			<a href="<?php echo base_url() ?>TimeSheet/listtimesheet"><i class="glyphicon glyphicon-list"></i>Timesheet</a>
		</li>
		<?php }else{ ?>
		 <li class="current">
			<a href="<?php echo base_url() ?>Employee/dashboard"><i class="glyphicon glyphicon-home"></i> Dashboard</a>
		 </li>
		 <li class="">
			<a href="<?php echo base_url() ?>Employee/taskList"><i class="glyphicon glyphicon-plus"></i>Your Task </a>
		 </li>
		 <li class="">
			<a href="<?php echo base_url() ?>Employee/grouplist"><i class="glyphicon glyphicon-plus"></i>Your Group </a>
		 </li>
		 <li class="">
			<a href="<?php echo base_url() ?>TimeSheet/listtimesheet"><i class="glyphicon glyphicon-list"></i>Your Timesheet</a>
		</li>
		<?php
		}
		?>
		
		</ul>
	</div>
</div>