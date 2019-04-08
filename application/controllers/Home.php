<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends MY_Controller
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
        $this->load->view("home");
    }
    public function get_pipe_transction_data(){
        $rows = get_rows("transaction",array("user_id"=>$this->session->userdata("member_id")));
        $data = array("sold products"=>0, "refund price"=>0, "service fee"=>0, "withdraw"=>0);
        foreach ($rows as $key => $row) {
            $name = "";
            if($row['payment_type'] == "checkout") {
                if($row['status']!="Refund")
                    $name = "sold products";
                else 
                    $name = "refund price";
                $price = $row['price'];
            } else if($row['payment_type'] == "service_fee"){
                $name = "service fee";
                $price = $row['fee'];
            } else if($row['payment_type'] == "withdraw_money"){
                if($row['status'] == "Complete") {
                    $name = "withdraw";
                    $price = $row['price'];
                }

            }
            if($name == "") continue;
            $data[$name] += $price;
        }
        $data_ = array();
        foreach ($data as $key => $value) {
            array_push($data_, array("name"=>$key,"y"=>$value));
        }
        echo json_encode($data_);
    }

    public function get_product_transction(){
        $products = get_rows("product",array("user_id"=>$this->session->userdata("member_id")));
        $data = array();
        foreach ($products as $key => $product) {
            $data_array = array();
            $data_array['name'] = $product['title'];
            $rows = get_rows("transaction",array("publish_key"=>$product['publish_key']));
            $data_array['y'] = 0;
            foreach ($rows as $row) {
                $data_array['y'] += $row['price'];
            }
            array_push($data, $data_array);
        }
        echo json_encode($data);
    }

    public function get_chart_data(){
        $rows = get_rows("transaction",array("user_id"=>$this->session->userdata("member_id"), "payment_type"=>"checkout","status!="=>"Refund"),"date ASC");
        $data = array();
        foreach ($rows as $key => $row) {
            $data_array = array();
            $date = strtotime($row['date']);
            array_push($data_array, $date*1000);
            array_push($data_array, $row['price']*1);
            array_push($data_array, $row['price']*1);
            array_push($data_array, $row['price']*1);
            array_push($data, $data_array);
        }

        echo json_encode($data);

    }
}
