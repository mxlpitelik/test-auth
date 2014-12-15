<h1>Авторизация</h1>
<p>Введите свой адрес электронной почты и пароль</p>
<center>
<div class="loginarea">
    <p id="auth_err_0">Неверная пара логин/пароль</p>
    <p id="auth_err_1">Пользователь заблокирован</p>
    <input type="text" id="email" placeholder="электронная почта"><br>
    <input type="password" id="password" placeholder="пароль"><br>
    <button onclick="login();">Войти</button><br>
    <br>
    Войти через социальные сети<br>
    <a href="<?php echo oauth::fb_link(); ?>"><image src="https://www.facebook.com/images/fb_icon_325x325.png" width="32" height="32" /></a>
    <br>
    <br>
    Вы еще не зарегистрированы?<br>
    <a href="/test-auth/user/registration">Зарегистрируйтесь</a>
</div>
</center>
<p>*тут кстати тоже проверяется вошел ли пользователь, и если да, то кидает в кабинет</p>