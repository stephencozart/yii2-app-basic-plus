<?php

namespace app\modules\admin\controllers;


use app\models\Field;
use app\modules\admin\ApiController;

class EntryTypeFieldController extends ApiController
{
    public $modelClass = Field::class;
}