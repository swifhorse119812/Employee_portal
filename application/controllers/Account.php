<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Account extends MY_Controller
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

        $this->load->view("home");
    }
    public function dashboard(){
        $this->load->view("dashboard");
    }
    public function update_profile(){
        $data = $this->input->post();
        $this->common_model->updateData("member",$data,array("id"=>$this->session->userdata("member_id")));
        $this->session->set_userdata("success","Successfully Updated!");
        redirect(site_url("account/dashboard"));
    }

    public function update_password(){
        $data = $this->input->post();
        if($data['new_password']!=$data['repeat_new_password']){
            $this->session->set_userdata('warning', "Don't same new password and new repeat password! Please try again.");
            redirect(site_url("account/dashboard"));
            return;
        }
        $res = get_row("member",array("id"=>$this->session->userdata("member_id"),"password"=>md5($data['old_password'])));
        if(!$res){
            $this->session->set_userdata('warning', "Incorrect old password! Please try again.");
            redirect(site_url("account/dashboard"));
            return;
        }
        $this->common_model->updateData("member",array("password"=>md5($data['new_password'])),array("id"=>$this->session->userdata("member_id")));
        $this->session->set_userdata("success","Successfully Updated!");
        redirect(site_url("account/dashboard"));
    }

    public function register_product(){
        $this->load->view("product");
    }

    public function order(){
        // $member = get_row("member",array("id"=>$this->session->userdata("member_id")));
        // $emp_level = $member['emp_level'];
        // if($emp_level!=2)
            $this->load->view("order");
        // else
            // $this->load->view("home");
    }
    public function order_list(){
        $this->load->view("order_list");
    }
    public function order_status_list($tag_id=""){ 
        $tag_id = 1;
        $this->load->view("order_status_list",array("tag_id"=>$tag_id));
    }
    public function update_order_state(){
        $data = $this->input->post();
        $row_datas = get_row('orders',array('id'=>$data['order_id']));
        if($data['id']==1 && $row_datas['reference_num']==0){
            $this->session->set_userdata("warning","You must enter the reference number!");
            $tag_id = 1;
            // $this->load->view("order_status_list",array("tag_id"=>$tag_id));
            //redirect(site_url("order_status_list",array("tag_id"=>$tag_id)));
            $data['names']="A";
            echo json_encode(array("data"=>$data));
        }else{

            $bal_datas = get_rows('balance_history');
            $default_balance = get_rows('balance');
            $remain_bal =  $default_balance[0]['balance'];
            foreach ($bal_datas as $key => $bal_data) {
                $remain_bal -= $bal_data['balance']; 
            }
            if($row_datas['itprice']>$remain_bal){
                $this->session->set_userdata("warning","Your order balance was flow default balance, please try again");
                redirect(site_url("home"));
            }
            else{
                $this->db->set('state', $data['id']+1);
                $this->db->where('id', $data['order_id']);
                $this->db->update('orders');

                $this->session->set_userdata("success","Successfully Updated!");
                /////////////////////////////////inserted the purchaged order's info to balance_histroy
                $rows = get_row('orders',array('id'=>$data['order_id']));
                
                $insert_data['balance']=$rows['itprice'];
                $insert_data['shipping_fee']=$rows['itshippingfee'];
                $insert_data['customer']=$rows['itcustom'];
                $insert_data['reference_num']=$rows['reference_num'];
                $insert_data['bal_date']=date("y-m-d ").date("h:i:s");
                $insert_data['order_id']=$rows['id'];
                if($rows['state']==2){
                    $this->common_model->createData("balance_history",$insert_data);
                }elseif($rows['state']==4){
                    $this->common_model->createData("shipping_history",$insert_data);
                }
                /////////////////////////////////
                $data['names']="A";
                echo json_encode(array("data"=>$data));
            }
        }
    }
    public function update_order_state_reject(){
        $data = $this->input->post();
        $row_datas = get_row('orders',array('id'=>$data['order_id']));
            
        $this->db->set('state', 0);
        $this->db->where('id', $data['order_id']);
        $this->db->update('orders');

        $this->session->set_userdata("success","Reject the Order!");
        $data['names']="A";
        echo json_encode(array("data"=>$data));

    }
    public function update_shipped_state(){
        $data = $this->input->post();

        for($i=0;$i<sizeof($data['id']);$i++){  
            $order_id = $data['id'][$i];
            $row_datas = get_row('orders',array('id'=>$order_id));

            $bal_datas = get_rows('balance_history');
            $default_balance = get_rows('balance');
            $remain_bal =  $default_balance[0]['balance'];
            foreach ($bal_datas as $key => $bal_data) {
                $remain_bal -= $bal_data['balance']; 
            }
            if($row_datas['itprice']>$remain_bal){
                //$this->session->set_userdata("warning","Your order balance was flow default balance, please try again");
                redirect(site_url("home"));
            }
            else{
                $this->db->set('state', 4);
                $this->db->where('id', $order_id);
                $this->db->update('orders');
                ///////////////////////////////inserted the purchaged order's info to balance_histroy
                $rows = get_row('orders',array('id'=>$order_id));
                
                $insert_data['balance']=$rows['itprice'];
                $insert_data['shipping_fee']=$rows['itshippingfee'];
                $insert_data['customer']=$rows['itcustom'];
                $insert_data['reference_num']=$rows['reference_num'];
                $insert_data['bal_date']=date("y-m-d ").date("h:i:s");
                $insert_data['order_id']=$rows['id'];
                if($rows['state']==2){
                    $this->common_model->createData("balance_history",$insert_data);
                }elseif($rows['state']==4){
                    $this->common_model->createData("shipping_history",$insert_data);
                }
                ///////////////////////////////
                $return_data['names']="A";
                $return_data['id']=4;
                echo json_encode(array("data"=>$return_data));
            }
        }
    }
    public function insert_referencenum(){
        $data = $this->input->post();
        $this->db->set('reference_num', $data['reference_num']);
		$this->db->where('id', $data['id']);
        $this->db->update('orders');
        $this->session->set_userdata("success","Successfully saved order reference number");
        redirect(base_url("account/order_status_list/".$data['sel_order_id']));
    }
    public function update_order_state_cancel(){
        $data = $this->input->post();
        $this->db->set('state',6);
        $this->db->set('cancel_reason',$data['cancel_reason']);
		$this->db->where('id', $data['id']);
        $this->db->update('orders');
        $data['names']="A";
        $this->session->set_userdata("success","Successfully canceled order info");
        redirect(base_url("account/order_status_list/"));
    }
    
    public function realcustomer_list(){
        // $member = get_row("member",array("id"=>$this->session->userdata("member_id")));
        // $emp_level = $member['emp_level'];
        // if($emp_level==1)
            $customers = get_rows("customer");
        // else
            // $customers = get_rows("customer",array('employee_id'=>$this->session->userdata("member_id")));
        // if($emp_level==2)
            // $this->load->view("home");
        // else
            $this->load->view("realcustomer_list",array('customers'=>$customers));
    }
    public function realcustomer_add(){
        // $member = get_row("member",array("id"=>$this->session->userdata("member_id")));
        // $emp_level = $member['emp_level'];
        // if($emp_level!=2)
            $this->load->view("createrealcustomer");
        // else
            // $this->load->view("home");
    }

    public function createrealcustomer(){
		//$insertData = array();
		$insertData = $this->input->post();
        $insertData['en_date']=date("y-m-d ").date("h:i:s");
        $insertData['employee_id'] = $this->session->userdata("member_id");
        $this->common_model->createData("customer",$insertData);
        redirect(site_url("account/realcustomer_list"));
         //render response data in JSON format
	}

    public function createorder(){
        $insertData = $this->input->post();
        $insertData['state']=1;
        $insertData['date']=date("y-m-d ").date("h:i:s") ;
        $insertData['reference_num']=0;
        $insertData['employee_id'] = $this->session->userdata("member_id");

        $user_id = $this->session->userdata("member_id");
        $rows=get_rows('orders',array('employee_id'=>$user_id));
        
        $datas = get_rows('balance_history');
        $default_balance = get_rows('balance');
        $remain_bal =  $default_balance[0]['balance'];
        foreach ($datas as $key => $data) {
            $remain_bal -= $data['balance']; 
        }
        if($insertData['itprice']>$remain_bal){
            $this->session->set_userdata("warning","Your order balance was flow default balance, please try again");
            redirect(site_url("account/order"));
        }

        $fileName = time().'_'.basename($_FILES["photo"]["name"]);
        if($fileName){
            //file upload path
            $targetDir = "assets/uploads/";
            $targetFilePath = $targetDir . $fileName;
            //allow certain file formats
            $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
            $allowTypes = array('jpg','png','jpeg','gif');    
            if(in_array(strtolower($fileType), $allowTypes)){
                //upload file to server
                if(move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFilePath)){
                    $insertData['photo'] = $fileName;
                }
            }
        }else{
            redirect(site_url("account/order"));
        }

        $this->common_model->createData("orders",$insertData);
        redirect(site_url("account/order_status_list"));
         //render response data in JSON format
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function register_customer(){
        $this->load->view("customer_list");
    }
    public function update_customer(){
        $data = $this->input->post();
        //die($data['id']);
        $id = isset($data['id'])?$data['id']:'';
        unset($data['id']);
        if($id!=''){
            $this->common_model->updateData("customers",$data,array("id"=>$id));
            $this->session->set_userdata("success","Successfully Updated!");

        } else {
            $this->common_model->createData("customers",$data);
            $this->session->set_userdata("success","Successfully registered.");
        }
        redirect(site_url("account/register_customer"));
    }
    public function get_customer(){
        $id = $this->input->post("id");
        $row = get_row("customers",array("id"=>$id));
        echo json_encode(array("data"=>$row));
    }
    public function remove_customer(){
        $this->common_model->deleteData("customers",array("id"=>$this->input->post("id")));
        $this->session->set_userdata("success","Successfully removed");
        redirect(site_url("account/customer_list"));
    }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function update_product(){
        $data = $this->input->post();
        $id = isset($data['id'])?$data['id']:'';
        unset($data['id']);
        if($id!=""){
            $this->common_model->updateData("product",$data,array("id"=>$id));
            $this->session->set_userdata("success","Successfully Updated!");

        } else {
            $con = true;
            $data['user_id'] = $this->session->userdata("member_id");
            while($con){
                $publish_key = "";
                $length = 8;
                $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
                $codeAlphabet.= "0123456789";
                $max = strlen($codeAlphabet); // edited

                for ($i=0; $i < $length; $i++) {
                    $publish_key .= $codeAlphabet[rand(0, $max-1)];
                }
                $res = get_row("product",array("publish_key"=>$publish_key));
                if(!$res){
                  $con = false;
                  break;  
                } 
            }
            $data['publish_key'] = $publish_key;
            $this->common_model->createData("product",$data);
            $this->session->set_userdata("success","Successfully registered.");
        }
        redirect(site_url("account/register_product"));
    }

    public function get_product(){
        $id = $this->input->post("id");
        $row = get_row("product",array("id"=>$id));
        echo json_encode(array("data"=>$row));
    }
    public function remove_product(){
        $this->common_model->deleteData("product",array("id"=>$this->input->post("id")));
        $this->session->set_userdata("success","Successfully removed");
        redirect(site_url("account/register_product"));
    }

    public function transaction_history(){
        $this->load->view("transaction_history");
    }

    public function withdraw_money(){
        $this->load->view("withdraw_money");
    }

    public function customer_list(){
        $this->load->view("customer_list");
    }

    public function update_bank(){
        $data = $this->input->post();
        $bank = get_row("bank",array("user_id"=>$this->session->userdata("member_id")));
        if($bank){
            $this->common_model->updateData("bank",$data,array("id"=>$bank['id']));
        } else {
            $data['user_id'] = $this->session->userdata("member_id");
            $this->common_model->createData("bank",$data);
        }
        $this->session->set_userdata("success","Successfully updated your bank account");
        redirect(site_url("account/withdraw_money"));
    }

    public function request_withdraw(){
        $amount = $this->input->post("amount");
        $member = get_row("member",array("id"=>$this->session->userdata("member_id")));
        if($amount*1>$member['balance']*1){
             $this->session->set_userdata("warning","You can't request withdraw more than $".$member['balance']." Please try again with small amount.");
             redirect(site_url("account/withdraw_money"));
        }
        $withdraw = get_row("withdraw",array("user_id"=>$this->session->userdata("member_id"),"status"=>"Pending"));
        if($withdraw){
            $this->session->set_userdata("warning","You can't request withdraw before complete preview request. Please try again later.");
             redirect(site_url("account/withdraw_money"));
        }

        $payment = get_row("paymentgetway",array("id"=>1));
        $transaction_fee = $payment['wire_fee_fix'] + $amount *  $payment['wire_fee_pro']/100;

        $data = array();
        $data['amount'] = $amount;
        $data['fee'] = $transaction_fee;
        $data['user_id'] = $this->session->userdata("member_id");
        $data['status'] = "Pending";
        $data['request_date'] = date("Y-m-d H:i:s");
        $insert_data = array();
        $insert_data['user_id'] = $data['user_id'];
        $insert_data['fee'] = $transaction_fee;
        $insert_data['payment_type'] = "withdraw_money";
        $insert_data['status'] = "Pending";
        $insert_data['date'] = $data['request_date'];
        $insert_data['price'] = $amount;
        $res = $this->common_model->createData("transaction",$insert_data);
        $data['transaction_id'] = $res['id'];

        $res = $this->common_model->createData("withdraw",$data);
        $this->session->set_userdata("success","Successfully requested withdraw money");
        redirect(site_url("account/withdraw_money"));
    }

    public function get_transaction(){
        $id = $this->input->post("id");
        $transaction = get_row("transaction",array("id"=>$id));
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
                    $publish_key = $transaction['publish_key'];
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
                Transaction ID : <b>$<?php echo $transaction['id']; ?></b>
            </div>

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


    public function card_info(){
        $this->load->view("card_info");
    }

    public function update_card_info(){
        $data = $this->input->post();
        $this->common_model->updateData("member",$data,array("id"=>$this->session->userdata("member_id")));
        $this->session->set_userdata("success","Successfully saved card info");
        redirect(site_url("account/card_info"));
    }

    public function inbox(){
        $this->load->view("inbox");
    }

    public function message_details($id=""){
        $this->common_model->updateData("message",array("status"=>2),array("id"=>$id));
        $this->load->view("message_details",array("id"=>$id));

    }

    public function message_remove($id=""){
        if($id!=""){
            $this->common_model->deleteData("message",array("id"=>$id));
            $this->session->set_userdata("success","Successfully deleted message.");
        }
        redirect(base_url("account/inbox"));
    }
    public function refund(){
        $id = $this->input->post("id");
        $this->common_model->updateData("transaction",array("status"=>"request_refund"),array("id"=>$id));
        $this->session->set_userdata("success","Successfully requested refund");
        redirect(base_url("account/transaction_history"));
    }

    public function get_email_count(){
        $email_count = get_rows_count("message",array("receiver"=>$this->session->userdata("member_id"),"status"=>1));
        echo json_encode(array("count"=>$email_count));
    }
}
