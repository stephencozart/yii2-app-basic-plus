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
        $userQuery = new Query();
        $userQuery->from('{{%user}} u')
            ->select(['u.id','CONCAT_WS(\' \', u.first_name, u.last_name) COLLATE utf8_general_ci as title', new Expression('u.email COLLATE utf8_general_ci as description'), new Expression("'user' COLLATE utf8_general_ci as resource"), new Expression("'edit-user' COLLATE utf8_general_ci as routeName")])
            ->where(['SOUNDS LIKE', 'last_name', $term])
            ->orWhere(['SOUNDS LIKE', 'first_name', $term])
            ->orWhere(['LIKE', 'last_name', $term])
            ->orWhere(['LIKE', 'first_name', $term])
            ->orWhere(['LIKE', 'email', $term]);

        $entryQuery = new Query();
        $entryQuery->from('{{%entry}} e')
            ->select(['e.id',new Expression('e.title COLLATE utf8_general_ci'),new Expression('e.meta_description COLLATE utf8_general_ci as description'), new Expression("'entry' COLLATE utf8_general_ci as resource"), new Expression("'edit-entry' COLLATE utf8_general_ci as routeName")])
            ->where(['SOUNDS LIKE', 'title', $term])
            ->orWhere(['SOUNDS LIKE', 'content', $term])
            ->orWhere(['SOUNDS LIKE', 'meta_title', $term])
            ->orWhere(['SOUNDS LIKE', 'meta_description', $term])
            ->orWhere(['LIKE', 'title', $term])
            ->andWhere(['is_master' => 1]);


        $userQuery->union($entryQuery, false);

        $totalCount = $userQuery->count();

        $command = $userQuery->createCommand();

        //return $command->getRawSql();

        $config = $this->dataProviderConfig;

        $config['sql'] = $command->sql;

        $config['params'] = $command->params;

        $config['totalCount'] = $totalCount;

        return new SqlDataProvider($config);
    }
}