<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Help extends MY_Controller
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

    public function get_support(){
        $this->load->view("get_support");
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
    	redirect(base_url("order_status_list/".$id));
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
        $member = get_row("member",array("id"=>$this->session->userdata("member_id")));
        $emp_level = $member['emp_level'];
        //$employee_id = $this->input->post("employee_id");
        if($tag_id==""){
            if($emp_level==2)
                $tag_id=2;
            else
                $tag_id=1;
        }
    ?>
    	<table id="ticket_table" class="display" style="width:100%">
            <thead>
                <tr>
                    <?php 
                        if($tag_id==2||$tag_id==3){
                    ?>
                    <th></th>
                    <?php 
                        }
                    ?>
                    <th>Order Num</th>
                    <?php 
                        if($tag_id>3){
                    ?>
                    <th>Shipment Num</th>
                    <?php 
                        }
                    ?>
                    <th>Item Name</th>
                    <th>Item Image</th>
                    <?php
                        if($emp_level!=2){
                            echo '<th>Item Price</th>';
                            echo '<th>Item Size</th>';
                            echo '<th>Item Color</th>';
                            echo '<th>Sipping fee</th>';
                            echo '<th>Customer</th>';
                        }
                    ?>
                    <th>ReferenceNum</th>
                    <th>Status</th>
                    <?php
                        // if($tag_id==1 && $emp_level==1){
                        //     echo '<th>Edit</th>';
                        // }
                        if($tag_id==1 && $emp_level!=2){
                            echo '<th>Cancel</th>';
                        }
                        
                        if($tag_id<7)
                            echo '<th>Goto Next</th>';
                        elseif($tag_id==8)
                            echo '<th>Cancel Reason</th>';
                        if($tag_id==5 && $emp_level==1)
                            echo '<th>Reject</th>';
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                    $employee_id = $this->session->userdata("member_id");
                    if($emp_level==0)
                        $orders = get_rows("orders",array('state'=>$tag_id,'employee_id'=>$employee_id));
                    else
                        $orders = get_rows("orders",array('state'=>$tag_id));
                    foreach ($orders as $key => $order) {
                        echo "<tr data-id='".$order['id']."'>";
                        if($tag_id==2||$tag_id==3)
                            echo '<td><input type="checkbox" id="chbox" name="chbox" value="'.$order['id'].'"></td>';

                        echo '<td>'.$order['order_num'].'</td>';
                        if($tag_id>3)
                            echo '<td>'.$order['shipment_num'].'</td>';
                        echo '<td>'.$order['itname'].'</td>';
                        // echo '<td> <img src="'.base_url().'assets/uploads/'.$order["photo"].'" style="width: 50px; height:50px "></td>';
                        echo '<td> <img src="'.base_url().'assets/uploads/'.$order["photo"].'" width="50" height="50" onmouseover= "this.width=400;this.height=400;" onmouseout="this.width=50;this.height=50"></td>';
                        //echo '<td> <img id="myImg" src="'.base_url().'assets/uploads/'.$order["photo"].'" style="width: 50px; height:50px "></td>';
                        if($emp_level!=2){
                            echo '<td>$'.$order['itprice'].'</td>';
                            echo '<td>'.$order['itsize'].'</td>';
                            echo '<td>'.$order['itcolor'].'</td>';
                            echo '<td>$'.$order['itshippingfee'].'</td>';
                            echo '<td>'.$order['itcustom'].'</td>';
                        }
                        echo '<td>'.$order['reference_num'].'</td>';
                    
                        $current_state = get_rows("order_status_list",array('id'=>$tag_id));
                        if($tag_id<8)
                            $next_status = get_rows("order_status_list",array('id'=>$tag_id+1));

                        echo '<td>'.$current_state[0]["title"].'</td>';
                    
                        // if($tag_id==1&&$emp_level==1){
                        //     echo '<td><button class="btn btn-warning pull-center" id="edit_btn" >Edit</button></td>';
                        // }
                        if($tag_id==1&&$emp_level!=2){
                            echo '<td><button class="btn btn-warning pull-center" id="push_cancel" >Cancel</button></td>';
                        }
                        
                        if($tag_id==1){
                            if($emp_level==1)
                                echo '<td><button class="btn btn-warning pull-center" id="push_btn" >'.$next_status[0]["title"].'</button></td>';
                            else
                                echo '<td></td>';
                        }
                        elseif($tag_id==2){
                            if($emp_level==2)
                                echo '<td><button class="btn btn-warning pull-center" id="push_btn" >'.$next_status[0]["title"].'</button></td>';
                            else
                                echo '<td></td>';
                        }
                        elseif($tag_id==3){
                            if($emp_level==2)
                                echo '<td><button class="btn btn-warning pull-center" id="push_btn" >'.$next_status[0]["title"].'</button></td>';
                            else
                                echo '<td></td>';
                        }
                        elseif($tag_id==4){
                            if($emp_level==0){
                                echo '<td><button class="btn btn-warning pull-center" id="push_btn" >'.$next_status[0]["title"].'</button></td>';
                            }
                            else
                                echo '<td></td>';
                        }
                        elseif($tag_id==5){
                            if($emp_level==1){
                                echo '<td><button class="btn btn-warning pull-center" id="push_btn" >'.$next_status[0]["title"].'</button></td>';
                                echo '<td><button class="btn btn-warning pull-center" id="reject_btn" >Reject</button></td>';
                            }else
                                echo '<td></td>';
                        }
                        elseif($tag_id==6){
                            if($emp_level==1){
                                echo '<td><button class="btn btn-warning pull-center" id="push_btn" >'.$next_status[0]["title"].'</button></td>';
                            }else
                                echo '<td></td>';
                        }
                        // elseif($tag_id==7){
                        //     echo '<td></td>';
                        // }
                        elseif($tag_id==8)
                            echo '<td>'.$order["cancel_reason"].'</td>';
                        
                    }
                    ?>
            </tbody>
            <tfoot>
                <tr>
                    <?php 
                        if($tag_id==2||$tag_id==3){
                    ?>
                    <th></th>
                    <?php 
                        }
                    ?>
                    <th>Order Num</th>
                    <?php 
                        if($tag_id>3){
                    ?>
                    <th>Shipment Num</th>
                    <?php 
                        }
                    ?>
                    <th>Item Name</th>
                    <th>Item Image</th>
                    <?php
                        if($emp_level!=2){
                            echo '<th>Item Price</th>';
                            echo '<th>Item Size</th>';
                            echo '<th>Item Color</th>';
                            echo '<th>Sipping fee</th>';
                            echo '<th>Customer</th>';
                        }
                    ?>
                    <th>ReferenceNum</th>
                    <th>Status</th>
                    <?php
                        // if($tag_id==1 && $emp_level==1){
                        //     echo '<th>Edit</th>';
                        // }
                        if($tag_id==1 && $emp_level!=2){
                            echo '<th>Cancel</th>';
                        }
                        if($tag_id<7)
                            echo '<th>Goto Next</th>';
                         elseif($tag_id==8)
                            echo '<th>Cancel Reason</th>';
                        if($tag_id==5 && $emp_level==1)
                            echo '<th>Reject</th>';
                    ?>
                </tr>
            </tfoot>
        </table>
	 <?php

    }

    public function faq(){
        $this->load->view("faq");
    }

    public function create_question(){
        $this->load->model("common_model");
        $data = $this->input->post();
        $id = $data['id'];
        unset($data['id']);
        $data['status'] = 1;
        if($id!=""){
            $res = get_row("questions",array("id"=>$id));
            $this->common_model->updateData("questions",$data,array("id"=>$id));
            if($res['status'] == 0){

                $template = get_row("email_template",array("id"=>9));
                $subject = $template['subject'];
                $body = nl2br($template['body']);
                $user = get_row("member",array("id"=>$this->session->userdata("member_id")));
                $user_name = $user['first_name']." ".$user['last_name'];
                $ticket_datais = "";
                $ticket_datais.= "<b>Ticket ID </b> : #".$id."<br/>";
                $tag = get_row("help_tag",array("id"=>$data['tag_id']));
                $ticket_datais.= "<b>Issue Type </b> : ".$tag['title']."<br/>";
                $ticket_datais.= "<b>Title </b> : ".$data['title']."<br/>";
                $ticket_datais.= "<b>Content </b> :<br/>";
                $ticket_datais.= "<div>".$data['content']."</div>";
                $ticket_url = '<a href="'.base_url("admini/help/answer/".$id).'">Ticket URL</a>';
                $body = str_replace("{#merchant_name}", $user_name, $body);
                $body = str_replace("{#ticket_details}", $ticket_datais, $body);
                $body = str_replace("{#ticket_url}", $ticket_url, $body);
                sendMail_to_admin($user['email'],$subject,$body,$this->session->userdata("member_id"));
                redirect(base_url("help/thanks"));
                exit;
            }
            $this->session->set_userdata("success","Successfully updated question");


        } else {
            $data['user_id'] = $this->session->userdata("member_id");
            $data['date'] = date("Y-m-d H:i:s");
            $this->common_model->createData("questions",$data);
            $this->session->set_userdata("success","Successfully created new question");

        }
        redirect(base_url("help/faq"));
    }

 

    public function before_question(){
        // $this->common_model->deleteData("questions",array("user_id"=>$this->session->userdata("member_id"), 'status'=>0));
        $res = get_row("questions",array("user_id"=>$this->session->userdata("member_id"), 'status'=>0));
        if($res){

        } else {
            $data = array("user_id"=>$this->session->userdata("member_id"));
            $data['date'] = date("Y-m-d H:i:s");
            $res = $this->common_model->createData("questions",$data);
        }
        echo json_encode(array("data"=>$res));
    }

    public function get_question(){
        $id = $this->input->post("id");
        $data = get_row("questions",array("id"=>$id));
        echo json_encode(array("data"=>$data));
    }

    public function remove_question(){
        $id = $this->input->post("id");
        $this->load->model("common_model");
        $this->common_model->deleteData("questions",array("id"=>$id));
        $this->session->set_userdata("success","Successfully deleted");
        echo json_encode(array("res"=>"ok"));
        exit;
    }

    public function answer($id=""){
        $this->load->view("answer",array("id"=>$id));
    }

    public function save_answer(){

        $data = $this->input->post();
        $url = $data['url'];
        unset($data['url']);

        $data['date'] = date("Y-m-d H:i:s");
        $data['user_id'] = $this->session->userdata("member_id");
        $data['user_type']="member";
        $this->load->model("common_model");
        $this->common_model->createData("answers",$data);
        $this->session->set_userdata("success","Successfully posted your answer");
        redirect(base_url($url));
    }

    public function thanks(){
        $this->load->view("thanks");
    }

    public function notification(){
        //$this->load->view("thanks");
        if(isset($_POST['view'])){

            $shipping_datas = get_rows('shipping_history');
            $count = sizeof($shipping_datas);
            $output = '';
            if($count){
                foreach($shipping_datas as $shipping_data){
                    $output .= '<li style="color:black;"><strong> Order '.$shipping_data["order_id"].' is shipped</strong></li>';
                }
            }else{
                $output .= '<li style="color:black;"><a href="#" class="text-bold text-italic">No Noti Found</a></li>';
            }
    
            $data = array(
                'notification' => $output,
                'unseen_notification'  => $count
            );
            echo json_encode($data);
        }
    }
}
