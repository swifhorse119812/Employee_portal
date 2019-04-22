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
              <div class="">
                <h3>Shipping List </h3>
                <button class="btn btn-sm pull-right btn-default" type="submit">Print Item</button>
              </div>
            </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Shipping List </h2>
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
                                                $shipped_datas = get_rows("shipping_history");
                                                $temp=0;
                                                $total=0;
                                                foreach($shipped_datas as $shipped_data){
                                                    $temp++;
                                                    $total+=$shipped_data['shipping_fee'];
                                                }
                                            ?>
                                            <div>
                                            <h2> <?php echo $temp; ?>&nbsp;&nbsp;Orders &nbsp;&nbsp; Shipping $<?php echo $total; ?></h2>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-12" style="margin-top: 20px;">
                                                    <table id="transaction_table" class="table table-striped jambo_table bulk_action" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Shipped Date</th>
                                                                <th>Order ID</th>
                                                                <th>Customer</th>
                                                                <th>Sipping fee</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                    <?php
                                                        $num = 0;
                                                        foreach ($shipped_datas as $key => $shipped_data) {
                                                            $num++;
                                                            echo "<tr data-id='".$shipped_data['id']."'>";
                                                            echo '<td>'.$shipped_data['bal_date'].'</td>';
                                                            echo '<td>'.$shipped_data['order_id'].'</td>';
                                                            echo '<td>'.$shipped_data['customer'].'</td>';
                                                            echo '<td>$'.$shipped_data['shipping_fee'].'</td>';
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
                        </section>
                    </div>
                </div>
        </div>
    </div>

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
            