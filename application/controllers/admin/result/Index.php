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
        $data['href'] = 'result';
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
        }
    }
    function loadTable(){
        $data['title'] = 'Kết quả';
        $data['href'] = 'result';
        $data['list_lession'] = $this->Model->query("lession",["where"=>["student"=>$this->session->userdata("id")]]);
        $data['header'] = array('id'=>'Kết quả','exercise'=>'Bài tập','point'=>'Số điểm','true'=>'Số câu đúng','false'=>'Số câu sai','action'=>'Detail');
        $this->load->view('admin/list',$data);
    }
    function delete(){
        $id = $this->uri->segment(4);
        $this->Model->delete('result_log',['id'=>$id]);
    }
    function loadEdit(){    
        $data['title'] = 'Kết quả';    
        $data['href'] = 'result';
        $id = $this->input->get("id");
        $table = $this->Model->query("result_log_detail",["where"=>["id"=>$id]]);
        $arr = [];
        foreach($table as $key=>$it){
            $arr[$key]['vocabulary'] = $this->Model->query($it['class'],["where"=>["id"=>$it['vocabulary']],"first_row"=>true])->e_name;
            $arr[$key]['result'] = empty($it['result']) ? "false" : "true";
        }
        $data['data'] = $arr;
        $this->load->view('admin/result/edit',$data);
    }
}