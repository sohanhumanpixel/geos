<?php  
	$msg_id = $full_thread[0]['id'];
	$this->load->model('mahana_model');
	$participants = $this->mahana_model->get_participant_list($thread_id,$vendorId);
	$sender_id = $participants[0]['user_id'];

	if(!empty($_GET['file'])){
	    $fileName = basename($_GET['file']);
	    $filePath = FCPATH.'assets/messages/'.$fileName;
	    if(!empty($fileName) && file_exists($filePath)){
	        // Define headers
	        header("Cache-Control: public");
	        header("Content-Description: File Transfer");
	        header("Content-Disposition: attachment; filename=$fileName");
	        header("Content-Type: application/zip");
	        header("Content-Transfer-Encoding: binary");
	        
	        // Read the file
	        readfile($filePath);
	        exit;
	    }
	}
?>
<div class="page-content">
	<div class="row">
		<?php $this->load->view('includes/left_sidebar');?> 
		<div class="col-md-10 padding-left-right">
			<div class="content-box-large">
				<div class="col-sm-12">
				    <div class="progress" style="display: none;">
                        <div class="progress-bar progress-bar-success myprogress" role="progressbar" style="width:0%">0% </div>
                        <span class="cancelUpld pull-right">Cancel</span>
                    </div>
			    </div>
				<div class="panel-heading">
					<div class="panel-title">
						<h3><?php echo $participants[0]['user_name'] ?></h3>
					</div>
					<div class="panel-options">
					  <a href="<?php echo base_url(); ?>Messaging" class="btn btn-success">Go Back</a>
					</div>
				</div>
				<div class="panel-body">
					<?php //echo "<pre>";print_r($full_thread); echo "</pre>"; ?>
					<?php foreach($full_thread as $single_thread){ ?>
						<div class="coversat col-md-12">
							<div class="display-thread col-md-12">
								<?php if($single_thread['image']!=""){ ?>
									<a href="<?=base_url()?>Admin/viewprofile/<?=base64_encode(convert_uuencode($single_thread['user_id']))?>"><img class="img-circle img-responsive pull-left" src="<?=base_url()?>assets/images/profile/<?=$single_thread['image']?>" width=30></a>
								<?php }else{ ?>
									<a href="<?=base_url()?>Admin/viewprofile/<?=base64_encode(convert_uuencode($single_thread['user_id']))?>"><img class="img-circle img-responsive pull-left" src="<?=base_url()?>assets/images/profile/default_profile.png" width=30></a>
								<?php } ?>
								<a href="<?=base_url()?>Admin/viewprofile/<?=base64_encode(convert_uuencode($single_thread['user_id']))?>"><span class="user-thread"><?=$single_thread['user_name']?></span></a><span class="pull-right"><em style="color: #aaa;"><i class="fa fa-clock-o"></i> <?=date('d-m-Y H:i',strtotime($single_thread['cdate']))?></em></span>
							</div>
							<div class="message-thread col-md-12">
								<p>
									<?php if($single_thread['type']=='text'){
										echo $single_thread['body'];
									}else{
										$ext = pathinfo($single_thread['body'], PATHINFO_EXTENSION);
										if($ext=='jpg' || $ext=='jpeg' || $ext=='gif' || $ext=='png'){ ?>
											<img class="imConv" src="<?php echo base_url() ?>assets/messages/<?=$single_thread['body']?>" width="200">
										<?php }else{
											$body = preg_replace('/[0-9]+/', '', $single_thread['body']); ?>
											<a target="_blank" href="<?php echo base_url() ?>assets/messages/<?=$single_thread['body']?>"><?=$body?></a>
										<?php }
									} ?>
								</p>
								<?php if($single_thread['user_id']==$vendorId){ ?>
									<span class="trash-msg" data-msg="<?=$single_thread['id']?>" data-toggle="tooltip" title="Delete" style="display: none;"><i class="fa fa-trash"></i></span>
								<?php } ?>
								<?php if($single_thread['type']=='file'){ ?>
									<a href="?file=<?=$single_thread['body']?>"><span class="dwnld-msg" data-file="<?=$single_thread['body']?>" data-toggle="tooltip" title="Download" style="display: none;"><i class="fa fa-download"></i></span></a>
								<?php } ?>
							</div>
						</div>
					<?php } ?>
					<div class="reply-box col-md-12">
						<div class="input-group">
					      <span class="input-group-addon" for="file"><i class="glyphicon glyphicon-plus"></i></span>
					      <input type="text" name="reply_msg" id="reply_msg" class="form-control" placeholder="Reply to this conversation...">
					      <input type="hidden" name="sender_id" id="sender_id" value="<?=$vendorId?>">
						  <input type="hidden" name="recipient" id="recipient" value="<?=$sender_id?>">
						  <input type="hidden" name="msg_id" id="msg_id" value="<?=$msg_id?>">
					    </div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="uploadFileModal" role="dialog">
		<div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
		<form id="fileUpldMsgForm" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Upload File</h4>
        </div>
        <div class="modal-body">
          <div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<div class="alert alert-success" style="display:none;" id="successmmm"></div>
				<input class="form-control" id="uploadFile" type="file" name="fileMsg" />
				<input type="hidden" name="thread_id" value="<?=$thread_id?>">
				<input type="hidden" name="sender_id" value="<?=$vendorId?>">
				<input type="hidden" name="msg_id" id="msg_id" value="<?=$msg_id?>">
			</div>
		  </div>
		  <div id="err" class="text-center"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		  <button type="submit" class="btn btn-success" id="fileSaveMsg">Send</button>
        </div>
		</form>
      </div>
    </div>
  </div>
