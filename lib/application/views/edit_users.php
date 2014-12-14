<div class="content">
    
    <table id="userlist" cellspacing="0">
        <tr class="head">
            <td>id</td>
            <td>Email</td>
            <td>Пароль</td>
            <td>Активен</td>
            <td>Удалить</td>
            <td>facebook</td>
        </tr>
<?php
    foreach ($userlist as $u) {
        echo '<tr userid="',$u['id'],'">
                <td>',$u['id'],'</td>
                <td class="email"><input type="text" value="',$u['email'],'"></td>
                <td class="password"><input type="text" value=""></td>
                <td class="active"><input type="checkbox" ',($u['active']?'checked="checked"':''),'></td>
                <td class="delete"><input type="checkbox"></td>
                <td>-</td>
            </tr>';
    }
?>
    </table>
    <br>
    <div id="userdatanotsaved">Изменения не сохранены</div>
        <button onclick="updateuserinfos();">Сохранить данные о пользователях</button>
        <br>
        <br>
        *можно удалить всех кроме первой записи, чтобы не потерять доступ к кабинету
</div>