<?php

namespace Sys\Classes;

class DataBase {

    private $_db_host = 'localhost';
    private $_db_port = '3306';
    private $_db_name = NULL;
    private $_db_user = 'root';
    private $_db_passwd = 'root';
    private $_db_charset = 'utf8';
    public $_db = NULL;
    public $is_active = FALSE;

    public function __construct() {
        $this->_db_host = DB_HOST;
        $this->_db_port = DB_PORT;
        $this->_db_name = DB_NAME;
        $this->_db_user = DB_USER;
        $this->_db_passwd = DB_PASSWD;
    }

    public function dbInit() {
        if($this->is_active == FALSE) {
            try {
                $this->_db = new \PDO('mysql:host='.$this->_db_host.';port='.$this->_db_port.';dbname='.$this->_db_name.';charset='.$this->_db_charset, $this->_db_user, $this->_db_passwd);
                $this->is_active = TRUE;
            } catch(PDOException $ex) {
                echo $ex->getMessage();
            }
        }
    }

}
