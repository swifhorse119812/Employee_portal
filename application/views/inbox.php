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
    .td-action{
        color: #ff7600;
    }
    .td-action:hover{
        color: red;
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
                    <li class="active"><a href="<?php echo site_url("/account/inbox"); ?>"><i class="ion-email"></i> Inbox  <span class="message-count-box" style="display: none;"></span></a></li>

                </ul>
            </div>
            <div class="col-md-9" style="padding: 0px 0px 0px 10px;">
                <div class="account-panel">
                    <div class="row">
                         <div class="col-md-12">
                            <?php 
                                $messages = get_rows("message",array("receiver"=>$this->session->userdata("member_id")));
                            ?>
                            <p style="font-weight: 500;">
                                Message Inbox <span style="color: white;background: green;display: inline-block;border-radius: 50%;width: 30px;text-align: center;height: 30px;padding-top: 5px;"><?php echo count($messages); ?></span>
                            </p>
                            <table id="transaction_table" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="width: 10px;"></th>
                                        <th>ID</th>
                                        <th>From</th>
                                        <th>Subject</th>
                                        <th>Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                             <?php
                                foreach ($messages as $key => $message) {
                                    echo "<tr data-id='".$message['id']."'>";
                                    if($message['status'] == 1){
                                        echo "<td style='width:10px;'><span class='unread'></span></td>";
                                    } else 
                                        echo "<td style='width:10px;'><span class='read'></span></td>";

                                    echo "<td>".$message['id']."</td>";
                                    $sender = $message['sender'];
                                    if($sender == "admin") $sender = "Virsympay Support";
                                    echo "<td>".$sender."</td>";
                                    echo "<td>".$message['subject']."</td>";
                                    $date1 = strtotime($message['date']);
                                    $date = date("F d,Y", $date1)." at ".date("H:i",$date1);
                                    echo "<td>".$date."</td>";
                                    echo '<td class="td-action">Remove</td>';
                                    echo "</tr>";
                                }
                             ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>ID</th>
                                        <th>From</th>
                                        <th>Subject</th>
                                        <th>Date</th>
                                        <th></th>
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
 
    var base_url = "<?php echo base_url("account/"); ?>";
    $.extend( true, $.fn.dataTable.defaults, {
        "searching": true,
        "ordering": false
    } );


    $(function(){
        $('#transaction_table').DataTable({
            "columnDefs": [ {
            "targets": [0,1],
            "orderable": false
            } ],
            "aaSorting": [[2, 'asc']]
        });

        $("body").on("click","#transaction_table tbody td",function(){
            id = $(this).closest("tr").data("id");
            if($(this).hasClass("td-action")) return;
            if(id==""||id===undefined) return;
            document.location.replace(base_url+"message_details/"+id);
        })
        $("body").on("click",".td-action",function(){
            id = $(this).closest("tr").data("id");
            document.location.replace(base_url+"message_remove/"+id);

        })
    })
</script>
            