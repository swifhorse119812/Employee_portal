<?php

defined('BASEPATH') or exit('No direct script access allowed');

class AcceptTerms extends CI_Controller
{
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *      http://example.com/index.php/welcome
     *  - or -
     *      http://example.com/index.php/welcome/index
     *  - or -
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
        $this->load->view("terms");
    }

    public function accept(){
        $id = $this->session->userdata("member_id");
        $this->load->model("common_model");
        $this->common_model->updateData("member",array("approve_status"=>1),array("id"=>$id));
        $this->session->set_userdata("approve_status",1);
        $this->session->set_userdata("success","Your account is now under review, we contact once further action is needed, Thank you for choosing Virsympay");
        redirect(base_url("home"));
    }
}
