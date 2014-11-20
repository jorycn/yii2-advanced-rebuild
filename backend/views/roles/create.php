<?php
use yii\helpers\Url;

$this->title = Yii::t('auth', 'Create Role');
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('auth', 'Roles'),
        'url' => Url::to(['roles/index'])
    ],
    Yii::t('auth', 'Create')
];

echo $this->render('_form', [
    'model' => $model,
    'permissions' => $permissions
]);