<?php 
    $this->load->view("header");
?>   
<section id="about">
    <div class="container">
        <div class="row">
            <!-- <div class="col-md-3"  style="padding: 0px 10px 0px 0px;">
                <ul class="account-siderbar">
                    <li class="active"><a href="<?php echo site_url("/account/dashboard"); ?>"><i class="ion-ios-contact"></i> My Profile</a></li>

                    <li><a href="<?php echo site_url("/account/card_info"); ?>"><i class="icon ion-card"></i> Credit Card Info</a></li>

                    <li><a href="<?php echo site_url("/account/register_product"); ?>"><i class="ion-ios-medkit"></i>  Products</a></li>
                    <li><a href="<?php echo site_url("/account/transaction_history"); ?>"><i class="ion-ios-paper"></i> Transaction History</a></li>
                    <li><a href="<?php echo site_url("/account/withdraw_money"); ?>"><i class="ion-merge"></i> Withdraw Money</a></li>
                    <li class=""><a href="<?php echo site_url("/account/inbox"); ?>"><i class="ion-email"></i> Inbox  <span class="message-count-box" style="display: none;"></span></a></li>
                </ul>
            </div> -->
            <div class="col-md-9" style="padding: 0px 0px 0px 10px;">
                <div class="account-panel">
                    <?php 
                        $member = get_row("member",array("id"=>$this->session->userdata("member_id")));
                    ?>
                    <div class="title">
                        My Profile
                    </div>
                    <div style="font-size: 20px;">
                        Balance : $<?php echo $member['balance']; ?>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <form action="<?php echo site_url("account/update_profile"); ?>" method="post" name="update_profile">
                            <div class="form-group" style="margin-top: 20px;">
                                <label for="email">First Name <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="first_name" value="<?php echo $member['first_name']; ?>" required="">
                            </div>

                            <div class="form-group">
                                <label for="email">Last Name <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="last_name" value="<?php echo $member['last_name']; ?>" required="">
                            </div>

                            

                             <div class="form-group" style="">
                                <label for="email">Country<span style="color: red">*</span></label>
                                <select class="form-control" name="country" required="">
                                    <option value="United States of America">United States of America</option>
                                    <?php
                                        $countries = get_rows("countries");
                                        foreach ($countries as $key => $country) {
                                            if($country['long_name'] == "United States of America") continue;
                                            echo '<option value="'.$country['long_name'].'">'.$country['long_name'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="email">City <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="city" value="<?php echo $member['city']; ?>" required="">
                            </div>

                            <div class="form-group">
                                <label for="email">Address <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="address" value="<?php echo $member['address']; ?>" required="">
                            </div>

                            <div class="form-group">
                                <label for="email">Email Address <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="email" value="<?php echo $member['email']; ?>" required="">
                            </div>

                            <div class="form-group">
                                <label for="email">Phone Number <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="phone_number" value="<?php echo $member['phone_number']; ?>" required="">
                            </div>
                            
                            <div class="form-group">
                                <button class="btn btn-info">Update Profile</button>
                            </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <form action="<?php echo site_url("account/update_password"); ?>" method="post" name="update_profile">

                            <div class="form-group" style="margin-top: 20px;">
                                <label for="email">Old Password</label>
                                <input type="password" class="form-control" name="old_password" required="">
                            </div>

                            <div class="form-group" style="margin-top: 20px;">
                                <label for="email">New Password</label>
                                <input type="password" class="form-control" name="new_password" required="">
                            </div>
                            <div class="form-group" style="margin-top: 20px;">
                                <label for="email">Repeat New Password</label>
                                <input type="password" class="form-control" name="repeat_new_password" required="">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-info">Update Password</button>
                            </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> <!-- /#about -->

 

<!--
==================================================
Call To Action Section Start
================================================== -->
<section id="call-to-action">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block">
                    <h2 class="title wow fadeInDown" data-wow-delay=".3s" data-wow-duration="500ms">SO WHAT YOU THINK ?</h1>
                    <p class="wow fadeInDown" data-wow-delay=".5s" data-wow-duration="500ms">All purchases with Virsympay are purchases of the Virsymcoin Cryptocurrency,<br/> we convert all purchases to the currency of your choice.</p>
                    <a href="<?php echo site_url("contact"); ?>" class="btn btn-default btn-contact wow fadeInDown" data-wow-delay=".7s" data-wow-duration="500ms">Contact With Me</a>
                </div>
            </div>
            
        </div>
    </div>
</section>


<?php 
    $this->load->view("footer");
?> 

            