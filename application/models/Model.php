<?php
class Model extends CI_Model{
    public function query($table,$option=[]){      
        $query=$this->db;
        if(!empty($option['from'])){
            $query->from($option['from'],true);
        }
        if(!empty($option['where'])){
            $query->where($option['where']);            
        }
        if(!empty($option['whereArray'])){
            foreach($option['whereArray'] as $key=>$where){
                if(is_array($where)){
                    if(is_numeric(key($where))){
                        foreach($where as $where2){
                            $query->where($where2); 
                        }
                    }else{
                        $query->where($where); 
                    }                                       
                }else{
                    if(is_numeric($key)){
                        $query->where($where);
                    }else{
                        $query->where([$key=>$where]);
                    }
                }
            }        
        }
        if(!empty($option['left_join'])){
            foreach($option['left_join'] as $tableJoin=>$join){
                if(is_numeric($tableJoin)){
                    foreach($join as $tableJoin2=>$join2){
                        $query->join($tableJoin2,$join2,"left");
                    }
                }else{
                    $query->join($tableJoin,$join,"left");
                }
    
            }
        }        
        if(!empty($option['join'])){
            foreach($option['join'] as $tableJoin=>$join){
                if(is_numeric($tableJoin)){
                    foreach($join as $tableJoin2=>$join2){
                        $query->join($tableJoin2,$join2);
                    }
                }else{
                    $query->join($tableJoin,$join);
                }
    
            }
        }
        if(!empty($option['select'])){
            $query->select($option['select']);
        }
        if(!empty($option['limit'])){
            if(is_array($option['limit'])) $query->limit($option['limit'][0],$option['limit'][1]);
            else $query->limit($option['limit']);
        }
        if(!empty($option['group_by'])){
            $query->group_by($option['group_by']);
        }
        if(!empty($option['order_by'])){
            $query->order_by($option['order_by']);
        }
        if(!empty($option['where_in'])){
            if(is_array($option['where_in'])){
                foreach($option['where_in'] as $key=>$it){
                    if(!empty($it))$query->where_in($key,$it);
                }
            }else{
                $query->where($option['where_in']);
            }
        }
        $query=$query->get_where($table);
        if(!empty($option['first_row'])){
            return $query->first_row();
        }
        return $query->result_array();   
    }
    public function insert($table,$data){
        $this->db->insert($table,$data);
        return $this->db->insert_id();
    }
    public function delete($table,$condition){
        $this->db->delete($table,$condition);
    }
    public function update($table,$data,$condition){
        $this->db->update($table,$data,$condition);
    }
    public function getAllTable($table,$limit = '',$start = '',$order = "created_at DESC",$condition = ''){
        $select = "*";
        switch($table){
            case "vocabulary":
                $select = 'id,e_name,v_name,spell,category,type';
            break;
            case "category":
                $select = 'id,e_name,v_name';
            break;
            case "pharse":
                $select = 'id,e_name,v_name';
            break;
        }
        $query = $this->db;
        if($limit != '' && $start != ''){
            $query = $query->limit($limit,$start);
        }
        if(!empty($condition)){
            $query = $query->where($condition);
        }
        return $query->order_by($order)->select($select)->get($table)->result_array();
    }
    public function getTable($table,$condition){
        return $this->db->get_where($table,$condition)->first_row();
    }
    public function getTotal($table){
        return $this->db->get($table)->num_rows();
    }
    public function isEmptyVocabulary($vocabulary,$type,$action="add",$id=""){
        if($action=="add"){
            if(empty($this->db->get_where('vocabulary',['e_name'=>$vocabulary,'type'=>$type])->first_row())) return true;
            else return false;
        }else{
            if(empty($this->db->get_where('vocabulary',['e_name'=>$vocabulary,'type'=>$type,"id !="=>$id])->first_row())) 
                return true;
            else return false;
        }

    }
    public function isEmptyPharse($pharse,$action="add",$id=""){
        if($action=="add"){
            if(empty($this->db->get_where('pharse',['e_name'=>$pharse])->first_row())) return true;
            else return false;
        }else{
            if(empty($this->db->get_where('pharse',['e_name'=>$pharse,"id !="=>$id])->first_row())) 
                return true;
            else return false;
        }
    }
}