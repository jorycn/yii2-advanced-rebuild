<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\icons\Icon;

$this->title = Yii::t('category', 'Categories');
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
                'heading' => '<h3 class="panel-title">' . Icon::show('files-o') . Yii::t('category', 'Categories') . '</h3>',
                'type' => 'default',
                'before' => Html::a(Icon::show('plus') . Yii::t('category', 'Create'), ['create'], ['class' => 'btn btn-success']),
                'after' => Html::a(Icon::show('repeat') . Yii::t('category', 'Reset'), ['index'], ['class' => 'btn btn-info'])
            ],
            'columns' => [
                ['class' => 'kartik\grid\SerialColumn'],
                [
                    'attribute' => 'name',
                    'width' => '25%',
                ],
                'title',
                [
                    'header' => Yii::t('category', 'Actions'),
                    'class' => 'kartik\grid\ActionColumn',
                    'dropdown' => false,
                    'vAlign' => 'middle',
                    'urlCreator' => function ($action, $model, $key, $index) {
                            $link = '#';
                            switch ($action) {
                                case 'view':
                                    $link = Url::to(['category/view', 'id'=>$model->id]);
                                    break;
                                case 'update':
                                    $link = Url::to(['category/update', 'id'=>$model->id]);
                                    break;
                                case 'delete':
                                    $link = Url::to(['category/delete', 'id'=>$model->id]);
                                    break;
                            }
                            return $link;
                        },
                    'viewOptions' => ['title' => Yii::t('category', 'Details')],
                    'updateOptions' => ['title' => Yii::t('category', 'Edit page')],
                    'deleteOptions' => ['title' => Yii::t('category','Delete action')],
                ],
                ['class' => 'kartik\grid\CheckboxColumn']
            ],
        ]);
        ?>
    </div>
</div>