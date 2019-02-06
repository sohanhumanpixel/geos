<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/css/style.css" />
    <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/cssjs/font-awesome.min.css">
	<!--<script src="<?php //echo base_url();?>assets/frontend/js/bootstrap.min.js"></script>-->
  </head>
  <body>
		<div class="login_margin_top">
			<div class=" col-md-12 center_div">
				<div class="login-wrapper">
				<div class="box">
					<div class="c-logo">
						<a href="<?php echo base_url() ?>dashboard">
							<img src="<?php echo base_url();?>assets/images/logo.png">
						</a>
    				</div>
					<div class="content-wrap">
					<?php if(validation_errors()) { ?>
				  <div class="alert alert-danger login_alert">
					<?php echo validation_errors(); ?>
				  </div>
				<?php } ?>
				<?php if(isset($this->session->invalid)) { ?>
				  <div class="alert alert-danger login_alert">
					<?php echo $this->session->invalid; ?>
				  </div>
				<?php 
				 unset($_SESSION['invalid']); 
				 }
				 ?>
					<?php echo form_open('login'); ?>
							
							<div class="form-group">
								<div class="input-group c-group">
								<input  name="username" placeholder="Username" class="form-control c-input"  type="text">	
								<div class="input-group-addon">
							      <i class="fa fa-user"></i>
							    </div>
							</div>
							</div>
							<div class="form-group">
							  <div class="input-group c-group">
							  <input name="password" placeholder="Password" class="required form-control c-input"  type="password">
							  <div class="input-group-addon">
							     <i class="fa fa-lock"></i>
							  </div>
							  </div>
						  </div>
						<div class="form-group c-link">
							<a href="#">Forgot Password?</a>&nbsp;&nbsp;
						</div>
						<button class="btn btn-large c-button" type="submit">Sign in</button>
						<div class="form-group c-bottom-link">
							<p>No Account? <a href="#">Sign Up</a></p>
						</div>
					 <?php echo form_close(); ?>
					 
					</div>
				</div>
			</div>
		</div>
		</div>

