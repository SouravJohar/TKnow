<?php

class Admin extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Kolkata');
    }
    function index(){
        $data['userdata'] = $this->session->userdata();
        $check = $this->session->userdata('admin');
        if(!isset($check)){
            redirect('/admin/adLogin');
        }
        $this->load->model("Posts");
        $this->load->view("header",$data);
        $data['postlist'] = $this->Posts->fetchTemp();
        if(!empty($data['postlist'])) {
            $this->load->view("postlist", $data);
        }else{
            $data['msg'] = "No posts to approve";
            $this->load->view('error',$data);
        }
        $this->load->view("footer");
    }
    function getMore(){
        $id = $this->input->get('id');
        $this->load->model("Posts");
        $data['postlist'] = $this->Posts->fetchMoreTemp($id);
        if(!empty($data['postlist'])){
            return $this->load->view('moretemp',$data);
        }

        if(empty($data['postlist'])){
            $data['msg'] = "No more posts available";
            return $this->load->view("error",$data);
        }
    }
    function readTemp(){
        $data['userdata'] = $this->session->userdata();
        $check = $this->session->userdata('admin');
        if(!isset($check)){
            redirect('/admin/adLogin');
        }
        $id = $this->input->get('id');
        $this->load->model("Posts");
        $this->load->view("header",$data);
        $data['post'] = $this->Posts->getTemp($id);
        $this->load->view("readtemp",$data);
        $this->load->view("footer");
    }
    function adLogin(){
        $data['userdata'] = $this->session->userdata();
        $this->load->model('admins','am');
        $this->load->view("header",$data);
        if($_POST) {
            $post = filter_var_array($_POST, FILTER_SANITIZE_STRING);
            if (strlen($post['apass']) > 6) {
                $post['apass'] = md5($post['apass']);
                echo $post['apass'];
                $udata = $this->am->login($post);
                if (isset($udata)) {
                    $udata['admin'] = true;
                    $udata['logged_in'] = true;
                    $this->session->set_userdata($udata);
                    redirect('/');
                } else {
                    $data['msg'] = "Invalid Credentials";
                    $this->load->view('error', $data);
                }
            }else{
                $data['msg'] = "Invalid Password";
                $this->load->view('error', $data);
            }
        }
        $this->load->view("adlogin");
        $this->load->view("footer");
    }
    function approval(){
        $check = $this->session->userdata('admin');
        if(!isset($check)){
            redirect('/admin/adLogin');
        }
        $target = '/jo-ctf-website/application/Assets/Images/';
        $this->load->model("Posts");
        if($_POST){
           $post = filter_var_array($_POST, FILTER_SANITIZE_STRING);
           $id = $post['id'];
           $post = $this->Posts->getTemp($id);
           unset($post['id']);
           $tmp_img = $_FILES['post_img']['tmp_name'];
           $img = $_FILES['post_img']['name'];
           $post['image'] = $img;
           $this->Posts->insPost($post);
           $this->Posts->delTemp($id);
           move_uploaded_file($tmp_img,$target.$img);
           redirect('/admin/index');
        }
    }
    function resetPw(){
        $check = $this->session->userdata('admin');
        if(!isset($check)){
            redirect('/admin/adLogin');
        }
        $data['userdata'] = $this->session->userdata();
        $this->load->model("Admins","am");
        $this->load->view("header",$data);
        if($_POST) {
            $post = filter_var_array($_POST, FILTER_SANITIZE_STRING);
            $mail = $this->session->userdata("aemail");
            $post['oldpw'] = md5($post['oldpw']);
            $admin = array(
                "aemail" => $mail,
                "apass" => $post['oldpw']
            );
            $udata = $this->am->login($admin);
            if (!empty($udata)) {
                if (strcmp($post['pw'], $post['cpw']) == 0) {
                    if (strlen($post['pw']) > 6) {
                        $post['pw'] = md5($post['pw']);
                        $this->am->resetPw($udata['id'],$post['pw']);
                        $data['msg'] = "Your password has been changed successfully";
                        $this->load->view("success",$data);
                    } else {
                        $data['msg'] = "Password length should at least be 6 characters";
                        $this->load->view("error",$data);
                    }

                } else {
                    $data['msg'] = "Please enter the same password in both fields";
                    $this->load->view("error",$data);
                }
            }else{
                $data['msg'] = "Invalid old password";
                $this->load->view("error",$data);
            }
        }
        $this->load->view("resetadmin");
        $this->load->view("footer");
    }
    function decline(){
        $check = $this->session->userdata('admin');
        if(!isset($check)){
            redirect('/admin/adLogin');
        }
        $id = $this->input->get('id');
        $this->load->model('Posts');
        $this->Posts->delTemp($id);
        redirect('/admin/index');
    }
}

?>