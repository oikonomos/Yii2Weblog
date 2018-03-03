<?php
$params = require(__DIR__ . '/params.php');
 
$config = [
        'id' => 'basic',
        'name' => 'Your Site Name',
        'language' => 'en',
        'sourceLanguage' => 'en-US',
        'charset' => 'utf-8',
        'basePath' => dirname(__DIR__),
        'bootstrap' => ['log'],
        'components' => [
                'request' => [
                        // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
                        'cookieValidationKey' => 'your validation key',
                ],
                'cache' => [
                        'class' => 'yii\caching\FileCache',
                ],
                'user' => [
                        'class' => 'app\components\WebUser',
                        'identityClass' => 'app\models\User',
                        'enableAutoLogin' => true,
                ],
                'authManager' => [
                        'class' => 'yii\rbac\DbManager',
                        'defaultRoles' => [],
                ],
                'view' => require(__DIR__ . '/theme.php'),
                'i18n' => [
                        'translations' => [
                                'app*' => [
                                        'class' => 'yii\i18n\PhpMessageSource',
                                        'basePath' => '@app/messages',
                                        //'sourceLanguage' => 'ko-KR',
                                        /* 'fileMap' => [
                                            'app' => 'app.php',
                                            'app/error' => 'error.php',
                                        ], */
                                ],
                        ],
                ],
                'errorHandler' => [
                        'errorAction' => 'site/error',
                ],
                'mailer' => [
                        'class' => 'yii\swiftmailer\Mailer',
                        // send all mails to a file by default. You have to set
                        // 'useFileTransport' to false and configure a transport
                        // for the mailer to send real emails.
                        'useFileTransport' => true,
                ],
                'log' => [
                        'traceLevel' => YII_DEBUG ? 3 : 0,
                        'targets' => [
                                [
                                        'class' => 'yii\log\FileTarget',
                                        'levels' => ['error', 'warning'],
                                ],
                        ],
                ],
                'db' => require(__DIR__ . '/db.php'),  
                'urlManager' => [
                        'enablePrettyUrl' => true,
                        'showScriptName' => false,
                        'rules' => [
                        ],
                ],
                'assetManager' => [
                        'fileMode' => 0707,
                        'dirMode' => 0707,
                ],
                'authClientCollection' => [
                        'class' => 'yii\authclient\Collection',
                        'clients' => [
                                'myserver' => [
                                        'class' => 'yii\authclient\OAuth2',
                                        'clientId' => 'unique client_id',
                                        'clientSecret' => 'client_secret',
                                        'tokenUrl' => 'http://example.com/auth/token',
                                        'authUrl' => 'http://example.com/auth/index',
                                        'apiBaseUrl' => 'http://example.com/api',
                                ],
                        ],
                ],
        ],
        'params' => $params,
];

if (YII_ENV_DEV) {
        // configuration adjustments for 'dev' environment
        $config['bootstrap'][] = 'debug';
        $config['modules']['debug'] = [
                'class' => 'yii\debug\Module',
                // uncomment the following to add your IP if you are not connecting from localhost.
                //'allowedIPs' => ['127.0.0.1', '::1'],
        ];

        $config['bootstrap'][] = 'gii';
        $config['modules']['gii'] = [
                'class' => 'yii\gii\Module',
                // uncomment the following to add your IP if you are not connecting from localhost.
                'allowedIPs' => ['127.0.0.1', '::1', 'your ip'],
        ];
}

return $config;
