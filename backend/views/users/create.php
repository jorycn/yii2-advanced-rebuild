<?php
use yii\helpers\Url;

$this->title = Yii::t('users', 'Create User');
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('users', 'Users'),
        'url' => Url::to(['users/index'])
    ],
    Yii::t('users', 'Create')
];

echo $this->render('_form', [
    'model' => $model,
    'roleArray' => $roleArray,
    'statusArray' => $statusArray
]);