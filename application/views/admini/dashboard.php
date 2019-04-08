<?php
  $this->load->view("common/header.php");
?>
<style type="text/css">

</style>
	<div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left" style="width: 100%;">
                <h3 >
                  Reports
                  <a class="btn btn-primary pull-right" id="download_btn"><i class="fa fa-download"></i> Download Report</a>
                </h3>
              </div>
            </div>
            <?php
                $payment = get_row("paymentgetway",array("id"=>1));
                $fee = $payment['checkout_fee'];
                $transactions = get_rows("transaction",array("payment_type"=>"checkout","status!="=>"Refund"),"date DESC");
                $day_data = array();
                $day = "";
                $row = array();
                $no = 0;
                $row['date'] = "";
                $row['sold_amout'] = 0;
                $row['total_price'] = 0;
                $total_price = 0;
                $total_sold = 0;

                $total_price_year = 0;
                $total_sold_year= 0;
                $total_price_month = 0;
                $total_sold_month = 0;
                $total_price_week = 0;
                $total_sold_week = 0;
                $total_price_day = 0;
                $total_sold_day = 0;

                $total_checkout_fee = 0;
                $total_checkout_fee_year = 0;
                $total_checkout_fee_month = 0;
                $total_checkout_fee_week = 0;
                $total_checkout_fee_day = 0;

                $first_day_of_the_week = 'Sunday';
                $start_of_the_week     = strtotime("Last $first_day_of_the_week");
                if ( strtolower(date('l')) === strtolower($first_day_of_the_week) )
                {
                    $start_of_the_week = strtotime('today');
                }
                $end_of_the_week = $start_of_the_week + (60 * 60 * 24 * 7) - 1;
                // $date_format =  'l jS \of F Y h:i:s A';
                $first_date =  date("Y-m-d", $start_of_the_week);
                $end_date = date("Y-m-d", $end_of_the_week);
                

                foreach ($transactions as $key => $transaction) {
                  $total_price += $transaction['price']+$transaction['checkout_fee'];
                  $total_sold ++;
                  $total_checkout_fee += $transaction['checkout_fee'];
                  if(strpos($transaction['date'], date("Y-"))!== false){
                    $total_price_year += $transaction['price']+$transaction['checkout_fee'];
                    $total_sold_year ++;
                    $total_checkout_fee_year += $transaction['checkout_fee'];
                  }

                  if(strpos($transaction['date'], date("Y-m-"))!== false){
                    $total_price_month += $transaction['price']+$transaction['checkout_fee'];
                    $total_sold_month ++;
                    $total_checkout_fee_month += $transaction['checkout_fee'];

                  }

                  if(strpos($transaction['date'], date("Y-m-d"))!== false){
                    $total_price_day += $transaction['price']+$transaction['checkout_fee'];
                    $total_sold_day ++;
                    $total_checkout_fee_day += $transaction['checkout_fee'];

                  }

                  if($first_date<=$transaction['date']&&$end_date>=$transaction['date']){
                    $total_price_week += $transaction['price']+$transaction['checkout_fee'];
                    $total_checkout_fee_week += $transaction['checkout_fee'];
                    $total_sold_week ++;
                  }


                  $t_day = substr($transaction['date'],0,10);
                  if($day!=$t_day){
                    $no++;
                    if($no!=1){
                      array_push($day_data, $row);
                    }
                    $day = $t_day;
                    $row['date'] = $t_day;
                    $row['sold_amout'] = 0;
                    $row['total_price'] = 0;
                  }
                  $row['sold_amout'] ++;
                  $row['total_price'] += $transaction['price']+$transaction['checkout_fee'];
                }
                if($row["sold_amout"]!=0){
                  array_push($day_data, $row);
                }

                $transactions = get_rows("transaction");
                $total_transaction_fee = 0;
                $total_transaction_fee_year = 0;
                $total_transaction_fee_month = 0;
                $total_transaction_fee_week = 0;
                $total_transaction_fee_day = 0;

                foreach ($transactions as $key => $transaction) {
                  $fee = $transaction['fee'];
                  $total_transaction_fee += $fee;
                  if(strpos($transaction['date'], date("Y-"))!== false){
                    $total_transaction_fee_year += $fee;
                   
                  }

                  if(strpos($transaction['date'], date("Y-m-"))!== false){
                    $total_transaction_fee_month += $fee;
                     
                  }

                  if(strpos($transaction['date'], date("Y-m-d"))!== false){
                    $total_transaction_fee_day += $fee;
                  }

                  if($first_date<=$transaction['date']&&$end_date>=$transaction['date']){
                    $total_transaction_fee_week += $fee;
                  }
                }

                $transactions = get_rows("transaction",array("payment_type"=>"service_fee"));
                $total_service_fee = 0;
                $total_service_fee_year = 0;
                $total_service_fee_month = 0;

                foreach ($transactions as $key => $transaction) {
                  $fee = $transaction['fee'];
                  $total_service_fee += $fee;
                  if(strpos($transaction['date'], date("Y-"))!== false){
                    $total_service_fee_year += $fee;
                  }

                  if(strpos($transaction['date'], date("Y-m-"))!== false){
                    $total_service_fee_month += $fee;
                     
                  }
                }


            ?>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-4" style="padding: 10px;">
                <div style="border: 1px solid #ccc;padding: 30px 20px;height: 160px;">
                  <div style="font-size: 25px;border-bottom: 1px solid #e0dede;padding-bottom: 10px;">
                    Total Checkout Fee
                    <span class="pull-right text-success">$<?php echo $total_checkout_fee; ?></span>
                  </div>
                  <div style="width: 100%;margin-top: 40px;font-size: 14px;">
                    <span class="pull-right" style="margin-left: 10px;">Today : <span class="text-success">$<?php echo $total_checkout_fee_day; ?></span></span>
                    <span class="pull-right" style="margin-left: 10px;">This Week : <span class="text-success">$<?php echo $total_checkout_fee_week; ?></span></span>
                    <span class="pull-right" style="margin-left: 10px;">This Month : <span class="text-success">$<?php echo $total_checkout_fee_month; ?></span></span>
                    <span class="pull-right" style="margin-left: 10px;">This Year : <span class="text-success">$<?php echo $total_checkout_fee_year; ?></span></span>
                  </div>
                </div>
              </div>
              <div class="col-md-4" style="padding: 10px;">
                <div style="border: 1px solid #ccc;padding: 30px 20px;height: 160px;">
                  <div style="font-size: 25px;border-bottom: 1px solid #e0dede;padding-bottom: 10px;">
                    Total Transaction Fee
                    <span class="pull-right text-info">$<?php echo $total_transaction_fee; ?></span>
                  </div>
                  <div style="width: 100%;margin-top: 40px;font-size: 14px;">
                    <span class="pull-right" style="margin-left: 10px;">Today : <span class="text-info">$<?php echo $total_transaction_fee_day; ?></span></span>
                    <span class="pull-right" style="margin-left: 10px;">This Week : <span class="text-info">$<?php echo $total_transaction_fee_week; ?></span></span>
                    <span class="pull-right" style="margin-left: 10px;">This Month : <span class="text-info">$<?php echo $total_transaction_fee_month; ?></span></span>
                    <span class="pull-right" style="margin-left: 10px;">This Year : <span class="text-info">$<?php echo $total_transaction_fee_year; ?></span></span>
                  </div>
                </div>
              </div>
              <div class="col-md-4" style="padding: 10px;">
                <div style="border: 1px solid #ccc;padding: 30px 20px;height: 160px;">
                  <div style="font-size: 25px;border-bottom: 1px solid #e0dede;padding-bottom: 10px;">
                    Total Service Fee
                    <span class="pull-right text-warning">$<?php echo $total_service_fee; ?></span>
                  </div>
                  <div style="width: 100%;margin-top: 40px;font-size: 14px;">
                    <span class="pull-right" style="margin-left: 10px;">This Month : <span class="text-warning">$<?php echo $total_service_fee_month; ?></span></span>
                    <span class="pull-right" style="margin-left: 10px;">This Year : <span class="text-warning">$<?php echo $total_service_fee_year; ?></span></span>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4" style="padding: 10px;">
                <div style="border: 1px solid #ccc;padding: 30px 20px;height: 160px;">
                  <div style="font-size: 25px;border-bottom: 1px solid #e0dede;padding-bottom: 10px;">
                    Total Price
                    <span class="pull-right text-success">$<?php echo $total_price; ?></span>
                  </div>
                  <div style="width: 100%;margin-top: 40px;font-size: 14px;">
                    <span class="pull-right" style="margin-left: 10px;">Today : <span class="text-success">$<?php echo $total_price_day; ?></span></span>
                    <span class="pull-right" style="margin-left: 10px;">This Week : <span class="text-success">$<?php echo $total_price_week; ?></span></span>
                    <span class="pull-right" style="margin-left: 10px;">This Month : <span class="text-success">$<?php echo $total_price_month; ?></span></span>
                    <span class="pull-right" style="margin-left: 10px;">This Year : <span class="text-success">$<?php echo $total_price_year; ?></span></span>
                  </div>
                </div>
                <div style="border: 1px solid #ccc;padding: 30px 20px;height: 160px; margin-top: 20px;">
                  <div style="font-size: 25px;border-bottom: 1px solid #e0dede;padding-bottom: 10px;">
                    Total Sold Amount
                    <span class="pull-right text-warning"><?php echo $total_sold; ?></span>
                  </div>
                  <div style="width: 100%;margin-top: 40px;font-size: 14px;">
                    <span class="pull-right" style="margin-left: 10px;">Today : <span class="text-warning"><?php echo $total_sold_day; ?></span></span>
                    <span class="pull-right" style="margin-left: 10px;">This Week : <span class="text-warning"><?php echo $total_sold_week; ?></span></span>
                    <span class="pull-right" style="margin-left: 10px;">This Month : <span class="text-warning"><?php echo $total_sold_month; ?></span></span>
                    <span class="pull-right" style="margin-left: 10px;">This Year : <span class="text-warning"><?php echo $total_sold_year; ?></span></span>
                  </div>
                </div>
              </div>

             <!--  <div class="col-md-4" style="padding: 10px;">
                <div style="border: 1px solid #ccc;padding: 30px 20px;height: 160px;">
                  <div style="font-size: 25px;border-bottom: 1px solid #e0dede;padding-bottom: 10px;">
                    Total Merchants
                    <span class="pull-right text-warning"><?php echo $total_sold; ?></span>
                  </div>
                  <div style="width: 100%;margin-top: 40px;font-size: 14px;">
                    <span class="pull-right" style="margin-left: 10px;">Today : <span class="text-warning"><?php echo $total_sold_day; ?></span></span>
                    <span class="pull-right" style="margin-left: 10px;">This Week : <span class="text-warning"><?php echo $total_sold_week; ?></span></span>
                    <span class="pull-right" style="margin-left: 10px;">This Month : <span class="text-warning"><?php echo $total_sold_month; ?></span></span>
                    <span class="pull-right" style="margin-left: 10px;">This Year : <span class="text-warning"><?php echo $total_sold_year; ?></span></span>
                  </div>
                </div>
              </div> -->
              <div class="col-md-8">
                <div id="pip_chart" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto">
                  
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div style="height: 400px; border: 1px solid #ccc;" id="chart_div">
                  
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
              <div class="table-responsive">
                <p style="margin-bottom: 10px; font-size: 20px; margin-top: 50px;">
                  Product Transactions by each date
                </p>
                      <table id="example" class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings" style="background-color:#24652e">
                            <th>Date</th>
                            <th>Sold Products Amount</th>
                            <th>Total Sold Price</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php
                            
                              foreach ($day_data as $key => $row) {
                                echo "<tr>";
                                echo "<td>".$row['date']."</td>";
                                echo "<td>".$row['sold_amout']."</td>";
                                echo "<td>$".$row['total_price']."</td>";
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
 
 
<style type="text/css">

</style>
<div class="modal fade in" id="report_modal" aria-hidden="false" style="display: none;">
  <div class="modal-dialog" style="width: 700px;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
            <h3 class="modal-title">Download Report</h3>
        </div>
        <form id="report_form" name="report_form" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo site_url("admini/dashboard/download_report"); ?>" method="post" enctype="multipart/form-data" target="_blank">

        <div class="modal-body" style="padding: 10px 0px;">
         <!--  <img id="featureimage" src=""/> -->
                 
          <div class="form-group" style="padding: 20px 40px; padding-bottom: 10px;">
              <div class="radio radio-primary">
                 <input type="radio" name="date_type" id="date_type_year" value="1" checked="">
                 <label for="date_type_year" style="padding-left: 0px !important;">
                    This Year 
                </label>
              </div>
              <div class="radio radio-primary">
                 <input type="radio" name="date_type" id="date_type_month" value="2">
                 <label for="date_type_month" style="padding-left: 0px !important;">
                    This Month 
                </label>
              </div>
              <div class="radio radio-primary">
                 <input type="radio" name="date_type" id="date_type_week" value="3">
                 <label for="date_type_week" style="padding-left: 0px !important;">
                    This Week 
                </label>
              </div>
              <div class="radio radio-primary">
                 <input type="radio" name="date_type" id="date_type_day" value="4">
                 <label for="date_type_day" style="padding-left: 0px !important;">
                    Today
                </label>
              </div>
              <div class="radio radio-primary" >
                 <input type="radio" name="date_type" id="date_type_special" value="5">
                 <label for="date_type_special" style="padding-left: 0px !important;">
                    Special Data
                </label>
              </div>
          </div>    
          <div class="form-group" style="padding: 0px 20px; display: none;" id="date_wrap">
                <label for="date_type_special">
                  From
                </label>
                <input type="date" name="from_date" id="from_date" class="" value="<?php echo date("m/01/Y"); ?>">
                &nbsp;&nbsp;
                <label for="date_type_special">
                  To
                </label>
                <input type="date" name="to_date" id="to_date" class="">
          </div>
          <div class="form-group" style="padding: 0px 20px; ">
            <label>Select Report</label>
            <select class="form-control" name="report_type">
              <option value="download_transaction">
                Tranasction Details
              </option>
              <option value="download_refunds">
                Refunds
              </option>
              <option value="download_checkout_fee">
                Checkout Fee
              </option>
              <option value="download_transaction_fee">
                Transaction Fee
              </option>
              <option value="download_wire_fee">
                Wire transfer fee
              </option>
              <option value="download_product_sold">
                Product Sold
              </option>
              
            </select>
          </div>
        </div>
        <input type="hidden" name="download_type" id="download_type">
        <div class="modal-footer">
          <?php
            $getway = get_row("paymentgetway",array("id"=>1));
          ?>
             <button type="button" class="btn btn-info submit_btn" data-value="1" style="<?php if($getway['download_type'] == 2) echo 'display: none;' ?>"><i class="fa fa-download"></i> Download PDF</button>
             <button type="button" class="btn btn-info submit_btn" data-value="2" style="<?php if($getway['download_type'] == 1) echo 'display: none;' ?>"><i class="fa fa-download"></i> Download CSV</button>
              <button type="button" class="btn" id="remove_btn" style="margin-right: 20px;" data-dismiss="modal">Cancel</button>
        </div>
      </form>

    </div>
  </div>
</div>


<?php
	$this->load->view("common/footer.php");
?>
<script src="<?php echo base_url("assets/code/highstock.js"); ?>"></script>
<script src="<?php echo base_url("assets/code/modules/exporting.js"); ?>"></script>
<script src="<?php echo base_url("assets/code/modules/export-data.js"); ?>"></script>

<script type="text/javascript">

   $.extend( true, $.fn.dataTable.defaults, {
        "searching": true,
        "ordering": false
    } );

  $('document').ready(function(){

    $("body").on("click","input[name='date_type']",function(){
      $("#date_wrap").hide();
      $("input[type='date']").removeAttr("required");
      if($(this).val() == 5){
        $("#date_wrap").show();
        $("input[type='date']").attr("required",true);
      }

    })
    $("body").on("click","#download_btn",function(){
        $("#report_form")[0].reset();
        $("#date_wrap").hide();
        $("input[type='date']").removeAttr("required");
        // var today = new Date();
        // $("#from_date").val(today.toISOString().substr(0, 10));

        $("#report_modal").modal();
    })

    $(".body").on("click",".submit_btn",function(){
      $("#download_type").val($(this).data("value"));
      $("#report_form")[0].submit();
    })

 if( typeof ($.fn.DataTable) === 'undefined'){ return; }
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

$.getJSON('<?php echo base_url("admini/dashboard/get_chart_data"); ?>', function (data) {

// $.getJSON('https://www.highcharts.com/samples/data/aapl-c.json', function (data) {
    // Create the chart
    Highcharts.stockChart('chart_div', {


        rangeSelector: {
            buttons: [{
                type: 'day',
                count: 1,
                text: '1D'
            }, {
                type: 'week',
                count: 1,
                text: '1W'
            }, 
      {
                type: 'month',
                count: 1,
                text: '1M'
            }, 
      {
                type: 'all',
                count: 1,
                text: 'All'
            }],
            selected: 1,
            inputEnabled: true
        },

        title: {
            text: 'Transaction on Virsympay'
        },
    
      series: [{
            name: 'Gross Price',
            data: data,
            type: 'areaspline',
            threshold: null,
            tooltip: {
                valueDecimals: 2
            },
            fillColor: {
                linearGradient: {
                    x1: 0,
                    y1: 0,
                    x2: 0,
                    y2: 1
                },
                stops: [
                    [0, Highcharts.getOptions().colors[0]],
                    [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                ]
            }
        }]
    });
});
 
$.getJSON('<?php echo base_url("admini/dashboard/get_pipe_data"); ?>', function (data) {

  // Build the chart
  Highcharts.chart('pip_chart', {
      chart: {
          plotBackgroundColor: null,
          plotBorderWidth: null,
          plotShadow: false,
          type: 'pie'
      },
      title: {
          text: 'Merchants Transaction'
      },
      tooltip: {
          pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
      },
      plotOptions: {
          pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                  enabled: true,
                  format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                  style: {
                      color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                  },
                  connectorColor: 'silver'
              }
          }
      },
      series: [{
          name: 'Share',
          data:  data
      }]
  });
});


})

</script>

