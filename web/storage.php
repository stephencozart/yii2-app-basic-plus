<?php
require(__DIR__ . '/../config/constants.php');
require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

$app = new yii\web\Application($config);

$params = Yii::$app->request->get();

//$file = \app\models\File::findOne($params['fileId']);

if (Yii::$container->has(\League\Flysystem\AdapterInterface::class)) {

    /** @var \League\Flysystem\AdapterInterface $storage */
    $storage = Yii::$container->get(League\Flysystem\AdapterInterface::class);

    $path = sprintf('%s/%s.%s', $params['folderSegment'], $params['fileName'], $params['fileExtension']);

    $file = $storage->read($path);

    $mimeType = $storage->getMimetype($path);

    header('Content-Type: ' . $mimeType['mimetype']);

    file_put_contents('php://output', $file['contents']);
}
