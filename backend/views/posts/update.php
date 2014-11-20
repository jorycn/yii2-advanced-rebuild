<?php
use yii\helpers\Url;

$this->title = Yii::t('pages', 'Update post #{id}', [
    'id' => $model->id
]);
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('pages', 'Posts'),
        'url' => Url::toRoute('/posts')
    ],
    $this->title
];

echo $this->render('_form', [
    'model' => $model,
    'translates' => $translates,
    'postStatuses' => $postStatuses,
    'category' => $category
]);

?>