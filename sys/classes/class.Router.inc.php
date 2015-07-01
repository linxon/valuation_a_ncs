<?php

namespace Sys\Classes;

use Sys\Classes\Template as tpl;

/**
 * Класс необходим для роутинга виртуальных каталогов
 * 
 * @package Router
 * @autor Yury Matynov <linxon>
 * @version 0.4_beta
 */
class Router {

    /**
     * Массивы, которые содержат в себе данные для работы с маршрутизацией
     * @var type 
     */
    private $_view = array();
    private $_uri = array();

    /**
     * Наименование ключа в массиве $_GET[*] который используется
     * для получения параметров из адресной строки
     * @var type 
     */
    private $_handler;

    /**
     * Страница ошибки
     * @var type 
     */
    private $_error_page;

    /**
     * Свойство, которое принимает путь к views*
     * @var type 
     */
    private $_views_dir;
    private $_params;

    public function __construct($params = array()) {
        isset($params['handler']) ? $this->_handler = $params['handler'] : $this->_handler = NULL;
        isset($params['error_page']) ? $this->_error_page = $params['error_page'] : $this->_error_page = NULL;
        isset($params['views_dir']) ? $this->_views_dir = $params['views_dir'] : $this->_views_dir = NULL;

        isset($params['params']) ? $this->_params = $params['params'] : $this->_params = NULL;
    }

    private function checkView($name) {
        return TRUE;
    }

    /**
     * Добавляем новые пункты для прослушки
     * 
     * @param type $uri
     * @param type $viewer
     * @return boolean
     */
    public function add($uri, $viewer = NULL) {
        if(empty($uri) and is_null($viewer)) return FALSE;
        else {
            if($this->checkView($viewer) == TRUE) {
                $this->_uri[] = $uri;
                if(is_null($viewer) != TRUE) {
                    $this->_view[] = $viewer;
                } else $this->_view[] = FALSE;
            }
        }
    }

    /**
     * Вынимаем данные из адресной строки
     * @return type
     */
    private function parseUri() {
        $h = $this->_handler;
        if(isset($_GET[$h]) and $_SERVER['REQUEST_METHOD'] == 'GET') return explode('/', $_GET[$h]);
        else return FALSE;
    }

    /**
     * Обработка запроса
     */
    public function submit() {

        $url = $this->parseUri();

        $path = NULL;
        foreach($this->_uri as $key => $value) {

            if($value == '/'.$url[0]) {
                $path = array(
                    'view' => $this->_view[$key],
                    'exec' => $url[0]
                );
                break;
            }
        }

        switch($path) {
            case!empty($path['view']):

                $tpl = new tpl(array(
                    'theme' => $this->_params['theme']
                ));

                $view_file = $this->_views_dir.$path['view'].EXT;

                if(file_exists($view_file) and is_readable($view_file)) $tpl->render($view_file);
                else $this->show_error(404);

                break;

            case empty($path['view']) :
                $filename = $this->_params['exec_dir'].$url[0].EXT;
                if(file_exists($filename) and is_readable($filename)) require($filename);
                else die('Ошибка во время обработки запроса');
                break;
            default :
                $this->show_error(404);
                break;
        }
    }

    private function show_error($code = NULL) {
        if(is_null($code)) return FALSE;
        else {
            $filename = $this->_views_dir.$this->_error_page.EXT;
            if(file_exists($filename) and is_readable($filename)) require($filename);
            else die('Ошибка во время обработки запроса');
        }
    }

}
