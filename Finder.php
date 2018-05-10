<?php
interface  Finder {
    public function initData(\Travserble $datas);
    public function addData($key, $value);
    public function fetchData($key);
}