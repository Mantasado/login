<?php

namespace App\Models;

use App\Models\Model;

class Users extends Model
{
    public function getUserByEmail($email)
    {
        //SQL statment to find a user by email
        $stmt = $this->connect()->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        $stmt = null;
        return $user;
    }

    public function createUser(array $details)
    {
        //SQL statment to create new user
        $stmt = $this->connect()->prepare('INSERT INTO users(email, name, last_name, phone, password, registered_at, last_login_at)
         VALUES (?, ?, ?, ?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)');
        $stmt->execute([$details['email'], $details['name'], $details['last_name'], $details['phone'], $details['password']]);
        $stmt = null;
    }

    public function updateUserLastLogin($email)
    {
        //SQL statment to update last_login_at time
        $stmt = $this->connect()->prepare('UPDATE users SET last_login_at=CURRENT_TIMESTAMP WHERE email=?');
        $stmt->execute([$email]);
        $stmt = null;
    }
}
