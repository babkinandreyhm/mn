<?php
/**
 * Created by JetBrains PhpStorm.
 * User: andrey
 * Date: 21.08.13
 * Time: 17:32
 * To change this template use File | Settings | File Templates.
 */
//ini_set( 'default_charset', 'UTF-8' );
date_default_timezone_set('Europe/Moscow');
include 'autoload.php';
use api\Api as API;

$api = new API;

var_dump($api->v1());