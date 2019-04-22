<?php 
    $this->load->view("header");
    //var_dump($shipped_datas);exit;
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
                        Shipment Details
                    </div>
                    
                    <div class="row">
                         <div class="col-md-12" style="margin-top: 20px;">
                            <table id="transaction_table"  class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Shipment Number</th>
                                        <th>Order Number</th>
                                        <th>Reference Number</th>
                                        <th>Photo</th>
                                        <th>Customer</th>
                                        <th>Shipped Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                             <?php
                                //$shipment_datas = get_rows("shipping_history");
                                foreach ($shipped_datas as $key => $shipped_data) {
                                  //var_dump($shipped_data);exit;
                                    echo "<tr data-id='".$shipped_data["id"]."'>";
                                    echo '<td>'.$shipped_data['shipment_num'].'</td>';
                                    echo '<td>'.$shipped_data['order_num'].'</td>';
                                    echo '<td>'.$shipped_data['reference_num'].'</td>';
                                    echo '<td> <img src="'.base_url().'assets/uploads/'.$shipped_data["photo"].'" width="50" height="50" onmouseover= "this.width=400;this.height=400;" onmouseout="this.width=50;this.height=50"></td>';
                                    // echo '<td>'.$shipped_data['itcustom'].'</td>';
                                    $customer = get_row('customer',array('id'=>$shipped_data['itcustom']));
                                    echo '<td>'.$customer['firstname'].' '.$customer['lastname'].'</td>';
                                    echo '<td>'.$shipped_data['shipped_date'].'</td>';
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



<?php 
    $this->load->view("footer");
?> 
<script type="text/javascript">
    var ajax_url = "<?php echo base_url(); ?>";
    $.extend( true, $.fn.dataTable.defaults, {
        "searching": true,
        "ordering": true
    } );
    $(function(){
        $('#transaction_table').DataTable({responsive: true});
        
        $("body").on("click","#transaction_table tbody tr",function(){
            var shipment_id = $(this).closest("tr").data("id");
            document.location.replace(ajax_url+"account/shipment_details/"+shipment_id);
        })
    })

    // 
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
            