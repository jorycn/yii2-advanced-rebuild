<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\icons\Icon;

?>

<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Icon::show('book'); ?> <?= Yii::t('category', 'Translate')?>
            </div>
            <div class="panel-body">

                <ul class="nav nav-tabs">
                    <?php foreach ($translates as $key => $translate): ?>
                        <li class="<?= ($translate->language == Yii::$app->language) ? 'active' : '';?>">
                            <a href="#<?= $translate->language; ?>" data-toggle="tab"> <?= Yii::$app->params['languages'][$translate->language]; ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div class="tab-content">
                    <?php foreach ($translates as $key => $translate): ?>
                        <div class="tab-pane <?= ($translate->language == Yii::$app->language) ? 'active' : '';?>" id="<?= $translate->language; ?>">
                            <?php
                            $form = ActiveForm::begin();
                            echo $form->field($model, "name");
                            
                            echo $form->field($translate, "language")->hiddenInput()->label('', ['style' => 'display:none']);
                            echo $form->field($translate, "cid")->hiddenInput(['value' => $model->id])->label('', ['style' => 'display:none']);
                            echo $form->field($translate, "title");
                            echo $form->field($translate, "meta_title");
                            echo $form->field($translate, "meta_descriptions");
                            echo $form->field($translate, "meta_keywords");

                            echo Html::submitButton(Yii::t('sections', 'Save'), [
                                'class' => 'btn btn-success pull-right'
                            ]);
                            ActiveForm::end();
                            ?>

                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>