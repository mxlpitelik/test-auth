<?php

class Index
{
    //публичное свойство, которое содержит настройки базы данных и контроллер по умолчанию
    //я бы сделал по другому и хранил конфиг в отдельном файле
    public $config=Array(
                            "db"=>Array(
                                        "db_host"=>"localhost",
                                        "db_name"=>"test-auth",
                                        "db_user"=>"root",
                                        "db_password"=>"123"   
                                     ),
                            "main_controller"=>"main",
                            "main_method"=>"index"
                        );
    
    //функции получающие имя контроллера, метода и параметры
    //и тут я бы сделал по другому, и способ получения бы не через именнованные переменные GET
    //что дало бы больше пространства для маневра в будущем
    public function getController()
    {
        if ( !empty($_GET['controller']) ) $cn = $_GET['controller'];
        else $cn = $this->config['main_controller'];
        
        return strtolower("controller_$cn");
    }
    public function getMethod()
    {
        if ( !empty($_GET['method']) ) $mn = $_GET['method'];
        else $mn = $this->config['main_method'];
        
        return strtolower("method_$mn");
    }
    public function getParams()
    {
        $params=false;
        if ( !empty($_GET['param1']) ) $params[1]=$_GET['param1'];
        if ( !empty($_GET['param2']) ) $params[2]=$_GET['param2'];

        return $params;
    }

    //функция начала сценария...запускаестя в конструкторе
    public function start()
    {
        // контроллер и действие по умолчанию
        $controller_name = $this->getController();

        //подцепляем файл с классом контроллера
        //этот файл обязательный, т.к. что делать без контроллера хз
        //поэтому - если не нашелся кидаем ошибку 404
        $controller_path = "lib/application/controllers/$controller_name.php";
//        echo $controller_path;
        if(file_exists($controller_path))
        {
            include $controller_path;
        }
        else
        {
            //правильно было бы кинуть здесь исключение,
            //но для упрощения сразу сделаем редирект на страницу 404
            Index::ErrorPage404();
        }
        
        //создаем контроллер
        //*создаем вне метода лоадМетод, дабы передать указатель, и оптимизировать память
        $controller = new $controller_name;
        
        //проверка на существование метода
        //если нет указанного метода, вызов индекса
        //если и индекса нет ошибка 404
        $method_name = $this->getMethod();
        
        if(!$this->loadMethod($controller, $method_name))
        {
            if(!$this->loadMethod($controller, 'method_'.$this->config['main_method']))
            {
                Index::ErrorPage404();
            }
        }
    }
    
    //*дабы не создавать копию класса контроллера при вызове мотеда используем указатели (небольшая оптимизация памяти)
    function loadMethod(&$controller, $method)
    {
        if(method_exists($controller, $method))
        {
            // вызываем действие контроллера
            // если есть параметры то кидаем масив данных с параметрами, если нет, то нафиг его кидать?
            $params= $this->getParams();
            if ( $params ) $controller->$method($params);
            else $controller->$method();
        
            //если метод удачно подключен был и загружен даём знать истиной
            return true;
        }
        //если нет такого метода - возвращаем фальш
        else return false;
    }
    
    function ErrorPage404()
    {
        //собственно редирект на 404 ошибку
        $host = '/test-auth/err404.html';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        die('Error 404:<br>Page cannot be displayed<br>Sorry :(');
        header("Location: $host");
    }
}

?>