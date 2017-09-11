<?php

class User extends CI_Controller{
    function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
        parent::__construct();
        $this->load->library('encryption');
        $econfig = array(
            'cipher' => 'aes-128',
            'mode' => 'ctr',
            'key' => 'onlyicandecrypt!'
        );
        $this->encryption->initialize($econfig);

    }

    function index(){
        $data['userdata'] = $this->session->userdata();
        $data['target'] = '/application/Assets/Images/';
        $this->load->view("header",$data);
        $this->load->view("coverspace");
        $this->load->model("Posts");
        $data['postlist'] = $this->Posts->fetchPosts();
        $this->load->view("feed",$data);
        $this->load->view("footer");
    }
    function getMore(){
        $data['target'] = '/application/Assets/Images/';
       $id = $this->input->get('id');
       $this->load->model("Posts");
       $data['postlist'] = $this->Posts->fetchMore($id);
       if(!empty($data['postlist'])){
           return $this->load->view('moreposts',$data);
       }

       if(empty($data['postlist'])){
           $data['msg'] = "No more posts available";
           return $this->load->view("error",$data);
       }
    }
    function readPost(){
        $data['userdata'] = $this->session->userdata();
        $data['target'] = '/application/Assets/Images/';
        $id = $this->input->get('id');
        $this->load->model('Posts');
        $this->load->view('header',$data);
        $data['post'] = $this->Posts->getPost($id);
        $prev = $this->Posts->getPrev($id);
        $next = $this->Posts->getNext($id);
        if(!empty($prev)) {
            $data['prev'] = $prev->id;
        }
        if(!empty($next)) {
            $data['next'] = $next->id;
        }
        $this->load->view('readpost',$data);
        $this->load->view('footer');
    }
    function login(){
        $check = $this->session->userdata('logged_in');
        if(isset($check)){
            redirect('/User/');
        }
        $data['userdata'] = $this->session->userdata();
        $this->load->model('Users','um');
        $this->load->view("header",$data);
        if($_POST) {
            $post = filter_var_array($_POST, FILTER_SANITIZE_STRING);
            if (strlen($post['upass']) > 6) {
                $post['upass'] = md5($post['upass']);
                $udata = $this->um->login($post);
                if (isset($udata)) {
                    $udata['logged_in'] = true;
                    $this->session->set_userdata($udata);
                    redirect('/');
                } else {
                    $data['msg'] = "Invalid Credentials";
                    $this->load->view('error', $data);
                }
            }else{
                $data['msg'] = "Password length should be greater than 6";
                $this->load->view('error', $data);
            }
        }
        $this->load->view("login");
        $this->load->view("footer");
    }
    function register(){
        $check = $this->session->userdata('logged_in');
        if(isset($check)){
            redirect('/User/');
        }
        $data['userdata'] = $this->session->userdata();
        $this->load->model('Users','um');
        $this->load->view("header",$data);
        if($_POST) {
            $post = filter_var_array($_POST, FILTER_SANITIZE_STRING);
            $tempCheck = $this->um->getTemp(array('uemail'=>$post['umail']));
            $check = $this->um->getUser(array('uemail'=>$post['umail']));
            if (isset($tempCheck) || isset($check)) {
                $data['msg'] = "You've registered already";
                $this->load->view('error',$data);
            } else {
                if (strcmp($post['upass'], $post['ucpass']) == 0) {
                    $post['upass'] = md5($post['upass']);
                    if (strlen($post['upass']) > 6) {
                        $userdata = array(
                            'uname' => $post['uname'],
                            'uemail' => $post['umail'],
                            'upass' => $post['upass']
                        );
                        $this->um->insTemp($userdata);
                        $key = array('uemail' => $post['umail']);
                        $tudata = $this->um->getTemp($key);
                        $id = $this->encryption->encrypt($tudata['id']);

                        $config = Array(
                            'protocol' => 'smtp',
                            'smtp_host' => 'ssl://smtp.googlemail.com',
                            'smtp_port' => 465,
                            'smtp_user' => 'coder30597@gmail.com', // change it to yours
                            'smtp_pass' => 'swagmeansitsme', // change it to yours
                            'mailtype' => 'html',
                            'charset' => 'iso-8859-1',
                            'wordwrap' => TRUE
                        );
                        $message = '<p>Please confirm your account by clicking <a href="cm.s/User/Confirm/?id=' . $id . '">here</a></p>';
                        $this->load->library('email', $config);
                        $this->email->set_newline("\r\n");
                        $this->email->from('coder30597@gmail.com'); // change it to yours
                        $this->email->to($tudata['uemail']);// change it to yours
                        $this->email->subject('Confirm your account');
                        $this->email->message($message);
                        if ($this->email->send()) {
                            echo 'Email sent.';
                        } else {
                            show_error($this->email->print_debugger());
                        }

                    } else {
                        $data['msg'] = "Password length should be more than 6 characters";
                        $this->load->view('error', $data);
                    }
                } else {
                    $data['msg'] = "Please enter same password in both the fields";
                    $this->load->view('error', $data);
                }
            }
        }
        $this->load->view("register");
        $this->load->view("footer");
    }
    function submission(){
        $data['userdata'] = $this->session->userdata();
        $check = $this->session->userdata('logged_in');
        if(!isset($check)){
            redirect('/User/login');
        }
        $this->load->model('Posts');
        $this->load->view("header",$data);
        if($_POST){
            $post = filter_var_array($_POST, FILTER_SANITIZE_STRING);
            $post['data'] = date('Y-m-d H-i-s');
            $post['author'] = $this->session->userdata('uname');
            $this->Posts->insTemp($post);
            $data['msg'] = "Your post has been submitted for admin approval";
            $this->load->view("success",$data);
        }
        $this->load->view("submission");
        $this->load->view("footer");
    }
    function confirm(){
        $id = $this->input->get('id');
        for($i =0; $i<strlen($id);$i++){
            if($id[$i]==' '){
                $id[$i] ='+';
            }
        }
       $id = $this->encryption->decrypt($id);
        $key = array('id' => $id);
       $this->load->model('Users','um');
       $udata = $this->um->getTemp($key);
       $this->um->delTemp($id);
       unset($udata['id']);
       $this->um->insUser($udata);
       $this->load->view('header');
       $data['msg'] = "Your account has been confirmed. Login.";
       $this->load->view('success',$data);
    }
    function resetPw(){
        $check = $this->session->userdata('logged_in');
        if(!isset($check)){
            redirect('/User/login');
        }
        $data['userdata'] = $this->session->userdata();
        $this->load->model("Users","um");
        $this->load->view("header",$data);
        if($_POST) {
            $post = filter_var_array($_POST, FILTER_SANITIZE_STRING);
            $mail = $this->session->userdata("uemail");
            $post['oldpw'] = md5($post['oldpw']);
            $user = array(
                "uemail" => $mail,
                "upass" => $post['oldpw']
            );
            $udata = $this->um->login($user);
            if (!empty($udata)) {
                if (strcmp($post['pw'], $post['cpw']) == 0) {
                    if (strlen($post['pw']) > 6) {
                        $post['pw'] = md5($post['pw']);
                        $this->um->resetPw($udata['id'],$post['pw']);
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
        $this->load->view("resetuser");
        $this->load->view("footer");
    }
    function logout(){
        $udata = $this->session->userdata();
        $this->session->unset_userdata($udata);
        $this->session->sess_destroy();
        redirect('/');
    }
}

?>