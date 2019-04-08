<!DOCTYPE html>
<html class="no-js">
    <head>
        <!-- Basic Page Needs
        ================================================== -->
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="icon" href="favicon.ico">
        <title>Merchant virsympay</title>
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

            #alert_error_wrap{
                top: 0px !important;
                position: fixed !important;
                right: 0px !important;
            }
           
            @media(max-width: 800px){
                .mobile-row{
                    margin-top: 80px;
                }
                .mobile-header{
                  float:none !important;
                  text-align:center;
                }
              .mobile-img{
                display:inline-block !important;
              }
            }

        </style>
    </head>
    <body>

<?php
    $publish_key = $_REQUEST['publish_key'];
    $product = get_row("product",array("publish_key"=>$publish_key));
    $member = get_row("member",array("id"=>$product['user_id']));
    if($member['approve_status']!=2){ 
?> 
<div style="position: fixed; width: 100%; height: 100%; background: white; opacity: 0.5; z-index: 10000; ">
    <p style="width: 1024px;padding: 30px;font-size: 30px;margin: 200px auto;background: black;color: white;text-align: center;">
        Merchant's account is pending to live mode. Please try later!
    </p>
</div>
<?php 
    }
?>

<?php
    if($this->session->userdata("warning")!=""){
?>
    <div id="alert_error_wrap" class="float-alert animated fadeInRight col-xs-11 col-sm-4 alert alert-danger" style="z-index: 10000;float: right;margin-top: 10px;position: fixed;right: 0px;top: 0px;">
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
    <div id="alert_error_wrap" class="float-alert animated fadeInRight col-xs-11 col-sm-4 alert alert-success" style="z-index: 10000;float: right;margin-top: 10px;position: fixed;right: 0px;top: 0px;">
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
        <div class="navbar-header  mobile-header" style="float: left; margin-top: 10px;" >
            <div class="navbar-brand mobile-header">
                <img class="mobile-img" src="<?php echo base_url('assets/client_assets/images/logo.png'); ?>" alt="" style="height: 50px;">
            </div>
            
            <!-- /logo -->
        </div>
        <div style="float: left;color: black;font-size: 14px;margin-left: 40px;margin-top: 25px;" class="mobile-header">
                <?php
                    $row = get_row("paymentgetway",array("id"=>1));
                    echo $row['checkout_title'];
                ?>
        </div>
    </div>
</header>


<section id="about">
    <div class="container">
        <div class="row mobile-row">
            <form id="stripe_form" name="stripe_form" method="post" action="<?php echo site_url("checkout_iPay/pay"); ?>">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12 title">
                            Billing Details
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" style="">
                                <label for="email">First Name <span style="color: red">*</span></label>
                                <input type="text" class="form-control" name="first_name" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" style="">
                                <label for="email">Last Name <span style="color: red">*</span></label>
                                <input type="text" class="form-control" name="last_name" required="">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group" style="">
                                <label for="email">Company Name(optional)</label>
                                <input type="text" class="form-control" name="company_name">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group" style="">
                                <label for="email">Country<span style="color: red">*</span></label>
                                <select class="form-control" name="country" required="">
                                    <option value="US">United States of America</option>
                                    <?php
                                        $countries = get_rows("countries");
                                        foreach ($countries as $key => $country) {
                                            if($country['long_name'] == "United States of America") continue;
                                            echo '<option value="'.$country['ios2'].'">'.$country['long_name'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" style="">
                                <label for="email">Street Address<span style="color: red">*</span></label>
                                <input type="text" class="form-control" name="street_address" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" style="">
                                <label for="email">&nbsp;</label>
                                <input type="text" class="form-control" name="home_type" placeholder="Apartment, suite, unit etc. (optional)">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group" style="">
                                <label for="email">City<span style="color: red">*</span></label>
                                <input type="text" class="form-control" name="city" required="">
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group" style="">
                                <label for="email">State / Province <span style="color: red">*</span></label>
                                <input type="text" class="form-control" name="state" required="">
                            </div>
                        </div>

                        
                        <div class="col-md-5">
                            <div class="form-group" style="">
                                <label for="email">Postcode / ZIP <span style="color: red">*</span></label>
                                <input type="text" class="form-control" name="zipcode" required="">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group" style="">
                                <label for="email">Phone Number<span style="color: red">*</span></label>
                                <input type="text" class="form-control" name="phone_number" id="phone_number" required="">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group" style="">
                                <label for="email">Email Address<span style="color: red">*</span></label>
                                <input type="text" class="form-control" name="email" id="email" required="">
                            </div>
                        </div>
                        <div class="col-md-12" style="font-size: 20px; margin-top: 20px;">
                            ADDITIONAL INFORMATION
                        </div>
                        <div class="col-md-12">
                            <div class="form-group" style="">
                                <label for="email">Order notes (optional)</label>
                                <textarea class="form-control" name="add_info" style="resize: none; height: 100px;"></textarea>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="col-md-12 title">
                        <div class="pull-left" style="padding-top: 15px;">Card Info</div> 
                    </div>
                    <div class="col-md-12" style="margin-top:  5px;">
                        <div class="form-group" style="">
                            <label for="email">Card Number<span style="color: red">*</span></label>
                            <input type="text" class="form-control" name="card_number" required="" id="card_number" placeholder="xxxx xxxx xxxx xxxx">
                        </div>
                    </div>
                    <div class="col-md-12" style="font-weight: 700;">
                        Expiry Date
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" style="">
                            <label for="email">Month<span style="color: red">*</span></label>
                            <input type="text" class="form-control" id="expiry_date_m" name="expiry_date_m" required=""  placeholder="mm">
                        </div>
                    </div>
                     <div class="col-md-6">
                        <div class="form-group" style="">
                            <label for="email">Year<span style="color: red">*</span></label>
                            <input type="text" class="form-control" id="expiry_date_y" name="expiry_date_y" required=""  placeholder="yy" data-year="<?php echo date("y"); ?>">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group" style="">
                            <label for="email">CVV<span style="color: red">*</span></label>
                            <input type="text" class="form-control" name="cvv" required="" id="cvv" placeholder="xxx">
                        </div>
                    </div>
                    <?php
                        $publish_key = $_REQUEST['publish_key'];
                        $product = get_row("product",array("publish_key"=>$publish_key));
                        $payment = get_row("paymentgetway",array("id"=>1));
                        $fee = $payment['checkout_fee'];

                    ?>
                    <div class="col-md-12" style="font-size: 20px; margin-top: 20px;">
                        Product Details
                        <p style="font-size: 14px; font-weight: 500; margin-top: 10px; margin-bottom: 0px;">
                            <b>Product ID :</b> <?php echo $product['id']; ?>
                        </p>
                        <p style="font-size: 14px; font-weight: 500; margin-bottom: 5px;">
                            <b>Title :</b> <?php echo $product['title']; ?>
                        </p>

                         <p style="font-size: 14px; font-weight: 500; margin-bottom: 5px;">
                            <b>Description</b>
                        </p>

                         <p style="font-size: 14px; font-weight: 400; margin-bottom: 5px; padding-left: 5px;">
                            <?php echo nl2br($product['description']); ?>
                        </p>

                        <p style="font-size: 14px; font-weight: 500; margin-bottom: 5px;">
                            <b>Price :</b> $<?php echo $product['price']; ?>
                        </p>

                        <p style="font-size: 14px; font-weight: 500; margin-bottom: 5px;">
                            <b>Fee :</b> $<?php echo $fee; ?>
                        </p>
                        
                        <p style="font-size: 14px; font-weight: 500; margin-bottom: 5px;">
                            <b>Total Price :</b> $<?php echo $product["price"]+$fee; ?>
                        </p>
                        
                    </div>
                    <div class="col-md-12">
                        <button type="submit" id="pay_btn" class="btn btn-success" style="width: 100%; margin-top: 20px;" >Pay now</button>
                    </div>
                </div>

                <input type="hidden" name="publish_key" value="<?php echo $_REQUEST["publish_key"]; ?>">
                <input type="hidden" name="price" value="<?php echo ($product["price"]+$fee); ?>">
                <?php
                    $stripe_publish_key = $payment['stripe_publish_key'];
                ?>
            </form>
        </div>
    </div>
</section> 
 

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>    
<?php 
    $this->load->view("footer");
?> 
<script type="text/javascript">
    var stripe_publish_key = "<?php echo $stripe_publish_key; ?>";
    $(function(){

        setTimeout(function() {
            $('#alert_error_wrap').hide('fast', function() { $('#alert_error_wrap').remove(); });
        }, 3500);


        $("#stripe_form").submit(function(event) {
            event.preventDefault();
            error_status = "no";
            email_message = "";
            email = $("#email").val();
            if(email != ""){
                var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                if( !emailReg.test(email)) {
                    error_status = "yes";
                    email_message = "You have to enter correct email!" + "\n";
                }
            }

            phone_number = $("#phone_number").val();
            if(phone_number != ""){
                var phone_number_reg = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/;
                if( !phone_number_reg.test(phone_number)) {
                    error_status = "yes";
                    email_message += "You have to enter correct phone number!\n";
                }
            }

            expiry_date = $("#expiry_date_m").val()+"/"+$("#expiry_date_y").val();
            var match = expiry_date.match(/^\s*(0?[1-9]|1[0-2])\/(\d\d|\d{4})\s*$/);
            if (!match){
                error_status = "yes";
                email_message +="You have to enter correct expiry date!\n";
                
            } else {
                var exp = new Date(normalizeYear(1*match[2]),1*match[1]-1,1).valueOf();
                var now=new Date();
                var currMonth = new Date(now.getFullYear(),now.getMonth(),1).valueOf();
                if (exp<=currMonth){
                    error_status = "yes";
                    email_message +="You have to enter correct expiry!\n";
                }  
            }

            card_number = $("#card_number").val();
            if(card_number!=""){
                card_type = GetCardType(card_number);
                if(card_type!="Visa" && card_type!="Mastercard"){
                    error_status = "yes";
                    email_message +="Sorry only Visa, Master card accepted, try again!\n";
                }
            }

            if(error_status!="no"){
                alert(email_message);
                return false;
            } else {
                document.stripe_form.submit();
            }

           return false;
        });
    })
    function normalizeYear(year){
        // Century fix
        var YEARS_AHEAD = 20;
        if (year<100){
            var nowYear = new Date().getFullYear();
            year += Math.floor(nowYear/100)*100;
            if (year > nowYear + YEARS_AHEAD){
                year -= 100;
            } else if (year <= nowYear - 100 + YEARS_AHEAD) {
                year += 100;
            }
        }
        return year;
    }
    function GetCardType(number)
    {
        // visa
        var re = new RegExp("^4");
        if (number.match(re) != null)
            return "Visa";

        // Mastercard 
        // Updated for Mastercard 2017 BINs expansion
         if (/^(5[1-5][0-9]{14}|2(22[1-9][0-9]{12}|2[3-9][0-9]{13}|[3-6][0-9]{14}|7[0-1][0-9]{13}|720[0-9]{12}))$/.test(number)) 
            return "Mastercard";

        // AMEX
        re = new RegExp("^3[47]");
        if (number.match(re) != null)
            return "AMEX";

        // Discover
        re = new RegExp("^(6011|622(12[6-9]|1[3-9][0-9]|[2-8][0-9]{2}|9[0-1][0-9]|92[0-5]|64[4-9])|65)");
        if (number.match(re) != null)
            return "Discover";

        // Diners
        re = new RegExp("^36");
        if (number.match(re) != null)
            return "Diners";

        // Diners - Carte Blanche
        re = new RegExp("^30[0-5]");
        if (number.match(re) != null)
            return "Diners - Carte Blanche";

        // JCB
        re = new RegExp("^35(2[89]|[3-8][0-9])");
        if (number.match(re) != null)
            return "JCB";

        // Visa Electron
        re = new RegExp("^(4026|417500|4508|4844|491(3|7))");
        if (number.match(re) != null)
            return "Visa Electron";

        return "";
    }

</script>
