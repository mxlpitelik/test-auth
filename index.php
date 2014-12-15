<?php
    require_once 'lib/application/init.php';
    
    global $_app;
    $_app= new Index();
    $_app->start();
?>