<?php

namespace app\fields;


class AssetInputDecorator extends BaseDecorator
{
    public function decorate($value)
    {
        return $value ? json_decode($value, true) : [];
    }
}
