<?php

namespace Sys\Classes;

class Template {

    private $_theme;
    private $_params;
    
    /**
     * Стили и прочие
     * @param type $params
     */
    public $styles;
    public $scripts;
    public $headers;

    public function __construct($params = array()) {
        isset($params['theme']) ? $this->_theme = $params['theme'] : $this->_theme = NULL;
        isset($params['params']) ? $this->_params = $params['params'] : $this->_params = array();
    }
    
    private function loadFile($part = NULL) {
        return $files = glob($part);
    }
    
    /**
     * Устанавливаем стили
     * 
     * Если второй параметр равен TRUE то запустим сканирование 
     * этих стилей по заданному ключу
     * 
     * @param type $styles
     * @param type $param
     */
    public function setStyle($styles = NULL, $param = FALSE) {
        if($param == TRUE) {
            $files = $this->loadFile($styles);

            foreach($files as $key => $value) {
                $this->styles[] = $value;
            }
        } else if(file_exists($styles) && is_readable($styles)) $this->styles[] = $styles;
    }
    
    /**
     * Устанавливаем скрипты
     * 
     * @param type $scripts\
     */
    public function setScript($scripts = NULL, $param = FALSE) {
        if($param == TRUE) {
            $files = $this->loadFile($scripts);

            foreach($files as $key => $value) {
                $this->scripts[] = $value;
            }
        } else if(file_exists($scripts) && is_readable($scripts)) $this->scripts[] = $scripts;
    }
    
    /**
     * Устанавливаем заголовки
     * 
     * @param type $headers
     */
    public function setHeaders($headers = array()) {
        if(!empty($headers)) {
            foreach($headers as $key => $val) {
                $this->headers[$key] = $val;
            }
        }
    }

    public function render($view_file) {
        $theme = './theme/'.$this->_theme.EXT;
        if(file_exists($theme) and is_readable($theme)) require($theme);
        else die('Ошибка во время обработки запроса');
    }

}
