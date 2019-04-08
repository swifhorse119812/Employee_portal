<?php

defined('BASEPATH') or exit('No direct script access allowed');

function sendMail_to_admin($email,$msg_subject,$msg_body,$user_id=""){
   
    $CI = & get_instance();

    $msg_body = add_logo($msg_body);
    if($user_id!=""){
        $data = array();
        $data['receiver'] = "admin";
        $data['sender'] = $user_id;
        $data['subject'] = $msg_subject;
        $data['body'] = $msg_body;
        $data['date'] = date("Y-m-d H:i:s");
        $data['status'] = 1;
        $CI->db->insert("message",$data);
    }
    $CI->load->library('email');
    // $config['protocol'] = 'sendmail';
    // $config['mailpath'] = '/usr/sbin/sendmail';
    $config['charset'] = 'iso-8859-1';
    $config['wordwrap'] = TRUE;
    // $config['useragent'] = 'l33t Mailer 1.0';
    // $config['priority'] = 5;

    $config = array(
        'protocol'  => 'smtp',
        'smtp_host' => 'smtp.ionos.com',
        'smtp_port' => 587,
        'smtp_user' => 'merchant@virsympay.com',
        'smtp_pass' => 'Bahaman32908!',
        'mailtype'  => 'html',
        'charset'   => 'utf-8'
    );

    $CI->email->initialize($config);


    $CI->email->set_mailtype("html");
    
    $row = get_row("paymentgetway",array("id"=>1));
    $support_email = $row['support_email'];

    $CI->email->from($email);
    $CI->email->to($support_email);
    $CI->email->cc($support_email);

    $CI->email->subject($msg_subject);

    $CI->email->message($msg_body);
    $CI->email->send();
}


function sendMail($email,$msg_subject,$msg_body,$user_id=""){
    $CI = & get_instance();

    $msg_body = add_logo($msg_body);
    if($user_id!=""){
        $data = array();
        $data['sender'] = "admin";
        $data['receiver'] = $user_id;
        $data['subject'] = $msg_subject;
        $data['body'] = $msg_body;
        $data['date'] = date("Y-m-d H:i:s");
        $data['status'] = 1;
        $CI->db->insert("message",$data);
    }

    $CI->load->library('email');
    // $config['protocol'] = 'sendmail';
    // $config['mailpath'] = '/usr/sbin/sendmail';
    $config['charset'] = 'iso-8859-1';
    $config['wordwrap'] = TRUE;
    // $config['useragent'] = 'l33t Mailer 1.0';
    // $config['priority'] = 5;

      $config = array(
        'protocol'  => 'smtp',
        'smtp_host' => 'smtp.ionos.com',
        'smtp_port' => 587,
        'smtp_user' => 'merchant@virsympay.com',
        'smtp_pass' => 'Bahaman32908!',
        'mailtype'  => 'html',
        'charset'   => 'utf-8'
    );


    $CI->email->initialize($config);


    $CI->email->set_mailtype("html");
    
    $row = get_row("paymentgetway",array("id"=>1));
    $support_email = $row['support_email'];

    $CI->email->from($support_email);
    $CI->email->to($email);
    $CI->email->cc($email);

    $CI->email->subject($msg_subject);

    $CI->email->message($msg_body);
    $CI->email->send();
     
}

function get_row($table, $where)
{
    $CI = & get_instance();
    $CI->db->where($where);

    return $CI->db->get($table)->row_array();
}

function add_logo($msg_body)
{
    $CI = & get_instance();
    $ele = '<div class="message_box" style="width:1024px; margin:0px auto;  padding: 20px; border:1px solid #ccc;">';
    $ele .= '<style type="text/css"> p[style="text-align: center;font-size: 14px;margin-top: 30px;font-family: sans-serif;"]{display:none;}</style>';
    $ele .= '<div style="text-align: center;border-bottom: 3px double  #ccc;"><img src="'.base_url("assets/client_assets/images/logo.png").'" alt="" style="height: 100px;"> ';
    $ele .='<div style="font-size: 20px; text-align:center;">The Official Processor of VirSymCoin - The Cryptocurrency For Payments</div></div>';
    $msg_body = str_replace("font-family: sans-serif;", "display:none;", $msg_body);
    $ele .= $msg_body;
    $ele .= '</div>';
    return $ele;
}

 
function get_rows($table, $where=array(),$order_by="",$like=array())
{
    $CI = & get_instance();
    if($where!=array()) $CI->db->where($where);
    if($like!=array()) {
        $CI->db->like($like);
    }
    if($order_by!="") $CI->db->order_by($order_by);

    return $CI->db->get($table)->result_array();
}

function get_rows_count($table, $where=array(),$order_by="",$like=array())
{
    $CI = & get_instance();
    $CI->db->select("id");
    if($where!=array()) $CI->db->where($where);
    if($like!=array()) {
        $CI->db->like($like);
    }
    if($order_by!="") $CI->db->order_by($order_by);

    return $CI->db->get($table)->num_rows();
}
 