<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Neon Admin Panel" />
	<meta name="author" content="" />

	<link rel="icon" href="<?php echo base_url(); ?>assets/img/logo_small.png">

	<title>Canteen Management</title>			

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-icons/entypo/css/entypo.css">
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/neon-core.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/neon-theme.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/neon-forms.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css">

	<script src="<?php echo base_url(); ?>assets/js/jquery-1.11.3.min.js"></script>

	<!--[if lt IE 9]><script src="<?php echo base_url(); ?>assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
	
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->


</head>
<body class="page-body  page-fade gray" data-url="http://neon.dev">

<div class="page-container"> 
	<div class="main-content">
		<div class="row">
		 	<center>
		 		
		 		<?php
		 		//print_r($this->session->userdata('access_type'));
		 		$access_type = $this->session->userdata('access_type');
		 		if(count($access_type)>1){
		 			echo '<h4>GO TO</h4>';
			 		
			 		if(!empty($access_type)){
			 			foreach($access_type as $kAccess=>$vAccess){
			 				echo '<button class="goto btn btn-info text-uppercase" onclick="goto(\''.$vAccess.'\');">'.ucfirst(str_replace("_", " ", $vAccess)).'</button> &nbsp;';
			 			}
			 		}	
			 	} 
			 	echo '<button class="goto btn btn-info text-uppercase" onclick="goto(\'logout\');">Logout</button>'; ?>
		 		<!--<button class="goto btn btn-info text-uppercase" onclick="goto('canteen');">Canteen</button>
		 		<button class="goto btn btn-info text-uppercase" onclick="goto('locker');">Locker</button>
		 		<button class="goto btn btn-info text-uppercase" onclick="goto('theme_park');">Theme Park</button>-->
		 	</center>
			<div class="canteen-access col-sm-4 col-sm-offset-4" style="margin-top:150px; display: <?php echo (count($access_type)>1)?"none":""; ?>">
				<div class="panel panel-dark"  >
				    <!-- panel head -->
				    <div class="panel-heading">
				        <div class="panel-title">
				        	<?php 
				        	if($this->session->userdata('user_type') == STORE_MANAGER){ 
				        		echo ucfirst(STORE_MANAGER); 
				        	}
				        	else { 
				        		echo ucfirst(STALL_OPERATOR); 
				        	} ?> 

				        	Login</div>
				    </div>
				    <!-- panel body -->
				    <div class="panel-body">
		 				<form method="post" role="form" class=" " autocomplete="off">
						    <div class="form-group">
					        	<label for="field-1" class="control-label">Storedetails</label>
					        
					            <select name="store_code" required class="form-control" onchange="get_stall_details(this)">
					            	<option value="">Select</option>
					            	<?php foreach($get_store_details as $store){ ?>
					            	<option value="<?php echo $store['store_code']; ?>"><?php echo $store['store_name']; ?></option>
					            	<?php }?>
					            </select> 
							</div>
							
							<?php 
							if($this->session->userdata('user_type') == STALL_OPERATOR){  ?>
								<div class="form-group">
									<label for="field-1" class="control-label">Stalldetails</label>
								
									<select name="stall_code" required class="form-control stall_details" required>
										<option value="">Select</option>
										
									</select> 
								</div>
								<?php 
							}?>
						    
						    <span style="color:red;"><?php $err = isset($error) ? $error : ''; echo $err; ?></span>
						     
						    <div class="form-group">
						        <div class="col-sm-offset-3 col-sm-5">
						            <button type="submit" class="btn btn-success">Submit</button>
						        </div>
						    </div>
						</form>
		 		    </div>
				</div>
			</div>
		</div>
	</div> 
</div>

<script type="text/javascript">
	
	function get_stall_details(store_code){

		$('.stall_details').empty();

		$.ajax({
			type:'post',
			url:'inter_login/getStalldetails',
			data:{'store_code':store_code.value},
			success:function(data){
				//alert(data);
				var json = JSON.parse(data);

				$('.stall_details').append('<option value="">Select</option>');

				for(var i=0; i<json.length; i++){

					$('.stall_details').append('<option value="'+json[i].stall_code+'">'+json[i].stall_name+'</option>');
				}			
			}
		});
	}
	function goto(val){
		$(".canteen-access").slideUp("fast");
		if(val){			
			if(val=='canteen'){
				$(".canteen-access").slideDown("fast");
			}
			else if(val=='locker'){
				window.location = '<?php echo base_url(); ?>inter_login/set_locker?locker=1';
			}
			else if(val=='theme_park'){
				window.location = '<?php echo base_url(); ?>inter_login/set_theme_park?theme_park=1';
			}
			else if(val=='logout'){
				window.location = '<?php echo base_url(); ?>logout';
			}
		}
	}
</script>




<!-- Imported styles on this page -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jvectormap/jquery-jvectormap-1.2.2.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/rickshaw/rickshaw.min.css">

	<!-- Bottom scripts (common) -->
	<script src="<?php echo base_url(); ?>assets/js/gsap/TweenMax.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/joinable.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/resizeable.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/neon-api.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>


	<!-- Imported scripts on this page -->
	<script src="<?php echo base_url(); ?>assets/js/jvectormap/jquery-jvectormap-europe-merc-en.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.sparkline.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/rickshaw/vendor/d3.v3.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/rickshaw/rickshaw.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/raphael-min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/morris.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/toastr.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/fullcalendar/fullcalendar.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/neon-chat.js"></script>


	<!-- JavaScripts initializations and stuff -->
	<script src="<?php echo base_url(); ?>assets/js/neon-custom.js"></script>


	<!-- Demo Settings -->
	<script src="<?php echo base_url(); ?>assets/js/neon-demo.js"></script>

</body>
</html>