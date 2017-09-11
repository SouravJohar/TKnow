<?php

class Posts extends CI_Model{
    function __construct()
    {
        $this->load->database();
    }
    function insTemp($postdata){
        $this->db->insert('Temp_Posts',$postdata);
    }
    function fetchTemp(){
        $this->db->select('*');
        $this->db->limit(3);
        $post = $this->db->get('Temp_Posts');
        return $post->result();
    }
    function getTemp($id){
        $this->db->select('*');
        $this->db->where('id',$id);
        $post = $this->db->get('Temp_Posts');
        return $post->row_array();
    }
    function delTemp($id){
        $this->db->where('id',$id);
        $this->db->delete('Temp_Posts');
    }
    function insPost($post){
        $this->db->insert("Posts",$post);
    }
    function fetchPosts(){
        $this->db->select('*');
        $this->db->order_by('id');
        $this->db->limit(6);
        $post = $this->db->get('Posts');
        return $post->result();
    }
    function getPost($id){
        $this->db->select('*');
        $this->db->where('id',$id);
        $post = $this->db->get('Posts');
        return $post->row_array();
    }
    function getPrev($id){
        $this->db->select('*');
        $this->db->where('id <',$id);
        $this->db->order_by('id','desc');
        $this->db->limit(1);
        $prev = $this->db->get('Posts');
        return $prev->row();
    }
    function getNext($id){
        $this->db->select('*');
        $this->db->where('id >',$id);
        $this->db->order_by('id');
        $this->db->limit(1);
        $next = $this->db->get('Posts');
        return $next->row();
    }
    function fetchMore($id){
        $this->db->select('*');
        $this->db->where('id <',$id);
        $this->db->order_by('id','desc');
        $this->db->limit(3);
        $res = $this->db->get('Posts');
        return $res->result();
    }
    function fetchMoreTemp($id){
        $this->db->select('*');
        $this->db->where('id >',$id);
        $this->db->limit(3);
        $res = $this->db->get('Temp_Posts');
        return $res->result();
    }
}

?>