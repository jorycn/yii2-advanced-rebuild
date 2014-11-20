<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\icons\Icon;
use kartik\detail\DetailView;

$this->title = 'Role' . " '$model->name'";
$this->params['breadcrumbs'] = [
    [
        'label' => 'Roles',
        'url' => Url::to(['roles/index'])
    ],
    $model->name
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
                'heading' => Icon::show('user') . Yii::t('auth', 'Role') .
                    Html::a(Icon::show('user') . Yii::t('auth', 'Update'), ['update', 'name' => $model->name], ['class' => 'btn-success btn-sm btn-dv pull-right']),
                'type' => DetailView::TYPE_DEFAULT,
            ],
            'attributes' => [
                'name',
                'description'
           ],
        ]);
        ?>
    </div>

    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Icon::show('lock'); ?> <?= Yii::t('auth', 'Permissions')?>
            </div>

            <div class="panel-body">
                <div class="list-group">
                    <?php foreach($model->_permissions as $key): ?>
                        <a class="list-group-item">
                            <?= $permissions[$key]?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>