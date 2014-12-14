<?php

class Controller_Main extends Controller
{
    function method_index()
    {	
        if(isset($_SESSION['logged']) && $_SESSION['logged'])
        {
            //редирект если пользователь залогинен
            $host = '/test-auth/user/list';
            header("Location: $host");
        }   
        else
        {
            $this->loadView('main_view.php', 'template_view.php', Array("title"=>'Начало', "css"=>'start.css'));
        }
    }
}

?>