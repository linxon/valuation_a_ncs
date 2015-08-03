<?php   //  config.inc.php Конфигурационный файл

/*
 * Конфигурация движка
 ------------------------*/
//  Необходимое
define('DEBUG', TRUE);                  //  Режим разработчика
define('TIMEZONE', 'Europe/Moscow');
define('ENCTYPE', 'UTF-8');
define('DS', DIRECTORY_SEPARATOR, true);
define('EXT', '.php', true);
define('INC_FILE_PREFIX', '.inc');
define('CLASS_FILE_PREFIX', 'class.');
define('SESS_ID_NAME', 'sessid');
define('AJAX_EX_DIR', 'sys/ajax_exec/');
define('THEME', 'EvaluationA');

/*
 * Параметры для подключения к БД
 -----------------------------------*/
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'eval_a');
define('DB_USER', 'root');
define('DB_PASSWD', 'root');
define('DB_CHARSET', 'utf8');

//  Необходимые флажки для функций
define('IS_POST', 2);
define('IS_GET', 1);


define('INC_ROOT', dirname(__DIR__));
define('HTTP_ROOT', 'http://'.$_SERVER['HTTP_HOST'].DS.str_replace($_SERVER['DOCUMENT_ROOT'], NULL, str_replace('\\', '/', INC_ROOT)));
define('ASSET_ROOT', 'http://'.$_SERVER['HTTP_HOST'].DS.str_replace($_SERVER['DOCUMENT_ROOT'], NULL, str_replace('\\', '/', INC_ROOT)));