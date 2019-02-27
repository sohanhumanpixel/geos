<div class="col-md-2 c-col-2">
	<div class="sidebar content-box" style="display: block;">
	       
		<!--<ul class="nav">-->
		<?php
		$userLogin = $this->session->userdata ( 'logged_in' );
    
		if($userLogin['role_id'] == ROLE_ADMIN || $userLogin['role_id'] == ROLE_MANAGER){ ?>
		
		
		  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar c-side">
      <!-- Logo -->
    <a href="<?php echo base_url() ?>dashboard" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="<?php echo base_url();?>assets/images/lg.png" style="width:60px;"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="<?php echo base_url();?>assets/images/logo.png" style="width: 187px;"></span>
    </a>
      <!-- Sidebar user panel -->
     <a href="<?php echo base_url() ?>profile">  <div class="user-panel">
        <div class="pull-left image">
          <?php if($currentUser[0]->image!=""){ ?>
          <img src="<?php echo base_url();?>assets/images/profile/<?=$currentUser[0]->image?>" class="img-circle" alt="User Image">
        <?php }else{ ?>
           <img src="<?php echo base_url();?>assets/images/profile/default_profile.png" class="img-circle" alt="User Image">
        <?php } ?>
        </div>
        <div class="pull-left info">
          <p><?=$currentUser[0]->fname.' '.$currentUser[0]->lname?></p>
        </div>
      </div></a>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="<?php if($this->uri->segment(1)=="dashboard"){ echo 'active'; } ?>  ">
          <a href="<?php echo base_url() ?>dashboard">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
      <!--  <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Layout Options</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right">4</span>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
            <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
            <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
            <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
          </ul>
        </li>-->
        <li class="<?php if($this->uri->segment(1)=="employee_list" || $this->uri->segment(1)=="addNewEmployee" || $this->uri->segment(2)=="editemp" || $this->uri->segment(2)=="skills" || $this->uri->segment(2)=="leaves" ){ echo 'active'; } ?> treeview">
         <a href="<?php echo base_url() ?>employee_list">
            <i class="fa fa-users"></i> <span>
                    Employee Management</span>
			<span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
		     <ul class="treeview-menu">
			    <li class="<?php if($this->uri->segment(1)=="employee_list"){ echo 'active'; } ?>"><a href="<?php echo base_url() ?>employee_list"><i class="fa fa-circle-o"></i>Employee List </a></li>
			    <li class="<?php if($this->uri->segment(1)=="addNewEmployee"){ echo 'active'; } ?>"> <a href="<?php echo base_url() ?>addNewEmployee"><i class="fa fa-circle-o"></i>Add New </a></li>
          <li class="<?php if($this->uri->segment(2)=="skills"){ echo 'active'; } ?>"> <a href="<?php echo base_url() ?>Employee/skills"><i class="fa fa-circle-o"></i>Skills </a></li>
          <li class="<?php if($this->uri->segment(2)=="leaves"){ echo 'active'; } ?>"> <a href="<?php echo base_url() ?>Employee/leaves"><i class="fa fa-circle-o"></i>Leave </a></li>
          </ul>
        </li>
        <li class="<?php if($this->uri->segment(2)=="roleList"){ echo 'active'; } ?> treeview">
         <a href="<?php echo base_url() ?>Admin/roleList">
            <i class="fa fa-plus"></i>
            <span>Role List</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
           <li class="<?php if($this->uri->segment(2)=="roleList"){ echo 'active'; } ?>">
				<a href="<?php echo base_url() ?>Admin/roleList"><i class="fa fa-circle-o"></i>All Role</a></li>
          </ul>
        </li>
        <li class="<?php if($this->uri->segment(1)=="UserGroups"){ echo 'active'; } ?> treeview">
          <a href="<?php echo base_url() ?>UserGroups/grouplist">
            <i class="fa fa-list"></i>
            <span>Groups</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if($this->uri->segment(2)=="grouplist"){ echo 'active'; } ?>"><a href="<?php echo base_url() ?>UserGroups/grouplist"><i class="fa fa-circle-o"></i>All Group</a>
					</li>
			<li class="<?php if($this->uri->segment(2)=="addGroup"){ echo 'active'; } ?>"><a href="<?php echo base_url() ?>UserGroups/addGroup"><i class="fa fa-circle-o"></i>Add New Group</a>
			</li>
          </ul>
        </li>
        <li class="<?php if($this->uri->segment(1)=="Company"){ echo 'active'; } ?> treeview">
          <a href="<?php echo base_url() ?>Company">
            <i class="fa fa-briefcase"></i> <span>Companies</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if($this->uri->segment(1)=="Company" && $this->uri->segment(2)!="add"){ echo 'active'; } ?>"><a href="<?php echo base_url() ?>Company"><i class="fa fa-circle-o"></i>All Companies</a></li>
      <li class="<?php if($this->uri->segment(1)=="Company" && $this->uri->segment(2)=="add"){ echo 'active'; } ?>"><a href="<?php echo base_url() ?>Company/add"><i class="fa fa-circle-o"></i>Add New </a></li>
          </ul>
        </li>
        <li class="<?php if($this->uri->segment(1)=="Client"){ echo 'active'; } ?> treeview">
          <a href="<?php echo base_url() ?>Client">
            <i class="fa fa-user"></i> <span>Contacts</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if($this->uri->segment(1)=="Client" && $this->uri->segment(2)!="add"){ echo 'active'; } ?>"><a href="<?php echo base_url() ?>Client"><i class="fa fa-circle-o"></i>Contact List</a></li>
			<li class="<?php if($this->uri->segment(1)=="Client" && $this->uri->segment(2)=="add"){ echo 'active'; } ?>"><a href="<?php echo base_url() ?>Client/add"><i class="fa fa-circle-o"></i>Add New </a></li>
          </ul>
        </li>
        <li class="<?php if($this->uri->segment(1)=="Projects"){ echo 'active'; } ?> treeview">
          <a href="<?php echo base_url() ?>Projects">
            <i class="fa fa-table"></i> <span>Projects</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if($this->uri->segment(1)=="Projects" && $this->uri->segment(2)!="add" && $this->uri->segment(2)!="projectTypes" && $this->uri->segment(2)!="categories" && $this->uri->segment(2)!="states" && $this->uri->segment(2)!="jobBriefs"){ echo 'active'; } ?>"><a href="<?php echo base_url() ?>Projects"><i class="fa fa-circle-o"></i>All Projects</a></li>
			<li class="<?php if($this->uri->segment(1)=="Projects" && $this->uri->segment(2)=="add"){ echo 'active'; } ?>"><a href="<?php echo base_url() ?>Projects/add"><i class="fa fa-circle-o"></i>Add Project</a></li>
      <li class="<?php if($this->uri->segment(2)=="projectTypes"){ echo 'active'; } ?>"><a href="<?php echo base_url() ?>Projects/projectTypes"><i class="fa fa-circle-o"></i>Project Types</a></li>
      <li class="<?php if($this->uri->segment(2)=="categories"){ echo 'active'; } ?>"><a href="<?php echo base_url() ?>Projects/categories"><i class="fa fa-circle-o"></i>Categories</a></li>
      <li class="<?php if($this->uri->segment(2)=="states"){ echo 'active'; } ?>"><a href="<?php echo base_url() ?>Projects/states"><i class="fa fa-circle-o"></i>States</a></li>
      <li class="<?php if($this->uri->segment(2)=="jobBriefs"){ echo 'active'; } ?>"><a href="<?php echo base_url() ?>Projects/jobBriefs"><i class="fa fa-circle-o"></i>Job Briefs</a></li>
          </ul>
        </li>
        <li class="<?php if($this->uri->segment(1)=="TaskList"){ echo 'active'; } ?> treeview">
          <a href="<?php echo base_url() ?>TaskList">
            <i class="fa fa-tasks"></i> <span>TaskList</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if($this->uri->segment(1)=="TaskList" && $this->uri->segment(2)!="add"){ echo 'active'; } ?>"><a href="<?php echo base_url() ?>TaskList"><i class="fa fa-circle-o"></i>TaskLists</a></li>
            <li class="<?php if($this->uri->segment(1)=="TaskList" && $this->uri->segment(2)=="add"){ echo 'active'; } ?>"><a href="<?php echo base_url() ?>TaskList/add"><i class="fa fa-circle-o"></i>Add Tasks</a></li>
          </ul>
        </li>
        <li class="<?php if($this->uri->segment(1)=="booking"){ echo 'active'; } ?> treeview">
          <a href="<?php echo base_url() ?>booking">
            <i class="fa fa-th"></i> <span>Bookings</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if($this->uri->segment(1)=="booking" && $this->uri->segment(2)!="add"){ echo 'active'; } ?>"><a href="<?php echo base_url() ?>booking"><i class="fa fa-circle-o"></i>Bookings</a></li>
            <li class="<?php if($this->uri->segment(1)=="booking" && $this->uri->segment(2)=="add"){ echo 'active'; } ?>"><a href="<?php echo base_url() ?>booking/add"><i class="fa fa-circle-o"></i>Add New</a></li>
          </ul>
        </li>
        <li class="<?php if($this->uri->segment(1)=="Schedules"){ echo 'active'; } ?> treeview">
          <a href="<?php echo base_url() ?>Schedules/listtimesheet">
            <i class="fa fa-calendar"></i> <span>Schedule</span>
            <span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
		  <ul class="treeview-menu">
		  <li class="<?php if($this->uri->segment(2)=="listtimesheet"){ echo 'active'; } ?>">
			<a href="<?php echo base_url() ?>Schedules/listtimesheet"><i class="fa fa-circle-o"></i>Schedule</a></li>
			<li class=""><a href="#"><i class="fa fa-circle-o"></i>Calendar View</a></li>
		  </ul>
        </li>
        <li class="<?php if($this->uri->segment(1)=="Announcement"){ echo 'active'; } ?> treeview">
          <a href="<?php echo base_url() ?>Announcement">
            <i class="fa fa-volume-up"></i> <span>Announcement</span>
            <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
      <ul class="treeview-menu">
      <li class="<?php if($this->uri->segment(1)=="Announcement" && $this->uri->segment(2)!="add"){ echo 'active'; } ?>">
      <a href="<?php echo base_url() ?>Announcement"><i class="fa fa-circle-o"></i>Announcement</a></li>
      <li class="<?php if($this->uri->segment(1)=="Announcement" && $this->uri->segment(2)=="add"){ echo 'active'; } ?>"><a href="<?php echo base_url() ?>Announcement/add"><i class="fa fa-circle-o"></i>Add New</a></li>
      </ul>
        </li>
        <li class="<?php if($this->uri->segment(1)=="Documents"){ echo 'active'; } ?>treeview"><a href="<?php echo base_url() ?>Documents"><i class="fa fa-book"></i> <span>Documentation</span>
		 <span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
            </span>
		</a>
		<ul class="treeview-menu">
		 <li class="<?php if($this->uri->segment(1)=="Documents" && $this->uri->segment(2)!="add"){ echo 'active'; } ?>">
			<a href="<?php echo base_url() ?>Documents"><i class="fa fa-circle-o"></i>Document List</a></li>
			<li class="<?php if($this->uri->segment(1)=="Documents" && $this->uri->segment(2)=="add"){ echo 'active'; } ?>"><a href="<?php echo base_url() ?>Documents/add"><i class="fa fa-circle-o"></i>Add New</a></li>
		 </ul>
		</li>
		
		<li class="treeview"><a href="<?php echo base_url() ?>Timesheetentry"><i class="fa fa-clock-o"></i> <span>Timesheets</span>
		 <span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
            </span>
		</a>
		<ul class="treeview-menu">
		 <li class="">
			<a href="<?php echo base_url() ?>Timesheetentry/listtimesheet"><i class=" fa fa-clock-o"></i>Timesheets</a></li>
			<li class=""><a href="#"><i class="fa fa-clock-o"></i>Add Time Sheet</a></li>
		 </ul>
		</li>
		
		<li class="treeview">
			<div class="humanpixel_logo">	
			<a href="https://humanpixel.com.au" target="_blank"><img src="https://humanpixel.com.au/wp-content/uploads/2018/07/lovinglycraftedby-grey.png" width="150px"></a>
			</div>
		</li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
			  
		<?php }else{
    //echo "<pre>";print_r($currentUser);die; ?>
      <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <a href="<?php echo base_url() ?>profile">  <div class="user-panel">
        <div class="pull-left image">
          <?php if($currentUser[0]->image!=""){ ?>
          <img src="<?php echo base_url();?>assets/images/profile/<?=$currentUser[0]->image?>" class="img-circle" alt="User Image">
        <?php }else{ ?>
           <img src="<?php echo base_url();?>assets/images/profile/default_profile.png" class="img-circle" alt="User Image">
        <?php } ?>
        </div>
        <div class="pull-left info">
          <p><?=$currentUser[0]->fname.' '.$currentUser[0]->lname?></p>
        </div>
      </div></a>
      <ul class="sidebar-menu" data-widget="tree">
        <li class="<?php if($this->uri->segment(2)=="dashboard"){ echo 'active'; } ?>  ">
          <a href="<?php echo base_url() ?>Employee/dashboard">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="<?php if($this->uri->segment(2)=="projectList" || $this->uri->segment(2)=="projectView"){ echo 'active'; } ?>  ">
          <a href="<?php echo base_url() ?>Employee/projectList">
            <i class="fa fa-table"></i> <span>My Projects</span>
          </a>
        </li>
        <li class="<?php if($this->uri->segment(2)=="taskList" || $this->uri->segment(2)=="projectTasks"){ echo 'active'; } ?> treeview">
          <a href="<?php echo base_url() ?>Employee/taskList">
            <i class="fa fa-table"></i> <span>My Tasks</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if($this->uri->segment(2)=="taskList"){ echo 'active'; } ?>"><a href="<?php echo base_url() ?>Employee/taskList"><i class="fa fa-circle-o"></i>Tasks</a></li>
            <li class="<?php if($this->uri->segment(2)=="projectTasks"){ echo 'active'; } ?>"><a href="<?php echo base_url() ?>Employee/projectTasks"><i class="fa fa-circle-o"></i>Project Tasks</a></li>
          </ul>
        </li>
        <li class="<?php if($this->uri->segment(1)=="Leave"){ echo 'active'; } ?> treeview">
          <a href="<?php echo base_url() ?>Leave/leavelist">
            <i class="fa fa-table"></i> <span>My Leave</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if($this->uri->segment(2)=="leavelist"){ echo 'active'; } ?>"><a href="<?php echo base_url() ?>Leave/leavelist"><i class="fa fa-circle-o"></i>Leave List</a></li>
            <li class="<?php if($this->uri->segment(2)=="leavecomingup"){ echo 'active'; } ?>"><a href="<?php echo base_url() ?>Leave/leavecomingup"><i class="fa fa-circle-o"></i>Upcoming</a></li>
          </ul>
        </li>
			  <!--
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
			  </div>-->
        <li class="<?php if($this->uri->segment(1)=="TimeSheet"){ echo 'active'; } ?> treeview">
          <a href="<?php echo base_url() ?>TimeSheet/listtimesheet">
            <i class="fa fa-table"></i> <span>My Timesheets</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class=""><a href="<?php echo base_url() ?>TimeSheet/listtimesheet"><i class="fa fa-circle-o"></i>Timesheet</a></li>
          </ul>
        </li>		
	    	
      </ul>
    </section>
  </aside>
		<?php
		}
		?>
		
		<!--</ul>-->
	</div>
</div>
<script type="text/javascript">
    $(document).ready( function() {
      console.log('height');
      var height = $('.padding-left-right').height();
      console.log(height);
        $('.main-sidebar .sidebar.c-side').css('height',height);
    });
</script>