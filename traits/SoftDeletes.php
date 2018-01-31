<?php

namespace app\traits;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Trait SoftDeletes - findBySql does not support soft deletes so if you use the findBySql method with this trait it will
 * return all models regardless of them being soft deleted or not.  You will need add the necessary conditions to your query.
 *
 * To implement this trait you must have a deleted_at column in your table with the data type of datetime.  If your table
 * uses a different name other than deleted_at you may specify it on the implementing model by setting a $deletedAtAttribute
 * property with the name of your column.
 *
 * This trait overrides the default ActiveRecord behaviour for the find(), findAll(), and findOne() methods to apply the
 * necessary scope to only fetch records where the $deletedAtAttribute is NULL
 *
 * SoftDeletes also provides two new finder methods that return ActiveQuery instances:
 *
 * findOnlyTrash() - Scopes only deleted models
 *
 * findWithTrashed() - Scopes deleted and non deleted models
 *
 * @package app\traits
 */
trait SoftDeletes
{
    public static function find()
    {
        /** @var ActiveQuery $query */
        $query = \Yii::createObject(ActiveQuery::className(), [get_called_class()]);

        $query->andWhere([static::deletedAtAttribute() => null]);

        return $query;
    }

    public static function findAll($condition)
    {
        return static::findByCondition($condition)
            ->andWhere([static::deletedAtAttribute() => null])
            ->all();
    }

    public static function findOne($condition)
    {
        return static::findByCondition($condition)
            ->andWhere([static::deletedAtAttribute() => null])
            ->one();
    }

    public static function findOnlyTrashed()
    {
        /** @var ActiveQuery $query */
        $query = \Yii::createObject(ActiveQuery::className(), [get_called_class()]);

        $query->andWhere(['not', [static::deletedAtAttribute() => null]]);

        return $query;
    }

    public static function findWithTrashed()
    {
        /** @var ActiveQuery $query */
        $query = \Yii::createObject(ActiveQuery::className(), [get_called_class()]);

        return $query;
    }

    public static function deletedAtAttribute()
    {
        return isset(self::$deletedAtAttribute) ? self::$deletedAtAttribute : 'deleted_on';
    }

    public function isTrashed()
    {
        return !empty($this->{static::deletedAtAttribute()});
    }

    public function restore()
    {
        $this->setAttribute(static::deletedAtAttribute(), null);

        return $this->save(false);
    }

    public function forceDelete()
    {
        return parent::delete();
    }

    public function delete()
    {
        $this->setAttribute(static::deletedAtAttribute(), date('Y-m-d H:i:s'));

        if ($this->save(false)) {

            if ($this instanceof ActiveRecord) {

                $this->trigger(ActiveRecord::EVENT_AFTER_DELETE);

            }

            return true;
        }

        return false;
    }
}
