<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Admin_Controller {

	function __construct()
    {
    	ini_set("max_execution_time","-1");
	    ini_set("max_input_time","-1");
	    ini_set("memory_limit","15G");
	    ini_set("post_max_size","15G");
	    ini_set("upload_max_filesize","15G");
        parent::__construct();
    
    }

	public function index()
	{
		$this->load->view("admini/dashboard");

	}
	public function get_chart_data(){
		$rows = get_rows("transaction",array("payment_type"=>"checkout","status!="=>"Refund"),"date ASC");
		$data = array();
		foreach ($rows as $key => $row) {
			$data_array = array();
			$date = strtotime($row['date']);
			array_push($data_array, $date*1000);
			array_push($data_array, $row['price']*1);
			array_push($data_array, $row['price']*1);
			array_push($data_array, $row['price']*1);
			array_push($data, $data_array);
		}

		echo json_encode($data);
	}
	public function get_pipe_data(){
		$members = get_rows("member");
		$data = array();
		foreach ($members as $key => $member) {
			$data_array = array();
			$data_array['name'] = $member['first_name']." ".$member['last_name'];
			$rows = get_rows("transaction",array("user_id"=>$member['id'], "payment_type"=>"checkout","status!="=>"Refund"),"date ASC");
			$data_array['y'] = 0;
			foreach ($rows as $key => $row) {
				$data_array['y'] += $row['price'];
			}
			array_push($data, $data_array);

		}
		echo json_encode($data);
	}

	public function download_report(){
		$data = $this->input->post();
		$date1 = strtotime($data['from_date']);
		$from_date = date("Y-m-d",$date1);

		$date1 = strtotime($data['to_date']);
		$to_date = date("Y-m-d 23:59:59",$date1);
		
		if($data['date_type'] == 1){
			$from_date = date("Y-01-01");
			$to_date = date("Y-m-d 23:59:59");
		}

		if($data['date_type'] == 2){
			$from_date = date("Y-m-01");
			$to_date = date("Y-m-d 23:59:59");
		}

		if($data['date_type'] == 4){
			$from_date = date("Y-m-d");
			$to_date = date("Y-m-d 23:59:59");
		}
		
		if($data['date_type'] == 3){
			$first_day_of_the_week = 'Sunday';
            $start_of_the_week     = strtotime("Last $first_day_of_the_week");
            if ( strtolower(date('l')) === strtolower($first_day_of_the_week) )
            {
                $start_of_the_week = strtotime('today');
            }
            $end_of_the_week = $start_of_the_week + (60 * 60 * 24 * 7) - 1;
            // $date_format =  'l jS \of F Y h:i:s A';
            $from_date =  date("Y-m-d", $start_of_the_week);
            $to_date = date("Y-m-d 23:59:59", $end_of_the_week);
		}
 
	    ini_set("max_execution_time","-1");
	    ini_set("max_input_time","-1");
	    ini_set("memory_limit","15G");
	    ini_set("post_max_size","15G");
	    ini_set("upload_max_filesize","15G");
	    set_time_limit(100000);
	    $report_type = $this->input->post("report_type");
	    $download_type = $this->input->post("download_type");
	    
	    if($download_type == 1){
			$html = $this->load->view('admini/'.$report_type,array("from_date"=>$from_date,"to_date"=>$to_date),TRUE);
		    $this->load->library('pdf');
	        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
			$pdf->SetTitle('My Title');
			$pdf->SetHeaderMargin(30);
			// $pdf->SetTopMargin(0);
			// $pdf->setFooterMargin(0);
			$pdf->SetAutoPageBreak(true);
			$pdf->SetAuthor('Author');
			// $pdf->SetDisplayMode('real', 'default');
			$pdf->AddPage();
			 
			$pdf->writeHTML($html, true, false, false, false, '');
			$pdf->Output($report_type.'.pdf', 'D');
		} else {
			$this->load->view('admini/'.$report_type."_excel",array("from_date"=>$from_date,"to_date"=>$to_date),TRUE);

		}

	}

	public function download_pdf($filename){
		$filename1 = "reports/".$filename;
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Content-type: application/pdf');
		readfile(base_url().$filename1);
		die();
	}

	public function print_data(){
?>

<?php
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
  th{
  	color: 
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
                            <th>Transaction Date</th>
                            <th>Customer Name</th>
                            <th>email</th>
                            <th>phone number</th>
                            <th>Card Number</th>
                            <th>Gross</th>
                            
                            <th>Status</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php
                                $transactions = get_rows("transaction",array(),"date DESC");
                                foreach ($transactions as $key => $transaction) {
                                	if(strtotime($transaction['date'])<=strtotime(date("Y-m-d")." 00:00:00")) continue;
                                  $member = get_row("member",array("id"=>$transaction['user_id']));
                                    echo "<tr class='".$transaction['status']."'>";
                                    echo '<td>'.$transaction['date'].'</td>';
                                    if($transaction['payment_type'] == "checkout"){
                                        echo '<td><span class="customer-details" data-id="'.$transaction['id'].'" data-publish_key="'.$transaction['publish_key'].'" data-status="'.$transaction['status'].'">'.$transaction['first_name']." ".$transaction['last_name'].'</span></td>';
                                        $card_number = "";
                                        echo '<td>'.$transaction['email'].'</td>';
                                        echo '<td>'.$transaction['phone_number'].'</td>';
                                        echo '<td>'.$transaction['card_number'].'</td>';

                                        echo '<td>$'.($transaction['price'] + $transaction['checkout_fee'] ).'USD</td>';
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
 
</script>


<?php

	}

}
