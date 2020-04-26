<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Index extends CI_Controller{
    private $uploadPath = './public/';
    private $_table = "vocabulary";
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
        $data['href'] = 'vocabulary';
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
        $data['title'] = 'Từ vựng';
        $data['href'] = 'vocabulary';
        $data['header'] = array('id'=>'Từ vựng','e_name'=>'Tiếng Anh','v_name'=>'Tiếng Việt','spell'=>'Spell','category'=>'Category','action'=>'Action');
        $this->load->view('admin/list',$data);
    }
    function loadAdd($action="add",$id=""){
        $data['title'] = 'Từ vựng';
        $data['categorys'] = $this->Model->getAllTable('category');
        $data['id'] = $id;
        $data['e_name'] = "";
        $data['v_name'] = "";
        $data['spell'] = "";
        $data['type'] = "";
        $data['current_categorys']= [];
        if(!empty($id)){
            $value = $this->Model->getTable($this->_table,["id"=>$id]);
            $data['e_name'] = $value->e_name;
            $data['v_name'] = $value->v_name;
            $data['spell'] = $value->spell;
            $data['type'] = $value->type;
            foreach($this->Model->query("category",["where_in"=>["id"=>explode(",",$value->category)],"select"=>"id"]) as $it){
                $data['current_categorys'][] = $it['id'];
            }
        }
        $this->load->view('admin/vocabulary/add',$data);
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
        $arr['spell'] = strtolower(trim($this->input->post('spell')));
        $arr['category'] = implode(",",$this->input->post('category'));
        $arr['type'] = $this->input->post('type');
        if($this->myfunction->isSpecialChar($arr['e_name'])){
            echo json_encode(array("err"=>1,"msg"=> "Không thể có ký tự đặc biệt"));
            return;
        }
        $action = empty($this->input->post("id")) ? "add" : "edit";
        if($this->Model->isEmptyVocabulary($arr['e_name'],$arr['type'],$action,$this->input->post("id"))){
            if(empty($this->input->post("id"))){
                $this->Model->insert("vocabulary",$arr);
                $this->myfunction->createFileSpeakEnglish($arr['e_name']);
                echo json_encode(array("err"=>0,"msg"=> "Thêm từ vựng thành công"));
            }else{
                $this->Model->update("vocabulary",$arr,["id"=>$this->input->post("id")]);
                echo json_encode(array("err"=>0,"msg"=> "Cập nhật từ vựng thành công"));
            }

        }else{
            echo json_encode(array("err"=>1,"msg"=> "Từ này đã tồn tại"));
        }
        
        
    }
}
