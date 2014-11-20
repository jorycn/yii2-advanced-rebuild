<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\icons\Icon;
use kartik\grid\GridView;

$this->title = Yii::t('i18n', 'Translated messages');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
    <div class="col-lg-12">
        <?php
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'responsive' => true,
            'hover' => true,
            'showPageSummary' => false,
            'showFooter' => false,
            'export' => false,
            'panel' => [
                'heading' => '<h3 class="panel-title">' . Icon::show('book') . Yii::t('i18n', 'Messages') . '</h3>',
                'type' => 'default',
                'before' => Html::a(Icon::show('repeat') . Yii::t('i18n', 'Extract messages'), ['extract'], ['class' => 'btn btn-success']),
                'after' => Html::a(Icon::show('repeat') . Yii::t('i18n', 'Reset filter'), ['index'], ['class' => 'btn btn-info'])
            ],
            'columns' => [
                ['class' => 'kartik\grid\SerialColumn'],
                [
                    'attribute' => 'category',
                    'width' => '200px'
                ],
                'message',
                [
                    'header' => 'Actions',
                    'class' => 'kartik\grid\ActionColumn',
                    'dropdown' => false,
                    'vAlign' => 'middle',
                    'urlCreator' => function ($action, $model, $key, $index) {
                            $link = '#';
                            switch ($action) {
                                case 'view':
                                    $link = Url::to(['translate/view', 'id'=>$key]);
                                    break;
                                case 'update':
                                    $link = Url::to(['translate/update', 'id'=>$key]);
                                    break;
                                case 'delete':
                                    $link = Url::to(['translate/delete', 'id'=>$key]);
                                    break;
                            }
                            return $link;
                        },
                    'viewOptions' => ['title' => Yii::t('i18n', 'Details')],
                    'updateOptions' => ['title' => Yii::t('i18n', 'Translate')],
                    'deleteOptions' => ['title' => Yii::t('i18n', 'Delete message')],
                ],
                ['class' => 'kartik\grid\CheckboxColumn']
            ],
        ]);
        ?>
    </div>
</div>