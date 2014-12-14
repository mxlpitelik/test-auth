<?php

class Model
{
    public $dbo=null;
    
    function __construct()
    {
        global $_app;
        $this->sdb($_app->config['db']);
    }

    //подключаем бд
    public function sdb($db_config)
    {
        
        try {
              $this->dbo = new PDO('mysql:host='.$db_config['db_host'].';dbname='.$db_config['db_name'], $db_config['db_user'], $db_config['db_password']);
        } catch (PDOException $e) {
            die('<br><br><br><center style="color: red;">Database connection error!</center><br><br><br>');
//            print_r($db_config);
//            die('<br><br>'.$e->getMessage());
        }
    }

    public function get_data()
    {
    }
}

?>
