<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend-webapps',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'gridview' => [
            'class' => 'kartik\grid\Module',
        ],
        // 'gridviewKrajee' =>  [
        //     'class' => '\kartik\grid\Module',
        // ]
        // 'pdfjs' => [
        //     'class' => '\yii2assets\pdfjs\Module',
        // ],
    ],
    'components' => [
        /* Configuration FTP By Elfinder Flysystem */
        // 'ftpFs' => [
		// 	'class' => 'creocoder\flysystem\FtpFilesystem',
		// 	'host' => 'hartaaba@ftp.hartaabadi.com',
			// 'port' => 21,
			//  'username' => 'hartaaba',
            //  'password' => '72f*Y5!xXN3jBk',
			// 'ssl' => true,
			// 'timeout' => 60,
			 //'root' => '/',
			// 'permPrivate' => 0700,
			// 'permPublic' => 0744,
			// 'passive' => false,
			// 'transferMode' => FTP_TEXT,
		// ],
        // 'fsID' => [
        //     'cache' => 'cacheID',
        //     'replica' => 'anotherFsID',
        //     'config' => [
        //         'visibility' => \League\Flysystem\AdapterInterface::VISIBILITY_PRIVATE,
        //     ],
        //     // 'cacheKey' => 'flysystem',
        //     // 'cacheDuration' => 3600,
        // ],
        // 'root' => [
        //     'class' => 'mihaildev\elfinder\flysystem\Volume',
        //     'url' => 'https://hartaabadi.com',
        //     'component' => 'ftpFs'
        // ],
        // 'qr' => [
        //     'class' => '\Da\QrCode\Component\QrCodeComponent',
        //     // ... you can configure more properties of the component here
        // ],
        // 'fs' => [
        //     'class' => 'creocoder\flysystem\LocalFilesystem',
        //     'path' => '@webroot/system/',
        // ],
        // 'sms' => [
        //     'logging' => [
        //         'class' => '',          // optionaly, default to miserenkov\sms\logging\Logger
        //         'connection' => 'db',    // string or array to database connection
        //         'tableName' => ''      // database table name, optionaly, default to {{%sms_log}}
        //     ],
        //     'class' => 'miserenkov\sms\Sms',
        //     'gateway' => 'smsc.ua',     // gateway, through which will sending sms, default 'smsc.ua'
        //     'login' => '',              // login
        //     'password' => '',           // password or lowercase password MD5-hash
        //     'senderName' => 'Bhadranaya Group',         // sender name
        //     'options' => [
        //         'useHttps' => true,     // use secure HTTPS connection, default true
        //     ],
        // ],
        'request' => [
            'csrfParam' => '_csrf-backend-webapps',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend-webapps', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend-webapps',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            //'suffix' => '.html',
            'rules' => [
                '<action:[\w-]+>' => 'site/<action>',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',

                ['class' => 'yii\rest\UrlRule', 'controller' => 'api'],
            ],
        ],
    ],
    'params' => $params,
];
