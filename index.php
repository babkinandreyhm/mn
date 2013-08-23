<?php
/**
 * Created by JetBrains PhpStorm.
 * User: andrey
 * Date: 21.08.13
 * Time: 17:32
 * To change this template use File | Settings | File Templates.
 */
include 'autoload.php';
use collect\Collector as CR;

$collector = new CR();
$a = $collector->getCurrencies();
var_dump($a);