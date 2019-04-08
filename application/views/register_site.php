<?php 
    $this->load->view("header");
?>        
<style type="text/css">
    .site-panel{
        width: 100%;
        border: 1px solid #ccc;
        padding: 20px;
    }
    .close-wrap{
        text-align: right;
        margin-bottom: 0px;
        margin-top: -20px;
        margin-right: -20px;
    }
</style>
<section id="about">
    <div class="container">
        <div class="row">
            <div class="col-md-3"  style="padding: 0px 10px 0px 0px;">
                <ul class="account-siderbar">
                    <li><a href="<?php echo base_url("/account/dashboard"); ?>"><i class="ion-ios-contact"></i> My Profile</a></li>
                    <li  class="active"><a href="<?php echo base_url("/account/register_product"); ?>"><i class="ion-ios-medkit"></i>  Products</a></li>
                    <li><a href="<?php echo base_url("/account/transaction_history"); ?>"><i class="ion-ios-paper"></i> Transaction History</a></li>
                    <li><a href="<?php echo base_url("/account/withdraw_money"); ?>"><i class="ion-merge"></i> Withdraw Money</a></li>
                </ul>
            </div>
            <div class="col-md-9" style="padding: 0px 0px 0px 10px;">
                <div class="account-panel">
                    <?php 
                        $member = get_row("member",array("id"=>$this->session->userdata("member_id")));
                    ?>
                    <div class="title">
                        Register Website
                    </div>
                    
                    <div class="row" style="margin-bottom: 20px;">
                        <?php
                            $sites = get_rows("register_product",array("user_id"=>$this->session->userdata("member_id")));
                            foreach ($sites as $key => $site) {
                        ?>
                        <div class="col-md-6">
                            <div class="site-panel">
                                <form action="<?php echo base_url("account/update_site"); ?>" method="post" name="update_profile">
                                <div class="form-group close-wrap">
                                    <a alt="remove" class="btn remove-site" style="font-size: 20px; color: red;"><i class="ion-ios-close"></i></a>
                                </div>
                                <input type="hidden" name="id" value="<?php echo $site['id']; ?>">
                                
                                <div class="form-group" style="">
                                    <label for="email">Publish Key</label>
                                    <input type="text" class="form-control" readonly="" value="<?php echo $site['publish_key']; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="email">Site Url</label>
                                    <input type="text" class="form-control" name="site_url" value="<?php echo $site['site_url']; ?>" required="">
                                </div>

                                <div class="form-group">
                                    <label for="email">Redirect Url</label>
                                    <input type="text" class="form-control" name="redirect_url" value="<?php echo $site['redirect_url']; ?>" required="">
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Update This site</button>
                                </div>
                                </form>
                            </div>
                        </div>
                        <?php 
                        }
                        ?>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="site-panel">

                                <form action="<?php echo base_url("account/update_site"); ?>" method="post" name="update_profile">
                                
                                <div class="form-group">
                                    <label for="email">Site Url</label>
                                    <input type="text" class="form-control" name="site_url" required="">
                                </div>

                                <div class="form-group">
                                    <label for="email">Redirect Url</label>
                                    <input type="text" class="form-control" name="redirect_url" required="">
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-info">Register New site</button>
                                </div>
                                </form>
                            </div>
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
<script type="text/javascript">
    $(function(){
         $("body").on("click",".remove-site",function(){
            $(this).closest("form").attr("action","<?php echo base_url("account/remove_site"); ?>");
            $(this).closest("form").submit();
        })
    })
</script>
            