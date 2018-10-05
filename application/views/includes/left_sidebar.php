<div class="col-md-3">
	<div class="sidebar content-box" style="display: block;">
	       
		<!--<ul class="nav">-->
		<?php
		$userLogin = $this->session->userdata ( 'logged_in' );
		if($userLogin['role_id'] == ROLE_ADMIN || $userLogin['role_id'] == ROLE_MANAGER){ ?>
		<div class="panel-group">
                <h4 class="panel-title">
                 <a href="<?php echo base_url() ?>employee_list"><i class="glyphicon glyphicon-user"></i>
                    Employee Management</a>
                </h4>
                <ul class="list-group">

					 <li class="">
						<a href="<?php echo base_url() ?>employee_list">Employee List </a>
					</li>
					<li class="">
					   <a href="<?php echo base_url() ?>addNewEmployee">Add New </a>
					</li>
				</ul>
			  </div>
			     <div class="panel-group">
                <h4 class="panel-title">
                <a href="<?php echo base_url() ?>Admin/roleList"><i class="glyphicon glyphicon-plus"></i>
                    Role List</a>
                </h4>
                <ul class="list-group">
					<li class="">
						<a href="<?php echo base_url() ?>Admin/roleList">All Role</a>
					 </li>
				</ul>
			  </div>
			  
			     <div class="panel-group">
                <h4 class="panel-title">
               <a href="<?php echo base_url() ?>UserGroups/grouplist"><i class="glyphicon glyphicon-list"></i>
                    Groups</a>
                </h4>
                <ul class="list-group">
					
					<li class="">
						<a href="<?php echo base_url() ?>UserGroups/grouplist">All Group</a>
					</li>
					<li class="">
						<a href="<?php echo base_url() ?>UserGroups/addGroup"><i class="glyphicon glyphicon-plus"></i>Add New Group</a>
					</li>
				</ul>
			  </div>
			  <div class="panel-group">
                <h4 class="panel-title">
               <a href="<?php echo base_url() ?>Client"><i class="glyphicon glyphicon-list"></i>
                    Clients</a>
                </h4>
                <ul class="list-group">
					
					<li class="">
						<a href="<?php echo base_url() ?>Client">Client List</a>
					</li>
					<li class="">
						<a href="<?php echo base_url() ?>Client/add">Add New </a>
					</li>
				</ul>
			  </div>
			   <div class="panel-group">
                <h4 class="panel-title">
               	<a href="<?php echo base_url() ?>Projects"><i class="glyphicon glyphicon-list"></i>
                    Project</a>
                </h4>
                <ul class="list-group">
					<li class="">
						<a href="<?php echo base_url() ?>Projects">All Projects</a>
					</li>
					<li class="">
						<a href="<?php echo base_url() ?>Projects/add">Add Project</a>
					</li>
				</ul>
			  </div>
			  	   <div class="panel-group">
                <h4 class="panel-title">
               	<a href="<?php echo base_url() ?>TimeSheet/listtimesheet"><i class="glyphicon glyphicon-list"></i>
                    Schedule</a>
                </h4>
                <ul class="list-group">
					<li class="">
					<a href="<?php echo base_url() ?>TimeSheet/listtimesheet">Schedule</a>
					</li>
					<li class="">
						<a href="#">Calendar View</a>
					</li>
				</ul>
			  </div>
			  <div class="panel-group">
                <h4 class="panel-title">
               	<a href="<?php echo base_url() ?>Announcement"><i class="glyphicon glyphicon-list"></i>
                    Announcement</a>
                </h4>
                <ul class="list-group">
					<li class="">
					<a href="<?php echo base_url() ?>Announcement">Announcement List</a>
					</li>
					<li class="">
						<a href="<?php echo base_url() ?>Announcement/add">Add New</a>
					</li>
				</ul>
			  </div>
		<?php }else{ ?>
			   <div class="panel-group">
                <h4 class="panel-title">
               <a href="<?php echo base_url() ?>Employee/dashboard"><i class="glyphicon glyphicon-home"></i> Dashboard</a>
                </h4>
			  </div>
			  <div class="panel-group">
                <h4 class="panel-title">
               	<a href="<?php echo base_url() ?>Employee/taskList"><i class="glyphicon glyphicon-plus"></i>Your Task </a>
                </h4>
                <ul class="list-group">
					<li class="">
					<a href="#">Task</a>
					</li>
				</ul>
			  </div>
			  <div class="panel-group">
                <h4 class="panel-title">
               <a href="<?php echo base_url() ?>Employee/grouplist"><i class="glyphicon glyphicon-plus"></i>Your Group </a>
                </h4>
                <ul class="list-group">
					<li class="">
					<a href="#">Group1</a>
					</li>
					<li class="">
					<a href="#">Group2</a>
					</li>
				</ul>
			  </div>
			   <div class="panel-group">
                <h4 class="panel-title">
              <a href="<?php echo base_url() ?>TimeSheet/listtimesheet"><i class="glyphicon glyphicon-list"></i>Your Timesheet</a>
                </h4>
                <ul class="list-group">
					<li class="">
					<a href="#">Timesheet</a>
					</li>
				</ul>
			  </div>
		<?php
		}
		?>
		
		<!--</ul>-->
	</div>
</div>