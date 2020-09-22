<?php

namespace App\Controllers;

use App\Models\Users;

class UserController
{
    private $users ;

    public function __construct() {
        $this->users = new Users;
    }

    public function registerUser($postData)
    {
        //Hash password 
        $hashPassword = password_hash($postData['password'], PASSWORD_DEFAULT);
        $postData['password'] = $hashPassword;
        //Create user
        $this->users->createUser($postData);
        //Login user to website
        $this->loginUser($postData['email']);
    }
    
    public function findUserByEmail($email)
    {
        //Find user by email
        return $this->users->getUserByEmail($email);
    }
    
    private function loginUser($email)
    {
        //Start session
        session_start();
        //Save email as session variable
        $_SESSION['userEmail'] = $email;
        //Redirect user to profile
        header('Location: profile.php');
    }

    public function checkPassword(array $loginData)
    {
        //Find user in database by email from login form
        $user = $this->findUserByEmail($loginData['email']);
        //Check if we got any results
        if(!empty($user)){
            //Check if password matches to password hash
            if(password_verify($loginData['password'], $user['password'])){
                //Login user to website
                $this->loginUser($loginData['email']);
            }
        }
        return [
            'email' => 'Neteisingai įvesta prisijungimo informacija'
        ];
    }

    public function saveLastLoginTime($email)
    {
        $this->users->updateUserLastLogin($email);
    }
}
