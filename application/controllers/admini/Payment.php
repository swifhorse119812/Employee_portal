<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends MY_Admin_Controller {

	function __construct()
    {
        parent::__construct();
    
    }

	public function index()
	{
		$history_datas = $this->common_model->readDatas("transaction");
		$this->load->view('admini/payment_history.php', array("history_datas"=>$history_datas));
	}

	public function paymentSetting(){
		$this->load->view("admini/payment_getway");
	}

	public function updateGetway(){
		$updateData = $this->input->post();
		$this->common_model->updateData("paymentgetway",$updateData,array("id"=>1));
		redirect(site_url("admini/payment/paymentSetting"));
	}

	public function withdraw(){
		$this->load->view("admini/withdraw");
	}

	public function get_withdraw(){
		$id = $this->input->post("id");
		$withdraw = get_row("withdraw",array("id"=>$id));
		$data = array();
		$data['amount'] = $withdraw['amount'];
		$data['fee'] = $withdraw['fee'];
		$data['total'] = $withdraw['amount'] - $data['fee'];
		$member = get_row("member",array("id"=>$withdraw['user_id']));
		$data['member'] = $member['first_name']." ".$member['last_name'];
		$data['balance'] = $member['balance'];
		$bank_info = "";
		$bank = get_row("bank",array("user_id"=>$withdraw['user_id']));
		$bank_info .= "Bank Name : ".$bank['name']."\n";
		$bank_info .= "Bank Address : ".$bank['address']."\n";
		$bank_info .= "Bank Country : ".$bank['country']."\n";
		$bank_info .= "Bank Account Name : ".$bank['account_name']."\n";
		$bank_info .= "Bank Account Number : ".$bank['account_number']."\n";
		$bank_info .= "Bank Routing Number : ".$bank['routing_number']."\n";
        $bank_info .= "Bank Swift Code : ".$bank['swift_code']."\n";
		$bank_info .= "Bank Transit Number : ".$bank['transit']."\n";

		$data['bank_info'] = $bank_info;
		echo json_encode(array("data"=>$data));
	}
 	public function	withdraw_complete(){
 		$status = $this->input->post("complete_status");
 		$id = $this->input->post("id");
 		$update_data = array();
 		$update_data['complete_date'] = date("Y-m-d H:i:s");
 		$withdraw = get_row("withdraw",array("id"=>$id));
 		if($status == 1){
 			$update_data['status'] = "Complete";
 			$member = get_row("member",array("id"=>$withdraw['user_id']));
 			$balance = $member['balance'] - $withdraw['amount'];
 			$this->common_model->updateData("member",array("balance"=>$balance),array("id"=>$member['id']));

            $template = get_row("email_template",array("id"=>6));
            $subject = $template['subject'];
            $body = nl2br($template['body']);

            $body = str_replace("{#withdraw_id}", $id, $body);
            $withdraw_details = "";
            $withdraw_details = "<br><br><b>Withdraw Details</b><br/>";

            $withdraw_details .= "Requested Date : ".$update_data['request_date']."<br/>";
            $withdraw_details .= "Completed Date : ".$update_data['complete_date']."<br/>";
            $withdraw_details .= "Requested Amount : $".$withdraw['amount']."<br/>";
            $withdraw_details .= "Withdraw Fee : $".$withdraw['fee']."<br/>";
            $withdraw_details .= "Charged Price : $".($withdraw['amount']-$withdraw['fee'])."<br/>";
            $body = str_replace("{#withdraw_details}", $withdraw_details, $body);
            $user = get_row("member",array("id"=>$withdraw['user_id']));
            sendMail($user['email'],$subject,$body,$user['id']);

 		} else {
 			$update_data['status'] = "Cancel";

             $template = get_row("email_template",array("id"=>7));
            $subject = $template['subject'];
            $body = nl2br($template['body']);

            $body = str_replace("{#withdraw_id}", $id, $body);
            $withdraw_details = "";
            $withdraw_details = "<br><br><b>Withdraw Details</b><br/>";

            $withdraw_details .= "Requested Date : ".$update_data['request_date']."<br/>";
            $withdraw_details .= "Canceled Date : ".$update_data['complete_date']."<br/>";
            $withdraw_details .= "Requested Amount : $".$withdraw['amount']."<br/>";
            $withdraw_details .= "Withdraw Fee : $".$withdraw['fee']."<br/>";
            
            $body = str_replace("{#withdraw_details}", $withdraw_details, $body);
            $user = get_row("member",array("id"=>$withdraw['user_id']));
            sendMail($user['email'],$subject,$body,$user['id']);

 		}
 		$this->common_model->updateData("withdraw",$update_data,array("id"=>$id));
 		$this->common_model->updateData("transaction",array("status"=>$update_data['status']),array("id"=>$withdraw['transaction_id']));
 		redirect(site_url("admini/payment/withdraw"));
 	}

    public function refund(){
        $id = $this->input->post("id");
        $transaction = get_row("transaction",array("id"=>$id));
        $user = get_row("member",array("id"=>$transaction['user_id']));
        $row = $transaction;
        $product = get_row("product",array("publish_key"=>$transaction['publish_key']));
        $data = $transaction;

        $merchant_name = $user['first_name']." ".$user['last_name'];
        $transaction_details = "<br/><br/><b>Transaction Details</b><br/>";
        $transaction_details .= "Transaction ID : ".$row['id']."<br/>";
        $transaction_details .= "Gross : $".$row['price']."<br/>";
        $transaction_details .= "Fee : $".$row['fee']."<br/>";
        $transaction_details .= "Net : $".($row['price']-$row['fee'])."<br/>";

        $product_details = "<b>Product Details</b><br/>";
        $product_details .= "Product ID : ".$product['id']."<br/>";
        $product_details .= "Title : ".$product['title']."<br/>";
        $product_details .= "Price : $".$product['price']."<br/>";

        $billing_details = "<b>Billing Details</b><br/>";
        $billing_details .="Customer Name : ".$data['first_name']." ".$data['last_name']."<br/>";
        $billing_details .="Billing Country : ".$data['country']."<br/>";
        $billing_details .="Billing Street Address : ".$data['street_address']."<br/>";
        $billing_details .="Billing City : ".$data['city']."<br/>";
        $billing_details .="Billing State : ".$data['State']."<br/>";
        $billing_details .="Billing Postcode/zip : ".$data['zipcode']."<br/>";
        $billing_details .="Billing Phone Number : ".$data['phone_number']."<br/>";
        $billing_details .="Billing Email Address : ".$data['email']."<br/>";

        $template = get_row("email_template",array("id"=>10));
        $subject = $template['subject'];
        $body = nl2br($template['body']);
        $customer_name = $data['first_name']." ".$data['last_name'];
        $body = str_replace("{#customer_name}", $customer_name, $body);
        $body = str_replace("{#merchant_name}", $merchant_name, $body);
        $body = str_replace("{#transaction_details}", $transaction_details, $body);
        $body = str_replace("{#product_details}", $product_details, $body);
        $body = str_replace("{#billing_details}", $billing_details, $body);
        $body = str_replace("{#transaction_id}", $id, $body);

        sendMail($user['email'],$subject,$body,$user['id']);

        $this->common_model->updateData("transaction",array("status"=>"Refund","refund_date"=>date("Y-m-d H:i:s")),array("id"=>$id));
        $balance = $user['balance'];
        $balance -= ($transaction['price']-$transaction['fee']);

        $this->common_model->updateData("member",array("balance"=>$balance), array("id"=>$user['id']));
        redirect(site_url("admini/payment"));
    }

    public function request_refund(){
        $this->load->view("admini/refund");
    }

 	public function get_transaction(){
        $id = $this->input->post("id");
        $transaction = get_row("transaction",array("id"=>$id));
        $publish_key = $transaction['publish_key'];
?>
        <div class="row" style="margin: 0px;">
            <p style="font-size: 16px; padding: 10px; font-weight: 500; padding-bottom: 0px; margin-bottom: 5px;">Billing Details</p>
            <div class="col-md-6">
                First Name : <b><?php echo $transaction['first_name']; ?></b>
            </div>
            <div class="col-md-6" style="margin-bottom: 10px;">
                Last Name : <b><?php echo $transaction['last_name']; ?></b>
            </div>
            <div class="col-md-6" style="margin-bottom: 10px;">
                Email Address : <b><?php echo $transaction['email']; ?></b>
            </div>
            <div class="col-md-6" style="margin-bottom: 10px;">
                Phone Number : <b><?php echo $transaction['phone_number']; ?></b>
            </div>
            <?php 
                if($transaction['company_name']!="") {
            ?>
            <div class="col-md-12" style="margin-bottom: 10px;">
                Company Name : <b><?php echo $transaction['phone_number']; ?></b>
            </div>

            <?php                     
                }
            ?>
            <div class="col-md-12" style="margin-bottom: 10px;">
                Street Address : <b><?php echo $transaction['street_address']; ?></b>
            </div>
             <div class="col-md-12" style="margin-bottom: 10px;">
                Street Address : 
                <b>
                    <?php 
                        echo $transaction['street_address'];
                        if($transaction['home_type']!="") echo "(".$transaction['home_type'].")";
                    ?>
                 </b>
            </div>
            <div class="col-md-12" style="margin-bottom: 10px;">
                City : <b><?php echo $transaction['city']; ?></b>
            </div>
            <div class="col-md-6" style="margin-bottom: 10px;">
                State / County : <b><?php echo $transaction['state']; ?></b>
            </div>
            <div class="col-md-6" style="margin-bottom: 20px;">
                Postcode / ZIP : <b><?php echo $transaction['zipcode']; ?></b>
            </div>

             <p style="font-size: 16px; padding: 10px; font-weight: 500; padding-bottom: 0px; margin-bottom: 5px;">
             Product Details</p>
            <div class="col-md-12">
                <?php
                    $product = get_row("product",array("publish_key"=>$publish_key));
                ?>
                Product Title : <b><?php echo $product['title']; ?></b>
            </div>
            <div class="col-md-12">
                Price : <b>$<?php echo $product['price']; ?></b>
            </div>
            <div class="col-md-12">
                Description
                <p style="font-weight: 400; padding-left: 20px; font-size: 12px;">
                    <?php
                        echo nl2br($product['description']);
                    ?>
                </p>
            </div>

             <p style="font-size: 16px; padding: 10px; font-weight: 500; padding-bottom: 0px; margin-bottom: 5px;">
             Transaction Details</p>
            <div class="col-md-12">
                Gross : <b>$<?php echo $transaction['price']; ?></b>
            </div>
            <div class="col-md-12">
                Fee : <b>$<?php echo $transaction['fee']; ?></b>
            </div>
            <div class="col-md-12">
                Net : <b>$<?php echo $transaction['price']-$transaction['fee']; ?></b>
            </div>
        </div>
<?php        
    }

}