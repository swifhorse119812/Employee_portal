<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends MY_Admin_Controller {

	function __construct()
    {
        parent::__construct();
    
    }

	public function index()
	{
		$categories = $this->common_model->readDatas("category");
		$this->load->view('admini/category_list.php', array("categories"=>$categories));
	}
	public function Add()
	{
		$this->load->view('admini/category_create.php');
	}

	public function createcategory(){
		$insertData = array();
		$insertData = $this->input->post();
		if($this->input->post("status")=="on") $insertData['status'] = 1; else $insertData['status'] = 0;
		$this->common_model->createData("category",$insertData);
 		redirect(site_url()."admini/category");
	}
 	
 	public function deleteCategory(){
 		$id = $this->input->post("id");
 		$this->common_model->deleteData("category",array("id"=>$id));
		echo json_encode(array("data"=>"OK"));
 	}

 	public function getCategoryData(){
 		$id = $this->input->post("id");
 		$data = $this->common_model->readData("category",array("id"=>$id));
 		echo json_encode(array("data"=>$data,"result"=>"ok"));
 	}

 	public function updateCategory(){
 		$id = $this->input->post("id");
 		$updateData = $this->input->post();
 		if($this->input->post("status")=="on")$updateData['status'] = 1; else $updateData['status'] = 0;
 		$this->common_model->updateData("category",$updateData,array('id'=>$id));
 		redirect(site_url()."admini/category");
 	}

 
}