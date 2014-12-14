<?php

class Controller {
    
    public $model;
    public $view;
    
    function __construct()
    {
    }
    
    function loadModel($model_name)
    {
        // подцепляем файл с классом модели (файла модели может и не быть)
        // если в бд нет нужды обращаться то зачем нам он
        $model_file = strtolower($model_name).'.php';
        $model_path = "lib/application/models/".$model_file;
//        echo $model_path;
        if(file_exists($model_path))
        {
            include $model_path;
            $this->model = new $model_name();

            return true;
        }
        else return false;
    }
    function loadView($content_view, $template_view = null, $data= null)
    {
        $this->view = new View();
        $this->view->generate($content_view, $template_view, $data);
    }
    function loadJsonView($data= null)
    {
        $this->loadView('json_view.php', null, $data);
    }
}

?>