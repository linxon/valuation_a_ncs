<?php

namespace Sys\Classes;

use Sys\Classes\DataBase;

/**
 * Базовый класс необходим для авторизации пользователя
 * 
 * @package AuthBase
 * @autor Yury Martynov <linxon> http://www.linxon.ru
 * @version 0.1
 */
class AuthBase extends DataBase {

    /**
     * Обрабатываемые данные
     * 
     * @var type 
     */
    private $_login_;                //  Логин
    private $_password_;             //  Пароль
    private $_new_password_;         //  Новый пароль
    private $_email_;                //  E-Mail
    private $_hash_;                 //  Уникальный идентификатор

    /**
     * БД
     * 
     * @var type 
     */
    private $_sql_;                    //  Пример запроса

    /**
     * Прочая конфигурация
     * 
     * @var type 
     */
    private $_passwd_prefix_;
    private $_login_regul_synt_;
    private $_rem_sid_name_;
    private $_back_list = array();

    /**
     * Инициализирем класс
     */
    function __construct() {

        $this->_login_ = NULL;
        $this->_password_ = NULL;
        $this->_email_ = NULL;
        $this->_hash_ = NULL;

        $this->_sql_ = '';

        $this->_passwd_prefix_ = '1234567890abcdefg';  //  Префикс для пароля (fcacc7b2b991fd2a731c7)

        $this->_login_regul_synt_ = '/^[a-zA-Z0-9\-\_?]*$/';  //  Регулярка для проверки вводимых данных
        $this->_rem_sid_name_ = 'remsid';   //  Название переменной в куках 
    }

    private function auth_db_init() {
        
    }

    private function check_cookie($cook_name) {
        if(isset($_COOKIE[$cook_name])) {
            return TRUE;
        } else return FALSE;
    }

    /**
     * Проверка пользователя на существование
     * 
     * @param type $login
     * @param type $email
     * @return boolean
     */
    private function check_new_user($login, $email) {
        if(isset($login, $email)) {
            
            if($this->is_active == FALSE) $this->dbInit();
            //  Проверяем логин
            $res = $this->_db->query("SELECT username FROM users WHERE username='".$login."' UNION SELECT email FROM users WHERE email='".$email."'");
            
            var_dump($res);
            $row = $res->fetchColumn();
            
            

            if(strtolower($row['username']) != strtolower($login) && $row['email'] != $email) {
                return TRUE;
            } else return FALSE;
        }
    }

    /**
     * Устанавливаем лимит на авторизацию (заморозил - для этих целей будем использовать Fil2Ban)
     * 
     * @param type $num
     * @param type $param
     * @return boolean
     */
    private function check_limit($num, $param = NULL) {
        if(isset($num) && is_int($num)) {
            
            if($this->is_active == FALSE) $this->dbInit();

            $db = new DataBase();
            $this->_sql_ = "SELECT last_ip FROM users WHERE login='".$this->_login_."'";
            $result = db_connect($this->_sql_);

            $row = $result->fetch_assoc();
        } else return FALSE;
    }

    /**
     * Генерируем уникальный хеш
     * 
     * @param type $login
     * @param type $passwd
     * @return boolean
     */
    private function gen_user_hash($login, $passwd) {
        if(isset($login, $passwd)) {
            return md5($passwd.$login).str_shuffle($this->_passwd_prefix_).md5($login);
        } else return FALSE;
    }

    /**
     * Генерируем уникальный идентификатор
     * 
     * @param type $chars
     * @param type $lenght
     * @return type
     */
    public function gen_user_id($chars = NULL, $lenght = NULL) {
        if(!is_null($chars) && !is_null($lenght)) {
            $res = '';
            for($i = 0; $i < $lenght; $i++) {
                $res .= $chars[rand(1, $lenght)];
            }
            $db = new DataBase();
            $this->_sql_ = "SELECT identify FROM users WHERE identify='".$res."'";
            $db_res = $db->query($this->_sql_);
            $row = $db_res->fetch_assoc();
            if($row['identify'] != '') {
                $this->gen_user_id($chars, $lenght);
            } else return $res;
        }
    }

    /**
     * Проверка на авторизацию
     * 
     * @return boolean
     */
    public function is_auth() {
        if(isset($_COOKIE[$this->_rem_sid_name_])) {

            if($this->is_active == FALSE) $this->dbInit();
            
            
            $this->_sql_ = "SELECT hash FROM users WHERE hash='".$_COOKIE[$this->_rem_sid_name_]."'";
            $res = $this->_db->query($this->_sql_);
            $row = $res->fetchAll();

            if($row['hash'] === $_COOKIE[$this->_rem_sid_name_]) {
                return TRUE;
            } else return FALSE;
        } else return FALSE;
    }

