<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends MY_Admin_Controller {

	function __construct()
    {
        parent::__construct();
    
    }

	public function index()
	{
		$id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
		if($id == "")
		 	$this->load->view("admini/inbox");
		else {
            $this->common_model->updateData("message",array("status"=>2),array("id"=>$id));
       	 	$this->load->view("admini/message_details",array("id"=>$id));
        }

	}
 
 	public function message_details($id=""){
        $this->common_model->updateData("message",array("status"=>2),array("id"=>$id));
        $this->load->view("admini/message_details",array("id"=>$id));

    }

    public function message_remove($id=""){
        if($id!=""){
            $this->common_model->deleteData("message",array("id"=>$id));
            // $this->session->set_userdata("success","Successfully deleted message.");
        }
        redirect(base_url("admini/inbox"));
    }

    public function sent(){
        $this->load->view("admini/sent");
    }
 

    public function sent_message($id=""){
        $this->common_model->updateData("message",array("status"=>2),array("id"=>$id));
        $this->load->view("admini/message_details_sent",array("id"=>$id));
    }

    public function message_remove_sent($id=""){
        if($id!=""){
            $this->common_model->deleteData("message",array("id"=>$id));
            // $this->session->set_userdata("success","Successfully deleted message.");
        }
        redirect(base_url("admini/message/sent"));
    }

    public function compose(){
        $this->load->view("admini/compose");
    }
    public function send_mail(){
        $id = $this->input->post("user_id");
        if($id == -1){
            $users = get_rows("member");
            foreach ($users as $key => $user) {
                sendMail($user['email'],$this->input->post("subject"), $this->input->post("body"), $user['id']);
            }
        } else {
            $user = get_row("member",array("id"=>$id));
            sendMail($user['email'],$this->input->post("subject"), $this->input->post("body"), $id);
        }
        redirect(base_url("admini/message/compose"));
    }
    public function reply($message_id = ""){
        $this->load->view("admini/reply",array("message_id"=>$message_id));
    }
}
