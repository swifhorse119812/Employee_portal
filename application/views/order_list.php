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
    .demo {
        position: relative;
        clear: both;
        *zoom: 1;
        zoom: 1;
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
                        Tracking Orders
                        <!-- <button class="btn btn-success pull-right" id="add_product">+ Create Product</button> -->
                    </div>
                    
                    <div class="row">
                         <div class="col-md-12" style="margin-top: 20px;">
                            <!-- <table id="transaction_table" class="display" style="width:100%"> -->
                            <!-- <table id="" class="display table table-striped bulk_action" style="width:100%"> -->
                            <table id="transaction_table"  class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Order Number</th>
                                        <th>Created Date</th>
                                        <th>Item Name</th>
                                        <th>Reference Number</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                             <?php
                                //$orders = get_rows("orders",array("user_id"=>$this->session->userdata("member_id")));
                                $orders = get_rows("orders");
                                foreach ($orders as $key => $order) {
                                    echo "<tr data-id='".$order['id']."'>";
                                    echo '<td>'.$order['order_num'].'</td>';
                                    echo '<td>'.$order['date'].'</td>';
                                    echo '<td>'.$order['itname'].'</td>';
                                    echo '<td>'.$order['reference_num'].'</td>';
                                    $status = get_rows("order_status_list",array('id'=>$order['state']));
                                    echo '<td>'.$status[0]["title"].'</td>';
                                    echo "</tr>";
                                }
                             ?>
                                </tbody>
                            </table>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> <!-- /#about -->

<!-- 
<div class="modal fade in" id="product_modal" aria-hidden="false" style="display: none;">
  <div class="modal-dialog" style="width: 700px;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
            <h3 class="modal-title">Create New Product</h3>
        </div>
        <div class="modal-body" style="padding: 10px 0px;">
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
</div> -->


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
        // $("body").on("click","#transaction_table tbody tr",function(){
        //     $("#create_product")[0].reset();
        //     $("#remove_btn").show();
        //     var id = $(this).data("id");
        //     $.ajax({
        //         url: "<?php echo site_url("account/get_product"); ?>",
        //         data:{id:id},
        //         dataType:"json",
        //         type:"post",
        //         success: function(res){
        //             $("#title").val(res.data.title);
        //             $("#price").val(res.data.price);
        //             $("#description").val(res.data.description);
        //             $("#redirect_url").val(res.data.redirect_url);
        //             $("#id").val(res.data.id);
        //             $(".button_html").show();
        //             // https://merchant.virsympay.com/defaultsite
        //             $("#button_html").text('<a href="<?php echo site_url("checkout"); ?>/?publish_key='+res.data.publish_key+'">Pay Now</a>');
        //             // $("#button_html").text('<a href="http://localhost/merchant_virsympay/checkout/?publish_key='+res.data.publish_key+'">Pay Now</a>');

        //             $("#submit_btn").html("Update");
        //             $("#product_modal").modal();
        //         }
        //     })
           
        // })
    })
</script>
<script src="<?php echo base_url('assets/js/tablefilter.js'); ?>"></script>
<!-- <script src="tablefilter/tablefilter.js"></script> -->

<script data-config="">
 var filtersConfig = {
  base_path: 'base_url/',
  auto_filter: {
                    delay: 110 //milliseconds
              },
              filters_row_index: 1,
              state: true,
              alternate_rows: true,
              rows_counter: true,
              btn_reset: true,
              status_bar: true,
              msg_filter: 'Filtering...'
            };
            var tf = new TableFilter('transaction_table', filtersConfig);
            tf.init();
          </script>
            