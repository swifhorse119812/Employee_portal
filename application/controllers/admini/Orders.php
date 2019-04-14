<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Orders extends MY_Controller
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

        $this->load->view("orders");
    }
   
    // public function update_profile(){
    //     $data = $this->input->post();
	// 	$this->db->set('status', $data['id']+1);
	// 	$this->db->where('id', $id);
	// 	$this->db->update('order');
    //     $this->common_model->updateData("member",$data,array("id"=>$this->session->userdata("member_id")));
    //     $this->session->set_userdata("success","Successfully Updated!");
    //     redirect(site_url("account/dashboard"));
    // }

    // public function update_password(){
    //     $data = $this->input->post();
    //     if($data['new_password']!=$data['repeat_new_password']){
    //         $this->session->set_userdata('warning', "Don't same new password and new repeat password! Please try again.");
    //         redirect(site_url("account/dashboard"));
    //         return;
    //     }
    //     $res = get_row("member",array("id"=>$this->session->userdata("member_id"),"password"=>md5($data['old_password'])));
    //     if(!$res){
    //         $this->session->set_userdata('warning', "Incorrect old password! Please try again.");
    //         redirect(site_url("account/dashboard"));
    //         return;
    //     }
    //     $this->common_model->updateData("member",array("password"=>md5($data['new_password'])),array("id"=>$this->session->userdata("member_id")));
    //     $this->session->set_userdata("success","Successfully Updated!");
    //     redirect(site_url("account/dashboard"));
    // }

    // public function register_product(){
    //     $this->load->view("product");
    // }

    public function order(){
        $this->load->view("admini/order");
    }
    public function order_list(){ 
        $this->load->view("admini/order_list");
    }
    public function shipping_list(){ 
        $this->load->view("admini/order_shipping_list");
    }
    public function order_status_list($tag_id=""){
        $this->load->view("order_status_list",array("tag_id"=>$tag_id));
    }
    public function update_order_state(){
        $data = $this->input->post();
        $this->db->set('state', $data['id']+1);
		$this->db->where('id', $data['order_id']);
        $this->db->update('orders');
        $data['names']="A";
        //$this->session->set_userdata("success","Successfully saved card info");
        //redirect(base_url("account/order_status_list/".$data['id']+1));
        echo json_encode(array("data"=>$data));
    }
    public function update_order_state_cancel(){
        $data = $this->input->post();
        $this->db->set('state',6);
		$this->db->where('id', $data['order_id']);
        $this->db->update('orders');
        $data['names']="A";
        //$this->session->set_userdata("success","Successfully saved card info");
        //redirect(base_url("account/order_status_list/".$data['id']+1));
        echo json_encode(array("data"=>$data));
    }
    
    public function realcustomer_list(){
        $this->load->view("realcustomer_list");
    }
    public function realcustomer_add(){
        $this->load->view("createrealcustomer");
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
		//$insertData = array();
        $insertData = $this->input->post();
        //var_dump($insertData);exit;
        $insertData['state']=1;
        $insertData['date']=date("y-m-d ").date("h:i:s") ;
        $insertData['employee_id'] = $this->session->userdata("member_id");

        $user_id = $this->session->userdata("member_id");
        $rows=get_rows('orders',array('employee_id'=>$user_id));
        $balance = 0;
        foreach($rows as $row){
            if($row['employee_id']==$user_id)
                $balance += $row['itprice'];
        }
        $toatal_balance = $balance + $insertData['itprice'];
        $default_balance = get_row('balance',array('id'=>1));
        if($toatal_balance>$default_balance['balance']){
            $this->session->set_userdata("warning","Your order balance was flow default balance, please try again");
            redirect(site_url("home"));
        }

        $fileName = time().'_'.basename($_FILES["photo"]["name"]);
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
        $this->common_model->createData("orders",$insertData);
        redirect(site_url("account/order_list"));
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

}
