<?php
	$this->load->view('common/header.php');
?>
<style type="text/css">
  .customer-details{
    cursor: pointer;
    color: #409abd;
  }
</style>
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Withdraw Money History</h3>
              </div>
            </div>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Requested Withdraw</h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                    <div class="table-responsive">
                      <table id="example" class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings" style="background-color:#24652e">
                            <th>Withdraw ID</th>
                            <th>Merchant</th>
                            <th>Request Date</th>
                            <th>Amount</th>
                            <th>Fee</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php
                                $withdraws = get_rows("withdraw",array("status"=>"Pending"),"request_date ASC");
                                foreach ($withdraws as $key => $withdraw) {
                                    $member = get_row("member",array("id"=>$withdraw['user_id']));
                                    echo "<tr>";
                                    echo '<td>'.$withdraw['id'].'</td>';
                                    echo '<td>'.$member['first_name']." ".$member["last_name"].'</td>';
                                    echo '<td>'.$withdraw['request_date'].'</td>';
                                    echo '<td>$'.$withdraw['amount'].'</td>';
                                    $fee = $withdraw['fee'];
                                    echo '<td>$'.$fee.'</td>';
                                    echo '<td style="color:red;">$'.($withdraw['amount']-$fee).'</td>';
                                    echo '<td>'.$withdraw['status'].'</td>';
                                    echo '<td><button class="btn btn-info action_btn" data-withdraw_id="'.$withdraw['id'].'">Action</button></td>';
                                    echo "</tr>";
                                }
                             ?>
                        </tbody>
                      </table>
                    </div>
              
            
                  </div>
                </div>
              </div>

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Withdraw History</h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                    <div class="table-responsive">
                      <table id="withdraw" class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings" style="background-color:#24652e">
                            <th>Withdraw ID</th>
                            <th>Merchant</th>
                            <th>Request Date</th>
                            <th>Completed Date</th>
                            <th>Amount</th>
                            <th>Fee</th>
                            <th>Total</th>
                            <th>Status</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php
                                $withdraws = get_rows("withdraw",array(),"request_date DESC");
                                foreach ($withdraws as $key => $withdraw) {
                                    $member = get_row("member",array("id"=>$withdraw['user_id']));
                                    echo "<tr>";
                                    echo '<td>'.$withdraw['id'].'</td>';
                                    echo '<td>'.$member['first_name']." ".$member["last_name"].'</td>';
                                    echo '<td>'.$withdraw['request_date'].'</td>';
                                    echo '<td>'.$withdraw['complete_date'].'</td>';
                                    echo '<td>$'.$withdraw['amount'].'</td>';
                                    $fee = $withdraw['fee'];
                                    echo '<td>$'.$fee.'</td>';
                                    echo '<td style="color:red;">$'.($withdraw['amount']-$fee).'</td>';
                                    echo '<td>'.$withdraw['status'].'</td>';
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

<div class="modal fade in" id="withdraw_modal" aria-hidden="false" style="display: none;">
  <div class="modal-dialog" style="width: 700px;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
            <h3 class="modal-title">Withdraw Money</h3>
        </div>
        <div class="modal-body" style="padding: 10px 0px;">
          <div class="row" style="margin: 10px;">
            <div class="col-md-12">
              <p>Bank Info</p>
              <textarea style="width: 100%; height: 180px; resize: none;" id="bank_info" readonly=""></textarea>
            </div>
            <div class="col-md-12" style="margin-top: 20px;">
              Merchat : <b id="merchant_id">Brist Back</b>
              &nbsp;&nbsp;&nbsp;
              Balance : <b id="balance">$100</b>
              &nbsp;&nbsp;&nbsp;
              Request Amount : <b id="amount">$100</b>
              &nbsp;&nbsp;&nbsp;
              Fee : <b id="fee">$100</b>
              &nbsp;&nbsp;&nbsp;
              Total : <b id="total">$100</b>
            </div>
          </div>              
        </div>
        <div class="modal-footer">
          <form action="<?php echo base_url("admini/payment/withdraw_complete"); ?>" method="post">
            <input type="hidden" name="id" id="withdraw_id">
            <input type="hidden" name="complete_status" id="complete_status">

            <button type="button" class="btn btn-success withdraw_btn" data-status="1"> Withdraw Complete </button>
            <button type="button" class="btn btn-warning withdraw_btn" data-status="2"> Withdraw Cancel </button>
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

      var table = $('#withdraw').DataTable( {
         "dom": "<'row'<'col-sm-8'B><'col-sm-1'l><'col-sm-1'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [
            'csv', 'print'
        ],
         

    } );

    // For demo to fit into DataTables site builder...
    $('#withdraw')
        .removeClass( 'display' )
         .addClass('table table-striped table-bordered');

    $(".col-sm-1").removeClass("col-sm-1");

    } );
   

  $(document).ready(function(){

    $("body").on("click",".action_btn",function(){
        var id = $(this).data("withdraw_id");
        $.ajax({
          url: BASE_URL + "admini/payment/get_withdraw",
          data:{"id":id},
          dataType:"json",
          type:"post",
          success: function(res){
            $("#withdraw_id").val(id);
            $("#merchant_id").html(res.data.member);
            $("#balance").html(res.data.balance);
            $("#fee").html(res.data.fee);
            $("#total").html(res.data.total);
            $("#bank_info").text(res.data.bank_info);
            $("#withdraw_modal").modal();
          }
        })
    });
    $("body").on("click",".withdraw_btn",function(){
      $("#complete_status").val($(this).data("status"));
      $(this).closest("form").submit();
    })
  });

</script>

