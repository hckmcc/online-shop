<?php

namespace Request;

class AddProductRequest extends Request
{
    public function getProductId()
    {
        return $this->data['product_id'];
    }
    public function getProductAmount()
    {
        return $this->data['amount'];
    }
}