<?php

$post = new Sys\Wigets\Comment(array(
    
    //  Устанавливае параметры соединения с БД для PDO
    'pdo_dsn' => 'pgsql:host=localhost;port=5432;dbname=comment_sys;user=postgres;password=postgres'
    
));

if(isset($_POST['send_post_msg']) && check_method() == IS_POST) {
    
    
    $post->addComment($_POST['send_post_msg']);
    
    
}
