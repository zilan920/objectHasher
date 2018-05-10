<?php 
interface DataHandler{
    public function save($key, $value, $timeOut = 0);
    public function fetch($key);
}