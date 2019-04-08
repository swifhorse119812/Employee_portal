<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Checkout_iPay extends CI_Controller
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

        $data = $this->input->post();
        //check whether stripe token is not empty
        try {
               
                $row = get_rows("transaction",array("publish_key"=>$data['publish_key']),"date DESC",array("date"=>date("Y-m-d H:i")));
                if($row){
                    $product = get_row("product",array("publish_key"=>$data['publish_key']));
                    redirect($product['redirect_url']);
                    exit;
                }
                // You can call our API following curl post example
                $url = "https://ipaytotal.solutions/api/transaction";
                $key = "LuhulYIzBEUfof8jDHTgztIycjRCMRRsKYLR8NQfHyfjG1QwQHGcvrduX3aScH7b";
                // Fill with real customer info
                
                $data = $this->input->post();
                $data['expiry_date'] = $data['expiry_date_m']." / ".$data['expiry_date_y'];
                unset($data['expiry_date_m']); 
                unset($data['expiry_date_y']); 

                $card_num = $_POST['card_number'];
                $card_cvc = $_POST['cvv'];
                $card_exp_month = $this->input->post("expiry_date_m");
                $card_exp_year = $this->input->post("expiry_date_y");
                if(strlen($card_exp_year) == 2) $card_exp_year = "20".$card_exp_year;
                
                $email = $data['email'];
                // echo $this->session->userdata("email");
                // exit;
                //include Stripe PHP library
               
                $getway = $this->common_model->readData("paymentgetway",array("id"=>1));
                $itemPrice = $data['price'];
 
                $card_data = [
                    'api_key' => $key,
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'address' => $data['street_address'],
                    'sulte_apt_no' => '',
                    'country' => $data['country'],
                    'state' => $data['state'], // if your country US then use only 2 letter state code.
                    'city' => $data['city'],
                    'zip' => $data['zipcode'],
                    'ip_address' => $this->input->ip_address(),
                    'birth_date' => '',
                    'email' => $email,
                    'phone_no' => $data['phone_number'],
                    // 'card_type' => '2', // See your card type in list
                    'amount' => $itemPrice,
                    'currency' => 'USD',
                    'card_no' => $card_num,
                    'ccExpiryMonth' => $card_exp_month,
                    'ccExpiryYear' => $card_exp_year,
                    'cvvNumber' => $card_cvc,
                    'shipping_first_name' => $data['first_name'],
                    'shipping_last_name' => $data['last_name'],
                    'shipping_address' => $data['street_address'],
                    'shipping_country' => $data['country'],
                    'shipping_state' => $data['state'],
                    'shipping_city' => $data['city'],
                    'shipping_zip' => $data['zipcode'],
                    'shipping_email' => $email,
                    'shipping_phone_no' => $data['phone_number'],
                ];

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($card_data));
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_HTTPHEADER,[
                    'Content-Type: application/json'
                ]);
                $response = curl_exec($curl);
                curl_close($curl);

                $responseData = json_decode($response);
//                 print_r($responseData);
// stdClass Object ( [status] => fail [message] => Your card was declined. Your request was in live mode, but used a known test card. [order_id] => )
//                 exit;
                $status = !empty($responseData->status)?$responseData->status:'';
                $order_id = !empty($responseData->order_id)?$responseData->order_id:'';
                if($status ="fail")
                {
                    //order details 
                    $amount = $itemPrice;
                    $data['status'] = "Paid";
                    $data['date'] = date("Y-m-d H:i:s");
                    $product = get_row("product",array("publish_key"=>$data['publish_key']));
                    $data['user_id'] = $product['user_id'];
                    $data['fee'] = ($data['price'] - $getway['checkout_fee']) * $getway['transaction_fee']/100;
                    $data['price'] = $data['price'] - $getway['checkout_fee'];
                    $data['payment_type'] = "checkout";
                    $data['checkout_fee'] = $getway['checkout_fee'];
                    $data['order_id'] = $order_id;
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
            } else {
                $this->session->set_userdata("warning","Your card was declined, please try again");
                redirect(site_url("checkout/?publish_key=".$data['publish_key']));
            }
           
        } catch (Exception $ex) {
             $this->session->set_userdata("warning","Your card was declined, please try again");
            redirect(site_url("checkout/?publish_key=".$data['publish_key']));

        }


    }

}
