<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Index extends CI_Controller{
    private $uploadPath = './public/';
    function __construct(){
        parent::__construct();
        $this->load->model('Model');
        $this->load->library('myfunction');
        $this->load->helper('form'); 
        if(!$this->session->userdata("username")){
            redirect('/verify', 'refresh');
        }
    }
    function index(){
        $data['href'] = 'read';
        $data['action'] = $this->input->get('action');
        $data['id'] = $this->input->get('id');
        $this->load->view('admin/admin',$data);
    }
    function indexAjax(){
        $action = $this->input->get('action');
        if($action == 'list'){
            $this->loadTable();
        }elseif($action == 'edit'){
            $this->loadEdit();
        }elseif($action == 'add'){
            $this->loadAdd();
        }
    }
    function loadTable(){
        $data['title'] = 'Bài đọc';
        $data['href'] = 'read';
        $data['header'] = array('id'=>'Bài đọc','read'=>'Tên bài đọc','action'=>'Action');
        $this->load->view('admin/list',$data);
    }
    function delete(){
        $id = $this->uri->segment(4);
        $this->Model->delete('read',['id'=>$id]);
    }
    function loadAdd($action = "",$id = ""){
        $data['title'] = 'Bài đọc';
        $this->load->view('admin/read/add',$data);
    }
    function add(){
        $read = $this->input->post('read');
        $name = $this->input->post('name');
        $student = $this->input->post('id');
        $this->Model->insert('read',['class'=>$it['class'],'vocabulary_id'=>$it['id'],'id'=>$id_current]);

    }
}