<?php

namespace app\modules\admin\controllers;


use app\models\User;
use app\modules\admin\ApiController;

class UserController extends ApiController
{
    public $modelClass = User::class;
}