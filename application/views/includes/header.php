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
  </head>
  <body>
  <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
	 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
	  <div class="logo">
    <h1><a href="<?php echo base_url() ?>dashboard"><img src="<?php echo base_url();?>assets/images/logo.png"></a></h1>
	   </div>
    </div>
	  <div class="collapse navbar-collapse" id="myNavbar">
	  <form class="navbar-form navbar-right" action="">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search" name="search">
        <div class="input-group-btn">
          <button class="btn btn-default" type="submit">
            <i class="glyphicon glyphicon-search"></i>
          </button>
        </div>
      </div>
    </form>
	<div class="container-fluid width100">
    <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Admin</a></li>
	    <li><a href="<?=base_url()?>Profile">My Profile</a></li>
		<li><a href="<?php echo base_url() ?>dashboard"><i class="glyphicon glyphicon-home"></i> My Dashboard</a></li> 
	    <li><a href="<?php echo base_url();?>logout">Logout</a></li>
		<li><a href="#">Feedback</a></li> 						
    </ul>
	</div>
  </div>
</div>
</nav>
