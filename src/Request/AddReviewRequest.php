<?php

namespace Request;

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
}