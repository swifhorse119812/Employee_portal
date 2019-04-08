<?php
	$this->load->view('common/header.php');
?>
<style type="text/css">
  .customer-details{
    cursor: pointer;
    color: #409abd;
  }
   .Refund td{
        color: blue;
    }
   .request_refund td{
      color: green;
  }
</style>
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Transaction History</h3>
              </div>
            </div>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Transaction History</h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">

                    <div class="table-responsive">
                      <table id="example" class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings" style="background-color:#24652e">
                            <th>Transaction Id</th>
                            <th>Transaction Date</th>
                            <th>Merchant</th>
                            <th>Type</th>
                            <th>Customer Name</th>
                            <th>Card Number</th>
                            <th>Gross</th>
                            <th>Fee</th>
                            <th>Net</th>
                            <th>Status</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php
                                $transactions = get_rows("transaction",array(),"date DESC");
                                foreach ($transactions as $key => $transaction) {
                                  $member = get_row("member",array("id"=>$transaction['user_id']));
                                    echo "<tr class='".$transaction['status']."'>";
                                    echo '<td>'.$transaction['id'].'</td>';
                                    echo '<td>'.$transaction['date'].'</td>';
                                    echo '<td>'.$member['first_name']." ".$member["last_name"].'</td>';
                                    if($transaction['payment_type'] == "checkout"){
                                        echo '<td>Payment from</td>';
                                        echo '<td><span class="customer-details" data-id="'.$transaction['id'].'" data-publish_key="'.$transaction['publish_key'].'" data-status="'.$transaction['status'].'">'.$transaction['first_name']." ".$transaction['last_name'].'</span></td>';
                                        $card_number = "";
        for($i=0; $i<strlen($transaction['card_number']); $i++)
            $card_number .= "*";
        $card_number.= substr($transaction['card_number'], -4);

                                        echo '<td>'.$card_number.'</td>';

                                        echo '<td>$'.($transaction['price'] + $transaction['checkout_fee'] ).'USD</td>';
                                        echo '<td>$'.($transaction['fee']+$transaction['checkout_fee']).'USD</td>';
                                        echo '<td>$'.($transaction['price']-$transaction['fee']).'USD</td>';
                                    } else if($transaction['payment_type'] == "service_fee") {
                                        echo '<td>Service Fee</td>';
                                        echo '<td> - </td>';
                                        echo '<td> - </td>';
                                        echo '<td>-</td>';

                                        echo '<td>$'.$transaction['fee'].'USD</td>';
                                        echo '<td style="color:blue;">-$'.$transaction['fee'].'USD</td>';
                                    } else if($transaction['payment_type'] == "withdraw_money"){
                                        echo '<td>Withdraw</td>';
                                        echo '<td>-</td>';
                                        echo '<td>-</td>';
                                        
                                        $fee = $transaction['fee'];
                                        echo '<td>$'.$transaction['price'].'USD</td>';
                                        echo '<td>$'.$fee.'USD';
                                        echo '<td style="color:red;">-$'.($transaction['price']-$fee).'USD</td>';
                                    }
                                    echo '<td>'.(str_replace("_", " ", $transaction['status'])).'</td>';
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
       
        </div> 
       <!-- /page content -->

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
          <form action="<?php echo base_url("admini/payment/refund"); ?>" method="post" name="refund_form">
            <input type="hidden" name="id" id="transaction_id">
            <button type="submit" class="btn btn-info" id="refund_btn"> Refund </button>
            &nbsp;
            &nbsp;
            <button class="btn" data-dismiss="modal"> Close </button>
          </form>
        </div>
    </div>
  </div>
</div>


<?php
	$this->load->view('common/footer.php');
?>
<script >

   $.extend( true, $.fn.dataTable.defaults, {
        "searching": true,
        "ordering": false
    } );


    $(document).ready(function() {
    var table = $('#example').DataTable( {
         "dom": "<'row'<'col-sm-8'B><'col-sm-1'l><'col-sm-1'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [
            'csv', 'print'
        ],
         

    } );

    // For demo to fit into DataTables site builder...
    $('#example')
        .removeClass( 'display' )
         .addClass('table table-striped table-bordered');

    $(".col-sm-1").removeClass("col-sm-1");

    $(".col-sm-1").removeClass("col-sm-1");
        
} );
   

  $(document).ready(function(){

    $("body").on("click",".customer-details",function(){
        var publish_key = $(this).data("publish_key");
        var id = $(this).data("id");
        var status = $(this).data("status");
        $.ajax({
            url: "<?php echo base_url("admini/payment/get_transaction"); ?>",
            data:{id:id},
            dataType:"html",
            type:"post",
            success: function(res){
                $("#refund_btn").hide();
                if(status != "Refund") $("#refund_btn").show();
                $("#transaction_id").val(id);
                $("#transaction_modal .modal-body").html(res);
                $("#transaction_modal").modal();
            }
        })

    })
    
  });

</script>

