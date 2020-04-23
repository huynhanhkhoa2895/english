<?php
interface Context{
    public function index();
    public function indexAjax();
    public function loadTable();
    public function delete();
}