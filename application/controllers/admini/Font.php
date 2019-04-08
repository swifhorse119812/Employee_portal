<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Font extends MY_Admin_Controller {

	function __construct()
    {
        parent::__construct();
    
    }

	public function index()
	{
		$fonts = $this->common_model->readDatas("font");
		$this->load->view('admini/font_list.php', array("fonts"=>$fonts));
	}

	public function Add()
	{
		$this->load->view('admini/font_create.php');
	}

	public function uploadfont(){
		$insertData = array();
		$insertData = $this->input->post();
		 
            
        //generate unique file name
        $fileName = time().'_'.basename($_FILES["file_name"]["name"]);
        $fileName = str_replace(" ", "_", $fileName);
        //file upload path
        $targetDir = "assets/fonts/";
        $targetFilePath = $targetDir . $fileName;
        
        //allow certain file formats
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
        $allowTypes = array('ttf','otf','woff','woff2','svg');
        // $insertData['date'] = date("Y-m-d H:i:s");
		if($this->input->post("status")=="on") $insertData['status'] = 1; else $insertData['status'] = 0;

        if(in_array(strtolower($fileType), $allowTypes)){
            //upload file to server
            if(move_uploaded_file($_FILES["file_name"]["tmp_name"], $targetFilePath)){
                $insertData['file_name'] = str_replace(" ", "_", $fileName);

                $this->common_model->createData("font",$insertData);
                redirect(site_url()."admini/font");
            }else{
                $error = 'err';
            }
        }else{
            $error = 'type_err';
        }
        
            //render response data in JSON format

	}
 	
 	public function deletefont(){
 		$id = $this->input->post("font_id");
 		$this->common_model->deleteData("font",array("id"=>$id));
 		redirect(site_url()."admini/font");
 	}



 	public function updatefont(){
 		// var_dump($_REQUEST);
 		// exit;
		$updateData = $this->input->post();

		$font_data = $this->common_model->readData("font",array("id"=>$updateData['id']));
		 
		if($this->input->post("status")=="on") $updateData['status'] = 1; else $updateData['status'] = 0;

		$id = $updateData['id'];

        if($_FILES["file_name"]["name"]){
	        //generate unique file name
	        $fileName = time().'_'.basename($_FILES["file_name"]["name"]);
	        //file upload path
	        $targetDir = "assets/fonts/";
	        $targetFilePath = $targetDir . $fileName;
	        
	        //allow certain file formats
	        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
	        $allowTypes = array('jpg','png','jpeg','gif',"svg");
	        
	        if(in_array(strtolower($fileType), $allowTypes)){
	            //upload file to server
	            if(move_uploaded_file($_FILES["file_name"]["tmp_name"], $targetFilePath)){
	                $updateData['file_name'] = $fileName;
	                $this->common_model->updateData("font",$updateData,array("id"=>$id));
	                redirect(site_url()."admini/font");
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

	        $this->common_model->updateData("font",$updateData,array("id"=>$id));
            redirect(site_url()."admini/font");
	    }

            //render response data in JSON format

	}

	public function getfontData(){
		$id = $this->input->post("id");
		$row = $this->common_model->readData("font",array("id"=>$id));
		echo json_encode(array("data"=>$row));
	}

	public function deletefontData(){
		$id = $this->input->post("id");
		$this->common_model->deleteData("font",array("id"=>$id));
		echo json_encode(array("data"=>"OK"));
	}

	public function profile(){
		$font = $this->common_model->readData("font",array("id"=>$this->session->fontdata("admin_id")));
		$this->load->view("admini/profile",array("font"=>$font,"error"=>""));
	}

	public function updateProfile(){
 		// var_dump($_REQUEST);
 		// exit;
		$updateData = $this->input->post();

		$font_data = $this->common_model->readData("font",array("id"=>$updateData['id']));
		 

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
	                $this->common_model->updateData("font",$updateData,array("id"=>$id));
	                redirect(site_url()."admini/font/profile");
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

	        $this->common_model->updateData("font",$updateData,array("id"=>$id));
            redirect(site_url()."admini/font/profile");
	    }

            //render response data in JSON format

	}

	public function updateAccount(){
		$data = $this->input->post();
		$font_data = $this->common_model->readData("font",array("id"=>$this->session->fontdata("admin_id")));
		$err = "";
		if($font_data['password']!=md5($data['old_password'])) $err = "Old Password is not correct!";
		if($data['new_password']!=$data['con_password']) $err = "No mached new password!";
		if($err!=""){
			$this->common_model->updateData("font",array("password"=>md5($data['new_password'])),array("id"=>$this->session->fontdata("admin_id")));
		}
		$this->load->view("admini/profile",array("font"=>$font_data,"error"=>$err));

	}

}