<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">
    <div class="horizon">
        <h1><?= property_exists($exception, 'statusCode') ? $exception->statusCode : Html::encode($this->title) ?></h1>
    </div>
    <div class="surface">
        <h2>OOOPS!!!</h2>
        <h3>
            <?= nl2br(Html::encode($message)) ?>
        </h3>
        <p>
            The above error occurred while the Web server was processing your request. Please contact us if you think this is an error.
        </p>
        <p>

        </p>
    </div>
</div>
