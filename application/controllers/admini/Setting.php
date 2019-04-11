<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends MY_Admin_Controller {

	function __construct()
    {
        parent::__construct();
    
    }

	public function index()
	{
		$setting = $this->common_model->readData("setting",array('id'=>1));
		$this->load->view('admini/setting.php', array("setting"=>$setting));
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

	public function statussetting($tag_id=""){
        $this->load->view("admini/statussetting",array("tag_id"=>$tag_id));
	}
	
	public function tag_create(){
    	$title = $this->input->post("title");
        $id = $this->input->post("id");
    	$this->load->model("common_model");
    	if($id==""){
    		$res = $this->common_model->createData("order_status_list",array("title"=>$title));
    		$id = $res['id'];
    	} else {
    		$this->common_model->updateData("order_status_list",array("title"=>$title),array("id"=>$id));
    	}
    	redirect(base_url("admini/setting/statussetting/".$id));
    }

    public function get_tag(){
        $id = $this->input->post("id");
        $row = get_row("order_status_list",array("id"=>$id));
    	echo json_encode(array("data"=>$row));
    }

    public function remove_tag(){
    	$id = $this->input->post("id");
    	$this->load->model("common_model");
    	$this->common_model->deleteData("order_status_list",array("id"=>$id));
    	echo json_encode(array("status"=>"OK"));
    }

    public function get_tag_table(){
        $tag_id = $this->input->post("tag_id");
        if($tag_id=="")$tag_id=1;
    ?>
    	<table id="ticket_table" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Item ID</th>
                    <th>Item Name</th>
                    <th>Item Image</th>
                    <th>Item Price</th>
                    <th>Item Size</th>
                    <th>Item Color</th>
                    <th>Sipping fee</th>
                    <th>Customer</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php
            //$orders = get_rows("orders",array("user_id"=>$this->session->userdata("member_id")));
            $orders = get_rows("orders",array('state'=>$tag_id));
            //var_dump($orders);exit;
            foreach ($orders as $key => $order) {
                echo "<tr data-id='".$order['id']."'>";
                echo '<td>'.$order['id'].'</td>';
                echo '<td>'.$order['itname'].'</td>';
                //echo '<td>'.$order['photo'].'</td>';
                echo '<td> <img src="'.base_url().'assets/uploads/'.$order["photo"].'" style="width: 50px; height:50px "/></td>';
                
                echo '<td>$'.$order['itprice'].'</td>';
                echo '<td>'.$order['itsize'].'</td>';
                echo '<td>'.$order['itcolor'].'</td>';
                echo '<td>$'.$order['itshippingfee'].'</td>';
                echo '<td>'.$order['itcustom'].'</td>';
                $status = get_rows("order_status_list",array('id'=>$tag_id));
                echo '<td>'.$status[0]["title"].'</td>';
                echo "</tr>";
            }
            ?>
            </tbody>
            <tfoot>
                <tr>
                <th>Item ID</th>
                    <th>Item Name</th>
                    <th>Item Image</th>
                    <th>Item Price</th>
                    <th>Item Size</th>
                    <th>Item Color</th>
                    <th>Sipping fee</th>
                    <th>Customer</th>
                    <th>Status</th>
                </tr>
            </tfoot>
        </table>
	 <?php

    }
}