 <!DOCTYPE html>
<html class="no-js">
    <head>
        <!-- Basic Page Needs
        ================================================== -->
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="icon" href="favicon.ico">
        <title>Employee Login</title>
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="author" content="">
        <!-- Mobile Specific Metas
        ================================================== -->
        <meta name="format-detection" content="telephone=no">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        
        <!-- Template CSS Files
        ================================================== -->
        <!-- Twitter Bootstrs CSS -->
        <link rel="stylesheet" href="<?php echo base_url('assets/client_assets/plugins/bootstrap/bootstrap.min.css'); ?>">
        <!-- Ionicons Fonts Css -->
        <link rel="stylesheet" href="<?php echo base_url('assets/client_assets/plugins/ionicons/ionicons.min.css'); ?>">
        <!-- animate css -->
        <link rel="stylesheet" href="<?php echo base_url('assets/client_assets/plugins/animate-css/animate.css'); ?>">
        <!-- Hero area slider css-->
        <link rel="stylesheet" href="<?php echo base_url('assets/client_assets/plugins/slider/slider.css'); ?>">
        <!-- owl craousel css -->
        <link rel="stylesheet" href="<?php echo base_url('assets/client_assets/plugins/owl-carousel/owl.carousel.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/client_assets/plugins/owl-carousel/owl.theme.css'); ?>">
        <!-- Fancybox -->
        <link rel="stylesheet" href="<?php echo base_url('assets/client_assets/plugins/facncybox/jquery.fancybox.css'); ?>">
        <!-- template main css file -->
        <link rel="stylesheet" href="<?php echo base_url('assets/client_assets/css/style.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/client_assets/css/jquery.dataTables.css'); ?>">
        <style type="text/css">
            .navbar-nav li{
                cursor: pointer;
            }
            .modal a{
                cursor: pointer;
            }
            .alert-warning{
                color: red;
            }

            @-webkit-keyframes fadeInRight {
                from {
                    opacity: 0;
                    -webkit-transform: translate3d(100%, 0, 0);
                    transform: translate3d(100%, 0, 0);
                }

                to {
                    opacity: 1;
                    -webkit-transform: none;
                    transform: none;
                }
            }

            @keyframes fadeInRight {
                from {
                    opacity: 0;
                    -webkit-transform: translate3d(100%, 0, 0);
                    transform: translate3d(100%, 0, 0);
                }

                to {
                    opacity: 1;
                    -webkit-transform: none;
                    transform: none;
                }
            }

            .fadeInRight {
                -webkit-animation-name: fadeInRight;
                animation-name: fadeInRight;
            }

            .animated {
                -webkit-animation-duration: 1s;
                animation-duration: 1s;
                -webkit-animation-fill-mode: both;
                animation-fill-mode: both;
            }
            .table .alert-danger {
                color: #a94442 !important;
                background-color: #f2dede !important;
                border-color: #ebccd1 !important;
            }

            .alert {
                padding: 10px 15px;
                font-size: 14px;
            }

            .alert:not(.float-alert) span[data-notify="icon"] {
                float: left;
                font-size: 18px;
                margin-top: 0;
            }

            .float-alert.alert span[data-notify="icon"] {
                font-size: 20px;
                display: block;
                left: 13px;
                position: absolute;
                top: 50%;
                margin-top: -11px;
            }

            .alert.float-alert .alert-title {
                margin-left: 30px;
                font-weight: 500;
            }

            body.rtl .alert.float-alert .alert-title {
                float: left;
            }

            .alert:not(.float-alert) .alert-title {
                margin-left: 10px;
            }

            .alert.float-alert button.close {
                position: absolute;
                right: 10px;
                top: 50%;
                margin-top: -13px;
                z-index: 1033;
                background-color: #FFFFFF;
                display: block;
                border-radius: 50%;
                opacity: .4;
                line-height: 11px;
                width: 25px;
                height: 25px;
                outline: 0 !important;
                text-align: center;
                padding: 3px;
                font-weight: 400;
            }

            .alert.float-alert button.close:hover {
                opacity: .55;
            }

            .alert.float-alert .close~span {
                display: block;
                max-width: 89%;
            }

            .alert.alert-dismissible button.close {
                right: -2px;
            }

            .announcement .alert-dismissible .close {
                top: -4px;
            }

            .account-siderbar{
                border: 1px solid #dedede;
                min-height: 500px;
            }
            .account-siderbar li{
                margin: 20px;
            }
            .account-siderbar li i{
                font-size: 15px;
            }
            .account-siderbar li.active a{
                color: #d87206;
            }
            .account-panel{
                border: 1px solid #dedede;
                min-height: 500px;
                padding: 20px;
            }
            .title{

            }
            .inline-input-wrap{

            }
           


        </style>
    </head>
    <body>

