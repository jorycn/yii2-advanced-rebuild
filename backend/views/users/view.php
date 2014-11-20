<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\icons\Icon;
use kartik\detail\DetailView;

$this->title = Yii::t('users', 'User \'{username}\'', ['username' => $model->username]);
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('users', 'Users'),
        'url' => Url::toRoute('/users')
    ],
    $model->username
];

?>

<div class="row">
    <div class="col-lg-6">
        <?php
        echo DetailView::widget([
            'model' => $model,
            'condensed' => true,
            'hover' => true,
            'mode' => DetailView::MODE_VIEW,
            'enableEditMode' => false,
            'panel' => [
                'heading' => Icon::show('user') . Yii::t('users', 'User') .
                    Html::a(Icon::show('user') . Yii::t('users', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn-success btn-sm btn-dv pull-right']),
                'type' => DetailView::TYPE_DEFAULT,
            ],
            'attributes' => [
                'id',
                'nickname',
                'username',
                'email',
                [
                    'attribute' => 'status',
                    'value' => $model->status
                ],
                [
                    'attribute' => 'created_at',
                    'format' => ['date', 'php:Y-m-d H:i:s']
                ],
                [
                    'attribute' => 'updated_at',
                    'format' => ['date', 'php:Y-m-d H:i:s']
                ]
            ],
        ]);
        ?>
    </div>
</div>