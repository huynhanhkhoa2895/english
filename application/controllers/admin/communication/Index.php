<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('./application/module/Context.php');
class Index extends CI_Controller implements Context{
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
        $data['href'] = 'communication';
        $data['action'] = empty($this->input->get('action'))? "list" : $this->input->get('action');
        $data['id'] = $this->input->get('id');
        $this->load->view('admin/admin',$data);
    }
    function indexAjax(){
        $action = $this->input->get('action');
        $id = $this->input->get('id');
        if($action == 'list'){
            $this->loadTable();
        }elseif($action == 'add'){
            $this->loadAdd();
        }elseif($action == 'edit'){
            $this->loadAdd('edit',$id);
        }
    }
    function loadTable(){
        $data['title'] = 'Giao tiếp';
        $data['href'] = 'communication';
        $data['header'] = array('id'=>'ID','e_name'=>'Câu hỏi','v_name'=>'Tiếng việt','created_at'=>'Ngày tạo','updated_at'=>'Ngày cập nhật','action'=>'Action');
        $this->load->view('admin/list',$data);
    }
    function delete(){
        $id = $this->uri->segment(4);
        $this->Model->delete('communication',['id'=>$id]);
    }
    function edit(){

    }
    function loadAdd($action = "add",$id=""){
        $data['title'] = 'Giao tiếp';
        $data['categorys'] = $this->Model->getAllTable('category');
        $data['action'] = $action;
        $data['id'] = $id;
        $data['v_name'] = '';
        $data['e_name'] = '';
        if($action == 'edit'){
            $data['e_name'] = $this->Model->getTable("communication",['id'=>$id])->e_name;
            $data['v_name'] = $this->Model->getTable("communication",['id'=>$id])->v_name;
        }
        $this->load->view('admin/communication/add',$data);
    }
    function add(){
        $action = $this->input->post('action');
        if(empty($this->input->post('e_name'))){
            echo json_encode(array("err"=>1,"msg"=> "Điền đầy đủ thông tin"));
            return;
        }
        $arr['e_name'] =trim($this->input->post('e_name'));
        $arr['v_name'] =trim($this->input->post('v_name'));
        $arr['student_id'] =$this->session->userdata("id");
        if($action == 'add'){        
            $this->Model->insert("communication",$arr);
            echo json_encode(array("err"=>0,"msg"=> "Thêm câu giao tiếp thành công"));      
        }else{
            $this->Model->update("communication",$arr,["id"=>$this->input->post('id')]);
            echo json_encode(array("err"=>0,"msg"=> "Update câu giao tiếp thành công"));  
        }
    }
}