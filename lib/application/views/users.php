<div class="content">
    
    <table id="userlist" cellspacing="0">
        <tr class="head">
            <td>id</td>
            <td>Email</td>
            <td>Активен</td>
            <td>facebook</td>
        </tr>
<?php
    foreach ($userlist as $u) {
        echo '<tr>
                <td>',$u['id'],'</td>
                <td class="email">',$u['email'],'</td>
                <td class="active">',($u['active']?'да':'нет'),'</td>
                <td>-</td>
            </tr>';
    }
?>
    </table>
    <br>
        <button onclick="location.href='/test-auth/user/users/edit/';">Редактировать пользователей</button>

</div>