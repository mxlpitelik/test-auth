<?php

class View
{
    function __construct()
    {
    }
    
    function generate($content_view, $template_view = null, $data = null)
    {
        // преобразуем элементы массива в переменные
        if(is_array($data)) { extract($data); }

        if($template_view) include 'lib/application/views/'.$template_view;
        else include 'lib/application/views/'.$content_view;
    }
}

?>