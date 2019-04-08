<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
    {
        parent::__construct();
    
    }

	public function index()
	{
		 $this->load->view('admini/login.php');
	}

	public function signup(){
		$email = $this->input->post("email");
		$password = $this->input->post("password");
		$this->load->model("common_model");
		$res = $this->common_model->createData("user",array("email"=>$email, "password"=>md5($password),"date"=>date("Y-m-d h:i:s"),"roll"=>1));
		if($res){
			$this->load->view("login.php",array("result"=>"OK"));
		}
	}

	public function login(){

		$email = $this->input->post("email");
		$password = $this->input->post("password");
		$password = md5($password);

		$row = $this->common_model->readData("user",array("email"=>$email,"password"=>$password));
		
		if(!$row) $row = array();
		if(count($row)>0) {
			// var_dump($row);
			// echo $img; exit;
			$this->session->set_userdata("email",$email);
			$this->session->set_userdata("roll",$row['roll'] );
			$this->session->set_userdata("admin_id",$row['id'] );
			// $this->session->set_userdata("user_image",$row['imagename']);
			redirect(site_url()."admini/user");
		} 
		else {
		 	$this->load->view('admini/login.php');
		}
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect(site_url()."admini/dashboard");
	}
}
