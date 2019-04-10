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
            <div class="col-md-12" style="padding: 0px 0px 0px 10px;">
                <div class="account-panel">
                    <?php 
                        $member = get_row("member",array("id"=>$this->session->userdata("member_id")));
                    ?>
                    <div class="title">
                        Customers
                        <button class="btn btn-success pull-right" id="add_product">+ Add Customer</button>
                    </div>
                    <!-- <div style="font-size: 20px;">
                        Balance : $<?php echo $member['balance']; ?>USD
                    </div> -->
                    <div class="row">
                         <div class="col-md-12" style="margin-top: 20px;">
                            <table id="transaction_table" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Customer ID</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Phone Number</th>
                                        <th>Address</th>
                                    </tr>
                                </thead>
                                <tbody>
                             <?php
                                $customers = get_rows("customers");
                                foreach ($customers as $key => $customer) {
                                    echo "<tr data-id='".$customer['id']."'>";
                                    echo '<td>'.$customer['id'].'</td>';
                                    echo '<td>'.$customer['first_name'].'</td>';
                                    echo '<td>'.$customer['last_name'].'</td>';
                                    echo '<td>'.$customer['phone_number'].'</td>';
                                    echo '<td>'.$customer['address'].'</td>';
                                    echo "</tr>";
                                }
                             ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                       <th>Customer ID</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Phone Number</th>
                                        <th>Address</th>
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
            <h3 class="modal-title">Add New Customer</h3>
        </div>
        <div class="modal-body" style="padding: 10px 0px;">
         <!--  <img id="featureimage" src=""/> -->
            <form id="create_product" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo site_url("account/update_customer"); ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
            
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">ID</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="id" id="id" readonly>
                    </div>
                      </div>          
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">First Name<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="first_name" id="first_name" required="required"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Last Name<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text"  name="last_name" id="last_name" required="required"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div> 
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Phone Number<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text"  name="phone_number" id="phone_number" required="required"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>   
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Address<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text"  name="address" id="address" required="required"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>  
                      <!-- <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Description
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea style="width: 100%; resize: none;height: 100px; " name="description" id="description"></textarea>
                        </div>
                      </div>     -->
                      <div class="form-group button_html">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Pay Now Button 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <code id="button_html">
                          </code>
                        </div>
                      </div>   

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
            $("#submit_btn").html("Add New Customer");
            $("#remove_btn").hide();
            $(".button_html").hide();
            $("#product_modal").modal();
        })
        $("body").on("click","#remove_btn",function(){
            $(this).closest("form").attr("action","<?php echo site_url("account/remove_customer"); ?>");
            $(this).closest("form").submit();
        })
        $("body").on("click","#transaction_table tbody tr",function(){
            $("#create_product")[0].reset();
            $("#remove_btn").show();
            var id = $(this).data("id");
            $.ajax({
                url: "<?php echo site_url("account/get_customer"); ?>",
                data:{id:id},
                dataType:"json",
                type:"post",
                success: function(res){
                    $("#first_name").val(res.data.first_name);
                    $("#last_name").val(res.data.last_name);
                    $("#phone_number").val(res.data.phone_number);
                    $("#address").val(res.data.address);
                    $("#id").val(res.data.id);
                    // $(".button_html").show();
                    // // https://merchant.virsympay.com/defaultsite
                    // $("#button_html").text('<a href="<?php echo site_url("checkout"); ?>/?publish_key='+res.data.publish_key+'">Pay Now</a>');
                    // // $("#button_html").text('<a href="http://localhost/merchant_virsympay/checkout/?publish_key='+res.data.publish_key+'">Pay Now</a>');

                    $("#submit_btn").html("Update");
                    $("#product_modal").modal();
                }
            })
           
        })
    })
</script>
            