<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stripe extends CI_Controller {

	public function index()
	{
		$this->load->view('product_form');		
	}

	public function check()
	{
		//check whether stripe token is not empty
		if(!empty($_POST['stripeToken']))
		{
			//get token, card and user info from the form
			$token  = $_POST['stripeToken'];
			$name = $_POST['user_name'];
			$password = md5($_POST['password']);
			$email = $_POST['email'];
			
			$card_num = $_POST['card_num'];
			$card_cvc = $_POST['cvc'];
			$exp_date = explode("/",$_POST['expiry_date']);
			$card_exp_month = $exp_date[0];
			$card_exp_year =  $exp_date[1];
			
			if($this->session->userdata("email")){
				$email = $this->session->userdata("email");
			}

			// echo $this->session->userdata("email");
			// exit;
			//include Stripe PHP library
			require_once APPPATH."third_party/stripe/init.php";
			
			//set api key
  			
  			$getway = $this->common_model->readData("paymentgetway",array("id"=>1));

			$stripe = array(
			  "secret_key"      => $getway['stripe_secret_key'],
			  "publishable_key" => $getway['stripe_publish_key']
			);
			
			\Stripe\Stripe::setApiKey($stripe['secret_key']);
			
			//add customer to stripe
			$customer = \Stripe\Customer::create(array(
				'email' => $email,
				'source'  => $token
			));
			
			//item information
			$itemName = "Stripe Donation";

			$getway = $this->common_model->readData("paymentgetway",array("id"=>1));

			$itemNumber = "SN".date("ymdhis");
			$itemPrice = $getway['service_fee'];
			$currency = "eur";
			$orderID = "SKA92712382139";
			$id = $this->session->userdata("user_id");
			$itemPrice *= 100;
			
			//charge a credit or a debit card
			$charge = \Stripe\Charge::create(array(
				'customer' => $customer->id,
				'amount'   => $itemPrice,
				'currency' => $currency,
				'description' => $itemNumber,
				'metadata' => array(
					'item_id' => $itemNumber
				)
			));
			
			//retrieve charge details
			$chargeJson = $charge->jsonSerialize();

			//check whether the charge is successful
			if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1)
			{
				//order details 
				$amount = $chargeJson['amount'];
				$balance_transaction = $chargeJson['balance_transaction'];
				$currency = $chargeJson['currency'];
				$status = $chargeJson['status'];

				if(!$this->session->userdata("user_id")){
					$member = $this->common_model->readData("member", array("email"=>$email,"password"=>$password));
					if(!$member){
						$insertData = array();
						$insertData['email'] = $email;
						$insertData['password'] = $password;
						$insertData['user_name'] = $name;
						$insertData['date'] = date("Y-m-d H:i:s");
						$member = $this->common_model->createData("member",$insertData);
					}
					$this->session->set_userdata("user_id",$member['id']);
				}


				$insertData = array();
	            $insertData['member_id'] = $this->session->userdata("user_id");
	            $template = $this->common_model->readData("template",array("id"=>1));

	            $insertData['content'] = $template['content'];
	            $insertData['icon_content'] = $template['icon_content'];
            	$insertData['type'] = $template['title']."^".$template['subtitle'];
	            $insertData['price'] = $amount/100;
	            $insertData['create_date'] = date("Y-m-d h:i:s");
	            $insertData['payment_id'] = $itemNumber;
	            $insertData['payment_type'] = "Stripe Card";

	            $this->common_model->createData("transaction",$insertData);


	           //  $this->common_model->updateData("carbooking",array("status"=>2),array("id"=>$id));
              	
            //   	$booking_data = $this->common_model->readData("carbooking",array("id"=>$id));
	           //  $custom_email_data = $this->common_model->readData("email_templates",array("template_name"=>"to customer when complete rental"));
	           //  $customer_data = $this->common_model->readData("member",array("id"=>$booking_data['custom_id']));
	           //  $car_data = $this->common_model->readData("cars",array("id"=>$booking_data['car_id']));
	           //  $this->sendMail($customer_data['email'],str_replace("{customer_name}", $customer_data['firstname']." ".$customer_data['lastname'], $custom_email_data['subject']),str_replace("{car name}",$car_data['cartitle'],$custom_email_data['content']));



            // $owner_email_data = $this->common_model->readData("email_templates",array("template_name"=>"to owner when complete rental"));
            // $owner_data = $this->common_model->readData("member",array("id"=>$booking_data['owner_id']));
            
            // $this->sendMail($owner_data['email'],str_replace("{customer_name}", $owner_data['firstname']." ".$owner_data['lastname'], $owner_email_data['subject']),$owner_email_data['content']);
 			$this->session->set_userdata("download_flg",1);
            $this->session->set_userdata("login_flg",1);
            $res = $this->common_model->readData("member",array("id"=>$this->session->userdata("user_id")));
            $this->session->set_userdata("email",$res['email']);
            $this->session->set_userdata("user_name",$res['user_name']);
            // http://localhost/logomaker/
            if($this->session->userdata("lang") != "FR") 
                redirect(site_url()."ViewLogos/EN");
            else 
                redirect(site_url()."ViewLogos/FR");


			}
			else
			{
				echo "Invalid Token";
				$statusMsg = "";
			}
		}
        redirect('site/rental/paymentBook/'.$id);

	}


    public function sendMail($email,$msg_subject,$msg_body){
        
            // $this->load->library("mandrill",array("6f27336f1823492fe6e59d4a5656"));
            // $params = array(
            //     "html" => "<p>\r\n\tHi Adam,</p>\r\n<p>\r\n\tThanks for <a    href=\"http://mandrill.com\">registering</a>.</p>\r\n<p>etc etc</p>",
            //     "text" => null,
            //     "from_email" => "xxx@xxx.example.com",
            //     "from_name" => "chris french",
            //     "subject" => "Your recent registration",
            //     "to" => array(array("email" => $email)),
            //     "track_opens" => true,
            //     "track_clicks" => true,
            //     "auto_text" => true
            // );
            // $this->mandrill->messages->send($params, true);



        $this->load->library('email');
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['useragent'] = 'l33t Mailer 1.0';
        $config['priority'] = 5;
        $this->email->initialize($config);

    
        $this->email->set_mailtype("html");
        

        $this->email->from(get_site_sadmin());
        $this->email->to($email);
        $this->email->cc($email);

        $this->email->subject($msg_subject);
        $this->email->message($msg_body);
        $this->email->send();
         
    }
    

	public function payment_success()
	{
		$this->load->view('payment_success');
	}

	public function payment_error()
	{
		$this->load->view('payment_error');
	}

	public function help()
	{
		$this->load->view('help');
	}
}
