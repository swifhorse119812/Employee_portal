<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
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
        $this->load->view("login");
    }

    public function write_comment(){
        //
        $data = $this->input->post();
        //$insert_data['id']=$data['member_id'];
        $insert_data['member_name']=$data['member_name'];
        $insert_data['commit_text']=$data['logout_comment'];
        $insert_data['commit_time']=date("Y-m-d H:i:s");
        $res = $this->common_model->createData("logout_commit",$insert_data);
        redirect(site_url("login"));
    }

    public function signup(){
        $data = $this->input->post();
        $data['date'] = date("Y-m-d H:i:s");
        $res = get_rows("member",array("email"=>$data['email']));
        if($res){
            $this->session->set_userdata('warning', "Email is exits already!");
            redirect(site_url());
        }
        $data['status'] = 0;
        $data['password'] = md5($data['password']);
        $data['balance'] = 0;
        $data['bank_account']='';
        $data['card_number']=0;
        $data['expiry_date']='00/0000';
        $data['cvv']=0;
        $data['approve_status']=1;
        $data['country']='';
		$data['city']='';
		$data['address']='';

        $res = $this->common_model->createData("member",$data);
        $this->session->set_userdata("member_id",$res['id']);

        $template = get_row("email_template",array("id"=>11));
        $subject = $template['subject'];
        $body = nl2br($template['body']);
        $merchant_name = $res['first_mame']." ".$res['last_name'];
        $body = str_replace("{#merchant_name}", $merchant_name, $body);
        sendMail($data['email'],$subject,$body,$res['id']);

        redirect(site_url("home"));
    }

    public function login(){
        $data = $this->input->post();
        $data['password'] = md5($data['password']);
        $res = get_row("member",$data);
        if($res){
            if($res['status'] == 0){
                $this->session->set_userdata('warning', "Your account was suspended!");
                redirect(site_url());
            }
            $this->session->set_userdata("member_id",$res['id']);
            $this->session->set_userdata("approve_status",$res['approve_status']);
            $this->session->set_userdata("member_status",$res['status']);
            $working_status = "yes";
            if($res['approve_status'] == 0 || $res['status']!=1) $working_status = "no";
            $this->session->set_userdata("working_status",$working_status);
            //redirect(site_url("home"));
            $tag_id=1;
            $this->load->view("order_status_list",array("tag_id"=>$tag_id));
        } else {
            $this->session->set_userdata('warning', "Invalid email or password!");
            redirect(site_url());
        }
    }
    public function logout(){
        $this->session->sess_destroy();
        redirect(site_url());
    }

    public function reset_password(){
        $email = $this->input->post("email");
        $row = get_row("member",array("email"=>$email));
        if(!$row){
            $this->session->set_userdata("warning","Don't exits email");
        } else {
            $subject = "Reset Passowrd";
            $body = "";
            $body .= "<form target='_blank' action='".base_url("home/update_password")."' method='post'>";
            $body .= "<p>If you wnat reset password, Please click Confirm button</p>";
            $body .= "<input type='password' name='password' />";
            $body .= "<input type='hidden' name='email' value='".$email."' />";
            $body .= "<button type='submit' formtarget='_blank'>Reset</button>";
            $body .= "</form>";
            sendMail($email,$subject,$body);
            $this->session->set_userdata("success","Sent email for reset password. Please check your inbox.");

        }
        redirect(site_url());
    }
    public function update_password(){
        $password = $this->input->post("password");
        $email = $this->input->post("email");
        $this->load->medel("common_model");
        $this->common_model->updateData("member",array("password"=>md5($password)),array("email"=>$email));
        $this->session->set_userdata("success","Successfully update password.");
        redirect(site_url());
    }
   
}
