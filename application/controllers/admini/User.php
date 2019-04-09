<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Admin_Controller {

	function __construct()
    {
        parent::__construct();
    
    }

	public function index()
	{
		$users = $this->common_model->readDatas("user");
		$this->load->view('admini/user_list.php', array("users"=>$users));
	}

	public function Add()
	{
		$this->load->view('admini/user_create.php');
	}

	public function createuser(){
		$insertData = array();
		$insertData = $this->input->post();
		var_dump($insertData);exit;
		$insertData['password'] = md5($insertData['password']);
		$insertData['date']=date("y-m-d ").date("h:i:s") ;
		
            
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
                $insertData['photo'] = $fileName;
                $this->common_model->createData("user",$insertData);
                redirect(site_url()."admini/user");
            }else{
                $error = 'err';
            }
        }else{
            $error = 'type_err';
        }
        
            //render response data in JSON format

	}
 	
 	public function deleteuser(){
 		$id = $this->input->post("user_id");
 		$this->common_model->deleteData("user",array("id"=>$id));
 		redirect(site_url()."admini/user");
 	}



 	public function updateuser(){
 		// var_dump($_REQUEST);
 		// exit;
		$updateData = $this->input->post();

		$user_data = $this->common_model->readData("user",array("id"=>$updateData['id']));
		 

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
	                $this->common_model->updateData("user",$updateData,array("id"=>$id));
	                redirect(site_url()."admini/user");
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

	        $this->common_model->updateData("user",$updateData,array("id"=>$id));
            redirect(site_url()."admini/user");
	    }

            //render response data in JSON format

	}

	public function getuserData(){
		$id = $this->input->post("id");
		$row = $this->common_model->readData("user",array("id"=>$id));
		echo json_encode(array("data"=>$row));
	}

	public function deleteuserData(){
		$id = $this->input->post("id");
		$this->common_model->deleteData("user",array("id"=>$id));
		echo json_encode(array("data"=>"OK"));
	}

	public function profile(){
		$user = $this->common_model->readData("user",array("id"=>$this->session->userdata("admin_id")));
		$this->load->view("admini/profile",array("user"=>$user,"error"=>""));
	}

	public function updateProfile(){
 		// var_dump($_REQUEST);
 		// exit;
		$updateData = $this->input->post();

		$user_data = $this->common_model->readData("user",array("id"=>$updateData['id']));
		 

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
	                $this->common_model->updateData("user",$updateData,array("id"=>$id));
	                redirect(site_url()."admini/user/profile");
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

	        $this->common_model->updateData("user",$updateData,array("id"=>$id));
            redirect(site_url()."admini/user/profile");
	    }

            //render response data in JSON format

	}

	public function updateAccount(){
		$data = $this->input->post();
		$user_data = $this->common_model->readData("user",array("id"=>$this->session->userdata("admin_id")));
		$err = "";
		if($user_data['password']!=md5($data['old_password'])) $err = "Old Password is not correct!";
		if($data['new_password']!=$data['con_password']) $err = "No mached new password!";
		if($err!=""){
			$this->common_model->updateData("user",array("password"=>md5($data['new_password'])),array("id"=>$this->session->userdata("admin_id")));
		}
		$this->load->view("admini/profile",array("user"=>$user_data,"error"=>$err));

	}

	public function fast_login($member_id=""){
		$this->session->set_userdata("member_id",$member_id);
		$this->load->helper("database");
        $res = get_row("member",array("id"=>$member_id));
		$this->session->set_userdata("approve_status",$res['approve_status']);
        $this->session->set_userdata("member_status",$res['status']);
        $working_status = "yes";
        if($res['approve_status'] == 0 || $res['status']!=1) $working_status = "no";
        $this->session->set_userdata("working_status",$working_status);
		redirect(base_url());
	}
}