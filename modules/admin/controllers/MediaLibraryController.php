<?php

namespace app\modules\admin\controllers;


use app\models\File;
use app\models\FileCollection;
use app\modules\admin\ApiController;
use League\Flysystem\AdapterInterface;
use League\Flysystem\FilesystemInterface;
use yii\base\Module;
use yii\data\ActiveDataProvider;
use yii\helpers\Inflector;
use yii\web\BadRequestHttpException;
use yii\web\UploadedFile;

class MediaLibraryController extends ApiController
{
    public $modelClass = File::class;

    protected $filesystem;

    public function __construct($id, Module $module, FilesystemInterface $filesystem, array $config = [])
    {
        $this->filesystem = $filesystem;

        parent::__construct($id, $module, $config);
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function actionCollections()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => FileCollection::find()
        ]);

        return $dataProvider;
    }

    public function actionUpload()
    {
        if ($uploadedFile = UploadedFile::getInstanceByName('file')) {
            $media = new File([
                'owner_type' => \Yii::$app->request->post('owner_type'),
                'owner_id' => \Yii::$app->request->post('owner_id'),
                'name' => Inflector::humanize($uploadedFile->baseName),
                'file_name' => $uploadedFile->name,
                'mime_type' => $uploadedFile->type,
                'file_size' => $uploadedFile->size,
                'sort_order' => time(),
                'width' => \Yii::$app->request->post('width'),
                'height' => \Yii::$app->request->post('height')
            ]);

            $save = $media->save();

            if ($save) {

                $config = [
                    'visibility' => AdapterInterface::VISIBILITY_PUBLIC,
                    'mimetype' => $uploadedFile->type
                ];

                $this->filesystem->put($media->getStoragePath(), file_get_contents($uploadedFile->tempName), $config);

            }

        } else {

            \Yii::$app->response->statusText = 'No file uploaded';

            \Yii::$app->response->statusCode = 400;

            return [
                'status' => 'fail'
            ];

        }

        return $uploadedFile;
    }

    public function prepareDataProvider()
    {
        $query = File::find();

        $sort = [];

        if ($type = \Yii::$app->request->get('type')) {

            $type = Inflector::singularize($type);

            switch($type) {
                case 'image':
                case 'video':
                case 'audio':
                    $query->andWhere(['like','mime_type', $type. '/%', false]);
                    $sort = [
                        'defaultOrder' => [
                            'created_at' => SORT_DESC
                        ],
                        'attributes' => [
                            'created_at',
                            'updated_at',
                            'file_name'
                        ]
                    ];
                    break;
                case 'recent':
                    $query->orderBy('updated_at DESC');
                    break;
                case 'document':
                    $query
                        ->andWhere(['not', ['like','mime_type', 'video/%', false]])
                        ->andWhere(['not', ['like','mime_type', 'audio/%', false]])
                        ->andWhere(['not', ['like','mime_type', 'image/%', false]]);
                    $sort = [
                        'defaultOrder' => [
                            'created_at' => SORT_DESC
                        ]
                    ];
                    break;

            }

        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => $sort
        ]);


        return $dataProvider;
    }

}