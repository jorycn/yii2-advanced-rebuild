<?php
use yii\helpers\Url;

$this->title = Yii::t('users', 'Update \'{username}\'', ['username' => $model->username]);
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('users', 'Users'),
        'url' => Url::toRoute('/users')
    ],
    $this->title
];

echo $this->render('_form', [
    'model' => $model,
    'roleArray' => $roleArray,
    'statusArray' => $statusArray
]);