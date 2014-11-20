<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\icons\Icon;
use kartik\detail\DetailView;

$this->title = Yii::t('category', 'Category \'{name}\'', ['name' => $model->name]);
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('category', 'Category'),
        'url' => Url::toRoute('/category')
    ],
    $this->title
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
                'heading' => Icon::show('files-o') . Yii::t('category', 'Category') .
                    Html::a(Icon::show('files-o') . Yii::t('category', 'Edit'), ['update', 'id' => $model->id], ['class' => 'btn-success btn-sm btn-dv pull-right']),
                'type' => DetailView::TYPE_DEFAULT,
            ],
            'attributes' => array_merge([
                'id',
                'name',
            ], $atributes),
        ]);
        ?>
    </div>
</div>