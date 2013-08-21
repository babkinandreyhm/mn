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

    protected $data;
    protected $simpleXml;

    public function __construct()
    {
        $this->simpleXml = new \SimpleXMLElement(self::SOURCE_URL, null, true);
        var_dump($this->simpleXml);
    }

    public function getData()
    {

    }


}