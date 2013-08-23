<?php
/**
 * Created by JetBrains PhpStorm.
 * User: andrey
 * Date: 22.08.13
 * Time: 16:07
 * To change this template use File | Settings | File Templates.
 */

const DSN = 'mysql:dbname=money;host=127.0.0.1';
const USER = 'root';
const PASS = '';

//init db connection
try {
    $dbh = new PDO(DSN, USER, PASS);
    echo 'rdy' . PHP_EOL;
} catch (PDOException $e) {
    echo 'Подключение не удалось: ' . $e->getMessage();
}

//create table currency
$sql = "CREATE  TABLE `money`.`currency` (
                        `id` INT NOT NULL AUTO_INCREMENT ,
                        `up_id` INT NOT NULL ,
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
$sql = "CREATE TABLE `money`.`updateHistory` (
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
          FOREIGN KEY (`up_id`)
          REFERENCES `money`.`updateHistory` (`id`)
          ON DELETE CASCADE
          ON UPDATE CASCADE,
        ADD INDEX `fk_currency_to_history` (`up_id` ASC) ;";
$sth = $dbh->prepare($sql);
$sth->execute();