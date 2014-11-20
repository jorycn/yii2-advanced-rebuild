<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\icons\Icon;
use kartik\detail\DetailView;

$this->title = Yii::t('i18n', 'Translate message #{id}', ['id' => $model->id]);
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('i18n', 'Translated messages'),
        'url' => 'translate'
    ],
    Yii::t('i18n', 'Message #{id}', ['id' => $model->id])
];
?>

<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Icon::show('book'); ?> <?= Yii::t('i18n', 'Translate')?>
            </div>
            <div class="panel-body">

                <?php
                $form = ActiveForm::begin();

                foreach ($messages as $key => $message) {
                    echo $form->field($message, "[$key]translation")
                        ->label(Yii::$app->params['languages'][$message->language]);
                }
                echo Html::submitButton(Yii::t('i18n', 'Save'), [
                    'class' => 'btn btn-success'
                ]);
                ActiveForm::end();
                ?>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <?php
        echo DetailView::widget([
            'model' => $model,
            'condensed' => true,
            'hover' => true,
            'mode' => DetailView::MODE_VIEW,
            'enableEditMode' => false,
            'panel' => [
                'heading' => Icon::show('book') . Yii::t('i18n', 'Message'),
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