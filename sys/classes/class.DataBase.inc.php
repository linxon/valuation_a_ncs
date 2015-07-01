<?php

namespace Sys\Classes;

class DataBase {

    public $_db;
    private $_dsn;
    public $is_active = FALSE;

    public function __construct(Array $params) {
        isset($params['dsn']) ? $this->_dsn = $params['dsn'] : $this->_dsn = NULL;

        $this->dbInit();
    }

    public function dbInit() {
        if($this->is_active == FALSE) {
            try {
                $this->_db = new \PDO($this->_dsn);
            } catch(\PDOException $ex) {
                var_dump($ex->getMessage());
            }
        }
    }

}
