<?php 
    $this->load->view("common/header");
?>   
<link href="<?php echo base_url(); ?>assets/css/mycustom.css" rel="stylesheet">
   
   <style type="text/css">
       .fr-view{
           min-height: 150px !important;
       }
        .class1 {
           border-radius: 10%;
           border: 2px solid #efefef;
         }
   
         .class2 {
           opacity: 0.5;
         }
         #faq_table tbody tr{
           cursor: pointer;
         }
         td{
           height: 25px;
         }
         .sider-menu{
           padding-left: 0px;
         }
         .sider-menu li{
           list-style-type: none;
           line-height: 30px;
           cursor: pointer;
           /*border-bottom: 1px solid #ddd;*/
           padding-top: 20px;
           padding-left: 20px;
           box-shadow: 1px 1px 1px #e0e0e0;
           margin-bottom: 5px;
   
         }
         ul .li-active{
           background: #e0e0e0;
         }
   </style>
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
              <!-- <div class="title_left"> -->
              <div class="">
                <h3> Reject Oders List </h3>
                <!-- <a class="btn btn-round btn-danger navbar-right" id="btn_print"> Print </a> -->
                <button class="btn btn-sm pull-right btn-default" type="submit">Print Item</button>
              </div>
            </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Reject Orders List </h2>
                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">
                        <section id="about">
                            <div class="container">
                                <div class="row">
                                    
                                    <div class="col-md-12" style="padding: 0px 0px 0px 10px;">
                                        <div class="account-panel">
                                            <?php 
                                                $member = get_row("member",array("id"=>$this->session->userdata("member_id")));
                                            ?>
                                            
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
                                                        $orders = get_rows("orders",array('state'=>0));
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
                                                            echo '<td>Reject</td>';
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
                    </div>
                </div>
        </div>
    </div>
 

<!--
==================================================
Call To Action Section Start
================================================== -->
<section id="call-to-action">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block">
                    <!-- <h2 class="title wow fadeInDown" data-wow-delay=".3s" data-wow-duration="500ms">SO WHAT YOU THINK ?</h1>
                    <p class="wow fadeInDown" data-wow-delay=".5s" data-wow-duration="500ms">All purchases with Virsympay are purchases of the Virsymcoin Cryptocurrency,<br/> we convert all purchases to the currency of your choice.</p>
                    <a href="<?php echo site_url("contact"); ?>" class="btn btn-default btn-contact wow fadeInDown" data-wow-delay=".7s" data-wow-duration="500ms">Contact With Me</a> -->
                </div>
            </div>
            
        </div>
    </div>
</section>


<!-- <div class="modal fade in" id="product_modal" aria-hidden="false" style="display: none;">
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
    $this->load->view("common/footer");
?> 
<script type="text/javascript">
    $.extend( true, $.fn.dataTable.defaults, {
        "searching": true,
        "ordering": true
    } );

    $(function(){
      $('button[type="submit"]').click(function () {
            var pageTitle = 'Page Title'
                stylesheet = '//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css'
                win = window.open('', 'Print', 'width=500,height=300');
            win.document.write('<html><head><title>' + pageTitle + '</title>' +
                '<link rel="stylesheet" href="' + stylesheet + '">' +
                '</head><body>' + $('.table')[0].outerHTML + '</body></html>');
            win.document.close();
            win.print();
            win.close();
            return false;
         })
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
            