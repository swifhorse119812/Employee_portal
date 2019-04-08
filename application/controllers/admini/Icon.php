<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Icon extends MY_Admin_Controller {

	function __construct()
    {
        parent::__construct();
    
    }

	public function index()
	{
		$icons = $this->common_model->readDatas("icon");
		$this->load->view('admini/icon_list.php', array("icons"=>$icons));
	}

	public function Add()
	{
		$this->load->view('admini/icon_create.php');
	}

	public function uploadIcon(){
		$insertData = array();
		$insertData = $this->input->post();
		 
            
        //generate unique file name
        $fileName = time().'_'.basename($_FILES["file_name"]["name"]);
        //file upload path
        $targetDir = "assets/icons/";
        $targetFilePath = $targetDir . $fileName;
        
        //allow certain file formats
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
        $allowTypes = array('jpg','png','jpeg','gif','svg');
        $insertData['date'] = date("Y-m-d H:i:s");
		if($this->input->post("status")=="on") $insertData['status'] = 1; else $insertData['status'] = 0;

        if(in_array(strtolower($fileType), $allowTypes)){
            //upload file to server
            if(move_uploaded_file($_FILES["file_name"]["tmp_name"], $targetFilePath)){
                $insertData['file_name'] = $fileName;
                $this->common_model->createData("icon",$insertData);
                redirect(site_url()."admini/icon");
            }else{
                $error = 'err';
            }
        }else{
            $error = 'type_err';
        }
        
            //render response data in JSON format

	}
 	
 	public function deleteicon(){
 		$id = $this->input->post("icon_id");
 		$this->common_model->deleteData("icon",array("id"=>$id));
 		redirect(site_url()."admini/icon");
 	}



 	public function updateicon(){
 		// var_dump($_REQUEST);
 		// exit;
		$updateData = $this->input->post();

		$icon_data = $this->common_model->readData("icon",array("id"=>$updateData['id']));
		 
		if($this->input->post("status")=="on") $updateData['status'] = 1; else $updateData['status'] = 0;

		$id = $updateData['id'];

        if($_FILES["file_name"]["name"]){
	        //generate unique file name
	        $fileName = time().'_'.basename($_FILES["file_name"]["name"]);
	        //file upload path
	        $targetDir = "assets/icons/";
	        $targetFilePath = $targetDir . $fileName;
	        
	        //allow certain file formats
	        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
	        $allowTypes = array('jpg','png','jpeg','gif',"svg");
	        
	        if(in_array(strtolower($fileType), $allowTypes)){
	            //upload file to server
	            if(move_uploaded_file($_FILES["file_name"]["tmp_name"], $targetFilePath)){
	                $updateData['file_name'] = $fileName;
	                $this->common_model->updateData("icon",$updateData,array("id"=>$id));
	                redirect(site_url()."admini/icon");
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

	        $this->common_model->updateData("icon",$updateData,array("id"=>$id));
            redirect(site_url()."admini/icon");
	    }

            //render response data in JSON format

	}

	public function geticonData(){
		$id = $this->input->post("id");
		$row = $this->common_model->readData("icon",array("id"=>$id));
		echo json_encode(array("data"=>$row));
	}

	public function deleteiconData(){
		$id = $this->input->post("id");
		$this->common_model->deleteData("icon",array("id"=>$id));
		echo json_encode(array("data"=>"OK"));
	}

	public function profile(){
		$icon = $this->common_model->readData("icon",array("id"=>$this->session->icondata("admin_id")));
		$this->load->view("admini/profile",array("icon"=>$icon,"error"=>""));
	}

	public function updateProfile(){
 		// var_dump($_REQUEST);
 		// exit;
		$updateData = $this->input->post();

		$icon_data = $this->common_model->readData("icon",array("id"=>$updateData['id']));
		 

		$id = $updateData['id'];

        if($_FILES["file_name"]["name"]){
	        //generate unique file name
	        $fileName = time().'_'.basename($_FILES["file_name"]["name"]);
	        //file upload path
	        $targetDir = "assets/uploads/";
	        $targetFilePath = $targetDir . $fileName;
	        
	        //allow certain file formats
	        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
	        $allowTypes = array('jpg','png','jpeg','gif');
	        
	        if(in_array(strtolower($fileType), $allowTypes)){
	            //upload file to server
	            if(move_uploaded_file($_FILES["file_name"]["tmp_name"], $targetFilePath)){
	                $updateData['file_name'] = $fileName;
	                $this->common_model->updateData("icon",$updateData,array("id"=>$id));
	                redirect(site_url()."admini/icon/profile");
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

	        $this->common_model->updateData("icon",$updateData,array("id"=>$id));
            redirect(site_url()."admini/icon/profile");
	    }

            //render response data in JSON format

	}

	public function updateAccount(){
		$data = $this->input->post();
		$icon_data = $this->common_model->readData("icon",array("id"=>$this->session->icondata("admin_id")));
		$err = "";
		if($icon_data['password']!=md5($data['old_password'])) $err = "Old Password is not correct!";
		if($data['new_password']!=$data['con_password']) $err = "No mached new password!";
		if($err!=""){
			$this->common_model->updateData("icon",array("password"=>md5($data['new_password'])),array("id"=>$this->session->icondata("admin_id")));
		}
		$this->load->view("admini/profile",array("icon"=>$icon_data,"error"=>$err));

	}

}