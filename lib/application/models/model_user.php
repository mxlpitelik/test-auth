<?php

class Model_User extends Model
{
    public function addUser($email, $password)
    {	
        //вообще не мешало бы предусмотреть уникальные email в бд дабы избежать дублирования
        $sql="INSERT INTO `users` SET `email`=:email, `active`=1, `password`=:password";
        $vars=array(':password' => md5($password), ':email' => $email);
        $sth = $this->dbo->prepare($sql);
        return $sth->execute($vars);
    }
    public function deleteUser($id)
    {
        //запрет на удаления пользователя 1
        if($id==1) return false;

        $sql="DELETE FROM `users` WHERE `id`=:id";
        $sth = $this->dbo->prepare($sql);
        return $sth->execute(Array(':id'=>$id));
    }
    
    //изменяемые пераметры передаються массивом
    public function editUser($data)
    {
        if($data['password']) 
        {
            $sql="UPDATE `users` SET `email`=:email, `active`=:active, `password`=:password WHERE `id`=:id";
            $vars=array(':password' => md5($data['password']), ':email' => $data['email'], ':active' => $data['active'], ':id' => $data['id']);
        }
        else
        {
            $sql="UPDATE `users` SET `email`=:email, `active`=:active WHERE `id`=:id";
            $vars=array(':email' => $data['email'], ':active' => $data['active'], ':id' => $data['id']);
        }
        $sth = $this->dbo->prepare($sql);
        return $sth->execute($vars);
    }
    
    //просто возвращает список пользователей
    public function userList()
    {
        $sth = $this->dbo->prepare("SELECT * FROM `users`");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    
    //проверка совпадения логин/пароль и активности
    public function auth($email, $pass)
    {
        $sth = $this->dbo->prepare("SELECT `active` FROM `users` WHERE `email`=:email AND `password`=:password");
        $sth->execute(array(':password' => md5($pass), ':email' => $email));
        $res = $sth->fetch(PDO::FETCH_ASSOC);

        if($res)
        {
            if($res['active'])
            {
                return 55;
            }
            else
            {
                return 1;
            }
        }
        else
        {
            return 0;
        }
    }
}

?>