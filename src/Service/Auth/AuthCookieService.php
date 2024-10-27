<?php

namespace Service\Auth;

use Model\User;

class AuthCookieService
{
    public function check(): bool
    {
        return isset($_COOKIE['user_id']);
    }

    public function getCurrentUser(): ?User
    {
        if (!$this->check()) {
            return null;
        }
        $userId = $_COOKIE['user_id'];
        return User::getUserById($userId);
    }

    public function login(string $email, string $password): bool
    {
        $user = User::getUserByEmail($email);
        if (!empty($user) and password_verify($password, $user->getPassword())) {
            $_COOKIE['user_id'] = $user->getId();
            return true;
        }else{
            return false;
        }
    }

    public function logout():void
    {
        if($this->check()){
            unset($_COOKIE['user_id']);
        }
    }
}