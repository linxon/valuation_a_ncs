<?php

namespace Sys\Wigets;

class Comment {

    /**
     * Результат подключения к БД
     * @var type 
     */
    private $_db = NULL;
    
    /**
     * Флажок статуса подключения к БД
     * @var type 
     */
    public $is_active = FALSE;
    
    /**
     * Параметры соединения с БД для PDO
     * @var type 
     */
    private $_dsn;
    
    public $max_post;

    public function __construct(array $params) {
        if(!empty($params)) {
            isset($params['pdo_dsn']) ? $this->_dsn = $params['pdo_dsn'] : $this->_dsn = NULL;
        }
    }

    /**
     * Инициализация БД
     */
    private function dbInit() {
        if($this->is_active == FALSE) {
            try {
                $this->_db = new \PDO($this->_dsn);
                $this->is_active = TRUE;
            } catch (PDOException $ex) {
                echo $ex->getMessage();
            }
        }
    }
    
    public function getCommentTree() {
        
    }
    
    public function postComment() {
        
    }
    
    public function addComment($msg) {
        
    }
    
    /**
     * Очищаем мусор
     * @param type $obj
     * @return type
     */
    private function dbFree($obj) {
        return $this->_db = NULL;
    }

}
