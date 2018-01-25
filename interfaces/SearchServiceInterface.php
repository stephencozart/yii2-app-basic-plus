<?php

namespace app\interfaces;


use yii\base\Configurable;
use yii\data\DataProviderInterface;

interface SearchServiceInterface extends Configurable
{
    /**
     * @param $term string
     * @return DataProviderInterface
     */
    public function search($term);
}