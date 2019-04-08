<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Checkout extends CI_Controller
{
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     *
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
    }

    public function index(){   
        $this->load->view("checkout");
    }

    public function pay()
    {

        try {
            if(!empty($_POST['stripeToken']))
            {   
                $row = get_rows("transaction",array("publish_key"=>$data['publish_key']),"date DESC",array("date"=>date("Y-m-d H:i")));
                if($row){
                    $product = get_row("product",array("publish_key"=>$data['publish_key']));
                    redirect($product['redirect_url']);
                    exit;
                }
                $data = $this->input->post();
                // unset($data['card_number']); 
                $data['expiry_date'] = $data['expiry_date_m']." / ".$data['expiry_date_y'];
                unset($data['expiry_date_m']); 
                unset($data['expiry_date_y']); 
                // unset($data['cvv']); 

                unset($data['stripeToken']); 
                //get token, card and user info from the form
                $token  = $_POST['stripeToken'];
               
                $card_num = $_POST['card_number'];
                $card_cvc = $_POST['cvv'];
                $card_exp_month = $this->input->post("expiry_date_m");
                $card_exp_year = $this->input->post("expiry_date_y");
                if(strlen($card_exp_year) == 2) $card_exp_year = "20".$card_exp_year;
                
                $email = $data['email'];
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
                    'email' => "",
                    'source'  => $token
                ));
                
                //item information
                $itemName = "Stripe Donation";

                $getway = $this->common_model->readData("paymentgetway",array("id"=>1));
                $itemPrice = $data['price'];
                $itemPrice *= 100;
                $itemNumber = "SN".date("ymdhis");
                
                //charge a credit or a debit card
                $charge = \Stripe\Charge::create(array(
                    'customer' => $customer->id,
                    'amount'   => $itemPrice,
                    'currency' => "USD",
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
                    echo "Invalid Token";
                    $statusMsg = "";

                     $this->session->set_userdata("warning","Your card was declined, please try again");
                     redirect(site_url("checkout/?publish_key=".$data['publish_key']));

                }
            } 
           
        } catch (Exception $ex) {
             $this->session->set_userdata("warning","Your card was declined, please try again");
            redirect(site_url("checkout/?publish_key=".$data['publish_key']));

        }


    }

}
