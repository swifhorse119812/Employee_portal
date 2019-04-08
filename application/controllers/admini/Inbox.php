<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inbox extends MY_Admin_Controller {

	function __construct()
    {
        parent::__construct();
    
    }

	public function index()
	{
		$id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
		if($id == "")
		 	$this->load->view("admini/inbox");
		else 
       	 	$this->load->view("admini/message_details",array("id"=>$id));

	}
 
 	public function message_details($id=""){
        // $this->common_model->updateData("message",array("status"=>2),array("id"=>$id));
        $this->load->view("admini/message_details",array("id"=>$id));

    }

    public function message_remove($id=""){
        if($id!=""){
            $this->common_model->deleteData("message",array("id"=>$id));
            $this->session->set_userdata("success","Successfully deleted message.");
        }
        redirect(base_url("admini/inbox"));
    }

    public function get_email_count(){
        $email_count = get_rows_count("message",array("receiver"=>"admin","status"=>1));
        echo json_encode(array("count"=>$email_count));
    }

 
}
