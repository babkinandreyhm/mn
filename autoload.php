<?php
/**
 * Created by JetBrains PhpStorm.
 * User: andrey
 * Date: 22.08.13
 * Time: 11:12
 * To change this template use File | Settings | File Templates.
 */
spl_autoload_register(function ($class) {
    include '/home/andreybabkin/hosts/hm/modules/' . str_replace('\\', '/', $class) . '.php';
});