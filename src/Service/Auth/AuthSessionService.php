<?php

namespace Service\Auth;

use Model\User;

class AuthSessionService implements AuthServiceInterface
{
    public function check(): bool
    {
        $this->sessionStart();
        return isset($_SESSION['user_id']);
    }

    public function getCurrentUser(): ?User
    {
        if (!$this->check()) {
            return null;
        }
        $this->sessionStart();
        $userId = $_SESSION['user_id'];
        return User::getUserById($userId);
    }

    public function login(string $email, string $password): bool
    {
        $user = User::getUserByEmail($email);
        if (!empty($user) and password_verify($password, $user->getPassword())) {
            $this->sessionStart();
            $_SESSION['user_id'] = $user->getId();
            return true;
        }else{
            return false;
        }
    }

    public function logout():void
    {
        $this->sessionStart();
        if($this->check()){
            unset($_SESSION['user_id']);
        }
    }
    private function sessionStart():void
    {
        if(session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }
}