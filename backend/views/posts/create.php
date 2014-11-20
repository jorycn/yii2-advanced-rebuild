<?php
use yii\helpers\Url;

$this->title = Yii::t('pages', 'Create post');
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('pages', 'Post'),
        'url' => Url::to(['/posts'])
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