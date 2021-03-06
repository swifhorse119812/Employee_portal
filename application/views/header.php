<!DOCTYPE html>
<html class="no-js">
    <head>
        <!-- Basic Page Needs
        ================================================== -->
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="icon" href="favicon.ico">
        <title>Employee</title>
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
        
        <link href="<?php echo base_url(); ?>assets/css/mycustom.css" rel="stylesheet">  <!--------------- Image size....-->

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

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
           
           .fr-wrapper > div:first-child{
              display:none;
            }
            .fr-view{
              display:block !important;
            }
            p[data-f-id="pbf"]{
              display:none;
            } 
            .message-count-box{
                display: inline-block;
                border-radius: 10px;
                text-align: center;
                font-size: 10px;
                padding-top: 4px;
                width: 20px;
                height: 20px;
                background: blue;
                color: white;
            }


        </style>
    </head>
    <body>

<?php 
    ////////////////////////////////////////// get balance
    $datas = get_rows('balance_history');
    $default_balance = get_rows('balance');
    $remain_bal =  $default_balance[0]['balance'];
    foreach ($datas as $key => $data) {
        $remain_bal -= $data['balance']; 
    }
    $member = get_row("member",array("id"=>$this->session->userdata("member_id")));
    $emp_level = $member['emp_level'];
    //echo $remain_bal;
    //////////////////////////////////////////
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
<?php 
    
?>

<style type="text/css">
    @media(max-width: 600px){
        .account-siderbar{
            display: none;
        }

    }
</style>

