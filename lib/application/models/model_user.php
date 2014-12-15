<?php

class Model_User extends Model
{
    public function addUser($email, $password, $name='', $surname='', $fb_id=null)
    {	
        //вообще не мешало бы предусмотреть уникальные email в бд дабы избежать дублирования
        $sql="INSERT INTO `users` SET `email`=:email, `active`=1, `password`=:password, `name`=:n, `surname`=:sn, `fb_id`=:fbid";
        $vars=array(':password' => md5($password), ':email' => $email, ':n' => $name, ':sn' => $surname, ':fbid' => $fb_id);
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
            $sql="UPDATE `users` SET `name`=:name, `surname`=:surname, `email`=:email, `active`=:active, `password`=:password WHERE `id`=:id";
            $vars=array(':password' => md5($data['password']), ':surname' => $data['surname'], ':name' => $data['name'], ':email' => $data['email'], ':active' => $data['active'], ':id' => $data['id']);
        }
        else
        {
            $sql="UPDATE `users` SET `name`=:name, `surname`=:surname,  `email`=:email, `active`=:active WHERE `id`=:id";
            $vars=array(':surname' => $data['surname'], ':name' => $data['name'], ':email' => $data['email'], ':active' => $data['active'], ':id' => $data['id']);
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
    public function auth($email, $pass, $fb_id=null)
    {
        if(strlen($pass)<6 && !$fb_id) return 0;
        elseif($fb_id)
        {
            $sth = $this->dbo->prepare("UPDATE `users` SET `fb_id`=:fbid WHERE `email`=:email");
            $sth->execute(array(':email' => $email, ':fbid' =>$fb_id));

            $params=array(':email' => $email);
            $sql="SELECT `active` FROM `users` WHERE `email`=:email";
        }
        else
        {   
            $params=array(':password' => md5($pass), ':email' => $email);
            $sql="SELECT `active` FROM `users` WHERE `email`=:email AND `password`=:password";
        }
        $sth = $this->dbo->prepare($sql);
        $sth->execute($params);
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