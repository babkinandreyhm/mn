<?php
/**
 * Created by JetBrains PhpStorm.
 * User: andrey
 * Date: 22.08.13
 * Time: 16:07
 * To change this template use File | Settings | File Templates.
 */
include '/home/andreybabkin/hosts/hm/autoload.php';
use db\Db as DB;
$dbh = DB::getConnection();

//create table currency
$sql = "CREATE  TABLE `money`.`currency` (
                        `id` INT NOT NULL AUTO_INCREMENT ,
                        `upId` INT NOT NULL ,
                        `numCode` VARCHAR(255) NOT NULL ,
                        `charCode` VARCHAR(255) NOT NULL ,
                        `nominal` VARCHAR(255) NOT NULL ,
                        `name` VARCHAR(255) NOT NULL ,
                        `value` VARCHAR(255) NOT NULL ,
                        PRIMARY KEY (`id`),
                        INDEX `CHAR` (`charCode` ASC));";
$sth = $dbh->prepare($sql);
$sth->execute();

//create table updateHistory
$sql = "CREATE TABLE `money`.`currHistory` (
                        `id` INT NOT NULL AUTO_INCREMENT ,
                        `currency_date` DATE NOT NULL ,
                        `load_date` DATETIME NOT NULL ,
                        PRIMARY KEY (`id`),
                        INDEX `CUR_DATE` (`currency_date` ASC) );";
$sth = $dbh->prepare($sql);
$sth->execute();

//example for creating indexes and foreign keys
/*$sql = "ALTER TABLE `money`.`currency`
          ADD FOREIGN KEY `CHAR` (`charCode` ASC) ;";
$sth = $dbh->prepare($sql);
$sth->execute();*/
$sql = "ALTER TABLE `money`.`currency`
          ADD CONSTRAINT `fk_currency_to_history`
          FOREIGN KEY (`upId`)
          REFERENCES `money`.`currHistory` (`id`)
          ON DELETE CASCADE
          ON UPDATE CASCADE,
        ADD INDEX `fk_currency_to_history` (`upId` ASC) ;";
$sth = $dbh->prepare($sql);
$sth->execute();