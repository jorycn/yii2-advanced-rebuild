<?php

$rootDir = dirname(dirname(__DIR__));
Yii::setAlias('root', $rootDir);

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'extensions' => require(__DIR__ . '/../../vendor/yiisoft/extensions.php'),
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['guest'],
        ],
        'i18n' => [
            'translations' => [
                'yii' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => "@yii/messages",
                    'sourceLanguage' => 'en',
                    'fileMap' => [
                        'yii'=>'yii.php',
                        'authorization'=>'authorization.php',
                        'app'=>'app.php',
                    ]
                ],
                '*' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'sourceLanguage' => 'en',
                ],
            ]
        ]
    ],
    'modules' => [
        'gridview' => [
            'class' => '\kartik\grid\Module',
            'i18n' => [
                'class' => 'yii\i18n\DbMessageSource',
                'sourceLanguage' => 'en',
                'forceTranslation' => true
            ]
        ],
        'detailview' => [
            'class' => '\kartik\detail-view\Module',
            'i18n' => [
                'class' => 'yii\i18n\DbMessageSource',
                'sourceLanguage' => 'en',
                'forceTranslation' => true
            ]
        ]
    ],
];
