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
                        Shipment
                    </div>
                    
                    <div class="row">
                         <div class="col-md-12" style="margin-top: 20px;">
                            <table id="transaction_table"  class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Shipment Number</th>
                                        <th>Date of Shipment</th>
                                    </tr>
                                </thead>
                                <tbody>
                             <?php
                                $shipment_datas = get_rows("shipping_history");
                                foreach ($shipment_datas as $key => $shipment_data) {
                                    echo "<tr data-id='".$shipment_data['id']."'>";
                                    echo '<td>'.$shipment_data['shipment_num'].'</td>';
                                    echo '<td>'.$shipment_data['bal_date'].'</td>';
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
            