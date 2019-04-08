<?php 
    $this->load->view("header");
?>   
<section id="about">
    <div class="container">
        <div class="row">
            <div class="col-md-3"  style="padding: 0px 10px 0px 0px;">
                <ul class="account-siderbar">
                    <li><a href="<?php echo site_url("/account/dashboard"); ?>"><i class="ion-ios-contact"></i> My Profile</a></li>
                    <li><a href="<?php echo site_url("/account/card_info"); ?>"><i class="icon ion-card"></i> Credit Card Info</a></li>
                    
                    <li><a href="<?php echo site_url("/account/register_product"); ?>"><i class="ion-ios-medkit"></i>  Products</a></li>
                    <li><a href="<?php echo site_url("/account/transaction_history"); ?>"><i class="ion-ios-paper"></i> Transaction History</a></li>
                    <li class="active"><a href="<?php echo site_url("/account/withdraw_money"); ?>"><i class="ion-merge"></i> Withdraw Money</a></li>
                    <li class=""><a href="<?php echo site_url("/account/inbox"); ?>"><i class="ion-email"></i> Inbox  <span class="message-count-box" style="display: none;"></span></a></li>
                    
                </ul>
            </div>
            <div class="col-md-9" style="padding: 0px 0px 0px 10px;">
                <div class="account-panel">
                    <?php 
                        $member = get_row("member",array("id"=>$this->session->userdata("member_id")));
                    ?>
                    <div class="title" style="margin-bottom: 0px;">
                        Withdraw Money
                    </div>
                    <p style="color: #848383;">
                        <?php 
                            $payment = get_row("paymentgetway",array("id"=>1));
                            $fee = $payment['transaction_fee'];
                        ?>
                        <!-- All transactions are subject to a <?php echo $fee; ?>% processing fee -->
                        All wire transfers are subject to $<?php echo $payment['wire_fee_fix']; ?> + <?php echo $payment['wire_fee_pro']; ?>% wire transfer fee.
                    </p>
                    <div style="font-size: 20px;">
                        Balance : $<?php echo $member['balance']; ?>USD
                    </div>
                    <div class="row" style="    background: #dedede; padding-bottom: 20px;">
                        <form name="bank_account" method="post" action="<?php echo site_url("account/update_bank"); ?>">
                            <div class="col-md-12" style="font-size: 16px; margin-top: 20px;">
                                My Bank Account
                            </div>
                            <?php
                                $bank = get_row("bank",array("user_id"=>$this->session->userdata("member_id")));
                            ?>
                            <div class="col-md-12">
                                <div class="form-group" style="margin-top: 0px;">
                                    <label for="email">Bank Name</label>
                                    <input type="text" class="form-control" name="name" value="<?php echo $bank['name']; ?>" >
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group" style="margin-top: 0px;">
                                    <label for="email">Bank Address</label>
                                    <input type="text" class="form-control" name="address" value="<?php echo $bank['address']; ?>" >
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group" style="margin-top: 0px;">
                                    <label for="email">Bank Country</label>
                                    <select class="form-control" name="country" >
                                    <?php
                                        $countries = get_rows("countries");
                                        foreach ($countries as $key => $country) {
                                            if($bank['country'] == $country['long_name']) 
                                                echo '<option value="'.$country['long_name'].'" selected>'.$country['long_name'].'</option>';
                                            else 
                                                echo '<option value="'.$country['long_name'].'">'.$country['long_name'].'</option>';

                                        }
                                    ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group" style="margin-top: 0px;">
                                    <label for="email">Bank Account Name</label>
                                    <input type="text" class="form-control" name="account_name" value="<?php echo $bank['account_name']; ?>" >
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group" style="margin-top: 0px;">
                                    <label for="email">Bank Account Number</label>
                                    <input type="text" class="form-control" name="account_number" value="<?php echo $bank['account_number']; ?>" >
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group" style="margin-top: 0px;">
                                    <label for="email">Bank Routing Number</label>
                                    <input type="text" class="form-control" name="routing_number" value="<?php echo $bank['routing_number']; ?>" >
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group" style="margin-top: 0px;">
                                    <label for="email">Bank Swift code</label>
                                    <input type="text" class="form-control" name="swift_code" value="<?php echo $bank['swift_code']; ?>" >
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group" style="margin-top: 0px;">
                                    <label for="email">Bank Transit Number</label>
                                    <input type="text" class="form-control" name="transit" value="<?php echo $bank['transit']; ?>" >
                                </div>
                            </div>


                            <div class="col-md-12">
                                <button type="submit" class="btn btn-info">Save</button>
                            </div>
                        </form>
                    </div>
                    <div class="row" style="padding: 20px 0px;">
                        <div class="col-md-12">
                            <form method="post" action="<?php echo site_url("account/request_withdraw"); ?>">
                            <span>Request Amount : </span><input class="form-control" type="text" name="amount" style="width: 100px; display: inline;" required="">
                            <button type="submit" class="btn btn-success">Withdraw Money Now</button>
                            <p style="font-size: 14px;font-weight: 500; color: #969696;">You can't request withdraw money more than $<?php echo $member['balance']; ?></p>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                         <div class="col-md-12">
                            <p style="font-weight: 500;">
                                Withdraw History
                            </p>
                            <table id="transaction_table" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Request Id</th>
                                        <th>Total</th>
                                        <th>Request Date</th>
                                        <th>Complete Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                             <?php
                                $withdraws = get_rows("withdraw",array("user_id"=>$this->session->userdata("member_id")),"request_date DESC");
                                foreach ($withdraws as $key => $withdraw) {
                                    $fee =floor($withdraw['fee']*100)/100;
                                    $complete_date = $withdraw['complete_date'];
                                    if($withdraw['status'] == "Pending") $complete_date = "-";
                                    echo "<tr>";
                                    echo '<td>'.$withdraw['id'].'</td>';
                                    echo '<td>$'.($withdraw['amount']-$fee).'USD</td>';
                                    echo '<td>'.$withdraw['request_date'].'</td>';
                                    echo '<td>'.$complete_date.'</td>';
                                    echo '<td>'.$withdraw['status'].'</td>';
                                    echo "</tr>";

                                }
                             ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Request Id</th>
                                        <th>Total</th>
                                        <th>Request Date</th>
                                        <th>Complete Date</th>
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


<?php 
    $this->load->view("footer");
?> 
<script type="text/javascript">
    $.extend( true, $.fn.dataTable.defaults, {
        "searching": true,
        "ordering": true
    } );

    $(function(){
        $('#transaction_table').DataTable();
    })
</script>
            