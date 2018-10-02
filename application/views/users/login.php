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
	<!--<script src="<?php //echo base_url();?>assets/frontend/js/bootstrap.min.js"></script>-->
  </head>
  <body>
  <nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <img src="<?php echo base_url();?>assets/images/logo.png" style="padding:2px; height:60px;" />
    </div>
  </div>
</nav>
	<div class="page-content container">
		<div class="row slideanim slide login_margin_top">
			<div class="col-lg-6 col-md-offset-6 center_div">
				<div class="login-wrapper">
				<div class="box">
					<div class="content-wrap">
					<h6>Intranet Login</h6>
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
							<p>
								No Account? <a href="register">Sign Up</a>
							</p>
							<div class="form-group">
								<input  name="username" placeholder="Username" class="form-control"  type="text">	
							</div>
							<div class="form-group">
							  <input name="password" placeholder="Password" class="required form-control"  type="password">
						  </div>
						<span class="help-block">
							<a href="forgot_password">Forgot Password?</a>&nbsp;&nbsp;
						</span>
						<button class="btn btn-large btn-primary" type="submit">Sign in</button>
					 <?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>
		</div>
</div>
