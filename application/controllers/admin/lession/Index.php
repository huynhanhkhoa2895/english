<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Index extends CI_Controller{
    private $_table = "lession";
    function __construct(){
        parent::__construct();
        $this->load->model('Model');
        $this->load->library('myfunction');
        $this->load->helper('form');
        $this->_table = $this->uri->segment(2) == "ajax" ? $this->uri->segment(3) : $this->uri->segment(2);
        if(!$this->session->userdata("username")){
            redirect('/verify', 'refresh');
        }
    }
    function index(){
        $data['href'] = $this->_table;
        $data['action'] = empty($this->input->get('action'))? "list" : $this->input->get('action');
        $data['id'] = $this->input->get('id');
        $this->load->view('admin/admin',$data);
    }
    function indexAjax(){
        $action = $this->input->get('action');
        $id = $this->input->get('id');
        $exercise_type = $this->input->get('exercise_type');
        if($action == 'list'){
            $this->loadTable();
        }elseif($action == 'add'){
            $this->loadAdd("add","",$exercise_type);
        }elseif($action == 'edit'){
            $this->loadAdd('edit',$id);
        }elseif($action == 'createExercise'){
            $this->loadCreateExercise();
        }
    }
    function loadCreateExercise(){
        $data["title"] = "Tạo nhanh bài tập";
        $this->load->view("admin/lession/createExercise",$data);
    }
    function createExercise(){
        $val = $this->input->post("val");
        if($val <= 0) $val = 1;
        $id = $this->input->post("id");
        $lession_name = $this->Model->query($this->_table,["where"=>["id"=>$id],"first_row"=>true])->name;
        $lession_detail = $this->Model->query($this->_table."_detail",["where"=>["id"=>$id]]);
        $class = [];
        $arr = [];
        $lession = [];        
        foreach($lession_detail as $it){
            $class[$it['class']][] = $it['vocabulary_id'];
        }
        foreach(array_keys($class) as $it){
            $arr = array_merge($arr,$this->Model->query($it,["where_in"=>["id"=>$class[$it]]]));
        }
        
        $arr = $this->randomVocabulary($arr);
        $eachLession = floor(count($arr)/$val);
        $i = 0;
        $lession[$i]= [];
        foreach($arr as $it){
            if(count($lession[$i]) > $eachLession){
                $i++;
            }
            $lession[$i][] = $it;
        }
        foreach($lession as $k=>$it){
            $id_exercise = $this->Model->insert("exercise",["count"=>count($it),"lession"=>$id,"name"=>"Bài tập số $k cho bài học ".$lession_name,"student"=>$this->session->userdata("id")]);
            foreach($it as $val){
                $this->Model->insert(
                    "exercise_detail",[
                    "vocabulary_id"=>$val['id'],
                    "id"=>$id_exercise,
                    "class"=> empty($val['type']) ? "pharse" : "vocabulary"
                ]);
            }
        }
        echo json_encode(array("err"=>0,"msg"=>"Thêm thành công"));
    }
    function loadTable(){
        $data['title'] = $this->_table == 'lession' ? 'Bài học' : 'Bài tập';
        $data['href'] = $this->_table;
        $data['header'] = array('id'=>'Bài học','name'=>'Tên bài hoc','created_at'=>'Ngày tạo','updated_at'=>'Ngày cập nhật','action'=>'Action');
        $this->load->view('admin/list',$data);
    }
    function loadAdd($action = "",$id = "",$exercise_type = "vocabulary"){
        $data['title'] = $this->_table == 'lession' ? 'Bài học' : 'Bài tập';
        $data['action'] = 'edit';
        $data['categorys'] = $this->Model->getAllTable('category');
        $data['exercise_type']= $exercise_type;
        $data['id'] = $id;
        $data['data'] = [];
        $data['name'] = "";
        $data['table'] =$this->_table;
        if(!empty($id)){
            $class = [];
            $arr = [];
            $detail = $this->Model->query($this->_table."_detail",["where"=>["id"=>$id]]);
            $data['name'] = $this->Model->query($this->_table,["where"=>["id"=>$id],"first_row"=>true])->name;
            foreach($detail as $it){
                $class[$it['class']][] = $it['vocabulary_id'];
            }
            foreach(array_keys($class) as $it){
                $arr = array_merge($arr,$this->Model->query($it,["where_in"=>["id"=>$class[$it]]]));
            }
            $data['data'] = $arr;
        }
        $this->load->view('admin/lession/add',$data);
    }
    function loadVocabulary($filter = [],$type = "vocabulary"){
        $condition = [];        
        $arr=[];
        $class = [];
        $sort = '';
        if(!empty($filter)){
            if(!empty($filter['vocabulary'])){
                $condition[] = "e_name like '%".$filter['vocabulary']."%'";
            }
            if(!empty($filter['sort'])){
                $sort = "created_at ".$filter['sort'];
            }
            if(!empty($filter['date'])){
                $start = explode("_",$filter['date'])[0];
                $end = explode("_",$filter['date'])[1];
                if($start == $end)
                $condition[] = "DATE(created_at) = '$start'";
                else
                $condition[] = "DATE(created_at) >= '$start' AND DATE(created_at) <= '$end'";
            }
            if(!empty($filter['class'])){
                if($filter['class'] == 'vocabulary') $class['pharse'] = true;
                else $class['vocabulary'] = true;
            }
        }
        if($type == "vocabulary"){
            if(empty($class['vocabulary'])){
                $conditionVocabulary = [];
                if(!empty($filter['category'])) $conditionVocabulary = ['category'=>$filter['category']];
                if(!empty($filter['type'])) $conditionVocabulary = ['type'=>$filter['type']];
                foreach($this->Model->query('vocabulary',["select"=>"id,e_name,v_name,spell,category,type","whereArray"=>[$condition,$conditionVocabulary],"order_by"=>$sort]) as $vocabulary){
                    $new_arr['id'] = $vocabulary['id'];
                    $new_arr['class'] = 'vocabulary';
                    $new_arr['e_name'] = $vocabulary['e_name'];
                    $new_arr['v_name'] = $vocabulary['v_name'];
                    $new_arr['type'] = $vocabulary['type'];
                    $arr[]=$new_arr;
                    $new_arr = [];
                }
            }
            if(empty($class['pharse'])){
                foreach($this->Model->query('pharse',["select"=>"id,e_name,v_name","whereArray"=>$condition,"order_by"=>$sort]) as $pharse){
                    $new_arr['id'] = $pharse['id'];
                    $new_arr['class'] = 'pharse';           
                    $new_arr['e_name'] = $pharse['e_name'];
                    $new_arr['v_name'] = $pharse['v_name'];
                    $arr[]=$new_arr;
                    $new_arr = [];
                }
            }
        }elseif($type == "communication"){
            foreach($this->Model->query('communication',["select"=>"id,e_name,v_name","whereArray"=>["student_id"=>$this->session->userdata("id")],"order_by"=>$sort]) as $it){
                $new_arr['id'] = $it['id'];
                $new_arr['class'] = 'communication';
                $new_arr['e_name'] = $it['e_name'];
                $new_arr['v_name'] = $it['v_name'];
                $arr[]=$new_arr;
                $new_arr = [];
            }
        }
        return $arr;
    }
    function loadTableVocabulary(){
        $data['vocabulary'] = [];
        $data['vocabulary'] = $this->loadVocabulary($this->input->post('filter'),$this->input->post('exercise_type'));   
        $this->load->view('admin/lession/table-vocabulary',$data);
    }
    function randomLession(){
        $arr = $this->loadVocabulary();
        $max = $this->input->get('count');
        $tmp_arr = [];
        $new_arr = [];
        if($max > count($arr)) $max = count($arr);
        while(count($tmp_arr)<$max){
            $numbers = rand(0, (count($arr)-1));
            if(empty($tmp_arr)){
                $tmp_arr[] = $numbers;
            }else{
                $check = true;
                foreach($tmp_arr as $it){
                    if($numbers == $it) $check = false;
                }
                if($check) $tmp_arr[] = $numbers;
            }
        }
        foreach($tmp_arr as $it){
            $new_arr[] = $arr[$it];
        }        
        echo json_encode($new_arr);
    }
    function randomVocabulary($arr){
        $max = count($arr);
        $tmp_arr = [];
        $new_arr = [];
        if($max > count($arr)) $max = count($arr);
        while(count($tmp_arr)<$max){
            $numbers = rand(0, (count($arr)-1));
            if(empty($tmp_arr)){
                $tmp_arr[] = $numbers;
            }else{
                $check = true;
                foreach($tmp_arr as $it){
                    if($numbers == $it) $check = false;
                }
                if($check) $tmp_arr[] = $numbers;
            }
        }
        foreach($tmp_arr as $it){
            $new_arr[] = $arr[$it];
        }        
        return $new_arr;
    }
    function delete(){
        $id = $this->uri->segment(4);
        $this->Model->delete($this->_table,['id'=>$id]);
    }
    function add(){
        $data = $this->input->post('data');
        $name = $this->input->post('name');
        $table = $this->input->post('table');
        $id_current = $this->input->post('id');
        $exercise_type = $this->input->post('exercise_type');
        
        if(!empty($id_current)){
            $this->Model->update($table,['name'=>$name,'count'=>count($data),"student"=>$this->session->userdata("id")],["id"=>$id_current]);
            $this->Model->delete($table.'_detail',["id"=>$id_current]);
            foreach($data as $it){
                $this->Model->insert($table.'_detail',['class'=>$it['class'],'vocabulary_id'=>$it['id'],'id'=>$id_current]);
            }
            echo json_encode(array("err"=>0,"msg"=>"Update thành công","action"=>"edit"));
        }else{
            $id = $this->Model->insert($table,['name'=>$name,'count'=>count($data),"student"=>$this->session->userdata("id"),"type"=>$exercise_type]);
            foreach($data as $it){
                $this->Model->insert($table.'_detail',['class'=>$it['class'],'vocabulary_id'=>$it['id'],'id'=>$id]);
            }
            echo json_encode(array("err"=>0,"msg"=>"Thêm thành công","action"=>"add"));
        }

    }
}
