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
    protected $xmlObject;

    public function __construct($source = self::SOURCE_URL)
    {
        $isUrl = false;
        if(strpos($source, 'http://')!==false) {
            $isUrl = true;
        }
        $this->xmlObject = new \SimpleXMLElement($source, null, $isUrl);
    }

    public function getDataObject()
    {
        return $this->xmlObject;
    }
}