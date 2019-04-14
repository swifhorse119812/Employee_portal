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
	public function bal_setting()
	{
		$this->load->view('admini/balancesetting.php');
	}
	public function report_ballance()
	{
		//$setting = $this->common_model->readData("setting",array('id'=>1));
		$datas = get_rows('balance_history');
		$default_balance = get_rows('balance');
		$this->load->view('admini/report_ballance.php',array("datas"=>$datas,"default_balance"=>$default_balance));
	}
	public function addbalance()
	{
		$insert_data = $this->input->post();
		$add_bal_str = " BALANCE ADDED $".$insert_data['balance'];
		$default_balance = get_rows('balance');
		$datas = get_rows('balance_history');
		// $remain_bal =  $default_balance[0]['balance'];
		// foreach ($datas as $key => $data) 
		// 	$remain_bal -= $data['balance']; 
		// echo $remain_bal;
		// var_dump($datas);exit;
		$insert_data['balance'] += $default_balance[0]['balance'];
		$insert_data['id']=1;
		$balancesetting = $this->common_model->readData("balance",array("id"=>1));
		if($balancesetting) {
			$this->common_model->updateData("balance",$insert_data);
			$this->session->set_userdata("success",$add_bal_str);
		} else {
			$insert_data['id'] = 1;
			 $this->common_model->createData("balance",$insert_data);
			 $this->session->set_userdata("success",$add_bal_str);
		}
		$add_bal_history['add_bal']=$add_bal_str;
		$add_bal_history['add_date']=date("y-m-d ").date("h:i:s");
		$this->common_model->createData("add_bal_history",$add_bal_history);
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