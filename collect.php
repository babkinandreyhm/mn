<?php
/**
 * Created by JetBrains PhpStorm.
 * User: andrey
 * Date: 23.08.13
 * Time: 18:38
 * To change this template use File | Settings | File Templates.
 */
//ini_set( 'default_charset', 'UTF-8' );
date_default_timezone_set('Europe/Moscow');
include 'autoload.php';
use collect\Collector as CR;

$collector = new CR();
$collector->saveCurrencies();