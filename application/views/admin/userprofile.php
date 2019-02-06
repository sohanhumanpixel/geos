<div class="page-content">
	<div class="row">
		<?php $this->load->view('includes/left_sidebar');?> 
		<div class="col-md-10 padding-left-right">
			<div class="content-box-large">
					<?php
					$userData = $profileData['userdata'];
					$currentUId = $userData[0]->userId;
					$Userskills = $profileData['Userskills'];
					$profileIamge = ($userData[0]->image !='') ? $userData[0]->image : 'default_profile.png';
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
				<!--New profile html-->
			<div class="emp-profile">
				
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-img">
                            <img src="<?php echo base_url(); ?>assets/images/profile/<?php echo $profileIamge; ?>" alt="" id="realPic" />
                        </div>
                        <div class="profile-work" id="changephotoEmp">
                            <a href="javaScript:void(0);">Change Photo</a></div>
                        <div class="profile-work">
                            <p>Address</p>
                            <p><?php echo $userData[0]->address; ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-head">
                                    <h5>
                                        <?php echo $userData[0]->fname.' '.$userData[0]->lname; ?>
                                    </h5>
                                    
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item active">
                                    <a class="nav-link" id="home-tab" data-toggle="tab" href="#abouttab" role="tab" aria-controls="home" aria-selected="true">About</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#skillstabdata" role="tab" aria-controls="profile" aria-selected="false">Skills</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane fade in active" id="abouttab" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Username</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $userData[0]->username; ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Name</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $userData[0]->fname.' '.$userData[0]->lname; ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Email</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $userData[0]->email; ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Phone</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $userData[0]->contact_phone; ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Home Address</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $userData[0]->address; ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Role</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $userData[0]->role_name; ?></p>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Construction card</label>
                                            </div>
                                            <div class="col-md-6">
                                            <?php if($userData[0]->construction_card!=''){ ?>
                                                <img class="constCardThumb" src="<?php echo base_url().'assets/images/usercard/'.$userData[0]->construction_card; ?>" width="100">
                                            <?php } ?>
                                            </div>
                                        </div>
                            </div>
                            <div class="tab-pane fade" id="skillstabdata" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="row">
                                    
                                    <?php 
                                    if(!empty($Userskills)){
                                        foreach($Userskills as $skillval){
                                        ?>
                                    <div class="col-md-4">
                                        <p><?php echo $skillval->skill_name; ?></p>
                                    </div>
                                    <?php
                                        }                                   
                                    }else{ ?>
                                    <div class="col-md-6"> No skills added </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
						<a href="<?php echo base_url().'Admin/editemp/'.base64_encode(convert_uuencode($currentUId));?>" class="btn btn-success">Edit Profile</a>
                    </div>
                </div> 
			</div>
				
				<!-- End New Profile -->
			</div>
		</div>
	</div>
</div>
  <div class="modal fade" id="editimgmodalemp" role="dialog">
		<div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
		<form id="empchangeimgform" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Change picture</h4>
        </div>
        <div class="modal-body">
          <div class="row">
			<div class="col-md-4"><img src="" id="oldimg" width="150"/></div>
			<div class="col-md-4">
				<div class="alert alert-success" style="display:none;" id="successmmm"></div>
				<input class="form-control" id="uploadImage" type="file" accept="image/*" name="profileimage" />
				<input type="hidden" name="uuid" value="<?php echo base64_encode(convert_uuencode($currentUId)); ?>" />
				<input type="hidden" name="oimage" value="<?php echo $userData[0]->image; ?>" />
			</div>
		  </div>
		  <div id="err"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		  <button type="submit" class="btn btn-success" id="empsaveImg">Save</button>
        </div>
		</form>
      </div>
    </div>
  </div>
<!-- End Image Modal -->
<div id="constCardModal" class="modal modal-wide fade">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Construction Card</h4>
        </div>
         <div id="constP"></div>
     </div>
    </div>
</div><!-- /.modal -->
<style>
.emp-profile{
    margin-top: 2%;
    margin-bottom: 3%;
    border-radius: 0.5rem;
}
.profile-img{
    text-align: center;
}
.profile-img img{
    width: 70%;
    height: 100%;
    border: 1px solid #e2e2e2;
    padding: 2px;
}
.profile-head h5{
    color: #333;
}
.profile-head h6{
    color: #0062cc;
}
.profile-edit-btn{
    border: none;
    border-radius: 1.5rem;
    width: 70%;
    padding: 2%;
    font-weight: 600;
    color: #6c757d;
    cursor: pointer;
}
.profile-head .nav-tabs{
    margin-bottom:5%;
}
.profile-head .nav-tabs .nav-link{
    font-weight:600;
    border: none;
}
.nav-tabs .active{
    border: none;
    border-bottom:2px solid #0062cc;
}

.profile-work{
    font-size: 12px;
    color: #818182;
    font-weight: 600;
    margin-top: 5%;
	margin-left: 16%;
}
.profile-tab label{
    font-weight: 600;
}
.profile-tab p{
    font-weight: 600;
    color: #0062cc;
}
.profile-tab .row {
    border-bottom: 1px solid #e2e2e2;
    box-shadow: 0px 1px 0px 0px #fff;
    padding: 5px;
}
</style>
<?php $this->load->view('includes/footer');?> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/common.js" charset="utf-8"></script>