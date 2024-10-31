<?php

namespace Request;

class GetProductRequest extends Request
{
    public function getProductId()
    {
        return $this->data['id'];
    }
}