<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Index extends CI_Controller{
    private $uploadPath = './public/';
    private $_table = "pharse";
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
        $data['href'] = 'pharse';
        $data['action'] = $this->input->get('action');
        $data['id'] = $this->input->get('id');
        $this->load->view('admin/admin',$data);
    }
    function indexAjax(){
        $action = $this->input->get('action');
        $id =  $this->input->get('id');
        if($action == 'list'){
            $this->loadTable();
        }elseif($action == 'add'){
            $this->loadAdd();
        }elseif($action == 'edit'){
            $this->loadAdd($action,$id);
        }
    }
    function loadTable(){
        $data['title'] = 'Cụm từ';
        $data['href'] = 'pharse';
        $data['header'] = array('id'=>'Cụm từ','e_name'=>'Tiếng Anh','v_name'=>'Tiếng Việt','action'=>'Action');
        $this->load->view('admin/list',$data);
    }
    function loadAdd($action="add",$id=""){
        $data['title'] = 'Từ vựng';
        $data['categorys'] = $this->Model->getAllTable('category');
        $data['id'] = $id;
        $data['e_name'] = "";
        $data['v_name'] = "";
        if(!empty($id)){
            $value = $this->Model->getTable($this->_table,["id"=>$id]);
            $data['e_name'] = $value->e_name;
            $data['v_name'] = $value->v_name;
        }
        return $this->load->view('admin/pharse/add',$data);
    }
    function postExcel(){        
        if(isset($_FILES['fileExcel'])){
            $allowedFileType = array('application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            if(in_array($_FILES["fileExcel"]["type"],$allowedFileType)) {
                $targetPath = $this->uploadPath . $_FILES['fileExcel']['name'];
                move_uploaded_file($_FILES['fileExcel']['tmp_name'], $targetPath);
                $file = $targetPath;
                $this->load->library('excel');
                $objPHPExcel = PHPExcel_IOFactory::load($file);
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $totalCol = PHPExcel_Cell::columnIndexFromString('E');
                $arr = [];
                $count = 0;
                for ($row = 2; $row <= $highestRow; $row++){
                    for($col = 0;$col < $totalCol; $col++){
                        $i = '';
                        $val = strtolower(trim($sheet->getCellByColumnAndRow($col,$row)->getValue()));
                        if(empty($val)) continue;
                        switch($col){
                            case 0: $i = 'e_name';                             
                            break;
                            case 1: $i = 'v_name';                             
                            break;
                            case 2: $i = 'spell';                             
                            break;
                            case 3: $i = 'type';                             
                            break;
                            case 4: $i = 'category';                             
                            break;
                        }
                        $arr[$i] = $val;
                        if(empty($i)) continue;
                    };
                    if(str_word_count($arr['e_name']) == 1){
                        if($this->Model->isEmptyVocabulary($arr['e_name'],$arr['type'])){                        
                            $this->Model->insert("vocabulary",$arr);
                            $this->myfunction->createFileSpeakEnglish($arr['e_name']);
                            $count++;
                        }
                    }else{
                        if($this->Model->isEmptyPharse($arr['e_name'])){                        
                            $this->Model->insert("pharse",$arr);
                            $this->myfunction->createFileSpeakEnglish($arr['e_name']);
                            $count++;
                        } 
                    } 
                    $arr = [];
                }
                unlink($file);
                echo json_encode(array("err"=>0,"msg"=>"Bạn vừa thêm $count từ vào bảng"));               
            }else{
                echo json_encode(array("err"=>1,"msg"=>"Không phải file excel"));
            }            
        }else{
            echo json_encode(array("err"=>1,"msg"=>"File không tồn tại"));
        }        
    }
    function add(){
        if(empty($this->input->post('e_name')) || empty($this->input->post('v_name'))){
            echo json_encode(array("err"=>1,"msg"=> "Điền đầy đủ thông tin"));
            return;
        }
        $arr['e_name'] =strtolower(trim($this->input->post('e_name')));
        $arr['v_name'] =strtolower(trim($this->input->post('v_name')));
        $action = empty($this->input->post("id")) ? "add" : "edit";
        if($this->myfunction->isSpecialChar($arr['e_name'])){
            echo json_encode(array("err"=>1,"msg"=> "Không thể có ký tự đặc biệt"));
            return;
        }
        if($this->Model->isEmptyPharse($arr['e_name'],$action,$this->input->post("id"))){
            if(empty($this->input->post("id"))){
                $this->Model->insert("pharse",$arr);
                $this->myfunction->createFileSpeakEnglish($arr['e_name']);
                echo json_encode(array("err"=>0,"msg"=> "Thêm từ vựng thành công"));
            }else{
                $this->Model->update("pharse",$arr,["id"=>$this->input->post("id")]);
                echo json_encode(array("err"=>0,"msg"=> "Cập nhật từ vựng thành công"));
            }

        }else{
            echo json_encode(array("err"=>1,"msg"=> "Từ này đã tồn tại"));
        }
        
    }
}
