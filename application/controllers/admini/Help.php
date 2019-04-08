<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Help extends MY_Admin_Controller {

	function __construct()
    {
        parent::__construct();
    
    }

	public function index()
	{
	 
		
		$this->load->view("admini/dashboard");
	 	// $this->load->view('front/carsearch.php',array("searchDate"=>$insertData));

	}

 	public function create_question(){
        $this->load->model("common_model");
        $data = $this->input->post();
        $id = $data['id'];
        unset($data['id']);
        if($id!=""){
            $this->common_model->updateData("questions",$data,array("id"=>$id));

        } else {
            $data['user_id'] = $this->session->userdata("member_id");
            $data['date'] = date("Y-m-d H:i:s");
            $this->common_model->createData("questions",$data);

        }
        redirect(base_url("admini/help/faq"));
    }


    public function get_support($tag_id=""){
    	$this->load->view("admini/get_support",array("tag_id"=>$tag_id));
    }

    public function faq(){
        $this->load->view("admini/faq");
    }

      
    public function remove_ticket(){
        $id = $this->input->post("id");
        $this->load->model("common_model");
        $this->common_model->deleteData("help_ticket",array("id"=>$id));
        echo json_encode(array("res"=>"ok"));
        exit;
    }

    public function answer($id=""){
        $this->load->view("admini/answer",array("id"=>$id));
    }

    public function save_answer(){

        $data = $this->input->post();
        $url = $data['url'];
        unset($data['url']);

        $data['date'] = date("Y-m-d H:i:s");
        $data['user_id'] = "";
        $data['user_type']="admin";
        $this->load->model("common_model");
        $this->common_model->createData("answers",$data);
        redirect(base_url($url));
    }
    public function remove_answer(){
    	$id = $this->input->post("id");
    	$this->load->model("common_model");
    	$this->common_model->deleteData("answers",array("id"=>$id));
    	echo json_encode(array("status"=>"ok"));
    }

    public function tag_create(){
    	$title = $this->input->post("title");
    	$id = $this->input->post("id");
    	$this->load->model("common_model");
    	if($id==""){
    		$res = $this->common_model->createData("help_tag",array("title"=>$title));
    		$id = $res['id'];
    	} else {
    		$this->common_model->updateData("help_tag",array("title"=>$title),array("id"=>$id));
    	}
    	redirect(base_url("admini/help/get_support/".$id));
    }

    public function get_tag(){
    	$id = $this->input->post("id");
    	$row = get_row("help_tag",array("id"=>$id));
    	echo json_encode(array("data"=>$row));
    }

     public function get_ticket(){
    	$id = $this->input->post("id");
    	$row = get_row("help_ticket",array("id"=>$id));
    	echo json_encode(array("data"=>$row));
    }
    public function remove_tag(){
    	$id = $this->input->post("id");
    	$this->load->model("common_model");
    	$this->common_model->deleteData("help_tag",array("id"=>$id));
    	echo json_encode(array("status"=>"OK"));
    }

    public function create_ticket(){
    	$data = $this->input->post();
    	$id = $data['id'];
    	unset($data['id']);
    	$this->load->model("common_model");
    	if($id == ""){
    		$this->common_model->createData("help_ticket",$data);
    	} else {
    		$this->common_model->updateData("help_ticket",$data,array("id"=>$id));
    	}
    	redirect(base_url("admini/help/get_support/".$data['tag_id']));
    }

    public function get_tag_table(){
    	$tag_id = $this->input->post("tag_id");
    ?>
    	<table id="ticket_table" class="display" style="width:100%">
	          <thead>
	              <tr>
	                  <th>Ticket ID</th>
	                  <th>Title</th>
	                  <th></th>
	              </tr>
	          </thead>
	          <tbody>
	 		<?php
	 			$tickets = get_rows("help_ticket",array("tag_id"=>$tag_id));
	 			foreach ($tickets as $key => $ticket) {
			?>
				<tr data-id="<?php echo $ticket['id']; ?>">
					<td class="edit-ticket"><?php echo $ticket['id']; ?></td>
					<td class="edit-ticket"><?php echo $ticket['title']; ?></td>
					<td style="text-align: right;" class="td-action">
	                    <a class="edit-ticket" style="color: #0f8602;"><i class="fa fa-edit"></i> Edit</a>
	                    &nbsp;| &nbsp;
	                    <a class="remove-ticket" style="color: #ff6000;"><i class="fa fa-trash"></i> Remove</a>

					</td>
				</tr>
			<?php	 				
	 			}
	 		?>
	          </tbody>
	          <tfoot>
	            <tr>
	                  <th>Ticket ID</th>
	                  <th>Title</th>
	                  <th></th>
	              </tr>
	          </tfoot>
	      </table>
	 <?php

    }
 
}
