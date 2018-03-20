<?php

namespace app\fields;


class PassThroughDecorator extends BaseDecorator
{
    public function decorate($value)
    {
        return $value;
    }
}
