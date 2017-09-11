<?php
class Admins extends CI_Model{
    function __construct()
    {
        $this->load->database();
    }

    function login($adata){
        $this->db->select('*');
        $this->db->where('aemail',$adata['aemail']);
        $this->db->where('apass',$adata['apass']);
        $res = $this->db->get('admins');
        return $res->row_array();
    }
    function resetPw($id,$newPw){
        $this->db->where('id',$id);
        $this->db->update('admins',array("apass"=>$newPw));
    }
}

?>