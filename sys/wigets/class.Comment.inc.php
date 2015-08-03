<?php

namespace Sys\Wigets;

use Sys\Classes\DataBase;

class Comment extends DataBase {
    
    public $max_post;
    
    public function getCommentTree() {
        
    }
    
    public function postComment() {
        
    }
    
    public function addComment($msg) {
        if($this->is_active == FALSE) $this->dbInit();
        
        $res = $this->_db->prepare("INSERT INTO comments(message) VALUES(:message)");
        $res->execute(array(':message' => $msg));
        
        $this->dbFree();
    }
    
    public function showComments() {
        if($this->is_active == FALSE) $this->dbInit();
        $res = $this->_db->exec("INSERT INTO users(username) VALUES('asdasdasd')");
    }
    
    /**
     * Очищаем мусор
     * @param type $obj
     * @return type
     */
    private function dbFree() {
        return $this->_db = NULL;
    }

}
