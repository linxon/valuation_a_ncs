<?php

namespace Sys\Classes;

class Ajax {

    private $_exec_dir;
    private $_exec = array();
    private $_result = NULL;

    public function __construct(Array $params) {
        if(!empty($params)) {
            isset($params['exec_dir']) ? $this->_exec_dir = $params['exec_dir'] : $this->_exec_dir = NULL;
            if(isset($params['exec'])) {
                $this->_exec = $params['exec'];
            }
        }
    }

    public function execFile($filename) {
        if(file_exists($filename) and is_readable($filename)) return require($filename);
    }

    public function request($req_alias) {
        foreach($this->_exec as $alias => $filename) {
            if(strtolower($alias) === strtolower($req_alias)) {
                $this->_result = $this->execFile($this->_exec_dir.$filename);
                break;
            }
        }
    }

    public function result() {
        return $this->_result;
    }

}
