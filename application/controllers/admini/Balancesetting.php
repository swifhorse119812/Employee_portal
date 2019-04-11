<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Balancesetting extends MY_Admin_Controller {

	function __construct()
    {
        parent::__construct();
    
    }

	public function index()
	{
		//$setting = $this->common_model->readData("setting",array('id'=>1));
		$this->load->view('admini/balancesetting.php');
	}
	public function addbalance()
	{
		$insert_data = $this->input->post();
		$insert_data['id']=1;
		$balancesetting = $this->common_model->readData("balance",array("id"=>1));
		if($balancesetting) {
			$this->common_model->updateData("balance",$insert_data);
		} else {
			$insert_data['id'] = 1;
		 	$this->common_model->createData("balance",$insert_data);
		}
		redirect(site_url("admini/balancesetting"));
	}

	public function Add()
	{
		$insert_data = $this->input->post();
		$setting = $this->common_model->readData("setting",array("id"=>1));

		if($setting) {
			$this->common_model->updateData("setting",$insert_data);
		} else {
			$insert_data['id'] = 1;
			$this->common_model->createData("setting",$insert_data);
		}
		redirect(site_url("admini/setting"));
	}

	public function email_template(){
		$this->load->view('admini/email_template');
	}

	public function update_template(){
		$id = $this->input->post("id");
		$row = get_row("email_template",array("id"=>$id));
		$data = $this->input->post();
		if($row){
			$this->common_model->updateData("email_template",$data,array("id"=>$id));
		} else {
			$this->common_model->createData("email_template",$data);
		}
		redirect(site_url("admini/setting/email_template"));
	}
}