<?php

//  Подключаем файл инициализации приложения
require('sys/init.inc.php');

$ajax = new Sys\Classes\Ajax(array(
    
    'exec_dir' => AJAX_EX_DIR,
    
    'exec' => array(
        'add_comment' => 'add_comment.php',
        'rate_up' => 'rate_up.php',
        'rate_down' => 'rate_down.php',
    )
    
));

if($ajax->request($_POST['request'])) 
    return $ajax->result();