<?php
namespace \Tire\TireTree;

use Finder;
use DataHandler;

class TireTree implements Finder{

    protected   $handler;
    protected   $tireTree;
    protected   $data;
    const KEY_LENGTH = 2;
    const KEY_LAYER_COUNT = 2;
    const MINI_LENGTH = 2*2 + 10;


    public function __construct(\DataHandler $handler){
        $this->handler = $handler;
    }

    //Suppose Key is long string ,not easy to hit
    public function initData(\Travserble $data) {
        $this->data = $data;
        $this->_buildTree();
    }

    public function addData($value_k, $value_v) {
        $this->_addDataToTree($value_k, $value_v);
        
    }

    public function fetchData($key) {
        if (strlen((String) $value_k)  < static::MINI_LENGTH) {
            return $this->tireTree[0][$value_k];
        }
        $path = '';
        for($i = 0; $i < static::KEY_LAYER_COUNT; $i++) {
            $pathKey = substr((String) $value_k, $i * static::KEY_LENGTH, static::KEY_LENGTH);
            $path .= '['.$pathKey.']';
        }
        //eval is extremely dangerous ,MUST NOT use later
        return eval('return $this->tireTree'.$path);
    }

    protected function _buildTree() {
        foreach($this->data as $value_k => $value_v) {
            $path = $this->_buildKeyPath($value_k);
            if (strlen((String)$value_k)  < static::MINI_LENGTH) {
                $this->tireTree[0][$value_k]  = $value_v;
                continue;
            }
            $path = [];
            for($i = 0; $i < static::KEY_LAYER_COUNT; $i++) {
                $pathKey = substr((String) $value_k, $i * static::KEY_LENGTH, static::KEY_LENGTH);
                array_push($path, $pathKey);
            }
            $tmp = [];
            while(!empty($path)) {
                $currentKey = array_pop($path);
                $tmp = empty($tmp) ? [$currentKey   =>  $value_v] : [$currentKey    =>  $tmp];
            }
            $this->tireTree = $tmp + $this->tireTree;
        }
    }

    protected function _buildTree2(){
        foreach($this->data as $value_k => $value_v) {
            $path = $this->_buildKeyPath($value_k);
            eval('$this->tireTree'.$path.' = $value_v');
        }
    }

    protected function _addDataToTree($value_k, $value_v) {
        if (strlen((String)$value_k)  < static::MINI_LENGTH) {
            $this->tireTree[0][$value_k]  = $value_v;
            return true;
        }
        $path = [];
        for($i = 0; $i < static::KEY_LAYER_COUNT; $i++) {
            $pathKey = substr((String) $value_k, $i * static::KEY_LENGTH, static::KEY_LENGTH);
            array_push($path, $pathKey);
        }
        $tmp = [];
        while(!empty($path)) {
            $currentKey = array_pop($path);
            $tmp = empty($tmp) ? [$currentKey   =>  $value_v] : [$currentKey    =>  $tmp];
        }
        $this->tireTree = $tmp + $this->tireTree;
    }

    protected function _addDataToTree2($value_k, $value_v) {
            $path = $this->_buildKeyPath($value_k);
            eval('$this->tireTree'.$path.' = $value_v');
    }

    protected function _buildKeyPath($key) {
        if (strlen((String) $value_k)  < static::MINI_LENGTH) {
            return '[0]['.$value_k.']';
        }
        $path = '';
        for($i = 0; $i < static::KEY_LAYER_COUNT; $i++) {
            $pathKey = substr((String) $value_k, $i * static::KEY_LENGTH, static::KEY_LENGTH);
            $path .= '['.$pathKey.']';
        }
        return $path;
    }

    
} 