<?php

namespace Request;

use Model\User;

class AddReviewRequest extends Request
{
    public function getProductId()
    {
        return $this->data['product_id'];
    }
    public function getRating():?int
    {
        if(!isset($this->data['rating'])){
            return null;
        }
        return $this->data['rating'];
    }
    public function getReviewText()
    {
        return $this->data['review_text'];
    }
    public function validation():array
    {
        $errors = [];
        if (empty($this->data['product_id'])) {
            $errors['product_id'] = 'Empty product id';
        }
        if (empty($this->data['rating'])) {
            $errors['rating'] = 'Empty rating';
        }elseif($this->data['rating']>5 or $this->data['rating']<1){
            $errors['rating'] = 'Invalid rating';
        }
        return $errors;
    }
}