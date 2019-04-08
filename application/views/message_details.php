<?php 
    $this->load->view("header");
?>   
<style type="text/css">
    tr{
        cursor: pointer;
    }
    .unread{
        display: inline-block;
        background: red;
        border-radius: 50%;
        width: 10px;
        height: 10px;
    }
    .message_box{
        width: 100% !important;
    }
</style>
<section id="about">
    <div class="container">
        <div class="row">
            <div class="col-md-3"  style="padding: 0px 10px 0px 0px;">
                <ul class="account-siderbar">
                    <li><a href="<?php echo site_url("/account/dashboard"); ?>"><i class="ion-ios-contact"></i> My Profile</a></li>
                    <li><a href="<?php echo site_url("/account/card_info"); ?>"><i class="icon ion-card"></i> Credit Card Info</a></li>
                    
                    <li><a href="<?php echo site_url("/account/register_product"); ?>"><i class="ion-ios-medkit"></i>  Products</a></li>
                    <li><a href="<?php echo site_url("/account/transaction_history"); ?>"><i class="ion-ios-paper"></i> Transaction History</a></li>
                    <li><a href="<?php echo site_url("/account/withdraw_money"); ?>"><i class="ion-merge"></i> Withdraw Money</a></li>
                    
                    <li class=""><a href="<?php echo site_url("/account/inbox"); ?>"><i class="ion-email"></i> Inbox  <span class="message-count-box" style="display: none;"></span></a></li>

                </ul>
            </div>
            <div class="col-md-9" style="padding: 0px 0px 0px 10px;">
                <div class="account-panel">
                    <div class="row">
                         <div class="col-md-12">
                            <?php 
                                $message = get_row("message",array("id"=>$id));
                            ?>
                            <p style="font-weight: 500; font-size: 24px;">
                                <?php echo $message['subject']; ?>
                            </p>
                            <p>
                                From <?php if($message['sender'] == "admin") echo "Virsympay Suppprt"; else echo $message['sender']; ?>
                            </p>
                            <p>
                                On <?php
                                    $date1 = strtotime($message['date']);
                                    $date = date("F d,Y", $date1)." at ".date("H:i",$date1);
                                     echo $date; 
                                    ?>
                            </p>
                            <div style="border: 1px solid #ccc;padding: 20px;">
                                <?php
                                    echo $message['body'];
                                ?>
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
 
    var base_url = "<?php echo base_url("account/message_details/"); ?>";
    $(function(){
        $('#transaction_table').DataTable({
            "columnDefs": [ {
            "targets": [0,1],
            "orderable": false
            } ],
            "aaSorting": [[2, 'asc']]
        });

        $("body").on("click","#transaction_table tbody tr",function(){
            id = $(this).data("id");
            if(id==""||id===undefined) return;
            document.location.replace(base_url+id);
        })
    })
</script>
            