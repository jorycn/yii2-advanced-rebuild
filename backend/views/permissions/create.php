<?php
use yii\helpers\Url;

$this->title = Yii::t('auth', 'Create Permission');
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('auth', 'Permissions'),
        'url' => Url::toRoute('/permissions')
    ],
    Yii::t('auth', 'Create')
];

echo $this->render('_form', [
    'model' => $model
]);