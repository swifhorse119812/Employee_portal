<?php 

defined('BASEPATH') or exit('No direct script access allowed');

class Orders extends MY_Controller
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

    // public function index123()
	// {
	// 	$status = 0;
	// 	$members = $this->common_model->readDatas("member",array("approve_status!="=>$status));
	// 	$this->load->view('admini/member_list.php', array("members"=>$members));
	// }

    public function index(){

        $this->load->view("admini/orders_lists");
    }
   
    public function order(){
        $this->load->view("admini/order");
    }
    public function order_list(){ 
        $this->load->view("admini/order_lists");
    }
    public function shipping_list(){ 
        $this->load->view("admini/order_shipping_list");
    }
    
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

}
