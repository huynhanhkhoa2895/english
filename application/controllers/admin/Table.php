<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Table extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Model');
        $this->load->library('myfunction');
    }

    function index(){
        $it['href'] = $this->input->get('href');
        $limit = $this->input->get('length');
        $start = $this->input->get('start');
        switch ($it['href']){
            case 'category' :
                $data=$this->Model->getAllTable($it['href'],$limit,$start,"created_at DESC",["active"=>1]);
                $total = $this->Model->getTotal($it['href']);
                break;
            case 'communication' :
                $data=$this->Model->getAllTable($it['href'],$limit,$start,"created_at DESC",["student_id"=>$this->session->userdata("id")]);
                $total = $this->Model->getTotal($it['href']);
                break;
            case 'read' :
                $data=$this->Model->getAllTable($it['href'],$limit,$start,"created_at DESC",["student"=>$this->session->userdata("id")]);
                $total = $this->Model->getTotal($it['href']);
                break;
            case 'result' :
                $data=$this->Model->getAllTable("result_log",$limit,$start,"created_at DESC",["student"=>$this->session->userdata("id")]);
                $total = $this->Model->getTotal("result_log");
                break;
            case 'lession' :
                $data=$this->Model->getAllTable("lession",$limit,$start,"created_at DESC",["student"=>$this->session->userdata("id")]);
                $total = $this->Model->getTotal("lession");
                break;
            case 'exercise' :
                $data=$this->Model->getAllTable($it['href'],$limit,$start,"created_at DESC",["student"=>$this->session->userdata("id")]);
                $total = $this->Model->getTotal($it['href']);
                break;
            case 'vocabulary' :
                $orderBy = "id DESC";
                $condition = '';
                if($this->input->get('order')[0]['column'] == 1) $orderBy = "e_name ".$this->input->get('order')[0]['dir'];              
                elseif($this->input->get('order')[0]['column'] == 0) $orderBy = "id ".$this->input->get('order')[0]['dir'];
                if(!empty($this->input->get('search')['value'])){
                    $condition = "`e_name` like '%".$this->input->get('search')['value']."%'";                    
                }
                $data=$this->Model->getAllTable($it['href'],$limit,$start,$orderBy,$condition);
                $total = $this->Model->getTotal($it['href']);
                break;
            case 'pharse' :
                $orderBy = "id DESC";
                $condition = '';
                if($this->input->get('order')[0]['column'] == 1) $orderBy = "e_name ".$this->input->get('order')[0]['dir'];              
                elseif($this->input->get('order')[0]['column'] == 0) $orderBy = "id ".$this->input->get('order')[0]['dir'];
                if(!empty($this->input->get('search')['value'])){
                    $condition = "`e_name` like '%".$this->input->get('search')['value']."%'";                    
                }
                $data=$this->Model->getAllTable($it['href'],$limit,$start,$orderBy,$condition);
                $total = $this->Model->getTotal($it['href']);
                break;

        }
        if(empty($data)){
            $table = [];
        }else{
            switch ($it['href']){
                case 'category' :
                    foreach ($data as $val){
                        $val['action'] = 
                        "   
                            <a href='".base_url()."admin/category?action=edit&id=".$val['id']."'>Edit</a> |
                            <a onclick='confirmDelete(this)' href='javascript:void(0)' data-href='".base_url()."admin/category/delete/".$val['id']."'>Delete</a>
                        ";
                        $table[] = $val; 
                    }
                    break;
                case 'communication' :
                    foreach ($data as $val){
                        $val['action'] = 
                        "   
                            <a href='".base_url()."admin/communication?action=edit&id=".$val['id']."'>Edit</a> |
                            <a onclick='confirmDelete(this)' href='javascript:void(0)' data-href='".base_url()."admin/communication/delete/".$val['id']."'>Delete</a>
                        ";
                        $table[] = $val; 
                    }
                    break;
                case 'result' :
                    foreach ($data as $val){
                        $val['action'] ="
                            <a href='".base_url()."admin/result?action=edit&id=".$val['id']."'>Detail</a> |
                            <a onclick='confirmDelete(this)' href='javascript:void(0)' data-href='".base_url()."admin/result/delete/".$val['id']."'>Delete</a>     
                        ";
                        $table[] = $val; 
                    }
                    break;
                case 'read' :
                    foreach ($data as $val){
                        $val['action'] ="
                            <a href='".base_url()."admin/read?action=edit&id=".$val['id']."'>Detail</a> |
                            <a onclick='confirmDelete(this)' href='javascript:void(0)' data-href='".base_url()."admin/read/delete/".$val['id']."'>Delete</a>     
                        ";
                        $table[] = $val; 
                    }
                    break;
                case 'exercise' :
                    foreach ($data as $val){     
                        $val['active'] = ($val['active'] == 1) ? "Kích hoạt" : "Chưa kích hoạt";
                        $val['action'] ="
                            <a href='".base_url()."admin/exercise?action=edit&id=".$val['id']."'>Edit</a> |
                            <a href='javascript:void(0)' data-href='".base_url()."admin/exercise/delete/".$val['id']."' onclick='confirmDelete(this)'>Delete</a>
                        ";
                        $table[] = $val;  
                    }
                    break;
                case 'lession' :
                    foreach ($data as $val){     
                        $val['action'] = 
                        "   
                            <a href='".base_url()."admin/lession?action=edit&id=".$val['id']."'>Edit</a> |
                            <a onclick='confirmDelete(this)' href='javascript:void(0)' data-href='".base_url()."admin/lession/delete/".$val['id']."'>Delete</a> |
                            <a href='".base_url()."admin/lession?action=createExercise&id=".$val['id']."'>Tạo bài tập</a>
                        ";
                        $table[] = $val;  
                    }
                    break;
                case 'pharse' :
                    foreach ($data as $val){
                        $val['action'] ="<a href='".base_url()."edit/".$val['id']."'>Edit</a>";
                        $val['e_name'] .= $this->myfunction->speakEnglish($val['e_name']);
                        $table[] = $val;                         
                    }
                    break;
                case 'vocabulary' :
                    $categorys = $this->Model->getAllTable("category");
                    $category = [];
                    foreach($categorys as $cate){
                        $category[$cate['id']] = $cate['e_name'];
                    }
                    
                    foreach ($data as $val){
                        $list_category = $this->Model->query("category",["where_in"=>["id"=>explode(",",$val['category'])]]);
                        $val['category'] = "";
                        foreach($list_category as $it){
                            $val['category'] .= $it['e_name'].", ";
                        }
                        $val['category']  = rtrim($val['category'],", ");
                        $val['e_name'] .= "(".$val['type'].") ".$this->myfunction->speakEnglish($val['e_name']);
                        $val['action'] = "<a href='".base_url()."admin/vocabulary?action=edit&id=".$val['id']."'>Edit</a>";
                        $table[] = $val;        
                    }
                    break;
            }

        }
        $it['table'] = array(
            "draw" => false,
            "recordsTotal" => $total,
            "recordsFiltered" =>$total,
            'data' => $table,
        );
        echo json_encode($it['table']);
    }
}
