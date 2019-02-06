<div class="page-content">
	<div class="row">
		<?php $this->load->view('includes/left_sidebar');?> 
		<div class="col-md-10 padding-left-right">
			<div class="content-box-large">
					<?php
					$currentUId = $_SESSION['logged_in']['user_id'];
					$userData = $profileData['userdata'];
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
                        <div class="profile-work" id="changephoto">
                            <a href="javaScript:void(0);">Change Photo</a></div>
                        <div class="profile-work">
                            <p>Address</p>
                            <p><?php echo $userData[0]->address; ?></p>
                        </div>
                    </div>
                    <div class="col-md-6 margin-lr">
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
                                <?php
                                if($isAdmin == TRUE){ ?>
                                    <li class="nav-item">
                                        <a class="nav-link" id="project-tab" data-toggle="tab" href="#exprojecttabdata" role="tab" aria-controls="project" aria-selected="false">Excluded Projects</a>
                                    </li>
                                <?php } ?>
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
                                    <!---<div class="col-md-6">
                                    </div>
                                    <div class="col-md-6">
                                        <a href="<?php echo base_url().'Admin/AddUserSkills/'.base64_encode(convert_uuencode($userData[0]->userId)); ?>" class="btn btn-success">Add /Edit Skills</a>
                                    </div>--->
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
                            <div class="tab-pane fade" id="exprojecttabdata" role="tabpanel" aria-labelledby="project-tab">
                                <div class="row">
                                   <a href="javaScript:void(0)" class="pull-right openExcModal">+ Add</a>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <label>Employee Name</label>
                                    </div>
                                    <div class="col-md-5">
                                        <label>Excluded Projects</label>
                                    </div>
                                </div>
                                <?php //echo "<pre>";print_r($excludedProjects);echo "</pre>";
                                foreach($excludedProjects as $k=>$v){
                                    $q = $this->db->query("SELECT project_name FROM projects WHERE id IN ($v->project_id)");
                                    $r = $q->result_array();
                                    $projectAr = array();
                                    foreach($r as $pV){
                                        array_push($projectAr, $pV['project_name']);
                                    }
                                    $projectNames = implode(',', $projectAr);
                                    $excludedProjects[$k]->project_names = $projectNames;
                                }
                                //echo "<pre>";print_r($excludedProjects);echo "</pre>";
                                foreach($excludedProjects as $excludedProject){ ?>
                                <div class="row">
                                    <div class="col-md-5">
                                        <p><?=$excludedProject->fname.' '.$excludedProject->lname?></p>
                                    </div>
                                    <div class="col-md-5">
                                        <p><?=$excludedProject->project_names?></p>
                                    </div>
                                    <div class="col-md-2 deleteExcProj" data-id="<?=$excludedProject->id?>">
                                        <i class="glyphicon glyphicon-pencil"></i>
                                        <i class="glyphicon glyphicon-trash"></i>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 padding-left">
						<a href="<?php echo base_url().'Admin/editemp/'.base64_encode(convert_uuencode($currentUId));?>" class="btn btn-success">Edit Profile</a>
                    </div>
                </div>    
			</div>
				
				<!-- End New Profile -->
			</div>
		</div>
	</div>
</div>
  <div class="modal fade" id="editimgmodal" role="dialog">
		<div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
		<form id="changeimgform" method="post" enctype="multipart/form-data">
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
			</div>
		  </div>
		  <div id="err"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		  <button type="submit" class="btn btn-success" id="saveImg">Save</button>
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
<!--Exclude projects modal-->
<div class="modal fade" id="exclmodal" role="dialog">
        <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <form id="exclProjForm" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Exclude Projects</h4>
        </div>
        <div class="modal-body opacity-add">
            <div class="alert alert-success" style="display:none">
                <strong>Success!</strong> Indicates a successful or positive action.
            </div>
            <div class="alert alert-danger" style="display:none">
                Indicates a dangerous or potentially negative action.
            </div>
            <div class="already_exists" style="display:none">
                
            </div>
          <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="employee_name">Select Employee</label>
                    <select name="employee_name" id="employee_name" class="form-control required">
                        <option value="">Select Employee</option>
                        <?php foreach($allEmployees as $employee){ ?>
                            <option value="<?=$employee->id?>"><?=$employee->fname.' '.$employee->lname?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="client_name">Client Name</label>
                    <input type="text" id="client_name" name="client_name" class="required form-control" />
                    <input type="hidden" id="client_id" name="client_id" class="required form-control" />
                </div>
                <div class="form-group">
                    <label for="project_name">Select Projects</label>
                    <select class="form-control required chosen-select" id="project_name" name="project_name[]" data-placeholder="Choose Projects..." multiple tabindex="2" disabled>

                    </select>
                </div>
            </div>
          </div>
          <div id="err"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success submiting" id="save">Save</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  <!--End Modal-->
  <!--Edit Exclude projects modal-->
<div class="modal fade" id="editexclmodal" role="dialog">
        <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <form id="editexclProjForm" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Exclude Projects</h4>
        </div>
        <div class="modal-body opacity-add">
            <div class="alert alert-success" style="display:none">
                <strong>Success!</strong> Indicates a successful or positive action.
            </div>
            <div class="alert alert-danger" style="display:none">
                Indicates a dangerous or potentially negative action.
            </div>
          <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="editemployee_name">Select Employee</label>
                    <select name="editemployee_name" id="editemployee_name" class="form-control required">
                        <option value="">Select Employee</option>
                        <?php foreach($allEmployees as $employee){ ?>
                            <option value="<?=$employee->id?>"><?=$employee->fname.' '.$employee->lname?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="editclient_name">Client Name</label>
                    <input type="text" id="editclient_name" name="editclient_name" class="required form-control" />
                    <input type="hidden" id="editclient_id" name="editclient_id" class="required form-control" />
                    <input type="hidden" id="edit_id" name="edit_id" class="required form-control" />
                </div>
                <div class="form-group">
                    <label for="editproject_name">Select Projects</label>
                    <select class="form-control required chosen-select" id="editproject_name" name="editproject_name[]" data-placeholder="Choose Projects..." multiple tabindex="2">

                    </select>
                </div>
            </div>
          </div>
          <div id="err"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success updating" id="save">Update</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  <!--End Modal-->
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
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/chosen/chosen.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/jquery-ui.css">
<script src="<?php echo base_url(); ?>assets/frontend/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/frontend/chosen/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery-ui.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/common.js" charset="utf-8"></script>