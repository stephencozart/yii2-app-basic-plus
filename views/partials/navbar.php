<?php
use yii\helpers\Url;
?>
<nav class="navbar navbar-expand-md fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#"><?= Yii::$app->name ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-main" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar-main">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= Url::to(['/user/register']) ?>">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= Url::to(['/user/login']) ?>">Sign In <i class="fas fa-long-arrow-alt-right"></i></a>
                </li>

            </ul>
        </div>
    </div>
</nav>