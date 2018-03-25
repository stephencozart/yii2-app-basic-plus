<?php

namespace app\fields;


class LocationInputDecorator extends BaseDecorator
{
    public function decorate($value)
    {
        return json_decode($value, true);
    }
}