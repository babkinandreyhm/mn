<?php
/**
 * Created by JetBrains PhpStorm.
 * User: andrey
 * Date: 26.08.13
 * Time: 15:40
 * To change this template use File | Settings | File Templates.
 */
include '/home/andreybabkin/hosts/hm/autoload.php';
use db\Db as DB;
$dbh = DB::getConnection();

//create table user

//create table currency
$sql = "CREATE  TABLE `money`.`user` (
                        `id` INT NOT NULL AUTO_INCREMENT ,
                        `login` VARCHAR(255) NOT NULL ,
                        `apikey` VARCHAR(255) NOT NULL ,
                        PRIMARY KEY (`id`));";
$sth = $dbh->prepare($sql);
$sth->execute();