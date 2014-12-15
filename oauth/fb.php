<?php

require_once '../lib/application/core/oauth.php';

$oa=new oauth();

if(isset($_GET['code']))
{
    session_start();
    $_SESSION['fb']=$oa->method_fb();
    $host = '/test-auth/user/authorization/';
    header("Location: $host");
}
else 
{
    echo '<a href="'.$oa->fb_link().'">Facebook Авторизация</a>';
}
    
?>