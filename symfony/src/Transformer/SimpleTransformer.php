<?php

namespace App\Transformer;

class SimpleTransformer extends AbstractTransformer
{
    public function transform($data)
    {
        if (is_scalar($data) || is_array($data)) {
            return $data;
        }

        return null;
    }
}
