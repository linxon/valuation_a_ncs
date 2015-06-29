<?php

require('sys/init.inc.php');

use Sys\Classes\Router as R;

/*
 * Устанавливаем параметры маршрутизации
  ------------------------------------------ */
$boot = new R(array(
    
    //  Обязательные параметры
    'handler' => 'route', // Устанавливаем ключ который будет принимать GET параметры в URL строке
    'error_page' => 'error', //  Страница ошибки 404 Not Found
    'views_dir' => './views/', //  Область видимости контроллеров роутером для аналогово подключения...
    
    'route_pos' => 3    //  Устанавливаем позицию перенаправляемого корневого каталога (если работа ведется не с корневого каталога - www.example.com/Dev/MySite/ - 3-й слеш третья позиция)
));

/*
 * Добавляем рабочие пункты
  ----------------------------- */
$boot->add('/', 'index');
$boot->add('/main', 'index');
$boot->add('/index', 'index');
$boot->add('/blog', 'blog');
$boot->add('/auth', 'auth');

//var_dump($GLOBALS);
//var_dump($boot);

//  Запускаем маршрутизацию
$boot->submit();