    /**
     * Регистрация пользователя
     * 
     * @param type $data
     * @return boolean|string
     */
    public function reg_user($data = array()) {
        if(!empty($data)) {
            if(is_array($data) && isset($data['login'], $data['passwd'], $data['email'])) {

                //  Очищаем от всякой нечисти и привязываем их к свойствам объекта
                $this->_email_ = strtolower(trim(strip_tags(htmlspecialchars(stripslashes($data['email'])))));
                $this->_login_ = trim(strip_tags(htmlspecialchars(stripslashes($data['login']))));
                $this->_password_ = trim(stripslashes($data['passwd']));    //  Следует зашифровать...
                unset($data);

                //  Проверяем введенные данные
                if(preg_match($this->_login_regul_synt_, $this->_login_) && preg_match('/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i', $this->_email_)) {
                    //  Максимальное число вводимых знаков
                    if(strlen($this->_login_) >= 3 && strlen($this->_login_) <= 15 && strlen($this->_password_) >= 6 && strlen($this->_password_) <= 25) {
                        //  на существование пользователя
                        if($this->check_new_user($this->_login_, $this->_email_) == TRUE) {

                            //  Генерируем уникальный идентификатор
                            $user_hash = $this->gen_user_hash($this->_login_, $this->_password_);

                            //  Шифруем пароль + солим
                            $crypt_passwd = md5(strrev($this->_password_.$this->_passwd_prefix_));

                            if($this->is_active == FALSE) $this->dbInit();
                            //  И записываем их в БД
                            $res = $this->_db->prepare('INSERT INTO users(username, password, email, hash) VALUES('
                                    .'":login", '
                                    .'":crypt_passwd", '
                                    .'":email",'
                                    .'":user_hash",');
                            $row = $res->execute(array(
                                ':login' => $this->_login_,
                                ':crypt_passwd' => $crypt_passwd,
                                ':email' => $this->_email_,
                                ':user_hash' => $this->_hash_
                            ));
                            
                            if($row) {   //  Если подключение к БД успешное то авторизовываем пользователя
                                //  Авторизовываем пользователя без предварительной проверки (Ключ 'd')
                                if($this->auth_user(array('login' => $this->_login_, 'passwd' => $this->_password_), 'd')) return TRUE;
                                else return FALSE;
                            } else return FALSE;
                        } else return 'Ошибка: Такой логин или e-mail уже используется';
                    } else return 'Ошибка: Логин: от 3 до 15; Пароль: 6 - 25 символов';
                } else return 'Ошибка: Логин может состоять только из букв английского алфавита и цифр (a-z, A-Z, 0-9)';
            } else return FALSE;
        }
    }

    /**
     * Авторизация пользователя
     * 
     * @param type $data
     * @param type $param
     * @return boolean|string
     */
    public function auth_user($data = array(), $params = NULL) {
        if(!empty($data) && is_array($data)) {
            if(isset($data['login'], $data['passwd'])) {

                //  Очищаем от нечисти
                if($params != 'd') {
                    $this->_login_ = trim(strip_tags(htmlspecialchars(stripslashes($data['login']))));
                    $this->_password_ = trim(stripslashes($data['passwd']));
                    unset($data);
                }

                //  Проверяем введенные данные
                if(preg_match($this->_login_regul_synt_, $this->_login_)) {

                    $db = new DataBase();
                    $this->_sql_ = "SELECT username,password,hash FROM users WHERE username='".$this->_login_."'";
                    $res = $db->query($this->_sql_, 'e');

                    $row = $res->fetch_assoc();
                    if(strtolower($row['username']) === strtolower($this->_login_) && $row['password'] === md5(strrev($this->_password_.$this->_passwd_prefix_))) {

                        if(setcookie($this->_rem_sid_name_, $row['hash'], time() + (60 * 60 * 24 * 30), '', '', FALSE, TRUE)) {

                            if(session_status() === PHP_SESSION_ACTIVE) {
                                $_SESSION['name'] = $this->_rem_sid_name_;
                            }

                            return TRUE;
                        } else return FALSE;
                    } else return "Ошибка: Неверный логин или пароль";
                } else return "Ошибка: Неверный логин или пароль";
            } else return FALSE;
        }
    }

