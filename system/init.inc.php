<?php   //  init.inc.php - Инициализация

header('Content-type: text/html; charset=utf-8');   //  Устанавливаем кодировку по умолчанию

define('CONF_FILE_NAME', 'config.inc.php');         // Задаем конфигурационный файл
define('VERSION', '0.1.26_dev');                    //  Версия движка

//  Проверяем версию PHP (Допустимо по умолчанию - 5.3.0)
if(version_compare(phpversion(), '5.3.0', '<') == TRUE) die("Приложение требует PHP выше 5.3.0 версии");
if(isset($_SERVER['HTTP_HOST']) == FALSE) die('Приложение будет работать только через WEB браузер');

/*
 * Запускаем инициализацию приложения
  ------------------------------------ */
if(FALSE == file_exists(CONF_FILE_NAME) && is_readable(CONF_FILE_NAME) == FALSE) {

        /*
         * Подключаем файл конфигурации
          --------------------------------- */
        require_once(CONF_FILE_NAME);

        /*
         * Вывод системных синтаксических ошибок
          ----------------------------------------- */
        if(DEBUG == TRUE) {

                @ini_set('display_errors', TRUE);
                @ini_set('display_startup_errors', TRUE);

                error_reporting(E_ALL);
        } else error_reporting(0);

        @date_default_timezone_set(TIMEZONE);
        @mb_internal_encoding(ENCTYPE);
        //setlocale(LC_ALL, 'en_US');

        /*
         * Подключаем необходимые функции...
          ------------------------------------- */
        require_once('functions.inc.php');

        /**
         * Автозагрузка всех необходимых классов (PSR-0)
         * http://www.php-fig.org/psr/psr-0/
         * 
         * @param type $class_name
         */
        spl_autoload_register(function($className) {

                $className = ltrim($className, '\\');

                $fileName = '';
                $namespace = '';

                if($lastNsPos = strrpos($className, '\\')) {
                        $namespace = substr($className, 0, $lastNsPos);
                        $className = substr($className, $lastNsPos + 1);
                        $fileName = strtolower(str_replace('\\', DS, $namespace).DS);
                }

                $fileName .= CLASS_FILE_PREFIX.str_replace('_', DS, $className).INC_FILE_PREFIX.EXT;
                if(file_exists($fileName) && is_readable($fileName)) require($fileName);
                
        });
        
} else die('Не найден конфигурационный файл!'); //  Завершаем скрипт в случае ошибки...