<?php
use yii\helpers\Url;

$this->title = Yii::t('auth', 'Update \'{name}\'', ['name' => $model->name]);
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('auth', 'Roles'),
        'url' => Url::to(['roles/index'])
    ],
    $this->title
];

echo $this->render('_form', [
    'model' => $model,
    'permissions' => $permissions,
]);