<div id="viewImConvModal" class="modal modal-wide fade">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Image File</h4>
        </div>
         <div id="convIm"></div>
     </div>
    </div>
</div><!-- /.modal -->
<style type="text/css">
span.user-thread {
    margin: 0 10px;
    vertical-align: -webkit-baseline-middle;
}

.message-thread.col-md-12 {
    margin: 0 0 0 40px;
    padding-right: 50px;
}

.message-thread p {
    margin: 0;
    float: left;
}
.message-thread span {
    float: right;
    cursor: pointer;
    margin: 0 8px;
}
.message-thread span.trash-msg{
    color: #ea2828;
}
.message-thread span.dwnld-msg {
    color: #1874d6;
}
.coversat.col-md-12 {
    margin: 4px 0;
    border-bottom: 1px solid #eee;
}
.reply-box.col-md-12 {
    position: fixed;
    bottom: 0;
    width: 78%;
    padding: 10px 0;
}
input#reply_msg {
    border: 2px solid rgba(145,145,147,.7);
    border-top-right-radius: 6px;
    border-bottom-right-radius: 6px;
    padding: 20px;
}
.coversat:hover {
    background: #eee;
}
.panel-body {
    max-height: 400px;
    overflow-y: scroll;
    overflow-x: hidden;
}
div#ascrail2000-hr {
    display: none !important;
}
span.input-group-addon {
    border: 2px solid rgba(145,145,147,.7);
    border-top-left-radius: 6px !important;
    border-bottom-left-radius: 6px !important;
    border-color: #b1b1b3 !important;
    color: #b1b1b3;
    cursor: pointer;
}
span.input-group-addon:hover {
    background: #00a65a;
    border-top: 2px solid #148250 !important;
    border-bottom: 2px solid #148250 !important;
    border-left: 2px solid #148250 !important;
}
span.input-group-addon:hover i {
    color: #fff;
}
div#err {
    color: #ff0000;
}
#convIm img {
    padding: 6px;
}
img.imConv:hover {
    opacity: 0.7;
    cursor: pointer;
}
img.imConv {
    border: 1px solid #b6b6b6;
    padding: 1px;
}
#uploadFileModal .modal-content {
    border-radius: .5rem;
    box-shadow: 0 20px 55px rgba(0,0,0,.35), 0 0 1px rgba(0,0,0,.15);
    max-height: 640px;
    max-width: calc(100% - 32px);
    transform: translateY(16.8%);
    transition: transform 168ms ease,opacity 168ms ease;
}
.progress {
    background-image: -webkit-linear-gradient(top,#ebebeb 0,#f5f5f5 100%);
    background-image: -o-linear-gradient(top,#ebebeb 0,#f5f5f5 100%);
    background-image: -webkit-gradient(linear,left top,left bottom,from(#ebebeb),to(#f5f5f5));
    background-image: linear-gradient(to bottom,#ebebeb 0,#f5f5f5 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffebebeb', endColorstr='#fff5f5f5', GradientType=0);
    background-repeat: repeat-x;
}
.progress-bar {
    float: left;
    width: 0;
    height: 100%;
    font-size: 12px;
    line-height: 20px;
    color: #fff;
    text-align: center;
    background-color: #337ab7;
    -webkit-box-shadow: inset 0 -1px 0 rgba(0,0,0,.15);
    box-shadow: inset 0 -1px 0 rgba(0,0,0,.15);
    -webkit-transition: width .6s ease;
    -o-transition: width .6s ease;
    transition: width .6s ease;
}
.progress-bar-success {
    background-color: #5cb85c;
}
.progress-bar {
    background-image: -webkit-linear-gradient(top,#337ab7 0,#286090 100%);
    background-image: -o-linear-gradient(top,#337ab7 0,#286090 100%);
    background-image: -webkit-gradient(linear,left top,left bottom,from(#337ab7),to(#286090));
    background-image: linear-gradient(to bottom,#337ab7 0,#286090 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff337ab7', endColorstr='#ff286090', GradientType=0);
    background-repeat: repeat-x;
}
.progress-bar-success {
    background-image: -webkit-linear-gradient(top,#5cb85c 0,#449d44 100%);
    background-image: -o-linear-gradient(top,#5cb85c 0,#449d44 100%);
    background-image: -webkit-gradient(linear,left top,left bottom,from(#5cb85c),to(#449d44));
    background-image: linear-gradient(to bottom,#5cb85c 0,#449d44 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff5cb85c', endColorstr='#ff449d44', GradientType=0);
    background-repeat: repeat-x;
}
.cancelUpld{
	cursor: pointer;
	position: absolute;
	right: 15px;
}
</style>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery.nicescroll.min.js" charset="utf-8"></script>
<script type="text/javascript">
$('#reply_msg').keydown(function (e){
	if($(this).val().length !=0){
	    if(e.keyCode == 13){
	        var sender_id = $("#sender_id").val();
	        var recipient = $("#recipient").val();
	        var msg_id = $("#msg_id").val();
	        var reply_msg = $("#reply_msg").val();
	        $.ajax({
	        	url: baseURL+"Messaging/ajax_replyMsg",
				type: 'POST',
				data: {'sender_id' : sender_id,'toid':recipient,'msg_id':msg_id,'reply_msg':reply_msg },
				success: function(response) {
					var responseA = JSON.parse(response);
					if(responseA.status=='success'){
						location.reload();
					}else{
						alert(responseA.msg);
					}
				}
	        })
	    }
	}
})
$(".coversat").mouseover(function(){
	$(this).find(".message-thread span").show();
})
$(".coversat").mouseout(function(){
	$(this).find(".message-thread span").hide();
})
$(".trash-msg").click(function(){
	var current_row = $(this).parents(".coversat");
	current_row.css('opacity','0.5');
	var msg_id = $(this).data('msg');
	$.ajax({
		url: baseURL+"Messaging/ajax_deleteMsg",
		type: 'POST',
		data: {'msg_id' : msg_id },
		success: function(response) {
			var responseA = JSON.parse(response);
			if(responseA.status=='success'){
				current_row.css('opacity','1');
				current_row.fadeTo("slow",0.7, function(){
		            $(this).remove();
		        })
			}else{
				current_row.css('opacity','1');
				alert(responseA.msg);
			}
		}
	})
})
$('.panel-body').niceScroll({
	cursorcolor: "#0f1a36",
});
$("span.input-group-addon").click(function(){
	$("#uploadFileModal").modal('show');
})
$("#fileUpldMsgForm").on('submit',(function(e) {
	e.preventDefault();
	//$(".modal-content").css('opacity','0.7');
	//$("#fileSaveMsg").text('Sending...');
	//$("#fileSaveMsg").prop( "disabled", true );
	if ($('#uploadFile').get(0).files.length === 0) {
		$("#err").html('Please Select File').fadeIn();
	}else{
		$("#uploadFileModal").modal('hide');
		$(".progress").show();
	  	var req = $.ajax({
			url: baseURL + "Messaging/ajax_uploadFileMsg",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        $('.myprogress').text(percentComplete + '%');
                        $('.myprogress').css('width', percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
			success: function(response) {
				$(".modal-content").css('opacity','1');
				$("#fileSaveMsg").text('Send');
				$("#fileSaveMsg").prop( "disabled", false );
				var responseA = JSON.parse(response);
				if(responseA.status=='success')
				{
				 location.reload();
				}
				else
				{
				 // invalid file format.
				 alert(responseA.message);
				}          
			}
		});

		$(".cancelUpld").click(function(){
			req.abort();
			$('.progress').fadeTo("slow",0.7, function(){
	            $(this).hide();
	        })
			$('.myprogress').text('0%');
			$('.myprogress').css('width', '0%');
		})
		return false;
	}
}));
$(".imConv").click(function(){
	var src = $(this).attr('src');
	$("#viewImConvModal").modal('show');
	$("#convIm").html('<img src="'+src+'" class="img-responsive">');
})
</script>