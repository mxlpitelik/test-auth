function login()
{
     $.ajax({
            data: ({email : $('#email').val(), password : $('#password').val()}),
            type: "POST",
            url: '/test-auth/user/authorization/try/json/',
            dataType: "json",
            error: function (jso) {  console.warn('Ошибка загрузки ответа сервера!'); },
            success:function(jso){
                    if(jso.logged==55)
                    {
                        console.info('Авторизация успешна, переходм в сеть, кабинет: '+jso.usertype);
                        location.href='/test-auth/user/users';
                    }
                    else if(jso.logged==1)
                    {
                        console.log(jso);
                        console.warn('Пользователь блокирован!');
                    }
                    else 
                    {
                        console.log(jso);
                        console.warn('Ошибка авторизации логин/пароль не совпадают!');
                    }
                }
         });
}

function register()
{
     $.ajax({
            data: ({email : $('#email').val(), password : $('#password').val(), password2 : $('#password2').val()}),
            type: "POST",
            url: '/test-auth/user/registration/try/json/',
            dataType: "json",
            error: function (jso) {  console.warn('Ошибка загрузки ответа сервера!'); },
            success:function(jso){
                    if(jso.result==55)
                    {
                        $('.regarea p').hide();
                        console.info('Регистрация успешна, переходм в сеть, кабинет: '+jso.usertype);
                        location.href='/test-auth/user/users';
                    }
                    else 
                    {
                        $('.regarea p').hide();
                        for(key in jso.error)
                        {
                            $('.regarea p.reg_err_'+key).show();
                        }
                        console.log(jso);
                        console.warn('Ошибка регистрации!');
                    }
                }
         });
}

function updateuserinfos()
{
    var users={}, udel=0;
    $("#userlist tr[userid]").each(function(i)
    {
        uid=$(this).attr('userid');
        users[uid]={
            "id": uid,
            "email": $(this).find('td.email input').val(),
            "password": $(this).find('td.password input').val(),
            "active": $(this).find('td.active input:checked').length,
            "delete": $(this).find('td.delete input:checked').length
        };

        if($(this).find('td.delete input:checked').length) udel++;
    });
    
    if(udel) 
        if(!window.confirm('Вы уверены что хотите удалить [ '+udel+' ] пользователей?'))
            return 0;
    
    $.ajax({
            data: users,
            type: "POST",
            url: '/test-auth/user/users/save/json/',
            dataType: "json",
            error: function (jso) {  console.error(jso.responseText); console.warn('Ошибка загрузки ответа сервера!'); },
            success:function(jso){
                    if(jso.result==55)
                    {
                        console.info('изминения сохранены');
                        console.info(jso);
                        location.href='/test-auth/user/users';
                    }
                    else 
                    {
                        $('#userdatanotsaved').show();
                        console.log(jso);
                        console.warn('Ошибка сохранения!');
                    }
                }
         });
}