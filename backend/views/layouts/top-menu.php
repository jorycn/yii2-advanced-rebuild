<?php

use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

function getLang(){
    $l = [];
    $lang = Yii::$app->params['languages'];
    foreach ($lang as $k => $v) {
        $l[$k]['label'] = $v;
        $l[$k]['url'] = Url::canonical().'&l='.$k;
    }
    return $l;
}


NavBar::begin([
    'brandLabel' => Yii::$app->params['siteName'],
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-static-top navbar-top-links',
    ],
]);
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => [
        [
            'label' => '<i class="fa fa-home"></i>',
            'url'   => '/',
            'active'=> false
        ],
        [
            'label' => '<i class="fa fa-language"></i>',
            'url'   => '',
            'active'=> false,
            'items' => getLang()
        ],
        [
            'label' => '<i class="fa fa-envelope fa-fw"></i>',
            'url' => Url::to(['/site/index']),
            'active' => false,
            'items' => [
                [
                    'label' => '
                            <div>
                                <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                            </div>
                            <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>',
                    'url' => "#",
                    'options' => [
                        'class' => 'dropdown-messages',
                    ],
                ],
            ]
        ],
        [
            'label' => '<i class="fa fa-tasks fa-fw"></i>',
            'url' => ['/site/index'],
            'active' => false,
            'items' => [
                [
                    'label' => '
                            <div>
                            <p>
                                <strong>Task 1</strong>
                                <span class="pull-right text-muted">40% Complete</span>
                            </p>
                            <div class="progress progress-striped active">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                    <span class="sr-only">40% Complete (success)</span>
                                </div>
                            </div>
                        </div>',
                    'url' => "#",
                    'options' => [
                        'class' => 'dropdown-messages',
                    ],
                ],
            ]
        ],
        [
            'label' => '<i class="fa fa-bell fa-fw"></i>',
            'url' => ['/site/index'],
            'active' => false,
            'items' => [
                [
                    'label' => '
                        <div>
                            <i class="fa fa-comment fa-fw"></i> New Comment
                            <span class="pull-right text-muted small">4 minutes ago</span>
                        </div>
                            ',
                    'url' => "#",
                    'options' => [
                        'class' => 'dropdown-messages',
                    ],
                ],
                [
                    'label' => '
                       <div>
                            <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                            <span class="pull-right text-muted small">12 minutes ago</span>
                        </div>
                            ',
                    'url' => "#",
                    'options' => [
                        'class' => 'dropdown-messages',
                    ],
                ],
                [
                    'label' => '
                        <div>
                            <i class="fa fa-envelope fa-fw"></i> Message Sent
                            <span class="pull-right text-muted small">4 minutes ago</span>
                        </div>
                            ',
                    'url' => "#",
                    'options' => [
                        'class' => 'dropdown-messages',
                    ],
                ],
                [
                    'label' => '
                        <div>
                            <i class="fa fa-upload fa-fw"></i> Server Rebooted
                            <span class="pull-right text-muted small">4 minutes ago</span>
                        </div>
                            ',
                    'url' => "#",
                    'options' => [
                        'class' => 'dropdown-messages',
                    ],
                ],
                [
                    'label' => '
                        <div>
                             <strong>See All Alerts</strong>
                            <i class="fa fa-angle-right"></i></div>
                            ',
                    'url' => "#",
                    'options' => [
                        'class' => 'dropdown-messages',
                    ],
                ],
            ]
        ],
        [
            'label' => Yii::$app->user->identity->username,
            'url' => ['/site/index'],
            'active' => false,
            'items' => [
                [
                    'label' => '<i class="fa fa-user fa-fw"></i> User Profile',
                    'url' => Url::to(['users/view', 'id'=>Yii::$app->user->id])
                ],
                /* [
                     'label' => '<i class="fa fa-gear fa-fw"></i> Settings',
                     'url' => "#",
                 ],*/
                [
                    'label' => '',
                    'url' => "#",
                    'options' => [
                        'class' => 'divider',
                    ],
                ],
                [
                    'label' => '<i class="fa fa-sign-out fa-fw"></i> Logout',
                    'url' => Url::to(["site/logout"]),
                    'linkOptions' => ['data-method' => 'post']
                ],
            ]
        ],
    ],
    'encodeLabels' => false,
]);
NavBar::end();