    /**
     * Запрос на восстановления пароля
     * 
     * @param type $data
     * @param type $sub
     * @param type $mess
     * @return boolean|string
     */
    public function recovery_pass($data = array(), $sub, $mess) {
        if(isset($data, $sub, $mess) && !empty($data)) {

            $this->_email_ = strtolower(trim(strip_tags(htmlspecialchars(stripslashes($data['email'])))));
            unset($data);

            if(preg_match('/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i', $this->_email_)) {

                $db = new DataBase();

                //  Отправляем запрос
                $this->_sql_ = "SELECT email FROM users WHERE email='".$this->_email_."'";
                $res = $db->query($this->_sql_, 'e');
                $row = $res->fetch_assoc();

                //  Обрабатываем
                if($row['email'] == $this->_email_) {

                    $send = new EmailSender($sub, $mess);
                    $send->send_to($this->_email_); //  отправляем сообщение

                    if($send) return 'Сообщение с инструкцией было отправлено вам на E-mail';
                    else return 'Ошибка во время отправки';
                } return 'Введен несуществующий Логин или Email';
            } else return 'Ошибка во время отправки';
        } else return FALSE;
    }

    /**
     * Метод для изменения пароля
     * 
     * @param type $old_pass
     * @param type $new_pass
     * @return boolean
     */
    public function change_pass($old_pass = NULL, $new_pass = NULL) {
        if(FALSE == is_null($old_pass) && is_null($new_pass) == FALSE) {

            //  Очищаем от нечисти
            $this->_password_ = trim(strip_tags(htmlspecialchars(stripslashes($old_pass))));
            $this->_new_password_ = trim(stripslashes($new_pass));
            unset($new_pass);

            $db = new DataBase();
            $this->_sql_ = "SELECT password FROM users WHERE hash='".$_COOKIE[$this->_rem_sid_name_]."'";
            $res = $db->query($this->_sql_);
            $row = $res->fetch_assoc();

            $this->_new_password_ = md5(strrev($this->_new_password_.$this->_passwd_prefix_));
            if($row['password'] != $this->_new_password_) {
                $this->_sql_ = "UPDATE users SET password='".$this->_new_password_."' WHERE hash='".$_COOKIE[$this->_rem_sid_name_]."'";
                return $db->query($this->_sql_);
            } else return FALSE;
        }
    }

    /**
     * Отдаем необходимую информацию о пользователе
     * 
     * @param type $data
     * @return type
     */
    public function user_profile($data = NULL, $id = NULL) {

        $db = new DataBase();

        //  Если пришел идентификатор то вынимаем информацию по идентификатору
        if(FALSE == is_null($id)) {

            $sql = "SELECT * FROM users WHERE user_id='".$id."'";
            if(!empty($data)) {

                $result = $db->query($sql);
                $row = $result->fetch_assoc();

                foreach($row as $key => $value) {
                    if($key == $data) return $value;
                }

                return TRUE;
            } else {
                $result = $db->query($sql);
                return $row = $result->fetch_assoc();
            }
        } else {    //  Если идентификатор пустой то вынимаем информацию авторизованного пользователя
            $sql = "SELECT * FROM users WHERE hash='".$_COOKIE[$this->_rem_sid_name_]."'";
            if(!empty($data)) {

                $result = $db->query($sql);
                $row = $result->fetch_assoc();

                foreach($row as $key => $value) {
                    if($key == $data) return $value;
                }

                return TRUE;
            } else {
                $result = $db->query($sql);
                return $row = $result->fetch_assoc();
            }
        }
    }

    /**
     * Применение настроек пользователя
     * 
     * @param type $key
     * @param type $value
     * @return type
     */
    public function apply_settings($key = NULL, $value = NULL) {
        if(FALSE == is_null($key) && is_null($value) == FALSE) {
            $db = new DataBase();
            $this->_sql_ = "UPDATE users SET ".trim($key)."='".trim($value)."' WHERE hash='".$_COOKIE[$this->_rem_sid_name_]."'";
            return $db->query($this->_sql_);
        }
    }

    /**
     * Выход из системы
     * 
     * @return boolean
     */
    public function logout() {
        if(!empty($_COOKIE) || !empty($_SESSION)) {

            unset($_SESSION);
            session_destroy();

            //  Очищаем сессию
            if(setcookie($this->_rem_sid_name_, time() - (60 * 60 * 24 * 30) - 1)) {
                if(empty($_COOKIE[$this->_rem_sid_name_])) return TRUE;
                else return FALSE;
            }
        } else return FALSE;
    }

}
