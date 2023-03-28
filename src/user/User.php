<?php
include 'UserInterface.php';

class User implements UserInterface
{
    private $username;
    private $password;
    private $roles;
    private $DB;

    public function __construct(string $username, string $password , ?DB $DB = null )
    {
        $this->username = $username;
        $this->password = $password;
        if ($DB) {
            $this->DB = $DB;
        } else {
            $this->DB = new DB('localhost'  , 'all_solid', 'root', '');
        }

    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRoles(): array
    {
        $id = $this->DB->select('user' , "username = '$this->username'" );
        $id = $id['id'];
        $this->roles = $this->DB->select('user_roles' , "user_id = '$id'" );
        return $this->roles;
    }

    public function eraseCredentials(): void
    {
        $this->password = null;
        $this->salt = null;
    }
}
