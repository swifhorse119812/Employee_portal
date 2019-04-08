<?php 
    $this->load->view("header");
?>   
<style type="text/css">
    a{
        cursor: pointer;
    }
    .Refund td{
        color: blue;
    }
      .request_refund td{
      color: green;
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
                    <li class="active"><a href="<?php echo site_url("/account/transaction_history"); ?>"><i class="ion-ios-paper"></i> Transaction History</a></li>
                    <li><a href="<?php echo site_url("/account/withdraw_money"); ?>"><i class="ion-merge"></i> Withdraw Money</a></li>
                    <li class=""><a href="<?php echo site_url("/account/inbox"); ?>"><i class="ion-email"></i> Inbox  <span class="message-count-box" style="display: none;"></span></a></li>
                    
                </ul>
            </div>
            <div class="col-md-9" style="padding: 0px 0px 0px 10px;">
                <div class="account-panel">
                    <?php 
                        $member = get_row("member",array("id"=>$this->session->userdata("member_id")));
                    ?>
                    <div class="title">
                        Transaction History
                    </div>
                    <div style="font-size: 20px;">
                        Balance : $<?php echo $member['balance']; ?>USD
                    </div>
                    <div class="row">
                         <div class="col-md-12" style="margin-top: 20px;">
                            <table id="transaction_table" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Transaction Id</th>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Name</th>
                                        <th>Gross</th>
                                        <th>Fee</th>
                                        <th>Net</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                             <?php
                                $transactions = get_rows("transaction",array("user_id"=>$this->session->userdata("member_id")),"date DESC");
                                foreach ($transactions as $key => $transaction) {
                                    echo "<tr class='".$transaction['status']."'>";
                                    echo '<td>'.$transaction['id'].'</td>';
                                    echo '<td>'.$transaction['date'].'</td>';
                                    if($transaction['payment_type'] == "checkout"){
                                        echo '<td>Payment from</td>';
                                        echo '<td><a class="customer-details" data-status="'.$transaction['status'].'" data-id="'.$transaction['id'].'">'.$transaction['first_name']." ".$transaction['last_name'].'</a></td>';
                                        echo '<td>$'.$transaction['price'].'USD</td>';
                                        echo '<td>$'.$transaction['fee'].'USD</td>';
                                        echo '<td>$'.($transaction['price']-$transaction['fee']).'USD</td>';
                                    } else if($transaction['payment_type'] == "service_fee") {
                                        echo '<td>Service Fee</td>';
                                        echo '<td> - </td>';
                                        echo '<td> - </td>';
                                        echo '<td>$'.$transaction['fee'].'USD</td>';
                                        echo '<td style="color:blue;">-$'.$transaction['fee'].'USD</td>';
                                    } else if($transaction['payment_type'] == "withdraw_money"){
                                        echo '<td>Withdraw</td>';
                                        echo '<td>-</td>';
                                        echo '<td>$'.$transaction['price'].'USD</td>';
                                          $fee = $transaction['fee'];
                                        echo '<td>$'.$fee.'USD</td>';
                                        echo '<td style="color:red;">-$'.($transaction['price']-$fee).'USD</td>';
                                    }
                                    echo '<td>'.(str_replace("_", " ",$transaction['status'])).'</td>';
                                    echo "</tr>";

                                }
                             ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Transaction Id</th>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Name</th>
                                        <th>Gross</th>
                                        <th>Fee</th>
                                        <th>Net</th>
                                        <th>Status</th>
                                    </tr>
                                </tfoot>
                            </table>

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



<div class="modal fade in" id="transaction_modal" aria-hidden="false" style="display: none;">
  <div class="modal-dialog" style="width: 700px;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
            <h3 class="modal-title">Transaction Details</h3>
        </div>
        <div class="modal-body" style="padding: 10px 0px;">
         <!--  <img id="featureimage" src=""/> -->
              
        </div>
        <div class="modal-footer">
            <form action="<?php echo base_url("account/refund"); ?>" method="post" name="refund_form">
                <input type="hidden" name="id" id="transaction_id">
                <button type="submit" class="btn btn-info" id="refund_btn">Request Refund </button>
                &nbsp;
                &nbsp;
                <button type="button" class="btn" data-dismiss="modal"> Close </button>
            </form>
        </div>
    </div>
  </div>
</div>

<?php 
    $this->load->view("footer");
?> 
<script type="text/javascript">
    $.extend( true, $.fn.dataTable.defaults, {
        "searching": true,
        "ordering": false
    } );

    $(function(){
        $('#transaction_table').DataTable({responsive: true});
        $("body").on("click",".customer-details",function(){
            // publish_key = $(this).data("publish_key");
            id = $(this).data("id");
            status = $(this).data("status");
            $("#transaction_id").val(id);
            $.ajax({
                url: "<?php echo site_url("account/get_transaction"); ?>",
                data:{id:id},
                dataType:"html",
                type:"post",
                success: function(res){
                    $("#refund_btn").hide();
                    if(status == "Paid") 
                        $("#refund_btn").show();

                    $("#transaction_modal .modal-body").html(res);
                    $("#transaction_modal").modal();
                }
            })

        })
    })
</script>
            