<div class="content">
    
    <table id="userlist" cellspacing="0">
        <tr class="head">
            <td>id</td>
            <td>Email</td>
            <td>Имя</td>
            <td>Фамилия</td>
            <td>Активен</td>
            <td>facebook</td>
        </tr>
<?php
    foreach ($userlist as $u) {
        echo '<tr>
                <td>',$u['id'],'</td>
                <td class="email">',$u['email'],'</td>
                <td class="name">',$u['name'],'</td>
                <td class="surname">',$u['surname'],'</td>
                <td class="active">',($u['active']?'да':'нет'),'</td>
                <td class="fb_id">',($u['fb_id']? $u['fb_id'] : 'не подключен' ),'</td>
            </tr>';
    }
?>
    </table>
    <br>
        <button onclick="location.href='/test-auth/user/users/edit/';">Редактировать пользователей</button>

</div>