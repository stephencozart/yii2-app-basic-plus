<?php

namespace app\rules;


use app\models\EntryType;
use yii\base\BaseObject;
use yii\web\UrlRuleInterface;

class EntryTypeUrlRule extends BaseObject implements UrlRuleInterface
{
    public function createUrl($manager, $route, $params)
    {
        if ($route === 'entry-type/view') {
            if (isset($params['handle'])) {
                return $params['handle'];
            }
        }
        return false; // this rule does not apply
    }

    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();
        $pathInfo = trim($pathInfo, '/');

        if (preg_match('%^(\w+)(/(\w+))?$%', $pathInfo, $matches)) {

            $entryTypeHandle = $matches[1];

            $entryHandle = isset($matches[3]) ? $matches[3] : null;

            if ($entryTypeHandle && ($entryHandle) === null) {

                if ($entryType = EntryType::find()->andWhere(['handle' => $entryTypeHandle, 'enabled' => 1])->one()) {

                    \Yii::$container->setSingleton(EntryType::class, function() use ($entryType) {

                        return $entryType;

                    });

                    return ['entry-type/view', ['handle' => $entryTypeHandle]];

                }

            }

            // check $matches[1] and $matches[3] to see
            // if they match a manufacturer and a model in the database.
            // If so, set $params['manufacturer'] and/or $params['model']
            // and return ['car/index', $params]
        }
        return false; // this rule does not apply
    }
}