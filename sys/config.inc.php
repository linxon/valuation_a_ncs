<?php   //  config.inc.php Конфигурационный файл

/*
 * Конфигурация движка
 ------------------------*/
//  Необходимое
define('DEBUG', TRUE);                  //  Режим разработчика
define('CONF_PREFIX', 'lin_');
define('TIMEZONE', 'Europe/Moscow');
define('ENCTYPE', 'UTF-8');
define('DS', DIRECTORY_SEPARATOR, true);
define('EXT', '.php', true);
define('INC_FILE_PREFIX', '.inc');
define('CLASS_FILE_PREFIX', 'class.');
define('SESS_ID_NAME', 'sessid');

//  Данные для подключения к БД
define('DB_HOST', "localhost");         //  Сервер
define('DB_USER', "root");              //  Пользователь
define('DB_PASSWD', "root");      //  Пароль
define('DB_NAME', "linxon_ru");         //  База данных
define('DB_PORT', "3306");              //  Порт
define('DB_CHARSET', "utf8");           //  Кодировка (utf8)
define('DB_PREFIX', CONF_PREFIX);       //  Префик таблиц в БД

define('THEME', 'EvaluationA');

define('INC_ROOT', dirname(__DIR__));
define('HTTP_ROOT', 'http://'.$_SERVER['HTTP_HOST'].DS.str_replace($_SERVER['DOCUMENT_ROOT'], NULL, str_replace('\\', '/', INC_ROOT)));
define('ASSET_ROOT', 'http://'.$_SERVER['HTTP_HOST'].DS.str_replace($_SERVER['DOCUMENT_ROOT'], NULL, str_replace('\\', '/', INC_ROOT)));

/*
 * Настройка сайта
 ---------------------*/
//  Заголовки
define('_DEFAULT_TITLE_PAGE', 'Linxon.ru', true);
define('_DESCRIPTION', 'Веб сайт для программистов и сисадминов', true);
define('_KEYWORDS', 'Веб-разработка, PHP, HTML, CSS, MySQL', true);
define('_CHARSET', 'utf-8', true);