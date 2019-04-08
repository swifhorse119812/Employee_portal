<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Contact extends CI_Controller
{
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     *
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
    }

    public function index(){   

        $this->load->view("contact");
    }

    public function send_mail(){
        $user = get_row("member",array("id"=>$this->session->userdata("member_id")));
        $msg_subject = $this->input->post("subject");
        $msg_body = $this->input->post("message");
        $msg_body .= "\n"."From ".$user['first_name']." ".$user['last_name'];
        $msg_body = nl2br($msg_body);

        sendMail_to_admin($user['email'],$msg_subject,$msg_body,$user['id']);
        $this->session->set_userdata("success","Successfully send email to support team!");
        redirect(site_url("contact"));

    }
}
