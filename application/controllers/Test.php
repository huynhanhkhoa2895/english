<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Test extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Model');
        $this->load->library('myfunction');
    }
    function index(){
        return $this->custom_sort(array(9, 2, 18, 34, 3, 10, 15),"desc");
    }
    function custom_sort($array,$type="esc"){
        $count = count($array);
        for ($i = 0; $i < $count; $i++) {
            for ($j = $i + 1; $j < $count; $j++) {
                if($type=="esc"){
                    if ($array[$i] > $array[$j]) {
                        $temp = $array[$i];
                        $array[$i] = $array[$j];
                        $array[$j] = $temp;
                    }
                }else{
                    if ($array[$i] < $array[$j]) {
                        $temp = $array[$i];
                        $array[$i] = $array[$j];
                        $array[$j] = $temp;
                    }
                }

            }
        }
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }
}