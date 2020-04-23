<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Index extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Model');
        $this->load->library('myfunction');
        if(!$this->session->userdata("username")){
            redirect('/verify', 'refresh');
        }
    }
    function index(){
        $data['href'] = 'category';
        $data['action'] = $this->input->get('action');
        $data['id'] = $this->input->get('id');
        $this->load->view('admin/admin',$data);
    }
    function indexAjax(){
        $action = $this->input->get('action');
        echo  "test ".$this->input->get('id');
        $id = $this->input->get('id');
        if($action == 'list'){
            $this->loadTable();
        }elseif($action == 'add'){
            $this->loadAdd();
        }elseif($action == 'edit'){
            $this->loadAdd("edit",$id);
        }
    }
    function delete(){
        $id = $this->uri->segment(4);
        $this->Model->delete("category",['id'=>$id]);
    }
    function loadTable(){
        $data['title'] = 'Chủ đề';
        $data['href'] = 'category';
        $data['header'] = array('id'=>'Chủ đề','e_name'=>'Tiếng Anh','v_name'=>'Tiếng Việt','action'=>"Action");
        $this->load->view('admin/list',$data);
    }
    function loadAdd($action = "add",$id=""){
        $data['title'] = 'Chủ đề';
        $data['categorys'] = $this->Model->getAllTable('category');
        $data['action'] = $action;
        $data['id'] = $id;
        $this->load->view('admin/category/add',$data);
    }
    function add(){
        $action = $this->input->post('action');
        if(empty($this->input->post('e_name')) || empty($this->input->post('v_name'))){
            echo json_encode(array("err"=>1,"msg"=> "Điền đầy đủ thông tin"));
            return;
        }
        $arr['e_name'] =strtoupper(trim($this->input->post('e_name')));
        $arr['v_name'] =strtoupper(trim($this->input->post('v_name')));
        if($action == 'add'){        
            if(empty($this->Model->query("category",["where"=>["e_name"=>$arr['e_name']]])) && empty($this->Model->query("category",["where"=>["v_name"=>$arr['v_name']]]))){
                $this->Model->insert("category",$arr);
                echo json_encode(array("err"=>0,"msg"=> "Thêm chủ đề thành công"));
            }else{
                echo json_encode(array("err"=>1,"msg"=> "Chủ đề này đã tồn tại"));
            }       
        }else{
            if(empty($this->Model->query("category",["where"=>["e_name"=>$arr['e_name']]])) && empty($this->Model->query("category",["where"=>["v_name"=>$arr['v_name']]]))){
                $this->Model->update("category",$arr);
                echo json_encode(array("err"=>0,"msg"=> "Thêm chủ đề thành công"));
            }else{
                echo json_encode(array("err"=>1,"msg"=> "Chủ đề này đã tồn tại"));
            }   
        }
    }
}
