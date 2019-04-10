<?php 
    $this->load->view("header");
?>   
<style type="text/css">
    .required{
        color: red;
    }
    tr{
        cursor: pointer;
    }
</style>
<section id="about">
    <div class="container">
        <div class="row">
            <!-- <div class="col-md-3"  style="padding: 0px 10px 0px 0px;">
                <ul class="account-siderbar">
                    <li><a href="<?php echo site_url("/account/dashboard"); ?>"><i class="ion-ios-contact"></i> My Profile</a></li>
                    <li><a href="<?php echo site_url("/account/card_info"); ?>"><i class="icon ion-card"></i> Credit Card Info</a></li>
                    
                    <li class="active"><a href="<?php echo site_url("/account/register_product"); ?>"><i class="ion-ios-medkit"></i>  Products</a></li>
                    <li><a href="<?php echo site_url("/account/transaction_history"); ?>"><i class="ion-ios-paper"></i> Transaction History</a></li>
                    <li><a href="<?php echo site_url("/account/withdraw_money"); ?>"><i class="ion-merge"></i> Withdraw Money</a></li>
                    <li class=""><a href="<?php echo site_url("/account/inbox"); ?>"><i class="ion-email"></i> Inbox  <span class="message-count-box" style="display: none;"></span></a></li>
                    
                </ul>
            </div> -->
            <div class="col-md-12" style="padding: 0px 0px 0px 10px;">
                <div class="account-panel">
                    <?php 
                        $member = get_row("member",array("id"=>$this->session->userdata("member_id")));
                    ?>
                    <div class="title">
                        Order Lists
                        <!-- <button class="btn btn-success pull-right" id="add_product">+ Create Product</button> -->
                    </div>
                    <!-- <div style="font-size: 20px;">
                        Balance : $<?php echo 1110; ?>USD
                    </div> -->
                    <div class="row">
                         <div class="col-md-12" style="margin-top: 20px;">
                            <table id="transaction_table" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Item ID</th>
                                        <th>Item Name</th>
                                        <th>Item Image</th>
                                        <th>Item Price</th>
                                        <th>Item Size</th>
                                        <th>Item Color</th>
                                        <th>Sipping fee</th>
                                        <th>Customer</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                             <?php
                                //$orders = get_rows("orders",array("user_id"=>$this->session->userdata("member_id")));
                                $orders = get_rows("orders");
                                //var_dump($orders);exit;
                                foreach ($orders as $key => $order) {
                                    echo "<tr data-id='".$order['id']."'>";
                                    echo '<td>'.$order['id'].'</td>';
                                    echo '<td>'.$order['itname'].'</td>';
                                    //echo '<td>'.$order['photo'].'</td>';
                                    echo '<td> <img src="'.base_url().'assets/uploads/'.$order["photo"].'" style="width: 50px; height:50px "/></td>';
                                   
                                    echo '<td>$'.$order['itprice'].'</td>';
                                    echo '<td>'.$order['itsize'].'</td>';
                                    echo '<td>'.$order['itcolor'].'</td>';
                                    echo '<td>$'.$order['itshippingfee'].'</td>';
                                    echo '<td>'.$order['itcustom'].'</td>';
                                    $status = get_rows("order_status_list",array('id'=>$order['state']));
                                    echo '<td>'.$status[0]["title"].'</td>';
                                    echo "</tr>";
                                }
                             ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                    <th>Item ID</th>
                                        <th>Item Name</th>
                                        <th>Item Image</th>
                                        <th>Item Price</th>
                                        <th>Item Size</th>
                                        <th>Item Color</th>
                                        <th>Sipping fee</th>
                                        <th>Customer</th>
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


<div class="modal fade in" id="product_modal" aria-hidden="false" style="display: none;">
  <div class="modal-dialog" style="width: 700px;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
            <h3 class="modal-title">Create New Product</h3>
        </div>
        <div class="modal-body" style="padding: 10px 0px;">
         <!--  <img id="featureimage" src=""/> -->
              <form id="create_product" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo site_url("account/update_product"); ?>" method="post" enctype="multipart/form-data">
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Title <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="title" id="title" required="required"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Price <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text"  name="price" id="price" required="required"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div> 
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Redirect Url <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text"  name="redirect_url" id="redirect_url" required="required"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>   
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Description
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea style="width: 100%; resize: none;height: 100px; " name="description" id="description"></textarea>
                        </div>
                      </div>    
                      <div class="form-group button_html">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Pay Now Button 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <code id="button_html">
                          </code>
                        </div>
                      </div>   

                    <input type="hidden" name="id" id="id">

                    <div class="form-group">
                        <div class="" style="text-align: center;">
                          <button type="submit" class="btn btn-info" id="submit_btn" style="">Create New Product</button>
                          <button type="button" class="btn btn-warning" id="remove_btn" style=" margin-left: 20px; display: none;">Remove Product</button>

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


<?php 
    $this->load->view("footer");
?> 
<script type="text/javascript">
    $.extend( true, $.fn.dataTable.defaults, {
        "searching": true,
        "ordering": true
    } );

    $(function(){
        $('#transaction_table').DataTable({responsive: true});
        $("#add_product").click(function(){
            $("#create_product")[0].reset();
            $("#submit_btn").html("Create New Product");
            $("#remove_btn").hide();
            $(".button_html").hide();
            //$("#product_modal").modal();
        })
        $("body").on("click","#remove_btn",function(){
            $(this).closest("form").attr("action","<?php echo site_url("account/remove_product"); ?>");
            $(this).closest("form").submit();
        })
        $("body").on("click","#transaction_table tbody tr",function(){
            $("#create_product")[0].reset();
            $("#remove_btn").show();
            var id = $(this).data("id");
            $.ajax({
                url: "<?php echo site_url("account/get_product"); ?>",
                data:{id:id},
                dataType:"json",
                type:"post",
                success: function(res){
                    $("#title").val(res.data.title);
                    $("#price").val(res.data.price);
                    $("#description").val(res.data.description);
                    $("#redirect_url").val(res.data.redirect_url);
                    $("#id").val(res.data.id);
                    $(".button_html").show();
                    // https://merchant.virsympay.com/defaultsite
                    $("#button_html").text('<a href="<?php echo site_url("checkout"); ?>/?publish_key='+res.data.publish_key+'">Pay Now</a>');
                    // $("#button_html").text('<a href="http://localhost/merchant_virsympay/checkout/?publish_key='+res.data.publish_key+'">Pay Now</a>');

                    $("#submit_btn").html("Update");
                    $("#product_modal").modal();
                }
            })
           
        })
    })
</script>
            