<!--
==================================================
Header Section Start
================================================== -->
<header id="top-bar" class="">
    <div class="container">
        <div class="navbar-header">
            <!-- responsive nav button -->
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
          
        <nav class="collapse navbar-collapse navbar-right" role="navigation">
            <div class="main-menu">
                <ul class="nav navbar-nav navbar-right">
                <?php
                    if($emp_level!=2){
                ?>
                    <li><a>Ballance : $<?php echo $remain_bal;?></a></li>
                    <li><a href="<?php echo site_url("/account/dashboard"); ?>">My Profile</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Customers <span class="caret"></span></a>
                        <div class="dropdown-menu">
                            <ul>
                                <li><a href="<?php echo site_url("/account/realcustomer_list"); ?>">Customer List</a></li>
                                <li><a href="<?php echo site_url("/account/realcustomer_add"); ?>">Add Customer</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Orders <span class="caret"></span></a>
                        <div class="dropdown-menu">
                            <ul>
                                <li><a href="<?php echo site_url("/account/order_status_list"); ?>">Order State List</a></li>
                                <li><a href="<?php echo site_url("/account/shipment"); ?>">Shipment</a></li>
                                <li><a href="<?php echo site_url("/account/order"); ?>">Add Order</a></li>
                            </ul>
                        </div>
                    </li>
                    <!-- <li><a href="<?php echo site_url("/login/logout"); ?>">Log Out</a></li> -->
                    <li><a id="logout" class="logout" >Log Out</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count" style="border-radius:10px;"></span> <span class="glyphicon glyphicon-bell" style="font-size:20px;"></span></a>
                        <div class="dropdown-menu">
                            <!-- <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count" style="border-radius:10px;"></span> <span class="glyphicon glyphicon-bell" style="font-size:20px;"></span></a> -->
                            <ul>
                                <?php
                                    $shipping_datas = get_rows('shipping_history');
                                    $count = sizeof($shipping_datas);
                                    $output = '';
                                    if($count){
                                        foreach($shipping_datas as $shipping_data){
                                            $output .= '<li style="color:white;">Shipment '.$shipping_data["shipment_num"].' has been shipped</li>';
                                        }
                                    }else{
                                        $output .= '<li style="color:white;"><a href="#" class="text-bold text-italic">No Noti Found</a></li>';
                                    }
                                    echo $output;
                                ?>
                            </ul>
                            <!-- <ul class="dropdown-menu" id="notification"></ul> -->
                        </div>
                    </li>
                    <?php
                        }
                        else{
                    ?>
                            <li><a href="<?php echo site_url("/account/dashboard"); ?>">My Profile</a></li>
                            <li><a href="<?php echo site_url("/account/order_status_list"); ?>">Order State List</a></li>
                            <li><a href="<?php echo site_url("/account/order_list"); ?>">Tracking Orders</a></li>
                            <li><a id="logout" class="logout" >Log Out</a></li>
                    <?php
                        }                        
                    ?>
                </ul>
            </div>
        </nav>
        <!-- /main nav -->
        <!-- logout modal-->
        <div class="modal fade in" id="logout_modal" aria-hidden="false" style="display: none;">
            <div class="modal-dialog" style="width: 700px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
                        <h3 class="modal-title" style="color:black;">To Administrator</h3>
                    </div>
                    <div class="modal-body" style="padding: 10px 0px;">
                        <form id="create_ticket" name="create_ticket" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo site_url("login/write_comment"); ?>" method="post" enctype="multipart/form-data">
                            
                                <div class="form-group" style="padding: 20px; padding-bottom: 10px;">
                                    <label class="control-label col-md-12 col-sm-12 col-xs-12" for="name" style="text-align: left; color:black;">Write down here<span class="required">*</span>
                                    </label>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <textarea type="text"  name="logout_comment" id="logout_comment" required="required"  class="form-control col-md-12 col-xs-12">
                                        </textarea>
                                    </div>
                                </div>  
                                
                                <input type="hidden" name="member_id" style="color:black;" id="<?php echo $member['id']; ?>" value="<?php echo $member['id']; ?>">
                                <?php $member_name = $member['first_name']." ".$member['last_name']; ?>
                                <input type="hidden" name="member_name" style="color:black;" id="<?php echo $member_name; ?>" value="<?php echo $member_name; ?>">

                                <div class="form-group">
                                    <div class="" style="text-align: center;">
                                        <button type="submit" class="btn btn-info" id="submit_btn" style="">Save</button>
                                        <button type="button" class="btn btn-warning" id="remove_btn" style=" margin-left: 20px;" data-dismiss="modal">Cancel</button>

                                    </div>
                                </div>
                                
                                <div class="ln_solid"></div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<style type="text/css">
    .notification_wrap{
        position: fixed;
        z-index: 1032;
        width: 600px;
        border: 3px double #ccc;
        background: rgba(250, 255, 225, 0.9);
        right: 20px;
        top: 20px;
        padding: 20px;
        
    }
    .error-note{
        font-size: 14px;
        font-style: italic;
        padding-left: 10px;
        color: #8c8b8b;
        margin-bottom: 20px;
    }
    .error-title{
        margin: 0px;
        font-weight: 500;
    }
</style>
<script src="<?php echo base_url('assets/client_assets/plugins/jQurey/jquery.min.js'); ?>"></script>
<script>
     $(document).ready(function () {
        $("body").on("click","#logout",function(){
             $("#logout_modal").modal();
        })
   
        function load_unseen_notification(view = '')
        {
            $.ajax({
                url: ajax_url + "help/notification",
                method:"POST",
                data:{view:view},
                dataType:"json",
                success:function(data)
                {
                    //$('#notification').html(data.notification);
                    if(data.unseen_notification > 0)
                    {
                        $('.count').html(data.unseen_notification);
                    }
                }
            });
        }

        load_unseen_notification();

        // load new notifications
        $(document).on('click', '.dropdown-toggle', function(){
             $('.count').html('');
             load_unseen_notification('yes');
        });

        setInterval(function(){
            load_unseen_notification();;
        }, 5000);

})
</script>


<?php 

    if($this->session->userdata("show_box") == "yes"){ 
?>
<div class="notification_wrap">
    <?php
        if($this->session->userdata("approve_status") != 2){
    ?>
    <p class="error-title">Your account is pending to live mode.</p>
    <p class="error-note">You can't do anything on this portal before accept it. Please Accept Employee Processing Terms To Continue.</p>
    <?php 
        }
    ?>
</div>
<?php } ?>
