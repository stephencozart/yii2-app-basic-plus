<?php
/**
 * Created by PhpStorm.
 * User: stephencozart
 * Date: 1/24/18
 * Time: 7:33 PM
 */

namespace app\services;


use app\interfaces\SearchServiceInterface;
use yii\data\SqlDataProvider;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\VarDumper;

class MySqlSearchService implements SearchServiceInterface
{
    protected $dataProviderConfig = [];

    public function __construct($config = [])
    {
        if (isset($config['dataProvider'])) {
            $this->dataProviderConfig = $config['dataProvider'];
        }
    }

    public function search($term)
    {
        $query = new Query();
        $query->from('{{%user}}')
            ->where(['SOUNDS LIKE', 'last_name', $term])
            ->orWhere(['SOUNDS LIKE', 'first_name', $term])
            ->orWhere(['LIKE', 'last_name', $term])
            ->orWhere(['LIKE', 'first_name', $term])
            ->orWhere(['LIKE', 'email', $term]);

        $totalCount = $query->count();

        $query->select(['id','CONCAT_WS(\' \', first_name, last_name) as title', 'email as description', new Expression("'user' as resource")]);

        $command = $query->createCommand();

        $config = $this->dataProviderConfig;

        $config['sql'] = $command->sql;

        $config['params'] = $command->params;

        $config['totalCount'] = $totalCount;

        return new SqlDataProvider($config);
    }
}