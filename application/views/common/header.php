<?php
if(!$this->session->userdata("user_type")){
    //Redirect to login if access without login
     header("Location:".base_url().login);
}
if(!$this->session->userdata("locker") && !$this->session->userdata("theme_park")){
    if($this->session->userdata("user_type")=='store'){
        //Store user will redirect to select the store if not selected
        if(!$this->session->userdata("store_code")){
            header("Location:".base_url().inter_login);
        }
    }
    else if($this->session->userdata("user_type")=='stall'){
        //Stall user will redirect to select the stall if not selected
        if(!$this->session->userdata("store_code") || !$this->session->userdata("stall_code")){
             header("Location:".base_url().inter_login);
        }
    }
}?>    
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
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/skins/blue.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/loader.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery_confirm.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap_datepicker.css">
    <script src="<?php echo base_url(); ?>assets/js/angular.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/angular_ui.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery-1.11.3.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap_datepicker.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/validate/jquery.validate.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/validate/additional-methods.min.js"></script>
    <style>
    textarea{
        resize: none;
    }
    .required-field{
        color:#f57;
        font-size: 13px;
    }
    </style>
    </head>

<body class="page-body skin-blue loaded" data-url="http://neon.dev">

    <div class="page-loader-wrapper" style="display: none;">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>

    <div class="page-container">
        <div class="sidebar-menu">

            <div class="sidebar-menu-inner">

                <header class="logo-env">

                    <!-- logo -->
                    <div class="logo">
                        <a href="<?php echo base_url(); ?>">
                            <img src="<?php echo base_url(); ?>assets/img/logo_small.png"
                                style="width: 57px; margin:5px;" alt="" />
                            <img src="<?php echo base_url(); ?>assets/img/multiplex_logo_small1.png" width="120"
                                alt="" />
                        </a>
                    </div>

                    <!-- logo collapse icon -->
                    <div class="sidebar-collapse">
                        <a href="#" class="sidebar-collapse-icon">
                            <!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
                            <i class="entypo-menu"></i>
                        </a>
                    </div>


                    <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
                    <div class="sidebar-mobile-menu visible-xs">
                        <a href="#" class="with-animation">
                            <!-- add class "with-animation" to support animation -->
                            <i class="entypo-menu"></i>
                        </a>
                    </div>
                </header>

                <ul id="main-menu" class="main-menu">
                    <!-- add class "multiple-expanded" to allow multiple submenus to open -->
                    <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->
					<?php /*
                    <li class="has-sub root-level"> 
						<a href="#">
								<i class="entypo-gauge"></i><span
								class="title">Dashboard</span>
						</a>
                        <ul class="">
                            <li> <a href="#"><span class="title">Dashboard
                                        1</span></a> </li>
                            <li> <a href="#"><span class="title">Dashboard
                                        2</span></a> </li>
                            <li> <a href="#"><span class="title">Dashboard
                                        3</span></a> </li>
                            <li class="has-sub"> <a href="#"><span class="title">Skins</span></a>
                                <ul>
                                    <li> <a href="#"><span class="title">Black
                                                Skin</span></a> </li>
                                    <li> <a href="#"><span class="title">White
                                                Skin</span></a> </li>
                                    <li> <a href="#"><span class="title">Purple
                                                Skin</span></a> </li>
                                    <li> <a href="#"><span class="title">Cafe
                                                Skin</span></a> </li>
                                </ul>
                            </li>
                            <li> <a href="#"><span class="title">What's
                                        New</span><span class="badge badge-success badge-roundless">v2.0</span></a>
                            </li>
                        </ul>
                    </li>
                    <?php  */	
					$menu_details = $this->common_details->GetMenus();
					//echo "<pre>";
					//print_r($menu_details); 
					//echo "</pre>";
                    $i=1;
					$uri = explode("/", uri_string());
					$thisControll = isset($uri[0])?$uri[0]:"";
                    foreach($menu_details as $main_menus){ 
                    	if($main_menus['menu_url'] != 'access_denied'){

                    		if($main_menus['menu_url'] != ''){
                            	$url = base_url().''.$main_menus['menu_url'];
	                        }    
	                        else{
	                            $url = 'javascript:void(0)';
	                        }

	                        if($main_menus['menu_icon'] != ''){
	                            $menu_icon = $main_menus['menu_icon'];
                            } 
                            $is_this_menu = $this->common_details->array_find_deep($main_menus, $thisControll);
                            /*echo "<pre>";
                            print_r($is_this_menu);
                            echo "</pre>";
							echo $main_menus['menu_url']."==".$thisControll;*/
                            /*if(!empty($this->common_details->array_find_deep($main_menus, $thisControll))){
                                echo "Active. ";
                            }*/
	                        //if($i == 1){ 
								$mainurl = ((!isset($main_menus['sub_menus']) || empty($main_menus['sub_menus'])) && $url)?$url:'javascript:void(0)';
								$has_sub_menu = (isset($main_menus['sub_menus']) && !empty($main_menus['sub_menus']))?'has-sub':'';
								$active_menu = ($thisControll!="" && !empty($is_this_menu))?'active':''; ?>
								
								<li class="<?php echo $has_sub_menu.' '.$active_menu ?> root-level"> 
									<a href="<?php echo $mainurl; ?>">
											<i class="<?php echo $menu_icon; ?>"></i>
											<span class="title"><?php echo $main_menus['menu_name'] ?></span>
									</a>
									<?php 
									if(!empty($main_menus['sub_menus'])){ ?>
										<ul class="<?php echo ($active_menu=="active")?"visible":""; ?>">
                                            <?php  
											foreach($main_menus['sub_menus'] as $submenu){ 
                                                /*echo "<pre>";
                                                print_r($submenu); 
                                                echo "</pre>";*/
												if($submenu['menu_url'] != ''){
													$url2 = base_url().''.$submenu['menu_url'];
												}    
												else{
													$url2 = 'javascript:void(0)';
												}					

                                               
												$suburl = ((!isset($submenu['inner_sub_menus']) || empty($submenu['inner_sub_menus'])) && $url2)?$url2:'javascript:void(0)';
												$has_inner_sub_menus = (isset($submenu['inner_sub_menus']) && !empty($submenu['inner_sub_menus']))?'has-sub':''; 
												$active_sub_menu = ($thisControll==$submenu['menu_url'])?"active":"";  ?>
												                                                
                                                <li class="<?php echo $has_inner_sub_menus.' '.$active_sub_menu ?>"> 
													<a href="<?php echo $suburl; ?>">
														<span class="title"><i class="fa fa-angle-right"></i> <?php echo $submenu['menu_name'] ?></span>
													</a>
													<?php 
													//Search value in multi array
													//echo in_array($thisControll, array_column($submenu['inner_sub_menus'], 'menu_url'))."<br>";
													if(!empty($submenu['inner_sub_menus'])){ ?>
														<ul class="<?php echo ($active_menu=="active" && in_array($thisControll, array_column($submenu['inner_sub_menus'], 'menu_url')))?"visible":""; ?>">
															<?php 
															/*echo "<pre>";
															print_r($submenu['inner_sub_menus']); 
															echo "</pre>";*/
															foreach($submenu['inner_sub_menus'] as $innersubmenu){ 
                                                               /* echo "<pre>";
                                                                print_r($innersubmenu); 
                                                                echo "</pre>"; */
                
																if($innersubmenu['menu_url'] != ''){
																	$url3 = base_url().''.$innersubmenu['menu_url'];
																}    
																else{
																	$url3 = 'javascript:void(0)';
                                                                }
                                                                
                                                                $innersuburl = ($url3)?$url3:'javascript:void(0)';
                                                                $active_inner_sub_menu = ($thisControll==$innersubmenu['menu_url'])?"active":""; ?>	

																<li class="<?php echo $active_inner_sub_menu ?>"> 
																	<a href="<?php echo $innersuburl; ?>">
																		<span class="title"><?php echo $innersubmenu['menu_name'] ?></span>
																	</a> 
																</li>
																<?php
															}?>
														</ul>
														<?php
													}?>
												</li>
												<?php 
											}?>
										</ul>
										<?php 
									}?>
								</li>
								<?php 
								$i++ ;
							/*}
							else{  
								$has_sub_menu = (isset($main_menus['sub_menus']) && !empty($main_menus['sub_menus']))?'has-sub root-level':'';
								$active_menu = ($thisControll==$main_menus['menu_url'])?'active':''; ?>
								
								<li class="<?php echo $has_sub_menu.' '.$active_menu ?>">
									<a href="<?php echo $url; ?>" <?php //if(count($main_menus['sub_menus']) != 0){ echo 'class="menu-toggle"'; } ?>>
										<i class="<?php echo $menu_icon; ?>"></i>
										<span><?php echo $main_menus['menu_name'] ?></span>
									</a>
									<?php 
									if(count($main_menus['sub_menus']) != 0){ ?>
									<ul class="ml-menu">
										<?php   
										foreach($main_menus['sub_menus'] as $submenu){ ?>
										<li <?php echo uri_string().'---'.$submenu['menu_url']; ?> class="active">
											<a
												href="<?php echo base_url().''.$submenu['menu_url']; ?>"><?php echo $submenu['menu_name'] ?></a>
										</li>
										<?php 
													}?>
									</ul>
									<?php 
												}?>
								</li>
								<?php  	
							}*/
						} 
					} ?>
                    <li class="root-level">
                        <a href="<?php echo base_url() ?>logout" ><i class="entypo-logout"> </i><span class="title">Logout</span></a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="main-content">
            <div class="row">
                
                    <?php 
                    //$this->session->set_userdata("alert", "Test");
                    if($this->session->userdata("alert")){ ?>
                        <script>
                        setTimeout(function(){ $("#alert-wrap").slideUp("Fade"); }, 3000);
                        </script>
                        <?php
                        echo '<div class="alert alert-warning col-sm-12 text-center" id="alert-wrap" style="position:absolute; z-index:100; top: 0; color: #555; font-weight: bold">';
                            echo $this->session->userdata("alert");
                        $this->session->unset_userdata('alert');
                        echo '</div>';
                    } ?>
                
                <!-- Profile Info and Notifications -->
                <div class="col-md-12 col-sm-8 clearfix">
                    <h5 class="store_stall_info pull-left" style="color: #1445b3; font-size: 13px; font-weight: bold;">
                        <?php
                        $currentStore = $currentStore2 = array();
                        if($this->session->userdata('store_name')){
                            $currentStore[] = "<span style=''>STORE NAME</span>: <span style='color: #d50d4e;'>".(strtoupper($this->session->userdata('store_name')))." (".$this->session->userdata('store_code').") </span>";

                            $currentStore2[] = "Store Name: ".(strtoupper($this->session->userdata('store_name')))." (".$this->session->userdata('store_code').")";
                        }
                        if($this->session->userdata('stall_name')){
                            $currentStore[] ="<span style=''>STALL NAME</span>: <span style='color: #d50d4e;'>".(strtoupper($this->session->userdata('stall_name')))." (".$this->session->userdata('stall_code').") </span> ";

                            $currentStore2[] ="Stall Name : ".(strtoupper($this->session->userdata('stall_name')))." (".$this->session->userdata('stall_code').")";
                        } 

                        if(!empty($currentStore))
                            echo "<div style='margin-bottom:7px;'>".implode("</div><div>", $currentStore)."</div>"; 

                        //We can use this session in anywhere in all page for show currently logged store/stall name and code
                        $this->session->set_userdata('logged_store_stall', implode(", ", $currentStore2)); ?>
                    </h5>
                    <ul class="user-info pull-right">

                        <li class="profile-info dropdown">
                            <!-- add class "pull-right" if you want to place this from right -->
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <img src="<?php echo base_url(); ?>assets/images/profile/user.png" alt=""
                                    class="img-circle" width="44">
                                <?php 
							if($this->session->userdata('user_name')){ 
								echo ucfirst($this->session->userdata('user_name'));
							}
                            if($this->session->userdata('user_role')){ 
                                echo " (".ucfirst($this->session->userdata('user_role')).")";
                            }
							/*if($this->session->userdata('user_type')==STORE_MANAGER){ 
                                $store_details = $this->common_details->GetStoreDetails();
                                echo ($store_details['store_name'])?" (".$store_details['store_name'].")":"";
                            } 
                            else if($this->session->userdata('user_type')==STALL_OPERATOR){ 
                                $stall_details = $this->common_details->GetStallDetails();
                                echo ($stall_details['stall_name'])?" (".$stall_details['stall_name'].")":"";
                            } 
                            else if($this->session->userdata('user_role')){ 
								echo " (".ucfirst($this->session->userdata('user_role')).")";
							} */?>

                                <i class="fa fa-chevron-down"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- Reverse Caret -->
                                <li class="caret"></li>
                                <!-- Profile sub-links -->
                                <!--
                                <li style="border-bottom: 1px solid #ccc; margin-bottom: 10px;">
                                    <a href="javascript:;"><?php echo str_replace("_"," ", ucfirst($this->session->userdata('user_type'))); ?></a>
                                </li> -->
                                <li>
                                    <a href="<?php echo base_url(); ?>Change_Password"> <i class="fa fa-edit"></i> Change password</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url() ?>logout"><i class="entypo-logout"> </i>Logout</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>

            </div>

            <hr>