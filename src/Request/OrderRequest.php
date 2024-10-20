<?php

namespace Request;

class OrderRequest extends Request
{
    public function getName(): string
    {
        return $this->data['name'];
    }
    public function getPhone(): string
    {
        return $this->data['phone'];
    }
    public function getAddress(): string
    {
        return $this->data['address'];
    }
    public function getComment(): string
    {
        return $this->data['comment'];
    }
    public function validation():array
    {
        $errors = array();
        if (empty($this->data['name'])) {
            $errors['name'] = 'Enter name';
        }elseif(strlen($this->data['name'])>50){
            $errors['name'] = 'Name must contain less than 50 symbols';
        }
        if (empty($this->data['phone'])) {
            $errors['phone'] = 'Enter phone';
        }elseif(strlen($this->data['phone'])!==12){
            $errors['phone'] = 'Invalid phone number';
        }
        if (empty($this->data['address'])) {
            $errors['address'] = 'Enter address';
        }elseif(strlen($this->data['address'])>1000){
            $errors['address'] = 'Address must contain less than 1000 symbols';
        }
        return $errors;
    }
}