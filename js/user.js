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