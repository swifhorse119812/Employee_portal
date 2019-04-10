<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Realcustomer extends MY_Admin_Controller {

	function __construct()
    {
        parent::__construct();
    
    }

	public function index()
	{
		echo 234234234;exit;
		//$members = $this->common_model->readDatas("member");
		//$this->load->view('admini/member_list.php', array("members"=>$members));
		$this->load->view('realcustomer.php');
	}

	public function Add()
	{
		$this->load->view('realcustomer.php');
	}
	public function list()
	{
		echo 2324242;exit;
		//$this->load->view('realcustomer.php');
	}

	public function createcustomer(){
		$insertData = array();
		$insertData = $this->input->post();
		var_dump($insertData);exit;
		$insertData['password'] = md5($insertData['password']);
		$insertData['date']=date("Y-m-d H:i:s") ;
		//------ edit info --------------
		$insertData['status']= 1 ;
		$insertData['balance']=0 ;
		$insertData['bank_account']= "" ;
		$insertData['card_number']=0;
		$insertData['expiry_date']="00/0000";
		$insertData['cvv']=0;
		$insertData['approve_status']=0;
 
        $this->common_model->createData("member",$insertData);
        redirect(site_url()."admini/customer");
       

	}
 	
 	public function deletemember(){
 		$id = $this->input->post("member_id");
 		$this->common_model->deleteData("member",array("id"=>$id));
 		redirect(site_url()."admini/member");
 	}



 	public function updatemember(){
 		// var_dump($_REQUEST);
 		// exit;
		$updateData = $this->input->post();
		$id = $this->input->post("id");
        $this->common_model->updateData("member",$updateData,array("id"=>$id));
        redirect(site_url()."admini/customer");
	}

	public function getmemberData(){
		$id = $this->input->post("id");
		$row = $this->common_model->readData("member",array("id"=>$id));
		echo json_encode(array("data"=>$row));
	}

	public function deletememberData(){
		$id = $this->input->post("id");
		$this->common_model->deleteData("member",array("id"=>$id));
		echo json_encode(array("data"=>"OK"));
	}

	public function profile(){
		$member = $this->common_model->readData("member",array("id"=>$this->session->memberdata("admin_id")));
		$this->load->view("admini/profile",array("member"=>$member,"error"=>""));
	}

	public function updateProfile(){
 		// var_dump($_REQUEST);
 		// exit;
		$updateData = $this->input->post();

		$member_data = $this->common_model->readData("member",array("id"=>$updateData['id']));
		 

		$id = $updateData['id'];

        if($_FILES["photo"]["name"]){
	        //generate unique file name
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
	                $updateData['photo'] = $fileName;
	                $this->common_model->updateData("member",$updateData,array("id"=>$id));
	                redirect(site_url()."admini/member/profile");
	            }else{
	                $error = 'err';
	                echo $error;
	            }
	        }else{
	            $error = 'type_err';
	            echo $error;
	        }
	    } else {
			// $updateData['imagename'] = $updateData['imagenamesave'];

	        $this->common_model->updateData("member",$updateData,array("id"=>$id));
            redirect(site_url()."admini/member/profile");
	    }

            //render response data in JSON format

	}

	public function updateAccount(){
		$data = $this->input->post();
		$member_data = $this->common_model->readData("member",array("id"=>$this->session->memberdata("admin_id")));
		$err = "";
		if($member_data['password']!=md5($data['old_password'])) $err = "Old Password is not correct!";
		if($data['new_password']!=$data['con_password']) $err = "No mached new password!";
		if($err!=""){
			$this->common_model->updateData("member",array("password"=>md5($data['new_password'])),array("id"=>$this->session->memberdata("admin_id")));
		}
		$this->load->view("admini/profile",array("member"=>$member_data,"error"=>$err));
	}

	public function get_card_info(){
		$user_id = $this->input->post("id");
		$card_info = get_row("member",array("id"=>$user_id));
		// if(!$card_info){
		// 	$card_info = array("card_number"=>"","expiry_date"=>"","cvv"=>"");
		// }
		echo json_encode(array("data"=>$card_info));
	}

	public function get_bank_info(){
		$user_id = $this->input->post("id");
		$bank_info = get_row("bank",array("user_id"=>$user_id));
		if(!$bank_info){
			$bank_info = array("name"=>"","address"=>"","country"=>"","account_name"=>"","account_number"=>"","routing_number"=>"","swift_code"=>"");
		}
		echo json_encode(array("data"=>$bank_info));
	}

	public function suspend_member(){
		$id = $this->input->post("id");
		// $status = $this->input->post("status");
		$this->common_model->updateData("member",array("approve_status"=>2),array("id"=>$id));
		echo json_encode(array("status"=>"ok"));
	}
}