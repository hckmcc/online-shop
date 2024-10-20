<?php

namespace Request;

class LoginRequest extends Request
{
    public function getEmail(): string
    {
        return $this->data['email'];
    }
    public function getPassword(): string
    {
        return $this->data['psw'];
    }
    public function validation(): array
    {
        $errors = [];
        if (empty($this->data['email'])) {
            $errors['email'] = 'Enter email';
        }elseif(!filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'Invalid email!';
        }
        if (empty($this->data['psw'])) {
            $errors['psw'] = 'Enter password';
        }
        return $errors;
    }
}