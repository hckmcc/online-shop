<?php

namespace Request;

use Model\User;

class RegisterRequest extends Request
{
    public function getName(): string
    {
        return $this->data['name'];
    }
    public function getEmail(): string
    {
        return $this->data['email'];
    }
    public function getPassword(): string
    {
        return $this->data['psw'];
    }
    public function validation(User $userModel):array
    {
        $errors = [];
        if (empty($this->data['name'])) {
            $errors['name'] = 'Enter name';
        }elseif(strlen($this->data['name'])>50){
            $errors['name'] = 'Name must contain less than 50 symbols';
        }
        if (empty($this->data['email'])) {
            $errors['email'] = 'Enter email';
        }elseif(!filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'Invalid email!';
        }elseif($userModel->getUserByEmail($this->data['email'])->getEmail()){
            $errors['email'] = 'Email already exists!';
        }
        if (empty($this->data['psw'])) {
            $errors['psw'] = 'Enter password';
        }elseif(!preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*\d)\S*$/", $this->data['psw'])){
            $errors['psw'] = 'Incorrect password';
        }
        if ($this->data['psw'] !== $this->data['psw_rpt']) {
            $errors['psw_rpt'] = 'Passwords don\'t match!';
        }
        return $errors;
    }
}