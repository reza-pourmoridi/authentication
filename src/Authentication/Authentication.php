<?php
include 'AuthenticationInterface.php';
include '../src/user/User.php';

class Authentication implements AuthenticationInterface
{
    public $DB;

    function __construct($DB = null)
    {
        if ($DB) {
            $this->DB = $DB;
        } else {
            $this->DB = new DB('localhost'  , 'all_solid', 'root', '');
        }
    }

    public function login(string $username, string $password): bool{
        if ($this->userExists($username)){
            $cheack_pass = $this->DB->select('users' , "username = '$username' AND password = '$password'");
            if (!empty($cheack_pass) && isset($cheack_pass)) {
                return true;
            }
        }
        return false;
    }

    public function logout(): void{

    }
    public function isLoggedIn(): bool{
        return false;

    }
    public function getCurrentUser(): ?User{
        return false;

    }
    public function register(array $userData): ?User{
        if (!$this->userExists($userData['username'])){
            $this->DB->insert('users', $userData);
        }
        return (new User($userData['username'] , $userData['password']));
    }

    public function userExists(string $username): bool{
        $cheack_exist = $this->DB->select('users' , "username = '$username'");
        if (!empty($cheack_exist) && isset($cheack_exist)) {
            return true;
        } else {
            return false;
        }
    }
}