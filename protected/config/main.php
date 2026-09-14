<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'EduNexus',
    'defaultController' => 'dashboard',
    //Default theme
    'theme' => 'classic',
    //Default time zone
    'timeZone' => 'Asia/Dhaka',
    //Default source language
    'sourceLanguage' => 'en_us',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.helpers.*',
        'application.components.*',
        'application.vendors.*',
    ),
    'modules' => array(
        // uncomment the following to enable the Gii tool
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'admin',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
    ),
    // application components
    'components' => array(
        //        'clientScript' => array(
//            'packages' => array(
//                'jquery' => array(
//                    'baseUrl' => '//ajax.googleapis.com/ajax/libs/jquery/2.0.3/',
//                    'js' => array('jquery.min.js'),
//                    'coreScriptPosition' => CClientScript::POS_HEAD,
//                ),
//                'jquery.ui' => array(
//                    'baseUrl' => '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/',
//                    'js' => array('jquery-ui.min.js'),
//                    'depends' => array('jquery'),
//                    'coreScriptPosition' => CClientScript::POS_BEGIN,
//                ),
//            ),
//        ),

        'image' => array(
            'class' => 'application.extensions.image.CImageComponent',
            // GD or ImageMagick
            'driver' => 'GD',
            // ImageMagick setup path
            'params' => array('directory' => '/opt/local/bin'),
        ),
        'cache' => array(
            'class' => 'application.components.LruFileCache',
        ),
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
            'loginUrl' => array('/site/login'),
        ),
        'session' => array(
            'class' => 'CDbHttpSession',
            'connectionID' => 'db',
            'sessionName' => 'EduNexus',
            'autoCreateSessionTable' => false,
            'sessionTableName' => 'os_yiisession',
            'cookieMode' => 'only',
            'timeout' => 3600,
        ),
        // uncomment the following to enable URLs in path-format
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'urlSuffix' => '.html',
            'rules' => array(
                'defaultController' => 'login',
                'POST hikvision/event' => 'hikvision/event',
                '<action>' => 'site/<action>',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
        // database settings are configured in database.php
        'db' => require(dirname(__FILE__) . '/database.php'),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
                // uncomment the following to show log messages on web pages
                /*
                  array(
                  'class'=>'CWebLogRoute',
                  ),
                 */
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminName' => 'EduNexus',
        'PoweredBy' => 'Powered by Momtaj Trading Pvt. Ltd',
        'tagLine' => 'EduNexus is an all-in-one school management platform designed to streamline administrative workflows, track academic progress, and simplify campus operations. By connecting administrators, teachers, parents, and students in one unified ecosystem, it ensures real-time communication and efficient daily school management.',
        'adminEmail' => 'info@domain.com',
        'noreply' => 'noreply@domain.com',
        'pageSize' => 25,
        'pageSize10' => 10,
        'pageSize20' => 20,
        'pageSize30' => 30,
        'pageSize40' => 40,
        'pageSize50' => 50,
        'pageSize100' => 100,
    ),
);
