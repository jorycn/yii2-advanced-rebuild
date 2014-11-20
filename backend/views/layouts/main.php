<?php

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

use backend\widgets\SideMenu;
use common\widgets\Alert;

use kartik\icons\Icon;

AppAsset::register($this);
Icon::map($this); // default Icon::FA
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language; ?>">
    <head>
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
            <div id="wrapper">

                <?php echo $this->render('//layouts/top-menu') ?>
                <div class="top-line"></div>
                <?php echo SideMenu::widget(['class' => $this]) ?>

                <div id="page-wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header"><?= $this->title ?></h1>
                        </div>
                    </div>
                    <?= Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        'homeLink' => [
                            'label' => Yii::t('app', 'Dashboard'),
                            'url' => Yii::$app->homeUrl
                        ]
                    ]); ?>
                    <?= Alert::widget() ?>
                    <?= $content; ?>
                </div>

            </div>
            <footer class="footer">
                <div class="col-lg-12">
                    <p class="pull-left">© <?= Yii::$app->params['siteName'] . ' ' . date('Y'); ?> </p>
                    <p class="pull-right">Powered by <a href="http://www.yiiframework.com/" rel="external">Yii Framework</a></p>
                </div>
            </footer>
        <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>
