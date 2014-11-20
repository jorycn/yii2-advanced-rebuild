<?php

use yii\helpers\Html;

$this->title = $name;
$this->context->layout = 'error';
?>

<div class="container">
    <div class="row">
        <div class="span12">
            <div class="hero-unit center">
                <h1><?= Html::encode($this->title) ?></h1>
                <br>
                <p><?= nl2br(Html::encode($message)) ?></p>
                <p><?= Yii::t('app', 'Either contact your webmaster or try again. Use your browsers <b>Back</b> button to navigate to the page you have prevously come from'); ?></p>

                <p><b><?= Yii::t('app', 'Or you could just press this neat little button:')?></b></p>
                <a href="<?= Yii::$app->homeUrl ?>" class="btn btn-large btn-info"><i class="icon-home icon-white"></i><?= Yii::t('app', 'Take Me Home'); ?></a>
            </div>
        </div>
    </div>
</div>
