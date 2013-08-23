<?php
/**
 * Created by JetBrains PhpStorm.
 * User: andrey
 * Date: 21.08.13
 * Time: 17:47
 * To change this template use File | Settings | File Templates.
 */
namespace collect;


class Collector
{
    const SOURCE_URL = 'http://www.cbr.ru/scripts/XML_daily.asp';

    const PDO_DSN = 'mysql:dbname=money;host=127.0.0.1;charset=utf8';
    const PDO_USER = 'root';
    const PDO_PASS = '';

    protected $data;
    protected $xmlObject;
    protected $attributes = [];
    protected $currencies = [];

    public function __construct($source = self::SOURCE_URL)
    {
        try {
            $isUrl = false;
            if(strpos($source, 'http://')!==false) {
                $isUrl = true;
            }
            //may be used both methods
            $this->xmlObject = new \SimpleXMLElement($source, null, $isUrl);
            //$this->xmlObject = simplexml_load_file($source);
        } catch (\Exception $e) {
            echo 'Unable to get data from XML';
        }
    }

    public function getDataObject()
    {
        return $this->xmlObject;
    }

    public function getDate()
    {
        return (string)$this->xmlObject->attributes()->Date;
    }

    /**
     * @return array $currencies
     */
    public function getCurrencies()
    {
        if (empty($this->currencies)) {
            $this->createCurrencyArray();
        }
        return $this->currencies;
    }

    public function saveCurrencies()
    {
        if (empty($this->currencies)) {
            $this->createCurrencyArray();
        }
        try {
            $dbh = new \PDO(self::PDO_DSN, self::PDO_USER, self::PDO_PASS);
        } catch (\PDOException $e) {
            echo 'Подключение не удалось: ' . $e->getMessage();
        }
        $date = date('Y-m-d H:i:s');
        //saving currHistory
        $sql = "INSERT INTO `money`.`currHistory`(`currency_date`, `load_date`)
        VALUES (:cur_date, :load_date)";
        $sth = $dbh->prepare($sql);
        $sth->execute(array(':cur_date' => $this->getDate(), ':load_date' => $date));
        try {
            $dbh->beginTransaction();
            //getting currHistory->id
            $sql = "SELECT `id` FROM `money`.`currHistory` WHERE `load_date` = '" . $date ."';";
            $sth = $dbh->prepare($sql);
            $sth->execute();
            $id = $sth->fetch(\PDO::FETCH_ASSOC)['id'];

            //saving currencies
            $sql = "INSERT INTO `money`.`currency`(`upId`, `numCode`, `charCode`, `nominal`, `Name`, `Value`)
                    VALUES (:upId, :numCode, :charCode, :nominal, :valName, :valValue)";
            $sth = $dbh->prepare($sql);
            foreach ($this->getCurrencies() as $currency) {
                $sth->execute(array(
                    ':upId' => $id,
                    ':numCode' => $currency['NumCode'],
                    ':charCode' => $currency['CharCode'],
                    ':nominal' => $currency['Nominal'],
                    ':valName' => $currency['Name'],
                    ':valValue' => $currency['Value'],
                ));
            }
            $dbh->commit();
        } catch (\PDOException $e) {
            echo ':(' . PHP_EOL;
            $dbh->rollBack();
            $sql = "DELETE FROM `money`.`currHistory` WHERE `load_date` = '" . $date ."';";
            $sth = $dbh->prepare($sql);
            $sth->execute();
        }
    }

    protected function createCurrencyArray()
    {
        foreach ($this->xmlObject->Valute as $currency) {
            $this->currencies[(string)$currency->NumCode] = array(
                'NumCode' => (string)$currency->NumCode,
                'CharCode' => (string)$currency->CharCode,
                'Nominal' => (string)$currency->Nominal,
                'Name' => (string)$currency->Name,
                'Value' => (string)$currency->Value
            );
        }
    }

    public function getAttributesArray()
    {
        if (empty($this->attributes)) {
            foreach ($this->xmlObject->attributes() as $k => $v) {
                $this->attributes[$k] = $v;
            }
        }
        return $this->attributes;
    }
}