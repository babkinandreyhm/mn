<?php
/**
 * Created by JetBrains PhpStorm.
 * User: andrey
 * Date: 21.08.13
 * Time: 17:32
 * To change this template use File | Settings | File Templates.
 */

spl_autoload_extensions(".php"); // comma-separated list
spl_autoload_register();

$collector = new collect\Collector();