<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Example usage of Authorize.net's
 * Advanced Integration Method (AIM)
 */
class Check_auth extends CI_Controller
{
	// Example auth & capture of a credit card
	public function index()
	{
		// Authorize.net lib
		$this->load->library('authorize_net');

	    $data = $this->input->post();
		
		$row = get_rows("transaction",array("publish_key"=>$data['publish_key']),"date DESC",array("date"=>date("Y-m-d H:i")));
	    if($row){
	        $product = get_row("product",array("publish_key"=>$data['publish_key']));
	        redirect($product['redirect_url']);
	        exit;
	    }
	    // unset($data['card_number']); 
	    $data['expiry_date'] = $data['expiry_date_m']." / ".$data['expiry_date_y'];
	    unset($data['expiry_date_m']); 
	    unset($data['expiry_date_y']); 
	    // unset($data['cvv']); 

	    unset($data['stripeToken']); 
	    //get token, card and user info from the form
	    // $token  = $_POST['stripeToken'];
	   
	    $card_num = $_POST['card_number'];
	    $card_cvc = $_POST['cvv'];
	    $card_exp_month = $this->input->post("expiry_date_m");
	    $card_exp_year = $this->input->post("expiry_date_y");
	    if(strlen($card_exp_year) == 2) $card_exp_year = "20".$card_exp_year;
	    
	    $itemPrice = $data['price'];
        $itemNumber = "SN".date("ymdhis");

	    $email = $data['email'];
	    $auth_net = array(
			'x_card_num'			=> $card_num, // Visa
			'x_exp_date'			=> $card_exp_month."/".$card_exp_year,
			'x_card_code'			=> $card_cvc,
			'x_description'			=> 'Virsympay transaction',
			'x_amount'				=> $itemPrice,
			'x_first_name'			=> $data['first_name'],
			'x_last_name'			=> $data['last_name'],
			'x_address'				=> $data['street_address'],
			'x_city'				=> $data['city'],
			'x_state'				=> $data['state'],
			'x_zip'					=> $data['zipcode'],
			'x_country'				=> $data['country'],
			'x_phone'				=> $data['phone_number'],
			'x_email'				=> "t".$email,
			'x_customer_ip'			=> $this->input->ip_address(),
			);

		$this->authorize_net->setData($auth_net);

		// Try to AUTH_CAPTURE
		if( $this->authorize_net->authorizeAndCapture() )
		{
			// echo '<h2>Success!</h2>';
			// echo '<p>Transaction ID: ' . $this->authorize_net->getTransactionId() . '</p>';
			// echo '<p>Approval Code: ' . $this->authorize_net->getApprovalCode() . '</p>';
			$amount = $data['price'];
            $getway = $this->common_model->readData("paymentgetway",array("id"=>1));

            // $balance_transaction = $chargeJson['balance_transaction'];
            // $currency = $chargeJson['currency'];
            // $status = $chargeJson['status'];
            $data['status'] = "Paid";
            $data['date'] = date("Y-m-d H:i:s");
            $product = get_row("product",array("publish_key"=>$data['publish_key']));
            $data['user_id'] = $product['user_id'];
            $data['fee'] = ($data['price'] - $getway['checkout_fee']) * $getway['transaction_fee']/100;
            $data['price'] = $data['price'] - $getway['checkout_fee'];
            $data['payment_type'] = "checkout";
            $data['checkout_fee'] = $getway['checkout_fee'];
            // $data['card_number'] = $this->
            $row = $this->common_model->createData("transaction",$data);
            $user = get_row("member",array("id"=>$data['user_id']));
            $balance = $user['balance'];
            $balance += $data['price'] - $data['fee'];
            $this->common_model->updateData("member",array("balance"=>$balance),array("id"=>$data['user_id']));

            $customer_name = $data['first_name']." ".$data['last_name'];
            $product = get_row("product",array("publish_key"=>$data['publish_key']));
            $product_name = $product['title'];
            $template = get_row("email_template",array("id"=>1));
            $subject = $template['subject'];
            $body = nl2br($template['body']);
            $body = str_replace("{#customer_name}", $customer_name, $body);
            $body = str_replace("{#product_name}", $product_name, $body);
            $body = str_replace("{#transaction_id}", $row["id"], $body);
            sendMail($data['email'],$subject,$body);

            $merchant_name = $user['first_name']." ".$user['last_name'];
            $transaction_details = "<b>Transaction Details</b><br/>";
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

            $template = get_row("email_template",array("id"=>2));
            $subject = $template['subject'];
            $body = nl2br($template['body']);

            $body = str_replace("{#customer_name}", $customer_name, $body);
            $body = str_replace("{#merchant_name}", $merchant_name, $body);
            $body = str_replace("{#transaction_details}", $transaction_details, $body);
            $body = str_replace("{#product_details}", $product_details, $body);
            $body = str_replace("{#billing_details}", $billing_details, $body);
            sendMail($user['email'],$subject,$body,$user['id']);

            $template = get_row("email_template",array("id"=>3));
            $subject = $template['subject'];
            $body = nl2br($template['body']);

            $body = str_replace("{#customer_name}", $customer_name, $body);
            $body = str_replace("{#merchant_name}", $merchant_name, $body);
            $body = str_replace("{#transaction_details}", $transaction_details, $body);
            $body = str_replace("{#product_details}", $product_details, $body);
            $body = str_replace("{#merchant_name}", $merchant_name, $body);
            
            sendMail_to_admin($user['email'],$subject,$body);

            redirect($product['redirect_url']);

		}
		else
		{
			echo '<h2>Fail!</h2>';
			echo '<p>Your card was declined, please try again</p>';
			// Get error
			echo '<p>' . $this->authorize_net->getError() . '</p>';
			// Show debug data
			$this->authorize_net->debug();
		}
	}
	
}

/* EOF */