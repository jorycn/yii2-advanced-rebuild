<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\icons\Icon;

?>

<div class="row">
    <?php
    $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'enableAjaxValidation' => true,
        'validateOnChange' => false
    ]);
    ?>
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Icon::show('user'); ?> <?= Yii::t('auth', 'Role'); ?>
            </div>
            <div class="panel-body">
                <?php
                echo $form->field($model, 'name')->textInput($model->isNewRecord ? [] : ['disabled' => 'disabled']) .
                     $form->field($model, 'description')->textarea(['style' => 'height: 100px']) .
                     Html::submitButton($model->isNewRecord ? Yii::t('auth', 'Save') : Yii::t('auth', 'Update'), [
                        'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'
                     ]);
                ?>
            </div>

        </div>
    </div>

    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Icon::show('lock'); ?> Permissions
            </div>

            <div class="panel-body">
                <?= $form->field($model, '_permissions')->checkboxList($permissions)->label('', ['hidden' => 'hidden']); ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>