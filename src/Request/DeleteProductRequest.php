<?php

namespace Request;

class DeleteProductRequest extends Request
{
    public function getProductId()
    {
        return $this->data['product_id'];
    }
}