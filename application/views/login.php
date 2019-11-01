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

	<link rel="stylesheet" href="<?php echo base_url(); ?><?php echo base_url(); ?>assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
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
	<div class="col-sm-4 col-sm-offset-4" style="margin-top:150px;">
		<div class="panel panel-dark"  >
		    <!-- panel head -->
		    <div class="panel-heading">
		        <div class="panel-title">Login</div>
		    </div>
		    <!-- panel body -->
		    <div class="panel-body">
 				<form method="post" role="form" class=" " autocomplete="off">
				    <div class="form-group">
			        	<label for="field-1" class="control-label">Username</label>
			        
			            <input type="text" class="form-control" id="field-1" value="<?php if(isset($usr_name)){ echo $usr_name; } ?>" name="usr_name" placeholder="Username"> 
				    </div>

				    <div class="form-group">
			        	<label for="field-1" class="control-label">Password</label>
			        
			            <input type="password" class="form-control" id="field-1" value="<?php if(isset($usr_password)){ echo $usr_password; } ?>" name="usr_password" placeholder="Password"> 
				    </div>
				    
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