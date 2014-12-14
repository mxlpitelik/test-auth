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
    
    function method_registration($params=null)
    {
        //проверка не авторизирован ли пользователь уже
        if(isset($_SESSION['logged']) && $_SESSION['logged'])
        {
            $this->method_users();
            return false;
        }

        if($params[1]=='try' && $_POST)
        {
            $this->loadModel('model_user');

            $result=Array("result" => 55, "errors" => 0, "error" => Array() );

            //проверяем на наличие ошибок и соотвествие валидностям передаваемых данных
            //проверки на занятость мыла в ТЗ небыло поэтому не проверяем, хотя можно
            if(!$this->check_emailvalid($_POST['email'])) 
            {
                $result['error']['email']=1;
                $result['errors']=1;
            }

            if($_POST['password']!=$_POST['password2']) 
            {
                $result['error']['password2']=1;
                $result['errors']=1;
            }
            
            if( !$this->check_passvalid($_POST['password']) && $_POST['password'] ) 
            {
                $result['error']['password']=1;
                $result['errors']=1;
            }
            
            //если флаг ошибки мы так нигде и не поставили, то начинаем процедуру изминения пользователей
            if(!$result['errors'])
            {
                if($this->model->addUser($_POST['email'], $_POST['password']))
                {
                    $_SESSION['logged']=1;
                    $_SESSION['email']=$_POST['email'];
                }
                else $result['result']=0;
            }
            else $result['result']=0;

            switch($params[2])
            {
                case 'json':
                default:
                    $this->loadJsonView($result);
            }
        }
        else{
            $this->loadView('registration.php', 'template_view.php', Array("title"=>'Авторизация', "css"=>'user.css', "js"=>'user.js'));
        }
    }
    
    //отображает страницу списка пользователей (/views/users.php), удаляет, редактирует, или
    //создает пользователя если передаются соответствующие параметры
    function method_users($params = null)
    {
        //проверка не авторизирован ли пользователь уже
        if(!isset($_SESSION['logged']) || !$_SESSION['logged'])
        {
            $this->method_authorization();
            return false;
        }

        $this->loadModel('model_user');

        if($params[1])
        switch($params[1])
        {
            default:
            case 'edit':
                $this->loadView('edit_users.php', 'template_cabinet.php', Array("title"=>'Редактироваие пользователей', 
                                                                            "css"=>'cabinet.css', 
                                                                            "js"=>'user.js', 
                                                                            "userlist"=> $this->model->userList()
                                                                           ));
                break;
            case 'save':
                $result=Array("result" => 55, "errors" => 0, "deleted" => 0);

                //проверяем на наличие ошибок и соотвествие валидностям передаваемых данных
                //проверки на занятость мыла в ТЗ небыло поэтому не проверяем, хотя можно
                foreach($_POST as $u)
                {
                    if($u['delete']) continue;

                    if(
                            !$u['id'] ||
                            !$this->check_emailvalid($u['email']) || 
                            (
                                !$this->check_passvalid($u['password']) &&
                                $u['password']
                            )
                        )
                    {
                        $result['errors']=1;
                        $result['result']=0;

                        break;
                    }
                }

                //если флаг ошибки мы так нигде и не поставили, то начинаем процедуру изминения пользователей
                if(!$result['errors'])
                    foreach($_POST as $u)
                    {
                        if($u['delete']) 
                        {
                            $this->model->deleteUser($u['id']);
                            continue;
                        }
                        $this->model->editUser($u);
                    }

                switch($params[2])
                {
                    case 'json':
                    default:
                        $this->loadJsonView($result);
                }
        }
        else{
            $this->loadView('users.php', 'template_cabinet.php', Array("title"=>'Личный кабинетЪ', 
                                                                            "css"=>'cabinet.css', 
                                                                            "js"=>'user.js', 
                                                                            "userlist"=> $this->model->userList()
                                                                           ));
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