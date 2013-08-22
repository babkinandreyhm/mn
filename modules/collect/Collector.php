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
    const PDO_HOST = 'mysql:dbname=money;host=127.0.0.1';

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
            $this->xmlObject = new \SimpleXMLElement($source, null, $isUrl);
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
        //$pdo = new \PDO()
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

    public function getSum($a, $b)
    {
        return $a + $b;
    }
}