<?php

include_once 'models/records.php';
include_once 'php/guid.php';
include_once 'php/formUtilities.php';
include_once 'php/imageFiles.php';

const UsersFile = "data/users.data";
const avatarsPath = "data/images/avatars/";

class User extends Record
{
    private $name;
    private $email;
    private $password;
    private $avatar;
    private $type = 0; // user => 0 , admin => 1
    private $blocked = 0; // not blocked => 0 , blocked => 1

    public function setName($name)
    {
        if (is_string($name))
            $this->name = $name;
    }
    public function setEmail($email)
    {
        if (is_string($email))
            $this->email = $email;
    }
    public function setPassword($password)
    {
        if (is_string($password))
            $this->password = $password;
    }
    public function setAvatar($avatar)
    {
        if (is_string($avatar))
            $this->avatar = $avatar;
    }
    public function setType($type)
    {
        $this->type = (int)$type;
    }
    public function setBlocked($blocked)
    {
        $this->blocked = (int)$blocked;
    }
    public function Name()
    {
        return $this->name;
    }
    public function Email()
    {
        return $this->email;
    }
    public function Password()
    {
        return $this->password;
    }
    public function Avatar()
    {
        return $this->avatar;
    }
    public function Type()
    {
        return $this->type;
    }
    public function Blocked()
    {
        return $this->blocked;
    }
    public function isAdmin() {
        return $this->type == 1;
    }

    public function isBlocked()
    {
        return $this->blocked == 1;
    }
    public static function compare($user_a, $user_b)
    {
        $string_a = no_Hyphens($user_a->Name());
        $string_b = no_Hyphens($user_b->Name());
        return strcmp($string_a, $string_b);
    }
    static function keyCompare($user_a, $user_b) {
        return strcmp($user_a->Email(),$user_b->Email());
    }


}

class UsersFile extends Records
{
    public function add($user)
    {
        $user->setAvatar(saveImage(avatarsPath, $user->Avatar()));
        parent::add($user);
    }
    public function update($user)
    {
        $userToUpdate = $this->get($user->Id());
        if ($userToUpdate != null) {
            $user->setAvatar(saveImage(avatarsPath, $user->Avatar(), $userToUpdate->Avatar()));
            parent::update($user);
        }
    }
    public function remove($id)
    {
        $userToRemove = $this->get($id);
        if ($userToRemove != null) {
            unlink($userToRemove->Avatar());
            return parent::remove($id);
        }
        return false;
    }
}

function UsersFile()
{
    return new UsersFile(UsersFile);
}