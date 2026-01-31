<?php

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'db' => [
            'on afterOpen' => function($event) {
                // Remove ONLY_FULL_GROUP_BY from the current session's sql_mode
                $event->sender->createCommand("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));")->execute();
            },
        ],
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'i18n' => ['translations' => [
            '*' => ['class' => \yii\i18n\PhpMessageSource::class],
            'yii' => ['class' => \yii\i18n\PhpMessageSource::class]
        ]],

    ],
    'modules' => [
        'project' => \common\modules\project\Module::class,
    ]
];
