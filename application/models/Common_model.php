<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common_model extends CI_Model
{
    /*  
     *  Developed by: Active IT zone
     *  Date    : 14 July, 2015
     *  Active Supershop eCommerce CMS
     *  http://codecanyon.net/user/activeitezone
     */
     
    function __construct()
    {
        parent::__construct();
    }
    
    public function createData($table,$insertData=array()){
        $res = $this->db->insert($table,$insertData);
        $id = $this->db->insert_id();
        $this->db->where(array("id"=>$id));
        $res = $this->db->get($table);
        return $res->row_array();

    }
    
    public function readData($table,$where){
        $this->db->where($where);
        $res = $this->db->get($table);
        return $res->row_array();
    }

     public function readDatas($table,$where=array(),$sort="",$like=array()){
        if(count($where)>0) $this->db->where($where);
        if(count($like)>0) $this->db->like($like);
        if($sort!="") $this->db->order_by($sort);
        $res = $this->db->get($table);
        return $res->result_array();
    }

    public function deleteData($table,$where = array()){
       $this->db->delete($table,$where);
    }

    public function updateData($table,$update_data=array(),$where=array()){
        $this->db->where($where);
        $this->db->update($table, $update_data);
    }
    //CHECK IF PRODUCT EXISTS IN TABLE
    public function exists_in_table($table, $field, $val)
    {
        $ret = '';
        $res = $this->db->get($table)->result_array();
        foreach ($res as $row) {
            if ($row[$field] == $val) {
                $ret = $row['id'];
                // $ret = $row[$table . '_id'];
            }
        }
        if ($ret == '') {
            return false;
        } else {
            return $ret;
        }
    }

    public function getRowBydate($table,$field,$date,$where=array()){

        $this->db->like($field,$date,"after");
        if(count($where)>0) $this->db->where($where);
        $query = $this->db->get($table);
        return $query->num_rows();
    }

    /**
     * Set Style for the flash messages
     *
     * @access  public
     * @param   string  the type of the flash message
     * @param   string  flash message 
     * @return  string  flash message with proper style
     */
    function flash_message($type,$message)
    {
        switch($type)
        {
            case 'success':
                    $data = '<div class="clsShow_Notification"><p class="success"><span>'.$message.'</span></p></div>';
                    break;
            case 'error':
                    $data = '<div class="clsShow_Notification"><p class="error"><span>'.$message.'</span></p></div>';
                    break;      
        }
        return $data;
    }//End of flash_message Function
     

}






