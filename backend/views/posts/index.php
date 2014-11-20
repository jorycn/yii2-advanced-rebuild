<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\icons\Icon;
use common\models\User;
use common\models\Post;
use common\models\Category;

$this->title = Yii::t('posts', 'Posts');
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
                'heading' => '<h3 class="panel-title">' . Icon::show('lock') . Yii::t('posts', 'Pages') . '</h3>',
                'type' => 'default',
                'before' => Html::a(Icon::show('plus') . Yii::t('posts', 'Create'), ['create'], ['class' => 'btn btn-success']),
                'after' => Html::a(Icon::show('repeat') . Yii::t('posts', 'Reset'), ['index'], ['class' => 'btn btn-info'])
            ],
            'columns' => [
                ['class' => 'kartik\grid\SerialColumn'],
                'title',
                'slug',
                [
                    'attribute' => 'author_id',
                    'vAlign' => 'middle',
                    'value' => function ($model) {
                            $user = User::find()
                                ->select(['username'])
                                ->where(['id' => $model->author_id])
                                ->one();
                            return $user->username;
                        },
                    'filter' => Html::activeDropDownList($searchModel, 'author_id', $users, ['class' => 'form-control', 'prompt' => '----'])
                ],
                [
                    'attribute' => 'category',
                    'vAlign'    => 'middle',
                    'value'     => function ($model) {
                            $cate = Category::find()->select(['name'])->where(['id' => $model->cid])->one();
                            return $cate->name;
                        },
                    'filter'  => Html::activeDropDownList($searchModel, 'cid', $categories, ['class' => 'form-control', 'prompt' => '----'])
                ],
                [
                    'attribute' => 'status',
                    'vAlign' => 'middle',
                    'value' => function ($model) {
                            $postStatuses = Post::getStatusArray();
                            return $postStatuses[$model->status];
                        },
                    'filter' => Html::activeDropDownList($searchModel, 'status', $postStatuses, ['class' => 'form-control', 'prompt' => '----'])
                ],
                'views',
                [
                    'header' => Yii::t('posts', 'Actions'),
                    'class' => 'kartik\grid\ActionColumn',
                    'dropdown' => false,
                    'vAlign' => 'middle',
                    'urlCreator' => function ($action, $model, $key, $index) {
                            $link = '#';
                            switch ($action) {
                                case 'view':
                                    $link = $model->url;
                                    break;
                                case 'update':
                                    $link = Url::to(['posts/update', 'id'=>$model->id]);
                                    break;
                                case 'delete':
                                    $link = Url::to(['posts/delete', 'id'=>$model->id]);
                                    break;
                            }
                            return $link;
                        },
                    'viewOptions' => ['title' => Yii::t('posts', 'Details')],
                    'updateOptions' => ['title' => Yii::t('posts', 'Edit page')],
                    'deleteOptions' => ['title' => Yii::t('posts', 'Delete action')],
                ],
                ['class' => 'kartik\grid\CheckboxColumn']
            ],
        ]);
        ?>
    </div>
</div>