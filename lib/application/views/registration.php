<h1>Регистрация нового пользователя</h1>
<p>Введите свой адрес электронной почты и пароль</p>
<center>
<div class="regarea">
    <p class="reg_err_email">Формат email неверен</p>
    <input type="text" id="email" placeholder="электронная почта"><br>
    <p class="reg_err_password">Формат пароля неверен</p>
    <p class="reg_err_password podskazka"><b>6 символов</b>: большие и маленькие латинские буквы и цифры</p>
    <input type="password" id="password" placeholder="пароль"><br>
    <p class="reg_err_password2">Пароли не свпадают</p>
    <input type="password" id="password2" placeholder="пароль, ещё раз"><br>
    <button onclick="register();">Зарегистрироваться</button><br>
    <br>
    Вы еще уже зарегистрированы?<br>
    <a href="/test-auth/user/authorization">Авторизироваться</a>
</div>
</center>
<p>*тут кстати тоже проверяется вошел ли пользователь, и если да, то кидает в кабинет</p>