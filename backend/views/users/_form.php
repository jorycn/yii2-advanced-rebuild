<?php

/**
 * Form view of the user
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var common\models\User $model
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\icons\Icon;

?>

<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Icon::show('user'); ?> <?= Yii::t('users', 'User'); ?>
            </div>
            <div class="panel-body">

                <?php
                $form = ActiveForm::begin(['id' => 'user-create']);

                echo 
                    $form->field($model, 'username') .
                    $form->field($model, 'nickname') .
                    $form->field($model, 'email') .
                    $form->field($model, 'status')->dropDownList($statusArray, [
                        'prompt' => Yii::t('users', 'Select status')
                    ]) .
                    $form->field($model, 'role')->dropDownList($roleArray, [
                        'prompt' => Yii::t('users', 'Select role')
                    ]) .
                    $form->field($model, 'password')->passwordInput() .
                    $form->field($model, 'repassword')->passwordInput() .
                    Html::submitButton($model->isNewRecord ? Yii::t('users', 'Save') : Yii::t('users', 'Update'), [
                        'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'
                    ]);
                ActiveForm::end();
                ?>
            </div>
        </div>
    </div>
</div>