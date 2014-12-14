<?php

class Controller_User extends Controller
{
    function method_index()
    {
        $this->method_authorization();
    }
    
    //метод логаута пользователя
    function method_logout()
    {
        //проверка не авторизирован ли пользователь уже
        if(isset($_SESSION['logged']) && $_SESSION['logged'])
        {
            $_SESSION['logged']=null;
            unset($_SESSION['logged']);
            unset($_SESSION);
        }

        $this->method_authorization();
    }
    
    function method_authorization($params=null)
    {
        //проверка не авторизирован ли пользователь уже
        if(isset($_SESSION['logged']) && $_SESSION['logged'])
        {
            $this->method_users();
            return false;
        }

        //согласно ТЗ смотрим передаются ли параметры
        //если параметр 1 == try (пытаемся войти)
        //параметр 2 == json (ответ в формате json)
        if(
            $params && 
            $params[1]=='try' && 
            $params[2] && 
            isset($_POST['email']) && 
            isset($_POST['password'])
           )
        {
            //если все что надо передали, грузим модель для доступа к БД
            $this->loadModel('model_user');
            $result=$this->model->auth($_POST['email'], $_POST['password']);
            
            //если авторизация прошла успешно, то так и запишем в сессию
            if($result==55)
            {
                $_SESSION['logged']=true;
                $_SESSION['email']=$_POST['email'];
            }
     
            //второй параметр передает формат ответа
            //это полезно если вдруг нам потом понадобиться формат JSONP к примеру
            switch($params[2])
            {
                case 'json':
                default:
                    $this->loadJsonView(Array("logged" => $result) );
            }
        }
        else{
            //открываем базовую страницу авторизации если ничего не передавалось
            $this->loadView('authorization.php', 'template_view.php', Array("title"=>'Авторизация', "css"=>'user.css', "js"=>'user.js'));
        }
    }
    

//==========================================
    //проверка валидности мыла
    function check_emailvalid($email)
    {
        if (! preg_match( "/^[-0-9a-z_\.]+@[-0-9a-z^\.]+\.[a-z]{2,4}$/i", $email))
            return false; 
        else
            return true;
    }
    
    //проверка влаидности пароля
    function check_passvalid($pass)
    {
        //проверяем наличие в пароле символов верхнего регистра, нижнего, и цифр, только латынь и минимум 8
        if (
                ! preg_match( '/[A-Za-z0-9]{6}/', $pass) ||
                ! preg_match( '/[A-Z]/', $pass) ||
                ! preg_match( '/[a-z]/', $pass) ||
                ! preg_match( '/[0-9]/', $pass) 
            )
            return false; 
        else
            return true;
    }
}


?>