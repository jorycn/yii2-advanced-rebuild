<?php

use yii\helpers\Html;
use kartik\icons\Icon;
use kartik\detail\DetailView;

$this->title = Yii::t('i18n', 'Message #{id}', ['id' => $model->id]);
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('i18n', 'Translated messages'),
        'url' => 'translate'
    ],
    Yii::t('i18n', 'Message #{id}', ['id' => $model->id])
];

?>

<div class="row">
    <div class="col-lg-8">
        <?php
        echo DetailView::widget([
            'model' => $model,
            'condensed' => true,
            'hover' => true,
            'mode' => DetailView::MODE_VIEW,
            'enableEditMode' => false,
            'panel' => [
                'heading' => Icon::show('book') . Yii::t('i18n', 'Message') .
                    Html::a(Icon::show('book') . Yii::t('i18n', 'Translate'), ['update', 'id' => $model->id], ['class' => 'btn-success btn-sm btn-dv pull-right']),
                'type' => DetailView::TYPE_DEFAULT,
            ],
            'attributes' => array_merge([
                'id',
                'category',
                'message',
            ], $atributes),
        ]);
        ?>
    </div>
</div>