<?php 
    if($this->session->userdata("warning")!=""){
?>
    <div id="alert_error_wrap" class="float-alert animated fadeInRight col-xs-11 col-sm-4 alert alert-danger" style="z-index: 10000; float: right; margin-top: 10px;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <span class="fa fa-bell-o" data-notify="icon"></span><span class="alert-title"><?php echo $this->session->userdata("warning"); ?></span>
    </div>

<?php     
    $this->session->unset_userdata("warning");
    }
?>

<?php
    if($this->session->userdata("success")!=""){
?>
    <div id="alert_error_wrap" class="float-alert animated fadeInRight col-xs-11 col-sm-4 alert alert-success" style="z-index: 10000; float: right; margin-top: 10px;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <span class="fa fa-bell-o" data-notify="icon"></span><span class="alert-title"><?php echo $this->session->userdata("success"); ?></span>
    </div>

<?php     
    $this->session->unset_userdata("success");
    }
?>

<!--
==================================================
Header Section Start
================================================== -->
<header id="top-bar" class="navbar-fixed-top animated-header">
    <div class="container">
       
    <div class="" style="text-align: center;">
        <a href="<?php echo base_url(); ?>"  style="font-size: 40px;">
            <img src="<?php echo base_url('assets/client_assets/images/logo.png'); ?>" alt="" style="height: 50px;">
            Employee
        </a>
    </div>
       
    </div>
</header>

<!--
==================================================
Slider Section Start
================================================== -->
<section>
    <style type="text/css">
        a{
            cursor: pointer;
        }
    </style>
<div class="container" style="min-height: 700px;">
    <div class="row" style="margin-top: 200px;">
        <div class="col-md-12" style="text-align: center; font-size: 30px; margin-bottom: 20px;">
            Employee Portal
        </div>
        <div class="col-md-12">
            <form id="login_form" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo site_url("login/login"); ?>" method="post" enctype="multipart/form-data">
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Email <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="email" name="email" required="required"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Password <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password"  name="password" required="required"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>              
                
                    <div class="form-group">
                        <div class="" style="text-align: center;">
                          <button type="submit" class="btn btn-info" type="reset" style="width: 250px;">Login</button>
                        </div>
                    </div>
                    <div style="text-align: center;">
                        New to site? <a class="signup_now"> Create Account </a>
                    </div>

                    <div style="text-align: center;">
                        <a class="forgot_password"> Forgot password? </a>
                    </div>
              <div class="ln_solid"></div>
            </form>

            <form id="reset_password" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo site_url("login/reset_password"); ?>" method="post" enctype="multipart/form-data" style="display: none;">
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Email <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="email" name="email" required="required"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>      
                
                    <div class="form-group">
                        <div class="" style="text-align: center;">
                          <button type="submit" class="btn btn-info" type="reset" style="width: 250px;">Send Mail</button>
                        </div>
                    </div>
                    <div style="text-align: center;">
                        New to site? <a class="signup_now"> Create Account </a>
                    </div>
              <div class="ln_solid"></div>
            </form>

            <form name="signup_form" id="signup_form" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo site_url("login/signup"); ?>" method="post" enctype="multipart/form-data" style="display: none;">
                   
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">First name<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text"  name="first_name" required="required"  class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>   

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Last name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text"  name="last_name" required="required"  class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>   

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Phone number <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text"  name="phone_number" required="required"  class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>   

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Email <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text"  name="email" required="required"  class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>      
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Password <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password"  id="password" name="password" required="required"  class="form-control col-md-7 col-xs-12">
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Repeat Password <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password"  id="repeat_password"  required="required"  class="form-control col-md-7 col-xs-12">
                        </div>
                    </div> 
                    <div style="color: red; text-align: center; display: none;" id="error_wrap">
                        Didn't match password!
                    </div>            
                
                    <div class="form-group">
                        <div class="" style="text-align: center;">
                          <button class="btn btn-info" id="signup_btn" type="submit" style="width: 250px;">Sign Up</button>
                        </div>
                    </div>
                    <div style="text-align: center;">
                        Aleady member? <a class="login_now"> Login Now </a>
                    </div>
              <div class="ln_solid"></div>
            </form>
        </div>
    </div>
</div>
</section><!--/#main-slider-->

<!--
==================================================
About Section Start
================================================== -->
 

<?php 
    $this->load->view("footer");
?> 

            