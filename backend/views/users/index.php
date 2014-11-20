<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\icons\Icon;

$this->title = Yii::t('users', 'Users');
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
                'heading' => '<h3 class="panel-title">' . Icon::show('users') . Yii::t('users', 'Users') . '</h3>',
                'type' => 'default',
                'before' => Html::a(Icon::show('plus') . Yii::t('users', 'Create'), ['create'], ['class' => 'btn btn-success']),
                'after' => Html::a(Icon::show('repeat') . Yii::t('users', 'Reset'), ['index'], ['class' => 'btn btn-info'])
            ],
            'columns' => [
                ['class' => 'kartik\grid\SerialColumn'],
                'username',
                'nickname',
                'email',
                [
                    'header' => Yii::t('users', 'Status'),
                    'attribute' => 'status_id',
                    'vAlign' => 'middle',
                    'value' => function ($model) {
                            return $model->status;
                        },
                    'filter' => Html::activeDropDownList($searchModel, 'status', $statusArray, ['class' => 'form-control', 'prompt' => Yii::t('users', 'Status')])
                ],
                [
                    'header' => 'Actions',
                    'class' => 'kartik\grid\ActionColumn',
                    'dropdown' => false,
                    'vAlign' => 'middle',
                    'urlCreator' => function ($action, $model, $key, $index) {
                            $link = '#';
                            switch ($action) {
                                case 'view':
                                    $link = Url::to(['users/view', 'id'=>$key]);
                                    break;
                                case 'update':
                                    $link = Url::to(['users/update', 'id'=>$key]);
                                    break;
                                case 'delete':
                                    $link = Url::to(['users/delete', 'id'=>$key]);
                                    break;
                            }
                            return $link;
                        },
                    'viewOptions' => ['title' => Yii::t('users', 'Details')],
                    'updateOptions' => ['title' => Yii::t('users', 'Edit page')],
                    'deleteOptions' => ['title' => Yii::t('users', 'Delete action')],
                ],
                ['class' => 'kartik\grid\CheckboxColumn']
            ],
        ]);
        ?>
    </div>
</div>

