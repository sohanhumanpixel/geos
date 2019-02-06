<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $title; ?></title>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  
	 <link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/css/admindashboard.css" />
    <link href="<?php echo base_url('assets/vendor/summernote/summernote.css')?>" rel="stylesheet">
	<script src="<?php echo base_url();?>assets/frontend/js/jquery.min.js"></script>
	<script src="<?php echo base_url();?>assets/frontend/js/bootstrap.min.js"></script>
	<script type="text/javascript">
        var baseURL = "<?php echo base_url(); ?>";
    </script>
	  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/cssjs/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/cssjs/ionicons.min.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/cssjs/jquery-jvectormap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/cssjs/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/cssjs/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="<?php echo base_url();?>assets/frontend/cssjs/css.css">
<!-- FastClick -->
<script src="<?php echo base_url();?>assets/frontend/cssjs/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url();?>assets/frontend/cssjs/adminlte.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url();?>assets/frontend/cssjs/jquery.sparkline.min.js"></script>
<!-- jvectormap  -->
<script src="<?php echo base_url();?>assets/frontend/cssjs/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url();?>assets/frontend/cssjs/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll -->
<script src="<?php echo base_url();?>assets/frontend/cssjs/jquery.slimscroll.min.js"></script>
<!-- AdminLTE for demo purposes -->

  </head>


<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <a href="#" class="sidebar-toggle-cross" data-toggle="push-menu" role="button">
        <i class="fa fa-close"></i>
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">
                <?php
                $isLoggedIn = $this->session->userdata ( 'logged_in' );
                $vendorId = $isLoggedIn['user_id'];
                $this->db->select("t.id");
                $this->db->from('msg_threads as t');
                $this->db->join('msg_participants as p','t.id=p.thread_id');
                $this->db->join('users as u','u.id=p.user_id');
                $this->db->where('p.user_id',$vendorId);
                $this->db->where('p.status',0);
                $query = $this->db->get();
                echo $msgCount = count($query->result_array()); ?>
              </span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have <?=$msgCount?> unread messages</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <?php 
                $this->db->select("t.subject,p.*,CONCAT(u.fname,' ',u.lname) as user_name");
                $this->db->from('msg_threads as t');
                $this->db->join('msg_participants as p','t.id=p.thread_id');
                $this->db->join('users as u','u.id=p.user_id');
                $this->db->where('p.user_id',$vendorId);
                $this->db->where('p.status',0);
                $this->db->limit(3);
                $this->db->order_by('p.cdate','desc');
                $query = $this->db->get();
                $all_threads = $query->result_array();
                if(!empty($all_threads))
                {
                    foreach($all_threads as $thread)
                    { ?>
                      <li><!-- start message -->
                        <a href="<?php echo base_url() ?>Messaging/conversations/<?=$thread['thread_id']?>">
                          <div class="pull-left">
                           <!-- <img src="images/user2-160x160.jpg" class="img-circle" alt="User Image">-->
                          </div>
                        <!--  <h4>
                            Support Team
                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                          </h4>-->
                          <p><?=$thread['subject']?> </p>
                        </a>
                      </li>
                    <?php
                    }
                }else{ ?>
                  <li><!-- start message -->
                        <a href="#">
                          <div class="pull-left">
                           <!-- <img src="images/user2-160x160.jpg" class="img-circle" alt="User Image">-->
                          </div>
                        <!--  <h4>
                            Support Team
                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                          </h4>-->
                          <p>Yo have no unread messages </p>
                        </a>
                      </li>
                <?php } ?>
                </ul>
              </li>
              <li class="footer"><a href="<?php echo base_url() ?>Messaging">See All Messages</a></li>
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">3</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 3 notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> Schedule has been locked 
                    </a>
                  </li>
				   <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i>You have some new tasks
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-warning text-yellow"></i>  Don't forget to submit your timesheet
                    </a>
                  </li>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <?php 
			  if($currentUser[0]->image!=""){ ?>
              <img src="<?php echo base_url();?>assets/images/profile/<?php echo $currentUser[0]->image ?>" class="user-image" alt="User Image">
            <?php }else{ ?>
               <img src="<?php echo base_url();?>assets/images/profile/default_profile.png" class="user-image" alt="User Image">
           <?php } ?>
              <span class="hidden-xs"><?=$currentUser[0]->fname?> <i class="fa fa-caret-down"></i></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <?php if($currentUser[0]->image!=""){ ?>
                <img src="<?php echo base_url();?>assets/images/profile/<?php echo $currentUser[0]->image ?>" class="img-circle" alt="User Image">
              <?php }else{ ?>
               <img src="<?php echo base_url();?>assets/images/profile/default_profile.png" class="user-image" alt="User Image">
           <?php } ?>
                <p>
                 <?=$currentUser[0]->fname.' '.$currentUser[0]->lname?> - <?=$currentUser[0]->role_name?>
                </p>
              </li>
          
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?=base_url()?>Profile" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo base_url();?>logout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>

    </nav>
  </header>
