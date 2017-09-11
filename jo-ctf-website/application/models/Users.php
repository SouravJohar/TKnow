<?php

class Users extends CI_Model{
    function __construct()
    {
        $this->load->database();
    }
    function insTemp($udata){
        $this->db->insert('Temp_Users',$udata);
    }
    function getTemp($key){
        $this->db->select('*');
        if(isset($key['uemail'])) {
            $this->db->where('uemail', $key['uemail']);
        }else{
            $this->db->where('id', $key['id']);
        }
        $res = $this->db->get('Temp_Users');
        return $res->row_array();
    }
    function delTemp($id){
        $this->db->where('id',$id);
        $this->db->delete('Temp_Users');
    }
    function insUser($udata){
        $this->db->insert('Users',$udata);
    }
    function getUser($key){
        $this->db->select('*');
        if(isset($key['uemail'])) {
            $this->db->where('uemail', $key['uemail']);
        }else{
            $this->db->where('id', $key['id']);
        }
        $res = $this->db->get('Users');
        return $res->row_array();
    }
    function login($creds){
        $this->db->select('*');
        $this->db->where('uemail',$creds['uemail']);
        $this->db->where('upass',$creds['upass']);
        $res = $this->db->get('Users');
        return $res->row_array();
    }
    function resetPw($id,$newPw){
        $this->db->where('id',$id);
        $this->db->update('Users',array("upass"=>$newPw));
    }
}

?>